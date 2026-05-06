<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    public function handle(Request $request, Closure $next, string $modulo, string $tipo = 'ver'): Response
    {
        $permisos = session('permisos', []);
        $clave    = strtolower($modulo);

        if (! ($permisos[$clave][$tipo] ?? false)) {
            return redirect()->route('menu.index')
                ->with('error', 'No tenés permiso para realizar esa acción.');
        }

        return $next($request);
    }
}
