<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Obra;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReporteController extends Controller
{
    public function index(): View
    {
        return view('reporte.index');
    }

    public function certificadoParametros(): View
    {
        $obras = Obra::orderBy('nombre')->get();

        return view('reporte.certificado_parametros', compact('obras'));
    }

    public function certificadoPdf(Request $request): Response
    {
        $data = $request->validate([
            'obra_id'     => 'nullable|integer|exists:obras,id',
            'mes'         => 'nullable|date_format:Y-m',
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date',
        ]);

        $fechaDesde = $data['fecha_desde'] ?? null;
        $fechaHasta = $data['fecha_hasta'] ?? null;
        $rangoLabel = 'Todas las fechas';

        if (!empty($data['mes'])) {
            $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

            $inicioMes  = Carbon::createFromFormat('Y-m', $data['mes'])->startOfMonth();
            $fechaDesde = $inicioMes->toDateString();
            $fechaHasta = $inicioMes->copy()->endOfMonth()->toDateString();
            $rangoLabel = 'Mes: ' . $meses[$inicioMes->month - 1] . ' de ' . $inicioMes->year;
        } elseif ($fechaDesde && $fechaHasta) {
            $rangoLabel = 'Del ' . Carbon::parse($fechaDesde)->format('d/m/Y') . ' al ' . Carbon::parse($fechaHasta)->format('d/m/Y');
        } elseif ($fechaDesde) {
            $rangoLabel = 'Desde el ' . Carbon::parse($fechaDesde)->format('d/m/Y');
        } elseif ($fechaHasta) {
            $rangoLabel = 'Hasta el ' . Carbon::parse($fechaHasta)->format('d/m/Y');
        }

        $query = Certificado::with([
            'obra',
            'detalles.remision.probetas',
            'detalles.informe.detalles',
        ])->orderBy('obra_id')->orderBy('id');

        if (!empty($data['obra_id'])) {
            $query->where('obra_id', $data['obra_id']);
        }
        if ($fechaDesde) {
            $query->whereDate('created_at', '>=', $fechaDesde);
        }
        if ($fechaHasta) {
            $query->whereDate('created_at', '<=', $fechaHasta);
        }

        $certificados = $query->get();

        $obrasIds = $certificados->pluck('obra_id')->unique();

        // Número correlativo de cada certificado dentro de su obra (histórico completo, no solo el filtrado).
        // Se arma con un array plano en vez de flatMap(): flatMap usa array_merge internamente,
        // que reindexa claves enteras y hacía perder el id del certificado como clave.
        $nrosCertificados = [];
        foreach (
            Certificado::whereIn('obra_id', $obrasIds)
                ->orderBy('obra_id')->orderBy('id')
                ->get(['id', 'obra_id'])
                ->groupBy('obra_id') as $grupoHistorico
        ) {
            foreach ($grupoHistorico->values() as $idx => $cert) {
                $nrosCertificados[$cert->id] = $idx + 1;
            }
        }

        $porObra = $certificados->groupBy('obra_id');

        $filas = $porObra->map(function ($grupo) use ($nrosCertificados) {
            $obra     = $grupo->first()->obra;
            $tipoCert = $obra->tipo_certificacion;

            $items = $grupo->map(function ($certificado) use ($tipoCert, $nrosCertificados) {
                $probetas = 0;
                foreach ($certificado->detalles as $d) {
                    $probetas += $tipoCert === 1
                        ? ($d->remision?->probetas->count() ?? 0)
                        : ($d->informe?->detalles->count() ?? 0);
                }
                $monto = $probetas * $certificado->precio_unitario;

                return [
                    'certificado' => $certificado,
                    'nro'         => $nrosCertificados[$certificado->id] ?? $certificado->id,
                    'probetas'    => $probetas,
                    'monto'       => $monto,
                ];
            })->values();

            return [
                'obra'          => $obra,
                'items'         => $items,
                'totalProbetas' => $items->sum('probetas'),
                'totalMonto'    => $items->sum('monto'),
            ];
        })->values();

        $totalGeneral          = $filas->sum('totalMonto');
        $totalProbetasGeneral  = $filas->sum('totalProbetas');

        $toBase64 = function (string $path): ?string {
            if (!file_exists($path)) return null;
            $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $mime = in_array($ext, ['jpg', 'jpeg']) ? 'jpeg' : 'png';
            return "data:image/{$mime};base64," . base64_encode(file_get_contents($path));
        };

        $logo    = $toBase64(storage_path('app/private/logo/logo-web.png'));
        $firmash = $toBase64(storage_path('app/private/firmash/firmash.png'));

        $pdf = Pdf::loadView('reporte.certificado_pdf', compact(
            'filas', 'totalGeneral', 'totalProbetasGeneral', 'rangoLabel', 'logo', 'firmash'
        ))->setPaper('a4', 'portrait');

        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Reporte de certificados.pdf"',
        ]);
    }
}
