<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\RemisionController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\Autenticado;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Autenticación
Route::get('/login',  [UsuarioController::class, 'loginForm'])->name('login');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.post');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

// Registro de usuario (público)
Route::get('/usuarios/crear',           [UsuarioController::class, 'createForm'])->name('usuarios.create');
Route::post('/usuarios/crear',          [UsuarioController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/nick-disponible', [UsuarioController::class, 'nickDisponible'])->name('usuarios.nickDisponible');

// App (requiere sesión)
Route::middleware(Autenticado::class)->group(function () {

    Route::get('/menu', function () {
        $campos = ['nombre', 'apellido', 'fecha_nacimiento', 'correo', 'ci', 'cargo', 'titulo'];
        $usuario = Usuario::find(session('usuario.id'));
        $persona = $usuario->persona_id ? Persona::find($usuario->persona_id) : null;
        $datosFaltantes = collect($campos)->filter(fn($c) => blank($persona?->$c))->count();
        return view('menu.index', compact('datosFaltantes'));
    })->name('menu.index');

    Route::middleware('permiso:DAT')->group(function () {
        Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index');
    });
    Route::middleware('permiso:DAT,editar')->group(function () {
        Route::post('/personas', [PersonaController::class, 'save'])->name('personas.save');
    });

    Route::middleware('permiso:ARE')->group(function () {
        Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
    });
    Route::middleware('permiso:ARE,agregar')->group(function () {
        Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
    });
    Route::middleware('permiso:ARE,editar')->group(function () {
        Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');
    });
    Route::middleware('permiso:ARE,eliminar')->group(function () {
        Route::patch('/areas/{area}/estado', [AreaController::class, 'toggleEstado'])->name('areas.toggleEstado');
    });

    Route::middleware('permiso:PER')->group(function () {
        Route::get('/permisos', [PermisoController::class, 'index'])->name('permisos.index');
    });
    Route::middleware('permiso:PER,editar')->group(function () {
        Route::get('/permisos/{area}/editar',  [PermisoController::class, 'edit'])->name('permisos.edit');
        Route::post('/permisos/{area}',        [PermisoController::class, 'update'])->name('permisos.update');
    });

    Route::middleware('permiso:USU')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    });
    Route::middleware('permiso:USU,eliminar')->group(function () {
        Route::patch('/usuarios/{usuario}/inactivar', [UsuarioController::class, 'inactivar'])->name('usuarios.inactivar');
        Route::patch('/usuarios/{usuario}/activar',   [UsuarioController::class, 'activar'])->name('usuarios.activar');
    });
    Route::middleware('permiso:USU,editar')->group(function () {
        Route::patch('/usuarios/{usuario}/area',  [UsuarioController::class, 'asignarArea'])->name('usuarios.asignarArea');
        Route::patch('/usuarios/{usuario}/envio', [UsuarioController::class, 'toggleEnvio'])->name('usuarios.toggleEnvio');
    });

    Route::middleware('permiso:OBR')->group(function () {
        Route::get('/obras',        [ObraController::class, 'index'])->name('obras.index');
        Route::get('/obras/{obra}', [ObraController::class, 'show'])->name('obras.show');
    });
    Route::middleware('permiso:OBR,agregar')->group(function () {
        Route::post('/obras', [ObraController::class, 'store'])->name('obras.store');
    });
    Route::middleware('permiso:OBR,editar')->group(function () {
        Route::put('/obras/{obra}', [ObraController::class, 'update'])->name('obras.update');
    });
    Route::middleware('permiso:OBR,eliminar')->group(function () {
        Route::patch('/obras/{obra}/inactivar', [ObraController::class, 'inactivarObra'])->name('obras.inactivar');
        Route::patch('/obras/{obra}/activar',   [ObraController::class, 'activarObra'])->name('obras.activar');
    });

    Route::middleware('permiso:CON')->group(function () {
        Route::get('/obras/{obra}/contactos',  [ContactoController::class, 'index'])->name('contactos.index');
    });
    Route::middleware('permiso:CON,agregar')->group(function () {
        Route::post('/obras/{obra}/contactos',                          [ContactoController::class, 'store'])->name('contactos.store');
        Route::post('/obras/{obra}/contactos/{contacto}/copiar',        [ContactoController::class, 'copiar'])->name('contactos.copiar');
    });
    Route::middleware('permiso:CON,editar')->group(function () {
        Route::put('/obras/{obra}/contactos/{contacto}', [ContactoController::class, 'update'])->name('contactos.update');
    });
    Route::middleware('permiso:CON,eliminar')->group(function () {
        Route::patch('/obras/{obra}/contactos/{contacto}/anular',  [ContactoController::class, 'anular'])->name('contactos.anular');
        Route::patch('/obras/{obra}/contactos/{contacto}/activar', [ContactoController::class, 'activar'])->name('contactos.activar');
    });
    Route::middleware('permiso:RPB')->group(function () {
        Route::get('/obras/{obra}/remisiones', [RemisionController::class, 'index'])->name('remisiones.index');
    });
    Route::middleware('permiso:RPB,agregar')->group(function () {
        Route::get('/obras/{obra}/remisiones/create',  [RemisionController::class, 'create'])->name('remisiones.create');
        Route::post('/obras/{obra}/remisiones',        [RemisionController::class, 'store'])->name('remisiones.store');
    });
    Route::middleware('permiso:RPB,editar')->group(function () {
        Route::get('/obras/{obra}/remisiones/{remision}/edit', [RemisionController::class, 'edit'])->name('remisiones.edit');
        Route::put('/obras/{obra}/remisiones/{remision}',      [RemisionController::class, 'update'])->name('remisiones.update');
    });
    Route::middleware('permiso:RPB,eliminar')->group(function () {
        Route::patch('/obras/{obra}/remisiones/{remision}/anular',  [RemisionController::class, 'anular'])->name('remisiones.anular');
        Route::patch('/obras/{obra}/remisiones/{remision}/activar', [RemisionController::class, 'activar'])->name('remisiones.activar');
    });

});
