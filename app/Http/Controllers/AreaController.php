<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function index(): View
    {
        $areas = Area::orderBy('descripcion')->get();
        return view('areas.index', compact('areas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'descripcion' => 'required|string|max:100|unique:areas,descripcion',
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.unique'   => 'Ya existe un área con ese nombre.',
            'descripcion.max'      => 'La descripción no puede superar los 100 caracteres.',
        ]);

        Area::create(['descripcion' => $request->descripcion, 'estado' => 1]);

        return back()->with('success', 'Área creada correctamente.');
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $request->validate([
            'descripcion' => 'required|string|max:100|unique:areas,descripcion,' . $area->id,
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.unique'   => 'Ya existe un área con ese nombre.',
            'descripcion.max'      => 'La descripción no puede superar los 100 caracteres.',
        ]);

        $area->update(['descripcion' => $request->descripcion]);

        return back()->with('success', 'Área actualizada correctamente.');
    }

    public function toggleEstado(Area $area): RedirectResponse
    {
        $area->update(['estado' => $area->estado === 1 ? 2 : 1]);
        $mensaje = $area->estado === 1 ? 'Área activada correctamente.' : 'Área anulada correctamente.';

        return back()->with('success', $mensaje);
    }
}
