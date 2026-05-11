<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planilla Ensayo Compresión — {{ $obra->nombre }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #000;
            background: #fff;
            padding: 20px 26px;
        }

        /* ════ CABECERA ════ */
        .cabecera {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            margin-bottom: 0;
        }
        .cabecera td { padding: 8px 12px; vertical-align: middle; }

        .cab-logo {
            width: 20%;
            border-right: 1.5px solid #000;
            text-align: center;
        }
        .cab-logo img { max-height: 52px; max-width: 130px; }

        .cab-titulo {
            width: 58%;
            text-align: center;
            border-right: 1.5px solid #000;
            padding: 10px 12px;
        }
        .cab-titulo .titulo-main {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.4;
        }

        .cab-fl {
            width: 22%;
            text-align: center;
            vertical-align: middle;
        }
        .fl-box {
            border: 1.5px solid #000;
            display: inline-block;
            padding: 6px 14px;
            text-align: center;
        }
        .fl-code { font-size: 13px; font-weight: bold; letter-spacing: 1.5px; }
        .fl-rev  { font-size: 9px;  font-weight: bold; margin-top: 2px; letter-spacing: 0.5px; }

        /* ════ DATOS GENERALES ════ */
        .datos {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            border-top: none;
            margin-bottom: 0;
        }
        .datos td {
            padding: 6px 11px 5px;
            vertical-align: bottom;
            border-right: 1.5px solid #000;
        }
        .datos td:last-child { border-right: none; }

        .campo-valor {
            font-size: 10px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            min-height: 16px;
            padding-bottom: 2px;
        }
        .campo-label {
            font-size: 7.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        /* ════ TABLA PROBETAS ════ */
        .probetas {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            border-top: none;
            table-layout: fixed;
        }
        .probetas thead tr { background: #000; }
        .probetas thead th {
            color: #fff;
            padding: 5px 4px;
            font-size: 7.5px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-right: 1px solid #555;
            line-height: 1.3;
        }
        .probetas thead th:last-child { border-right: none; }

        .probetas tbody td {
            padding: 4px 4px;
            font-size: 8.5px;
            text-align: center;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            vertical-align: middle;
        }
        .probetas tbody td:last-child { border-right: none; }
        .probetas tbody tr:last-child td { border-bottom: none; }
        .probetas tbody tr:nth-child(even) td { background: #f5f5f5; }
        .td-nombre { font-weight: bold; text-align: left !important; }
        .td-left   { text-align: left !important; }

        /* ════ OUTLIER ════ */
        .outlier {
            color: #cc0000 !important;
            font-weight: bold;
        }
        .probetas tbody tr:nth-child(even) td.outlier { background: #fff0f0 !important; }
        .probetas tbody tr:nth-child(odd)  td.outlier { background: #fff5f5 !important; }

    </style>
</head>
<body>

@php
    /* ── Estadísticas para detección de outliers ── */
    $numericFields = [
        'carga_rotura',
        'diametro_superior_1', 'diametro_superior_2',
        'diametro_inferior_1', 'diametro_inferior_2',
        'altura_1', 'altura_2', 'altura_3',
    ];

    $stats = [];
    foreach ($numericFields as $field) {
        $vals = $probetas->pluck($field)->filter(fn($v) => $v !== null)->map(fn($v) => (float)$v)->values();
        if ($vals->count() > 1) {
            $mean     = $vals->avg();
            $stdDev   = sqrt($vals->map(fn($v) => ($v - $mean) ** 2)->avg());
            $stats[$field] = ['mean' => $mean, 'stdDev' => $stdDev];
        }
    }

    $isOutlier = function($val, $field) use ($stats): bool {
        if ($val === null || !isset($stats[$field])) return false;
        if ($stats[$field]['stdDev'] < 0.0001) return false;
        return abs((float)$val - $stats[$field]['mean']) > 1.5 * $stats[$field]['stdDev'];
    };

@endphp

{{-- ═══ CABECERA ═══ --}}
<table class="cabecera">
    <tr>
        <td class="cab-logo">
            @if($logo)<img src="{{ $logo }}" alt="Logo">@endif
        </td>
        <td class="cab-titulo">
            <div class="titulo-main">Planilla — Ensayo Compresión</div>
        </td>
        <td class="cab-fl">
            <div class="fl-box">
                <div class="fl-code">FL-17</div>
                <div class="fl-rev">REV 03</div>
            </div>
        </td>
    </tr>
</table>

{{-- ═══ DATOS GENERALES ═══ --}}
<table class="datos">
    <tr>
        <td style="width:58%;">
            <div class="campo-valor">{{ $obra->nombre }}</div>
            <div class="campo-label">Obra</div>
        </td>
        <td style="width:42%;">
            <div class="campo-valor">ASTM C39/C39-2026</div>
            <div class="campo-label">Norma de referencia</div>
        </td>
    </tr>
</table>

{{-- ═══ TABLA ═══ --}}
<table class="probetas">
    <colgroup>
        <col style="width:7%">  {{-- Fecha ensayo --}}
        <col style="width:7%">  {{-- Fecha moldeo --}}
        <col style="width:10%"> {{-- Nombre --}}
        <col style="width:8%">  {{-- Defecto --}}
        <col style="width:7%">  {{-- Carga --}}
        <col style="width:4%">  {{-- Tipo --}}
        <col style="width:6%">  {{-- Ø Sup 1 --}}
        <col style="width:6%">  {{-- Ø Sup 2 --}}
        <col style="width:6%">  {{-- Ø Inf 1 --}}
        <col style="width:6%">  {{-- Ø Inf 2 --}}
        <col style="width:6%">  {{-- Alt 1 --}}
        <col style="width:6%">  {{-- Alt 2 --}}
        <col style="width:6%">  {{-- Alt 3 --}}
        <col style="width:15%"> {{-- Ensayado por --}}
    </colgroup>
    <thead>
        <tr>
            <th>Fecha<br>Ensayo</th>
            <th>Fecha<br>Moldeo</th>
            <th>Nombre<br>Probeta</th>
            <th>Defecto</th>
            <th>Carga<br>Rot. (kN)</th>
            <th>T.<br>Rot.</th>
            <th>Ø Sup 1<br>(mm)</th>
            <th>Ø Sup 2<br>(mm)</th>
            <th>Ø Inf 1<br>(mm)</th>
            <th>Ø Inf 2<br>(mm)</th>
            <th>Alt 1<br>(mm)</th>
            <th>Alt 2<br>(mm)</th>
            <th>Alt 3<br>(mm)</th>
            <th>Ensayado por</th>
        </tr>
    </thead>
    <tbody>
        @forelse($probetas as $probeta)
        @php
            $ens = $probeta->ensayadoPor;
            $nombreEns = $ens
                ? (($ens->persona && ($ens->persona->nombre || $ens->persona->apellido))
                    ? trim($ens->persona->nombre . ' ' . $ens->persona->apellido)
                    : $ens->nick)
                : '—';
        @endphp
        <tr>
            <td>{{ $probeta->fecha_ensayo?->format('d/m/Y') ?? '—' }}</td>
            <td>{{ $probeta->fecha_moldeo?->format('d/m/Y') ?? '—' }}</td>
            <td class="td-nombre">{{ $probeta->nombre }}</td>
            <td class="td-left">{{ $probeta->defecto ?: '—' }}</td>
            <td class="{{ $isOutlier($probeta->carga_rotura,        'carga_rotura')        ? 'outlier' : '' }}">{{ $probeta->carga_rotura        ?? '—' }}</td>
            <td>{{ $probeta->tipo_rotura ?? '—' }}</td>
            <td class="{{ $isOutlier($probeta->diametro_superior_1, 'diametro_superior_1') ? 'outlier' : '' }}">{{ $probeta->diametro_superior_1 ?? '—' }}</td>
            <td class="{{ $isOutlier($probeta->diametro_superior_2, 'diametro_superior_2') ? 'outlier' : '' }}">{{ $probeta->diametro_superior_2 ?? '—' }}</td>
            <td class="{{ $isOutlier($probeta->diametro_inferior_1, 'diametro_inferior_1') ? 'outlier' : '' }}">{{ $probeta->diametro_inferior_1 ?? '—' }}</td>
            <td class="{{ $isOutlier($probeta->diametro_inferior_2, 'diametro_inferior_2') ? 'outlier' : '' }}">{{ $probeta->diametro_inferior_2 ?? '—' }}</td>
            <td class="{{ $isOutlier($probeta->altura_1,            'altura_1')            ? 'outlier' : '' }}">{{ $probeta->altura_1            ?? '—' }}</td>
            <td class="{{ $isOutlier($probeta->altura_2,            'altura_2')            ? 'outlier' : '' }}">{{ $probeta->altura_2            ?? '—' }}</td>
            <td class="{{ $isOutlier($probeta->altura_3,            'altura_3')            ? 'outlier' : '' }}">{{ $probeta->altura_3            ?? '—' }}</td>
            <td class="td-left">{{ $nombreEns }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="14" style="text-align:center; color:#aaa; padding:14px; font-style:italic;">
                Sin probetas ensayadas registradas.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>


</body>
</html>
