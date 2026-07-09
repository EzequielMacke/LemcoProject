<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetalleRetiro;
use App\Models\Inventario;
use App\Models\Marca;
use App\Models\TipoEquipo;
use Illuminate\View\View;

class InventarioController extends Controller
{
    public function index(): View
    {
        $inventarios = Inventario::with(['equipo.marca', 'equipo.categoria', 'equipo.tipoEquipo'])
            ->whereHas('equipo', fn ($query) => $query->where('estado', 1))
            ->orderByDesc('id')
            ->get();

        $detallesPendientes = DetalleRetiro::whereNull('fecha_devolucion')
            ->with(['retiro.obraRetiro', 'retiro.funcionarioRetiro'])
            ->orderBy('fecha_retiro')
            ->get()
            ->groupBy('equipo_id');

        $inventarios->each(function (Inventario $inventario) use ($detallesPendientes) {
            $detalles = $detallesPendientes->get($inventario->equipo_id, collect());

            $retirosPendientes = $detalles->map(function (DetalleRetiro $detalle) {
                $cantidadRetirada = $detalle->cantidad_retirada ?? 1;
                $cantidadDevuelta = $detalle->cantidad_devuelta ?? 0;

                return [
                    'obra'               => $detalle->retiro?->obraRetiro?->descripcion,
                    'retirado_por'       => $detalle->retiro?->funcionarioRetiro?->descripcion,
                    'fecha_retiro'       => optional($detalle->fecha_retiro)->format('d/m/Y'),
                    'cantidad_retirada'  => $cantidadRetirada,
                    'cantidad_devuelta'  => $cantidadDevuelta,
                    'cantidad_pendiente' => max(0, $cantidadRetirada - $cantidadDevuelta),
                ];
            })->values();

            $inventario->cantidad_disponible = max(0, $inventario->cantidad - $retirosPendientes->sum('cantidad_pendiente'));
            $inventario->retiros_pendientes = $retirosPendientes;
        });

        $marcas = Marca::orderBy('descripcion')->get();
        $categorias = Categoria::orderBy('descripcion')->get();
        $tiposEquipo = TipoEquipo::orderBy('id')->get();

        return view('inventario.index', compact('inventarios', 'marcas', 'categorias', 'tiposEquipo'));
    }
}
