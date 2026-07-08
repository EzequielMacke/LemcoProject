<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Probeta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EnsayoCompresionController extends Controller
{
    public function index(Request $request): View
    {
        $mes  = max(1,    min(12,   (int) $request->get('mes',  now()->month)));
        $anio = max(2000, min(2100, (int) $request->get('anio', now()->year)));

        $primerDia = Carbon::create($anio, $mes, 1)->startOfDay();
        $ultimoDia = $primerDia->copy()->endOfMonth();

        $probetas = Probeta::whereRaw(
            'DATE_ADD(fecha_moldeo, INTERVAL edad_ensayo DAY) BETWEEN ? AND ?',
            [$primerDia->format('Y-m-d'), $ultimoDia->format('Y-m-d')]
        )->whereHas('remision', fn($q) => $q->where('estado', 1))->get();

        $datosPorDia = [];
        foreach ($probetas as $probeta) {
            $fecha = Carbon::parse($probeta->fecha_moldeo)
                ->addDays($probeta->edad_ensayo)
                ->format('Y-m-d');

            $datosPorDia[$fecha] ??= ['ensayadas' => 0, 'porEnsayar' => 0];

            if ($this->estaEnsayada($probeta)) {
                $datosPorDia[$fecha]['ensayadas']++;
            } else {
                $datosPorDia[$fecha]['porEnsayar']++;
            }
        }

        // Armar celdas del calendario (semana empieza el lunes)
        $celdas = [];
        $primerDiaSemana = (int) $primerDia->copy()->dayOfWeekIso; // 1=Lun ... 7=Dom
        $diasEnMes = (int) $primerDia->daysInMonth;

        for ($i = $primerDiaSemana - 1; $i > 0; $i--) {
            $d = $primerDia->copy()->subDays($i);
            $celdas[] = ['dia' => $d->day, 'fecha' => $d->format('Y-m-d'), 'esMes' => false];
        }
        for ($d = 1; $d <= $diasEnMes; $d++) {
            $celdas[] = ['dia' => $d, 'fecha' => Carbon::create($anio, $mes, $d)->format('Y-m-d'), 'esMes' => true];
        }
        $diasSiguiente = (int) ceil(count($celdas) / 7) * 7 - count($celdas);
        $ultimo = Carbon::create($anio, $mes, $diasEnMes);
        for ($i = 1; $i <= $diasSiguiente; $i++) {
            $d = $ultimo->copy()->addDays($i);
            $celdas[] = ['dia' => $d->day, 'fecha' => $d->format('Y-m-d'), 'esMes' => false];
        }

        $hoy     = now()->format('Y-m-d');
        $prevMes = $mes  === 1  ? 12       : $mes  - 1;
        $prevAnio = $mes === 1  ? $anio - 1 : $anio;
        $nextMes = $mes  === 12 ? 1        : $mes  + 1;
        $nextAnio = $mes === 12 ? $anio + 1 : $anio;

        return view('ensayo_compresion.index', compact(
            'mes', 'anio', 'celdas', 'datosPorDia', 'hoy',
            'prevMes', 'prevAnio', 'nextMes', 'nextAnio'
        ));
    }

    public function create(string $fecha): View
    {
        $fecha = Carbon::parse($fecha)->format('Y-m-d');

        $probetas = Probeta::with('remision.obra', 'detalles')
            ->whereRaw(
                'DATE_ADD(fecha_moldeo, INTERVAL edad_ensayo DAY) = ?',
                [$fecha]
            )
            ->whereHas('remision', fn($q) => $q->where('estado', 1))
            ->get();

        $pendientes = $probetas->filter(fn($p) => !$this->estaEnsayada($p))->values();
        $ensayadas  = $probetas->filter(fn($p) =>  $this->estaEnsayada($p))->values();

        return view('ensayo_compresion.create', compact('fecha', 'pendientes', 'ensayadas'));
    }

    public function pdfTodas(string $fecha)
    {
        $fecha = Carbon::parse($fecha)->format('Y-m-d');
        $logo  = $this->getLogo();

        $obraIds = DB::table('probetas')
            ->join('remisiones', 'probetas.remision_id', '=', 'remisiones.id')
            ->whereNotNull('probetas.fecha_ensayo')
            ->whereNotNull('probetas.ensayo_por')
            ->whereRaw('DATE_ADD(probetas.fecha_moldeo, INTERVAL probetas.edad_ensayo DAY) = ?', [$fecha])
            ->distinct()
            ->pluck('remisiones.obra_id');

        $obras = Obra::whereIn('id', $obraIds)->orderBy('nombre')->get();

        if ($obras->isEmpty()) {
            return response('No hay probetas ensayadas registradas.', 404)
                ->header('Content-Type', 'text/plain');
        }

        if ($obras->count() === 1) {
            $obra     = $obras->first();
            $probetas = $this->getProbetasEnsayadas($obra->id, $fecha);

            return Pdf::loadView('ensayo_compresion.pdf', compact('obra', 'probetas', 'fecha', 'logo'))
                ->setPaper('a4', 'landscape')
                ->download($this->pdfFilename($obra->nombre, $fecha));
        }

        // Múltiples obras → ZIP con un PDF por obra
        $tmpFile = tempnam(sys_get_temp_dir(), 'lemco_ensayos_');
        $zip     = new \ZipArchive();
        $zip->open($tmpFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($obras as $obra) {
            $probetas   = $this->getProbetasEnsayadas($obra->id, $fecha);
            $pdfContent = Pdf::loadView('ensayo_compresion.pdf', compact('obra', 'probetas', 'fecha', 'logo'))
                ->setPaper('a4', 'landscape')
                ->output();
            $zip->addFromString($this->pdfFilename($obra->nombre, $fecha), $pdfContent);
        }

        $zip->close();

        $fechaFmt = Carbon::parse($fecha)->format('d.m.y');

        return response()->download($tmpFile, "Ensayos fecha {$fechaFmt}.zip", [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }

    public function pdf(string $fecha, Obra $obra)
    {
        $fecha    = Carbon::parse($fecha)->format('Y-m-d');
        $logo     = $this->getLogo();
        $probetas = $this->getProbetasEnsayadas($obra->id, $fecha);

        return Pdf::loadView('ensayo_compresion.pdf', compact('obra', 'probetas', 'fecha', 'logo'))
            ->setPaper('a4', 'landscape')
            ->download($this->pdfFilename($obra->nombre, $fecha));
    }

    private function pdfFilename(string $obraNombre, string $fecha): string
    {
        $fechaFmt = Carbon::parse($fecha)->format('d.m.y');
        return "Obra {$obraNombre} fecha {$fechaFmt}.pdf";
    }

    private function getLogo(): ?string
    {
        $path = storage_path('app/private/logo/logo-web.png');
        return file_exists($path)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($path))
            : null;
    }

    private function getProbetasEnsayadas(int $obraId, string $fecha)
    {
        return Probeta::with(['remision', 'ensayadoPor.persona'])
            ->whereHas('remision', fn($q) => $q->where('obra_id', $obraId))
            ->whereNotNull('fecha_ensayo')
            ->whereNotNull('ensayo_por')
            ->whereRaw('DATE_ADD(fecha_moldeo, INTERVAL edad_ensayo DAY) <= ?', [$fecha])
            ->orderByRaw('DATE_ADD(fecha_moldeo, INTERVAL edad_ensayo DAY), id')
            ->get();
    }

    public function store(Request $request, Probeta $probeta): JsonResponse
    {
        if ($probeta->detalles()->exists()) {
            return response()->json(['message' => 'La probeta ya pertenece a un informe y no se puede editar.'], 403);
        }

        $validated = $request->validate([
            'defecto'             => ['nullable', 'string', 'max:255'],
            'carga_rotura'        => ['nullable', 'numeric', 'min:0'],
            'tipo_rotura'         => ['nullable', 'integer', 'between:1,6'],
            'diametro_superior_1' => ['nullable', 'numeric', 'min:0'],
            'diametro_superior_2' => ['nullable', 'numeric', 'min:0'],
            'diametro_inferior_1' => ['nullable', 'numeric', 'min:0'],
            'diametro_inferior_2' => ['nullable', 'numeric', 'min:0'],
            'altura_1'            => ['nullable', 'numeric', 'min:0'],
            'altura_2'            => ['nullable', 'numeric', 'min:0'],
            'altura_3'            => ['nullable', 'numeric', 'min:0'],
        ]);

        $campos = [
            'defecto',
            'carga_rotura', 'tipo_rotura',
            'diametro_superior_1', 'diametro_superior_2',
            'diametro_inferior_1', 'diametro_inferior_2',
            'altura_1', 'altura_2', 'altura_3',
        ];

        $completa = collect($campos)->every(fn($c) => ($validated[$c] ?? null) !== null);

        if ($completa) {
            if ($probeta->fecha_ensayo === null) {
                $validated['fecha_ensayo'] = now()->toDateString();
                $validated['ensayo_por']   = session('usuario.id');
            }
        } else {
            $validated['fecha_ensayo'] = null;
            $validated['ensayo_por']   = null;
        }

        $probeta->update($validated);

        return response()->json(['ok' => true]);
    }

    private function estaEnsayada(Probeta $probeta): bool
    {
        if ($probeta->fecha_ensayo === null || $probeta->ensayo_por === null) {
            return false;
        }

        return $probeta->defecto              !== null
            && $probeta->carga_rotura        !== null
            && $probeta->tipo_rotura         !== null
            && $probeta->diametro_superior_1 !== null
            && $probeta->diametro_superior_2 !== null
            && $probeta->diametro_inferior_1 !== null
            && $probeta->diametro_inferior_2 !== null
            && $probeta->altura_1            !== null
            && $probeta->altura_2            !== null
            && $probeta->altura_3            !== null;
    }
}
