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
            ->get()
            ->keyBy('equipo_id');

        $inventarios->each(function (Inventario $inventario) use ($detallesPendientes) {
            $detalle = $detallesPendientes->get($inventario->equipo_id);

            $inventario->cantidad_disponible = $detalle ? 0 : $inventario->cantidad;
            $inventario->retiro_info = $detalle ? [
                'obra'         => $detalle->retiro?->obraRetiro?->descripcion,
                'retirado_por' => $detalle->retiro?->funcionarioRetiro?->descripcion,
                'fecha_retiro' => optional($detalle->fecha_retiro)->format('d/m/Y'),
            ] : null;
        });

        $marcas = Marca::orderBy('descripcion')->get();
        $categorias = Categoria::orderBy('descripcion')->get();
        $tiposEquipo = TipoEquipo::orderBy('id')->get();

        return view('inventario.index', compact('inventarios', 'marcas', 'categorias', 'tiposEquipo'));
    }
}
