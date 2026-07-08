<?php

namespace App\Http\Controllers;

use App\Models\DetalleRetiro;
use App\Models\Equipo;
use App\Models\FuncionarioRetiro;
use App\Models\ObraRetiro;
use App\Models\Retiro;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ControlEquipoController extends Controller
{
    public function index(): View
    {
        return view('control_equipo.index');
    }

    public function retiro(): View
    {
        $obras = ObraRetiro::orderBy('descripcion')->get();
        $funcionarios = FuncionarioRetiro::orderBy('descripcion')->get();

        return view('control_equipo.retiro', compact('obras', 'funcionarios'));
    }

    public function storeRetiro(Request $request): JsonResponse
    {
        $request->validate([
            'obra'         => 'required|string|max:150',
            'retirado_por' => 'required|string|max:150',
            'equipos'      => 'required|array|min:1',
            'equipos.*'    => 'integer|exists:equipos,id',
        ], [
            'obra.required'         => 'La obra es obligatoria.',
            'retirado_por.required' => 'El campo "retirado por" es obligatorio.',
            'equipos.required'      => 'Debe agregar al menos un equipo a la lista.',
            'equipos.min'           => 'Debe agregar al menos un equipo a la lista.',
        ]);

        $equiposPendientes = DetalleRetiro::whereIn('equipo_id', $request->equipos)
            ->whereNull('fecha_devolucion')
            ->pluck('equipo_id')
            ->unique();

        if ($equiposPendientes->isNotEmpty()) {
            $nombres = Equipo::whereIn('id', $equiposPendientes)->pluck('abreviacion')->implode(', ');

            throw ValidationException::withMessages([
                'equipos' => "Los siguientes equipos ya tienen un retiro pendiente de devolución: {$nombres}",
            ]);
        }

        $obra = ObraRetiro::firstOrCreate(['descripcion' => trim($request->obra)]);
        $funcionario = FuncionarioRetiro::firstOrCreate(['descripcion' => trim($request->retirado_por)]);

        $retiro = Retiro::create([
            'obra_retiro_id'        => $obra->id,
            'funcionario_retiro_id' => $funcionario->id,
            'usuario_id'            => session('usuario.id'),
            'fecha_retiro'          => now(),
        ]);

        foreach ($request->equipos as $equipoId) {
            $retiro->detalles()->create([
                'equipo_id'    => $equipoId,
                'fecha_retiro' => now(),
            ]);
        }

        session()->flash('success', 'Retiro registrado correctamente.');

        return response()->json(['message' => 'Retiro registrado correctamente.']);
    }

    public function devolucion(): View
    {
        return view('control_equipo.devoluacion');
    }

    public function storeDevolucion(Request $request): JsonResponse
    {
        $request->validate([
            'detalles'   => 'required|array|min:1',
            'detalles.*' => 'integer|exists:detalle_retiros,id',
        ], [
            'detalles.required' => 'Debe agregar al menos un equipo a la lista.',
            'detalles.min'      => 'Debe agregar al menos un equipo a la lista.',
        ]);

        $detalles = DetalleRetiro::whereIn('id', $request->detalles)->get();

        if ($detalles->whereNotNull('fecha_devolucion')->isNotEmpty()) {
            throw ValidationException::withMessages([
                'detalles' => 'Algunos equipos de la lista ya tienen la devolución registrada. Volvé a escanearlos.',
            ]);
        }

        DetalleRetiro::whereIn('id', $request->detalles)->update(['fecha_devolucion' => now()]);

        $retiroIds = $detalles->pluck('retiro_id')->unique();
        foreach (Retiro::whereIn('id', $retiroIds)->get() as $retiro) {
            $tienePendientes = $retiro->detalles()->whereNull('fecha_devolucion')->exists();
            if (! $tienePendientes) {
                $retiro->update(['fecha_devolucion' => now()]);
            }
        }

        session()->flash('success', 'Devolución registrada correctamente.');

        return response()->json(['message' => 'Devolución registrada correctamente.']);
    }

    public function registros(): View
    {
        $retiros = Retiro::with(['obraRetiro', 'funcionarioRetiro', 'detalles.equipo.marca'])
            ->orderByDesc('id')
            ->get();

        return view('control_equipo.registros', compact('retiros'));
    }
}
