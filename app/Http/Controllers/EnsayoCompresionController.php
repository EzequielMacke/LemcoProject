<?php

namespace App\Http\Controllers;

use App\Models\Probeta;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        )->get();

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

        $probetas = Probeta::with('remision.obra')
            ->whereRaw(
                'DATE_ADD(fecha_moldeo, INTERVAL edad_ensayo DAY) = ?',
                [$fecha]
            )
            ->get();

        $pendientes = $probetas->filter(fn($p) => !$this->estaEnsayada($p))->values();
        $ensayadas  = $probetas->filter(fn($p) =>  $this->estaEnsayada($p))->values();

        return view('ensayo_compresion.create', compact('fecha', 'pendientes', 'ensayadas'));
    }

    public function store(Request $request, Probeta $probeta): JsonResponse
    {
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

        $validated['fecha_ensayo'] = now()->toDateString();
        $validated['ensayo_por']   = session('usuario.id');

        $probeta->update($validated);

        return response()->json(['ok' => true]);
    }

    private function estaEnsayada(Probeta $probeta): bool
    {
        return $probeta->fecha_ensayo        !== null
            && $probeta->carga_rotura        !== null
            && $probeta->tipo_rotura         !== null
            && $probeta->diametro_superior_1 !== null
            && $probeta->diametro_superior_2 !== null
            && $probeta->diametro_inferior_1 !== null
            && $probeta->diametro_inferior_2 !== null
            && $probeta->altura_1            !== null
            && $probeta->altura_2            !== null
            && $probeta->altura_3            !== null
            && $probeta->ensayo_por          !== null;
    }
}
