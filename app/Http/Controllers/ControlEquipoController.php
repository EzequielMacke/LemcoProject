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
            'obra'                => 'required|string|max:150',
            'retirado_por'        => 'required|string|max:150',
            'equipos'             => 'required|array|min:1',
            'equipos.*.id'        => 'integer|exists:equipos,id',
            'equipos.*.cantidad'  => 'nullable|integer|min:1',
        ], [
            'obra.required'         => 'La obra es obligatoria.',
            'retirado_por.required' => 'El campo "retirado por" es obligatorio.',
            'equipos.required'      => 'Debe agregar al menos un equipo a la lista.',
            'equipos.min'           => 'Debe agregar al menos un equipo a la lista.',
        ]);

        $equiposSolicitados = collect($request->equipos)->keyBy('id');
        $equipos = Equipo::whereIn('id', $equiposSolicitados->keys())->get()->keyBy('id');

        $errores = [];

        foreach ($equiposSolicitados as $equipoId => $item) {
            $equipo = $equipos->get($equipoId);
            if (! $equipo) {
                continue;
            }

            $cantidadSolicitada = $item['cantidad'] ?? 1;

            if ((int) $equipo->tipo_equipo_id === 2) {
                $existencia = $equipo->inventarios()->sum('cantidad');
                $retirado = DetalleRetiro::where('equipo_id', $equipoId)
                    ->whereNull('fecha_devolucion')
                    ->sum('cantidad_retirada');
                $disponible = max(0, $existencia - $retirado);

                if ($cantidadSolicitada > $disponible) {
                    $errores[] = "{$equipo->abreviacion} (disponible: {$disponible})";
                }
            } else {
                $tienePendiente = DetalleRetiro::where('equipo_id', $equipoId)
                    ->whereNull('fecha_devolucion')
                    ->exists();

                if ($tienePendiente) {
                    $errores[] = $equipo->abreviacion;
                }
            }
        }

        if (! empty($errores)) {
            $nombres = implode(', ', $errores);

            throw ValidationException::withMessages([
                'equipos' => "Los siguientes equipos no tienen disponibilidad suficiente o tienen un retiro pendiente de devolución: {$nombres}",
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

        foreach ($request->equipos as $equipo) {
            $retiro->detalles()->create([
                'equipo_id'         => $equipo['id'],
                'fecha_retiro'      => now(),
                'cantidad_retirada' => $equipo['cantidad'] ?? 1,
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
            'detalles'                     => 'required|array|min:1',
            'detalles.*.detalle_retiro_id' => 'integer|exists:detalle_retiros,id',
            'detalles.*.cantidad'          => 'integer|min:1',
        ], [
            'detalles.required' => 'Debe agregar al menos un equipo a la lista.',
            'detalles.min'      => 'Debe agregar al menos un equipo a la lista.',
        ]);

        $items = collect($request->detalles)->keyBy('detalle_retiro_id');
        $detalles = DetalleRetiro::whereIn('id', $items->keys())->get()->keyBy('id');

        if ($detalles->whereNotNull('fecha_devolucion')->isNotEmpty()) {
            throw ValidationException::withMessages([
                'detalles' => 'Algunos equipos de la lista ya tienen la devolución registrada. Volvé a escanearlos.',
            ]);
        }

        $errores = [];
        foreach ($items as $detalleId => $item) {
            $detalle = $detalles->get($detalleId);
            if (! $detalle) {
                continue;
            }

            $cantidadRetirada = $detalle->cantidad_retirada ?? 1;
            $cantidadDevueltaActual = $detalle->cantidad_devuelta ?? 0;
            $pendiente = $cantidadRetirada - $cantidadDevueltaActual;

            if ($item['cantidad'] > $pendiente) {
                $errores[] = "Detalle #{$detalle->id}: la cantidad supera lo pendiente de devolución ({$pendiente}).";
            }
        }

        if (! empty($errores)) {
            throw ValidationException::withMessages(['detalles' => implode(' ', $errores)]);
        }

        foreach ($items as $detalleId => $item) {
            $detalle = $detalles->get($detalleId);
            if (! $detalle) {
                continue;
            }

            $cantidadRetirada = $detalle->cantidad_retirada ?? 1;
            $nuevaCantidadDevuelta = ($detalle->cantidad_devuelta ?? 0) + $item['cantidad'];
            $completo = $nuevaCantidadDevuelta >= $cantidadRetirada;

            $detalle->update([
                'cantidad_devuelta' => $nuevaCantidadDevuelta,
                'fecha_devolucion'  => $completo ? now() : null,
            ]);
        }

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
