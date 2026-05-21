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
            [
                'nombre'    => 'required|string|max:150',
                'residente' => 'nullable|string|max:150',
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max'      => 'El nombre no puede superar los 150 caracteres.',
                'residente.max'   => 'El residente no puede superar los 150 caracteres.',
            ]
        );

        $obra->update([
            'nombre'    => $request->nombre,
            'residente' => $request->residente ?: null,
        ]);

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

    private function siguienteClave(): string
    {
        $ultima = Obra::orderBy('clave', 'desc')->value('clave');

        if (!$ultima) {
            return 'AAA';
        }

        $chars = str_split($ultima);

        for ($i = 2; $i >= 0; $i--) {
            if ($chars[$i] < 'Z') {
                $chars[$i] = chr(ord($chars[$i]) + 1);
                return implode('', $chars);
            }
            $chars[$i] = 'A';
        }

        // Si se superan ZZZ (17576 obras) se lanza excepción
        throw new \OverflowException('Se agotaron las claves disponibles (ZZZ).');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'nombre'    => 'required|string|max:150',
                'residente' => 'nullable|string|max:150',
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max'      => 'El nombre no puede superar los 150 caracteres.',
                'residente.max'   => 'El residente no puede superar los 150 caracteres.',
            ]
        );

        Obra::create([
            'nombre'     => $request->nombre,
            'clave'      => $this->siguienteClave(),
            'residente'  => $request->residente ?: null,
            'estado'     => 1,
            'usuario_id' => session('usuario.id'),
        ]);

        return back()->with('success', 'Obra creada correctamente.');
    }
}
