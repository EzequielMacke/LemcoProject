<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Modulo;
use App\Models\Permiso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermisoController extends Controller
{
    public function index(): View
    {
        $areas = Area::orderBy('id')->get();
        return view('permisos.index', compact('areas'));
    }

    public function edit(Area $area): View
    {
        $modulos  = Modulo::orderBy('id')->get();
        $permisos = Permiso::where('area_id', $area->id)
            ->get()
            ->keyBy('modulo_id');

        return view('permisos.edit', compact('area', 'modulos', 'permisos'));
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $data    = $request->input('permisos', []);
        $modulos = Modulo::all();

        foreach ($modulos as $modulo) {
            $vals = $data[$modulo->id] ?? [];

            Permiso::updateOrCreate(
                ['area_id' => $area->id, 'modulo_id' => $modulo->id],
                [
                    'ver'      => isset($vals['ver'])      ? 1 : 0,
                    'agregar'  => isset($vals['agregar'])  ? 1 : 0,
                    'editar'   => isset($vals['editar'])   ? 1 : 0,
                    'eliminar' => isset($vals['eliminar']) ? 1 : 0,
                ]
            );
        }

        return back()->with('success', 'Permisos actualizados correctamente.');
    }
}
