<?php

namespace App\Http\Controllers;

use App\Models\CertificadoDetalle;
use App\Models\Obra;
use App\Models\Probeta;
use App\Models\ProbetaInforme;
use App\Models\Remision;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class PendienteController extends Controller
{
    public function index(): View
    {
        $ensayosPendientes = $this->ensayosPendientes();
        $informesPendientes = $this->informesPendientes();
        $certificadosPendientes = $this->certificadosPendientes();

        return view('pendiente.index', compact('ensayosPendientes', 'informesPendientes', 'certificadosPendientes'));
    }

    private function ensayosPendientes()
    {
        $hoy = now()->format('Y-m-d');

        $probetas = Probeta::whereHas('remision', fn($q) => $q->where('estado', 1))->get();

        $ensayosPorFecha = [];
        foreach ($probetas as $probeta) {
            if ($this->estaEnsayada($probeta)) {
                continue;
            }

            $fecha = Carbon::parse($probeta->fecha_moldeo)
                ->addDays($probeta->edad_ensayo)
                ->format('Y-m-d');

            if ($fecha > $hoy) {
                continue;
            }

            $ensayosPorFecha[$fecha] = ($ensayosPorFecha[$fecha] ?? 0) + 1;
        }

        ksort($ensayosPorFecha);

        return collect($ensayosPorFecha)->map(fn($cantidad, $fecha) => [
            'fecha'    => $fecha,
            'cantidad' => $cantidad,
        ])->values();
    }

    private function informesPendientes()
    {
        $probetas = Probeta::whereDoesntHave('detalles')
            ->where(fn($q) => $this->scopeEnsayada($q))
            ->whereHas('remision', fn($q) => $q->where('estado', 1))
            ->with('remision.obra')
            ->get();

        return $probetas
            ->groupBy(fn($p) => $p->remision->obra_id)
            ->map(fn($grupo) => [
                'obra'     => $grupo->first()->remision->obra,
                'cantidad' => $grupo->count(),
            ])
            ->filter(fn($item) => $item['obra'] !== null)
            ->sortBy(fn($item) => $item['obra']->nombre)
            ->values();
    }

    private function certificadosPendientes()
    {
        $obras = Obra::where('estado', 1)->get();

        $resultado = collect();

        foreach ($obras as $obra) {
            $remisionesUsadas = CertificadoDetalle::whereNotNull('remision_id')
                ->whereHas('certificado', fn($q) => $q->where('obra_id', $obra->id))
                ->pluck('remision_id');

            $informesUsados = CertificadoDetalle::whereNotNull('informe_id')
                ->whereHas('certificado', fn($q) => $q->where('obra_id', $obra->id))
                ->pluck('informe_id');

            if ($obra->tipo_certificacion === 1) {
                $cantidad = Remision::where('obra_id', $obra->id)
                    ->whereNotIn('id', $remisionesUsadas)
                    ->withCount('probetas')
                    ->get()
                    ->sum('probetas_count');
            } else {
                $cantidad = ProbetaInforme::where('obra_id', $obra->id)
                    ->where('verificado', 1)
                    ->whereNotIn('id', $informesUsados)
                    ->withCount('detalles')
                    ->get()
                    ->sum('detalles_count');
            }

            if ($cantidad > 0) {
                $resultado->push(['obra' => $obra, 'cantidad' => $cantidad]);
            }
        }

        return $resultado->sortBy(fn($item) => $item['obra']->nombre)->values();
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

    private function scopeEnsayada(Builder $q): void
    {
        $q->whereNotNull('fecha_ensayo')
          ->whereNotNull('ensayo_por')
          ->whereNotNull('defecto')
          ->whereNotNull('carga_rotura')
          ->whereNotNull('tipo_rotura')
          ->whereNotNull('diametro_superior_1')
          ->whereNotNull('diametro_superior_2')
          ->whereNotNull('diametro_inferior_1')
          ->whereNotNull('diametro_inferior_2')
          ->whereNotNull('altura_1')
          ->whereNotNull('altura_2')
          ->whereNotNull('altura_3');
    }
}
