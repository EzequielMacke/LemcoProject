<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Remisión {{ $remision->nro }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            background: #fff;
            padding: 22px 28px 22px 28px;
        }

        /* ════ CABECERA ════ */
        .cabecera {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            margin-bottom: 0;
        }
        .cabecera td {
            padding: 8px 12px;
            vertical-align: middle;
        }
        .cab-logo {
            width: 22%;
            border-right: 1.5px solid #000;
            text-align: center;
        }
        .cab-logo img {
            max-height: 54px;
            max-width: 140px;
        }
        .cab-titulo {
            width: 55%;
            text-align: center;
            border-right: 1.5px solid #000;
            padding: 10px 12px;
        }
        .cab-titulo .titulo-text {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            line-height: 1.4;
        }
        .cab-nro {
            width: 23%;
            text-align: center;
        }
        .cab-nro .nro-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 4px;
        }
        .cab-nro .nro-value {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1.5px;
        }

        /* ════ FILA DE DATOS ════ */
        .datos {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            border-top: none;
            margin-bottom: 0;
        }
        .datos td {
            padding: 7px 11px 5px;
            vertical-align: bottom;
            border-right: 1.5px solid #000;
        }
        .datos td:last-child { border-right: none; }

        .campo-valor {
            font-size: 10.5px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            min-height: 17px;
            padding-bottom: 2px;
            padding-top: 2px;
        }
        .campo-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
            color: #000;
        }

        /* Recuadro FL-16 */
        .fl-box {
            border: 1.5px solid #000;
            text-align: center;
            padding: 5px 6px;
            display: inline-block;
        }
        .fl-code { font-size: 11px; font-weight: bold; letter-spacing: 1px; }
        .fl-rev  { font-size: 9px;  font-weight: bold; margin-top: 1px; }

        /* ════ TABLA PROBETAS ════ */
        .sec-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 6px 0 3px;
        }
        .probetas {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            margin-bottom: 0;
        }
        .probetas thead tr { background: #000; }
        .probetas thead th {
            color: #fff;
            padding: 5px 5px;
            font-size: 8.5px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-right: 1px solid #555;
            white-space: nowrap;
        }
        .probetas thead th:last-child { border-right: none; }
        .probetas tbody td {
            padding: 5px 5px;
            font-size: 9.5px;
            text-align: center;
            border-right: 1px solid #bbb;
            border-bottom: 1px solid #bbb;
            vertical-align: middle;
        }
        .probetas tbody td:last-child { border-right: none; }
        .probetas tbody tr:last-child td { border-bottom: none; }
        .probetas tbody tr:nth-child(even) td { background: #f5f5f5; }
        .td-nombre { font-weight: bold; }

        /* ════ OBSERVACIONES ════ */
        .obs {
            border: 1.5px solid #000;
            border-top: none;
            padding: 7px 11px;
            min-height: 52px;
        }
        .obs-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 5px;
        }
        .obs-value {
            font-size: 10px;
            line-height: 1.5;
        }
        .obs-value.muted { color: #aaa; font-style: italic; }

        /* ════ FIRMAS ════ */
        .firmas {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            border-top: none;
        }
        .firmas td {
            width: 50%;
            padding: 7px 20px 8px;
            vertical-align: bottom;
            border-right: 1.5px solid #000;
        }
        .firmas td:last-child { border-right: none; }
        .firma-valor {
            font-size: 10.5px;
            font-weight: bold;
            min-height: 28px;
            padding-bottom: 3px;
            text-align: center;
            border-bottom: 1px dotted #000;
        }
        .firma-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
            text-align: center;
        }
    </style>
</head>
<body>

@php
    $recibio = $remision->recibidoPor;
    $nombreRecibio = ($recibio && $recibio->persona && ($recibio->persona->nombre || $recibio->persona->apellido))
        ? trim($recibio->persona->nombre . ' ' . $recibio->persona->apellido)
        : ($recibio->nick ?? '');
@endphp

{{-- ═══ CABECERA ═══ --}}
<table class="cabecera">
    <tr>
        <td class="cab-logo">
            @if($logo)
                <img src="{{ $logo }}" alt="Logo">
            @endif
        </td>
        <td class="cab-titulo">
            <div class="titulo-text">Ficha de recepción<br>de probetas</div>
        </td>
        <td class="cab-nro">
            <div class="nro-label">N° de remisión</div>
            <div class="nro-value">{{ $remision->nro }}</div>
        </td>
    </tr>
</table>

{{-- ═══ DATOS GENERALES ═══ --}}
<table class="datos">
    <tr>
        {{-- Obra (más ancha) --}}
        <td style="width:38%;">
            <div class="campo-valor">{{ $obra->nombre }}</div>
            <div class="campo-label">Obra</div>
        </td>
        {{-- Contratista --}}
        <td style="width:30%;">
            <div class="campo-valor">{{ $remision->contratista }}</div>
            <div class="campo-label">Contratista</div>
        </td>
        {{-- Fecha --}}
        <td style="width:16%;">
            <div class="campo-valor">{{ $remision->created_at->format('d/m/Y') }}</div>
            <div class="campo-label">Fecha</div>
        </td>
        {{-- FL-16 REV 03 --}}
        <td style="width:16%; text-align:center; vertical-align:middle;">
            <div class="fl-box">
                <div class="fl-code">FL-16</div>
                <div class="fl-rev">REV 03</div>
            </div>
        </td>
    </tr>
</table>

{{-- ═══ TABLA PROBETAS ═══ --}}
<div class="sec-label">Probetas — {{ $remision->probetas->count() }} en total</div>
<table class="probetas">
    <thead>
        <tr>
            <th>Concretera</th>
            <th>fck (MPa)</th>
            <th>Fecha moldeo</th>
            <th>Hora</th>
            <th>Mixer</th>
            <th>Edad ensayo</th>
            <th>Elemento</th>
            <th>Muestra</th>
        </tr>
    </thead>
    <tbody>
        @forelse($remision->probetas as $probeta)
        <tr>
            <td>{{ $probeta->concretera }}</td>
            <td>{{ $probeta->fck }}</td>
            <td>{{ \Carbon\Carbon::parse($probeta->fecha_moldeo)->format('d/m/Y') }}</td>
            <td>{{ substr($probeta->hora_moldeo, 0, 5) }}</td>
            <td>{{ $probeta->mixer }}</td>
            <td>{{ $probeta->edad_ensayo }} días</td>
            <td>{{ $probeta->elemento }}</td>
            <td class="td-nombre">{{ $probeta->nombre }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center; color:#aaa; padding:14px; font-style:italic;">
                Sin probetas registradas
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ═══ OBSERVACIONES ═══ --}}
<div class="obs">
    <div class="obs-label">Observaciones</div>
    @if($remision->observacion)
        <div class="obs-value">{{ $remision->observacion }}</div>
    @else
        <div class="obs-value muted">&nbsp;</div>
    @endif
</div>

{{-- ═══ FIRMAS ═══ --}}
<table class="firmas">
    <tr>
        <td>
            <div class="firma-valor">{{ $remision->entregado_por }}</div>
            <div class="firma-label">Entregado por</div>
        </td>
        <td>
            <div class="firma-valor">{{ $nombreRecibio }}</div>
            <div class="firma-label">Recibido por</div>
        </td>
    </tr>
</table>

</body>
</html>
