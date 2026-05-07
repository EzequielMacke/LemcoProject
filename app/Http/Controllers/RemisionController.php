<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Probeta;
use App\Models\Remision;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RemisionController extends Controller
{
    public function show(Obra $obra, Remision $remision): View
    {
        $remision->load(['recibidoPor.persona', 'probetas']);
        return view('recepcion_probetas.show', compact('obra', 'remision'));
    }

    public function pdf(Obra $obra, Remision $remision): Response
    {
        $remision->load(['recibidoPor.persona', 'probetas']);

        $logoPath = storage_path('app/private/logo/logo-web.png');
        $logo = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $pdf = Pdf::loadView('recepcion_probetas.pdf', compact('obra', 'remision', 'logo'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Obra {$obra->nombre} Remision Nro {$remision->nro}.pdf");
    }

    public function create(Obra $obra): View
    {
        $ultima = Remision::where('estado', 1)->orderByDesc('nro')->value('nro');
        $proximoNro = $ultima
            ? str_pad((int) $ultima + 1, 7, '0', STR_PAD_LEFT)
            : '0000001';

        return view('recepcion_probetas.create', compact('obra', 'proximoNro'));
    }

    public function store(Request $request, Obra $obra): RedirectResponse
    {
        $data = $request->validate([
            'nro'                               => 'required|string|max:7',
            'contratista'                       => 'required|string|max:255',
            'entregado_por'                     => 'required|string|max:255',
            'observacion'                       => 'nullable|string',
            'grupos'                            => 'required|array|min:1',
            'grupos.*.mixer'                    => 'required|string|max:255',
            'grupos.*.cant'                     => 'required|integer|min:1|max:26',
            'grupos.*.concretera'               => 'required|string|max:255',
            'grupos.*.fck'                      => 'required|integer|min:1',
            'grupos.*.elemento'                 => 'required|string|max:255',
            'grupos.*.fecha_moldeo'             => 'required|date',
            'grupos.*.hora_moldeo'              => 'required|date_format:H:i',
            'grupos.*.muestras'                 => 'required|array',
            'grupos.*.muestras.*.edad_ensayo'   => 'required|integer|min:1',
        ]);

        $remision = Remision::create([
            'nro'           => $data['nro'],
            'obra_id'       => $obra->id,
            'contratista'   => $data['contratista'],
            'entregado_por' => $data['entregado_por'],
            'observacion'   => $data['observacion'] ?? null,
            'estado'        => 1,
            'recibio_por'   => session('usuario.id'),
        ]);

        foreach ($data['grupos'] as $grupo) {
            $cant = (int) $grupo['cant'];
            for ($i = 0; $i < $cant; $i++) {
                $letra = chr(65 + $i);
                Probeta::create([
                    'remision_id'  => $remision->id,
                    'mixer'        => $grupo['mixer'],
                    'concretera'   => $grupo['concretera'],
                    'fck'          => $grupo['fck'],
                    'elemento'     => $grupo['elemento'],
                    'fecha_moldeo' => $grupo['fecha_moldeo'],
                    'hora_moldeo'  => $grupo['hora_moldeo'],
                    'edad_ensayo'  => $grupo['muestras'][$i]['edad_ensayo'],
                    'nombre'       => $grupo['mixer'] . '-' . $letra,
                    'estado'       => 1,
                ]);
            }
        }

        return redirect()
            ->route('remisiones.index', $obra)
            ->with('success', "Remisión «{$remision->nro}» creada con éxito.");
    }

    public function edit(Obra $obra, Remision $remision): View
    {
        $grupos = $remision->probetas()
            ->orderBy('nombre')
            ->get()
            ->groupBy(fn($p) => preg_replace('/-[A-Z]$/', '', $p->nombre))
            ->map(fn($muestras) => [
                'mixer'        => $muestras->first()->mixer,
                'concretera'   => $muestras->first()->concretera,
                'fck'          => $muestras->first()->fck,
                'elemento'     => $muestras->first()->elemento,
                'fecha_moldeo' => $muestras->first()->fecha_moldeo->format('Y-m-d'),
                'hora_moldeo'  => substr($muestras->first()->hora_moldeo, 0, 5),
                'muestras'     => $muestras->map(fn($p) => ['edad_ensayo' => $p->edad_ensayo])->values(),
            ])
            ->values();

        return view('recepcion_probetas.edit', compact('obra', 'remision', 'grupos'));
    }

    public function update(Request $request, Obra $obra, Remision $remision): RedirectResponse
    {
        $data = $request->validate([
            'nro'                               => 'required|string|max:7',
            'contratista'                       => 'required|string|max:255',
            'entregado_por'                     => 'required|string|max:255',
            'observacion'                       => 'nullable|string',
            'grupos'                            => 'required|array|min:1',
            'grupos.*.mixer'                    => 'required|string|max:255',
            'grupos.*.cant'                     => 'required|integer|min:1|max:26',
            'grupos.*.concretera'               => 'required|string|max:255',
            'grupos.*.fck'                      => 'required|integer|min:1',
            'grupos.*.elemento'                 => 'required|string|max:255',
            'grupos.*.fecha_moldeo'             => 'required|date',
            'grupos.*.hora_moldeo'              => 'required|date_format:H:i',
            'grupos.*.muestras'                 => 'required|array',
            'grupos.*.muestras.*.edad_ensayo'   => 'required|integer|min:1',
        ]);

        $remision->update([
            'nro'           => $data['nro'],
            'contratista'   => $data['contratista'],
            'entregado_por' => $data['entregado_por'],
            'observacion'   => $data['observacion'] ?? null,
        ]);

        $remision->probetas()->delete();

        foreach ($data['grupos'] as $grupo) {
            $cant = (int) $grupo['cant'];
            for ($i = 0; $i < $cant; $i++) {
                $letra = chr(65 + $i);
                Probeta::create([
                    'remision_id'  => $remision->id,
                    'mixer'        => $grupo['mixer'],
                    'concretera'   => $grupo['concretera'],
                    'fck'          => $grupo['fck'],
                    'elemento'     => $grupo['elemento'],
                    'fecha_moldeo' => $grupo['fecha_moldeo'],
                    'hora_moldeo'  => $grupo['hora_moldeo'],
                    'edad_ensayo'  => $grupo['muestras'][$i]['edad_ensayo'],
                    'nombre'       => $grupo['mixer'] . '-' . $letra,
                    'estado'       => 1,
                ]);
            }
        }

        return redirect()
            ->route('remisiones.index', $obra)
            ->with('success', "Remisión «{$remision->nro}» actualizada.");
    }

    public function index(Obra $obra): View
    {
        $remisiones = Remision::where('obra_id', $obra->id)
            ->with(['recibidoPor.persona'])
            ->withCount('probetas')
            ->orderByDesc('id')
            ->get();

        $permsRpb      = session('permisos', [])['rpb'] ?? [];
        $puedeAgregar  = $permsRpb['agregar']  ?? false;
        $puedeEditar   = $permsRpb['editar']   ?? false;
        $puedeEliminar = $permsRpb['eliminar'] ?? false;

        $activas  = $remisiones->where('estado', 1)->count();
        $anuladas = $remisiones->where('estado', 2)->count();

        return view('recepcion_probetas.index', compact(
            'obra', 'remisiones', 'puedeAgregar', 'puedeEditar', 'puedeEliminar', 'activas', 'anuladas'
        ));
    }

    public function anular(Obra $obra, Remision $remision): RedirectResponse
    {
        $remision->update(['estado' => 2]);

        return back()->with('success', "La remisión «{$remision->nro}» fue anulada.");
    }

    public function activar(Obra $obra, Remision $remision): RedirectResponse
    {
        $remision->update(['estado' => 1]);

        return back()->with('success', "La remisión «{$remision->nro}» fue activada.");
    }
}
