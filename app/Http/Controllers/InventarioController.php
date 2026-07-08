<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
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

        $marcas = Marca::orderBy('descripcion')->get();
        $categorias = Categoria::orderBy('descripcion')->get();
        $tiposEquipo = TipoEquipo::orderBy('id')->get();

        return view('inventario.index', compact('inventarios', 'marcas', 'categorias', 'tiposEquipo'));
    }
}
