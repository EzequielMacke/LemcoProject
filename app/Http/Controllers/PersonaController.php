<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonaController extends Controller
{
    public function index(): View
    {
        $usuario = Usuario::find(session('usuario.id'));
        $persona = $usuario->persona_id ? Persona::find($usuario->persona_id) : null;

        return view('datos_personales.datos', compact('persona'));
    }

    public function save(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre'           => 'nullable|string|max:100',
            'apellido'         => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'correo'           => 'nullable|email|max:150',
            'ci'               => 'nullable|string|max:20',
            'cargo'            => 'nullable|string|max:100',
            'titulo'           => 'nullable|string|max:100',
        ]);

        $usuario = Usuario::find(session('usuario.id'));

        if ($usuario->persona_id) {
            Persona::find($usuario->persona_id)->update($data);
        } else {
            $persona = Persona::create($data);
            $usuario->update(['persona_id' => $persona->id]);
        }

        return back()->with('success', 'Datos guardados correctamente.');
    }
}
