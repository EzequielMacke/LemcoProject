<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ObraController extends Controller
{
    public function index(): View
    {
        $obras = Obra::with('usuario')->orderBy('nombre')->get();

        return view('obras.index', compact('obras'));
    }

    public function show(Obra $obra): View
    {
        $permsObr      = session('permisos', [])['obr'] ?? [];
        $puedeEditar   = $permsObr['editar']   ?? false;
        $puedeEliminar = $permsObr['eliminar'] ?? false;

        return view('obras.show', compact('obra', 'puedeEditar', 'puedeEliminar'));
    }

    public function update(Request $request, Obra $obra): RedirectResponse
    {
        $request->validate(
            ['nombre' => 'required|string|max:150'],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max'      => 'El nombre no puede superar los 150 caracteres.',
            ]
        );

        $obra->update(['nombre' => $request->nombre]);

        return back()->with('success', 'Nombre de la obra actualizado correctamente.');
    }

    public function inactivarObra(Obra $obra): RedirectResponse
    {
        $obra->update(['estado' => 2]);

        return back()->with('success', "La obra «{$obra->nombre}» fue inactivada.");
    }

    public function activarObra(Obra $obra): RedirectResponse
    {
        $obra->update(['estado' => 1]);

        return back()->with('success', "La obra «{$obra->nombre}» fue activada.");
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            ['nombre' => 'required|string|max:150'],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max'      => 'El nombre no puede superar los 150 caracteres.',
            ]
        );

        Obra::create([
            'nombre'     => $request->nombre,
            'estado'     => 1,
            'usuario_id' => session('usuario.id'),
        ]);

        return back()->with('success', 'Obra creada correctamente.');
    }
}
