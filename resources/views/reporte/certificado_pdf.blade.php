<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de certificados</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8.5px;
            color: #1a1a1a;
            background: #fff;
            /* espacio para cabecera fija + pie fijo */
            padding: 100px 32px 90px 32px;
        }

        /* ══════════════════════════════════════
           CABECERA FIJA
        ══════════════════════════════════════ */
        .page-header {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 84px;
        }
        .cabecera {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            margin: 14px 32px 0 32px;
            width: calc(100% - 64px);
        }
        .cab-logo  { width: 24%; padding: 8px 12px; border-right: 1.5px solid #000; text-align: center; vertical-align: middle; }
        .cab-logo img { max-height: 46px; max-width: 140px; }
        .cab-logo .logo-txt { font-size: 14px; font-weight: bold; letter-spacing: 2px; }
        .cab-titulo { width: 76%; padding: 8px 14px; text-align: center; vertical-align: middle; }
        .cab-titulo .titulo-main { font-size: 12.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .cab-titulo .titulo-sub  { font-size: 8px; color: #444; margin-top: 3px; }

        /* ══════════════════════════════════════
           PIE FIJO
        ══════════════════════════════════════ */
        .page-footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: 82px;
        }
        .footer-inner {
            width: calc(100% - 64px);
            margin: 0 32px;
            border-collapse: collapse;
        }
        .footer-inner td { vertical-align: middle; padding: 6px 8px; }
        .foot-firma { width: 42%; text-align: left; }
        .foot-firma img { max-height: 52px; max-width: 190px; }
        .foot-contacto { width: 58%; }
        .contacto-box {
            border: 1.5px solid #333;
            border-radius: 4px;
            padding: 5px 10px;
            background: #f8f8f8;
        }
        .contacto-nombre { font-size: 7.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .contacto-ciudad { font-size: 7px; color: #444; margin-top: 1px; }
        .contacto-sep    { border: none; border-top: 1px solid #ccc; margin: 3px 0; }
        .contacto-mail   { font-size: 7px; color: #1a1a8a; }
        .contacto-tel    { font-size: 7px; margin-top: 1px; }

        /* ══════════════════════════════════════
           CUERPO
        ══════════════════════════════════════ */
        .titulo-reporte { font-size: 13px; font-weight: bold; margin-bottom: 3px; text-transform: uppercase; letter-spacing: 0.5px; }
        .subtitulo-reporte { font-size: 8px; color: #555; margin-bottom: 14px; }

        table.reporte {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
        }
        table.reporte thead th {
            background: #d8d8d8;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 5px 4px;
            text-align: center;
            border: 1px solid #888;
        }
        table.reporte tbody td {
            padding: 5px 4px;
            font-size: 8px;
            text-align: center;
            border: 1px solid #ccc;
            vertical-align: middle;
        }
        table.reporte tbody tr:nth-child(even) { background: #f6f6f6; }
        .td-left { text-align: left !important; }

        .td-subtotal {
            background: #e4e4e4 !important;
            font-weight: bold;
            font-size: 8px;
            border: 1px solid #aaa;
            vertical-align: middle !important;
        }

        .estado-ok    { color: #15803d; font-weight: bold; }
        .estado-pend  { color: #b45309; font-weight: bold; }

        .tr-total-general td {
            background: #cfcfcf !important;
            font-weight: bold;
            font-size: 9px;
            border: 1.5px solid #777;
            padding: 7px 4px;
        }

        .sin-resultados { text-align: center; color: #777; padding: 40px 0; font-size: 10px; border: 1.5px solid #ccc; }
    </style>
</head>
<body>

@php
    $meses = ['enero','febrero','marzo','abril','mayo','junio',
              'julio','agosto','septiembre','octubre','noviembre','diciembre'];
    $hoy = now();
    $hoyStr = $hoy->day . ' de ' . $meses[$hoy->month - 1] . ' de ' . $hoy->year;
@endphp

{{-- ══ CABECERA FIJA ══ --}}
<div class="page-header">
    <table class="cabecera">
        <tr>
            <td class="cab-logo">
                @if($logo)
                    <img src="{{ $logo }}" alt="Logo">
                @else
                    <span class="logo-txt">LEMCO</span>
                @endif
            </td>
            <td class="cab-titulo">
                <div class="titulo-main">Reporte de certificados</div>
                <div class="titulo-sub">Generado el {{ $hoyStr }} &mdash; {{ $rangoLabel }}</div>
            </td>
        </tr>
    </table>
</div>

{{-- ══ PIE FIJO ══ --}}
<div class="page-footer">
    <table class="footer-inner">
        <tr>
            <td class="foot-firma">
                @if($firmash)
                    <img src="{{ $firmash }}" alt="Firma">
                @endif
            </td>
            <td class="foot-contacto">
                <div class="contacto-box">
                    <div class="contacto-nombre">Soldado Ovelar 1027</div>
                    <div class="contacto-ciudad">Fernando de la Mora &mdash; Paraguay</div>
                    <hr class="contacto-sep">
                    <div class="contacto-mail">&#9993;&nbsp; consulta@lemco.com.py</div>
                    <div class="contacto-tel">&#9990;&nbsp; (595 21) 021 456 &nbsp;|&nbsp; +595 986 161 059</div>
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- ══ CUERPO ══ --}}
@if($filas->isEmpty())
    <div class="sin-resultados">No se encontraron certificados con los parámetros seleccionados.</div>
@else
    <table class="reporte">
        <thead>
            <tr>
                <th style="width:7%">N.°</th>
                <th style="width:24%">Obra</th>
                <th style="width:10%">Fecha</th>
                <th style="width:11%">Cant. probetas</th>
                <th style="width:13%">Precio unit. (Gs.)</th>
                <th style="width:13%">Monto (Gs.)</th>
                <th style="width:14%">Subtotal obra (Gs.)</th>
                <th style="width:8%">Estado</th>
            </tr>
        </thead>
        @foreach($filas as $bloque)
        @php $cantItems = $bloque['items']->count(); @endphp
        <tbody>
            @foreach($bloque['items'] as $i => $item)
            @php $c = $item['certificado']; @endphp
            <tr>
                <td>{{ str_pad($item['nro'], 3, '0', STR_PAD_LEFT) }}</td>
                <td class="td-left">{{ $bloque['obra']->nombre }}</td>
                <td>{{ $c->created_at->format('d/m/Y') }}</td>
                <td>{{ $item['probetas'] }}</td>
                <td>{{ number_format($c->precio_unitario, 0, ',', '.') }}</td>
                <td>{{ number_format($item['monto'], 0, ',', '.') }}</td>
                @if($i === 0)
                <td class="td-subtotal" rowspan="{{ $cantItems }}">
                    {{ number_format($bloque['totalMonto'], 0, ',', '.') }}
                </td>
                @endif
                <td class="{{ $c->verificado ? 'estado-ok' : 'estado-pend' }}">
                    {{ $c->verificado ? 'Verif.' : 'Pend.' }}
                </td>
            </tr>
            @endforeach
        </tbody>
        @endforeach
        <tfoot>
            <tr class="tr-total-general">
                <td colspan="6" class="td-left">TOTAL GENERAL &mdash; {{ $totalProbetasGeneral }} probetas</td>
                <td>{{ number_format($totalGeneral, 0, ',', '.') }}</td>
                <td>&mdash;</td>
            </tr>
        </tfoot>
    </table>
@endif

</body>
</html>
