<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Permiso;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function loginForm(): View
    {
        return view('login.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'nick'       => 'required|string',
            'contrasena' => 'required|string',
        ], [
            'nick.required'       => 'El usuario es obligatorio.',
            'contrasena.required' => 'La contraseña es obligatoria.',
        ]);

        $usuario = Usuario::where('nick', $request->nick)->first();

        if (! $usuario || ! Hash::check($request->contrasena, $usuario->contrasena)) {
            return back()
                ->withInput($request->only('nick'))
                ->withErrors(['nick' => 'Usuario o contraseña incorrectos.']);
        }

        if ($usuario->estado !== 1) {
            return back()
                ->withInput($request->only('nick'))
                ->withErrors(['nick' => 'Tu cuenta está desactivada.']);
        }

        $permisos = Permiso::with('modulo')
            ->where('area_id', $usuario->area_id)
            ->get()
            ->mapWithKeys(fn($p) => [
                strtolower($p->modulo->abreviacion) => [
                    'ver'      => $p->ver      === 1,
                    'agregar'  => $p->agregar  === 1,
                    'editar'   => $p->editar   === 1,
                    'eliminar' => $p->eliminar === 1,
                ],
            ])
            ->toArray();

        session()->regenerate();
        session([
            'usuario'  => $usuario->only('id', 'nick', 'estado', 'area_id'),
            'permisos' => $permisos,
        ]);

        return redirect()->route('menu.index');
    }

    public function createForm(): View
    {
        return view('login.create');
    }

    public function nickDisponible(Request $request): \Illuminate\Http\JsonResponse
    {
        $existe = Usuario::where('nick', $request->nick)->exists();
        return response()->json(['disponible' => ! $existe]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nick'       => 'required|string|max:50|unique:usuarios,nick',
            'contrasena' => 'required|string|min:6|confirmed',
        ], [
            'nick.required'        => 'El nick es obligatorio.',
            'nick.unique'          => 'Ese nick ya está en uso.',
            'nick.max'             => 'El nick no puede superar los 50 caracteres.',
            'contrasena.required'  => 'La contraseña es obligatoria.',
            'contrasena.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        Usuario::create([
            'nick'       => $request->nick,
            'contrasena' => $request->contrasena,
            'estado'     => 1,
        ]);

        return back()->with('success', 'Usuario creado correctamente.');
    }

    public function index(): View
    {
        $usuarios = Usuario::with(['area', 'persona'])->orderBy('nick')->get();
        $areas    = Area::where('estado', 1)->orderBy('descripcion')->get();

        return view('usuarios.index', compact('usuarios', 'areas'));
    }

    public function inactivar(Usuario $usuario): RedirectResponse
    {
        if ($usuario->id === session('usuario.id')) {
            return back()->with('error', 'No podés inactivar tu propia cuenta.');
        }

        $usuario->update(['estado' => 2]);

        return back()->with('success', "El usuario «{$usuario->nick}» fue inactivado.");
    }

    public function activar(Usuario $usuario): RedirectResponse
    {
        $usuario->update(['estado' => 1]);

        return back()->with('success', "El usuario «{$usuario->nick}» fue activado.");
    }

    public function toggleEnvio(Usuario $usuario): \Illuminate\Http\JsonResponse
    {
        $nuevoValor = $usuario->envio === 1 ? 0 : 1;

        if ($nuevoValor === 1) {
            if (! $usuario->persona_id) {
                return response()->json(['error' => 'Este usuario no tiene una persona asociada. Por favor, complete primero sus datos personales.'], 422);
            }
            $usuario->loadMissing('persona');
            if (! $usuario->persona || ! $usuario->persona->correo) {
                return response()->json(['error' => 'La persona asociada no tiene un correo electrónico asignado.'], 422);
            }
        }

        $usuario->update(['envio' => $nuevoValor]);

        return response()->json(['envio' => $nuevoValor]);
    }

    public function asignarArea(Request $request, Usuario $usuario): RedirectResponse
    {
        $request->validate(
            ['area_id' => 'required|exists:areas,id'],
            ['area_id.required' => 'Debés seleccionar un área.', 'area_id.exists' => 'El área seleccionada no existe.']
        );

        $usuario->update(['area_id' => $request->area_id]);

        return back()->with('success', "Área del usuario «{$usuario->nick}» actualizada.");
    }

    public function logout(): RedirectResponse
    {
        session()->flush();
        session()->regenerate();

        return redirect()->route('login');
    }
}
