<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Obra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactoController extends Controller
{
    public function index(Obra $obra): View
    {
        $contactos = Contacto::where('obra_id', $obra->id)
            ->with('usuario')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        $permsCon      = session('permisos', [])['con'] ?? [];
        $puedeAgregar  = $permsCon['agregar']  ?? false;
        $puedeEditar   = $permsCon['editar']   ?? false;
        $puedeEliminar = $permsCon['eliminar'] ?? false;

        $obrasDisponibles = Obra::where('estado', 1)
            ->where('id', '!=', $obra->id)
            ->orderBy('nombre')
            ->get();

        return view('contactos.index', compact(
            'obra', 'contactos', 'puedeAgregar', 'puedeEditar', 'puedeEliminar', 'obrasDisponibles'
        ));
    }

    public function store(Request $request, Obra $obra): RedirectResponse
    {
        $request->validate(
            [
                'nombre'   => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'correo'   => 'required|email|max:150',
            ],
            [
                'nombre.required'   => 'El nombre es obligatorio.',
                'nombre.max'        => 'El nombre no puede superar los 100 caracteres.',
                'apellido.required' => 'El apellido es obligatorio.',
                'apellido.max'      => 'El apellido no puede superar los 100 caracteres.',
                'correo.required'   => 'El correo es obligatorio.',
                'correo.email'      => 'El correo debe ser una dirección válida.',
                'correo.max'        => 'El correo no puede superar los 150 caracteres.',
            ]
        );

        Contacto::create([
            'nombre'     => $request->nombre,
            'apellido'   => $request->apellido,
            'correo'     => $request->correo,
            'estado'     => 1,
            'usuario_id' => session('usuario.id'),
            'obra_id'    => $obra->id,
        ]);

        return back()->with('success', 'Contacto agregado correctamente.');
    }

    public function update(Request $request, Obra $obra, Contacto $contacto): RedirectResponse
    {
        $request->validate(
            [
                'nombre'   => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'correo'   => 'required|email|max:150',
            ],
            [
                'nombre.required'   => 'El nombre es obligatorio.',
                'nombre.max'        => 'El nombre no puede superar los 100 caracteres.',
                'apellido.required' => 'El apellido es obligatorio.',
                'apellido.max'      => 'El apellido no puede superar los 100 caracteres.',
                'correo.required'   => 'El correo es obligatorio.',
                'correo.email'      => 'El correo debe ser una dirección válida.',
                'correo.max'        => 'El correo no puede superar los 150 caracteres.',
            ]
        );

        $contacto->update([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'correo'   => $request->correo,
        ]);

        return back()->with('success', 'Contacto actualizado correctamente.');
    }

    public function anular(Obra $obra, Contacto $contacto): RedirectResponse
    {
        $contacto->update(['estado' => 2]);

        return back()->with('success', "El contacto {$contacto->nombre} {$contacto->apellido} fue anulado.");
    }

    public function activar(Obra $obra, Contacto $contacto): RedirectResponse
    {
        $contacto->update(['estado' => 1]);

        return back()->with('success', "El contacto {$contacto->nombre} {$contacto->apellido} fue activado.");
    }

    public function copiar(Request $request, Obra $obra, Contacto $contacto): RedirectResponse
    {
        $request->validate(
            ['obra_destino_id' => ['required', 'exists:obras,id', Rule::notIn([$obra->id])]],
            ['obra_destino_id.required' => 'Seleccioná una obra destino.',
             'obra_destino_id.exists'   => 'La obra seleccionada no existe.',
             'obra_destino_id.not_in'   => 'El contacto ya pertenece a esta obra.']
        );

        $destino = Obra::find($request->obra_destino_id);

        Contacto::create([
            'nombre'     => $contacto->nombre,
            'apellido'   => $contacto->apellido,
            'correo'     => $contacto->correo,
            'estado'     => 1,
            'usuario_id' => session('usuario.id'),
            'obra_id'    => $destino->id,
        ]);

        return back()->with('success', "Contacto copiado a «{$destino->nombre}» correctamente.");
    }
}
