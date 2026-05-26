<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado #{{ $nroCertificado }} — {{ $obra->nombre }}</title>
    <style>
        /* ── Página: sin márgenes en @page, los controla el body ── */
        @page {
            size: A4 portrait;
            margin: 0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9.5px;
            color: #111;
            background: #fff;
            /* Espacio para cabecera (88px) + margen extra + pie + laterales */
            padding: 110px 40px 90px 40px;
        }

        /* ══════════════════════════════════════
           CABECERA FIJA — solo logo
        ══════════════════════════════════════ */
        .page-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 88px;
            background: #fff;
            padding: 14px 0 0 40px;
        }
        .header-table {
            width: 100%;
            height: 88px;
            border-collapse: collapse;
            padding: 0 40px;
        }
        .header-logo {
            vertical-align: middle;
            text-align: left;
            padding: 12px 0 10px 40px;
        }
        .header-fecha {
            vertical-align: bottom;
            text-align: right;
            padding: 0 40px 12px 0;
            font-size: 9px;
            color: #333;
            white-space: nowrap;
        }
        .page-header img {
            max-height: 60px;
            max-width: 160px;
        }
        .page-header .logo-txt {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #1a1a1a;
            line-height: 60px;
        }

        /* ══════════════════════════════════════
           PIE FIJO — solo firma
        ══════════════════════════════════════ */
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: #fff;
            padding: 8px 40px 0 40px;
            text-align: right;
        }
        .page-footer img {
            max-height: 60px;
            max-width: 190px;
        }

        /* ══════════════════════════════════════
           CUERPO — empieza con la fecha
        ══════════════════════════════════════ */
        .col-fecha {
            font-size: 9px;
            color: #333;
            text-align: right;
            margin-bottom: 20px;
        }

        .dest-label {
            font-size: 9.5px;
            font-weight: bold;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
        }
        .dest-value { font-size: 10px; margin-bottom: 10px; }

        .atte-row { font-size: 9.5px; margin-bottom: 5px; }
        .atte-row b { font-weight: bold; }
        .ref-row  { font-size: 9.5px; margin-bottom: 4px; }
        .ref-row b { font-weight: bold; }

        .cert-nro {
            font-size: 10px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 16px;
        }

        .cuerpo-parrafo {
            font-size: 9.5px;
            line-height: 1.6;
            text-align: justify;
            margin-bottom: 18px;
        }

        /* ── Tabla de ítems ── */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        table.items thead th {
            background: #e8e8e8;
            color: #111;
            font-size: 7.5px;
            font-weight: bold;
            letter-spacing: 0.4px;
            padding: 5px 8px;
            text-align: center;
            border: 1px solid #bbb;
        }
        table.items tbody td {
            padding: 5px 8px;
            font-size: 9px;
            border: 1px solid #bbb;
            vertical-align: middle;
            text-align: center;
        }
        table.items tbody tr:nth-child(even) { background: #f4f4f4; }

        .td-rowspan {
            vertical-align: middle !important;
            text-align: center !important;
            font-size: 8.5px;
            font-weight: bold;
            line-height: 1.4;
            background: #fff !important;
        }
        .td-left { text-align: left !important; }
        .td-bold { font-weight: bold; }

        .tr-total td {
            background: #e0e0e0 !important;
            font-weight: bold;
            font-size: 9.5px;
            border: 1px solid #aaa;
            padding: 5px 8px;
            text-align: center;
        }

        .son-guaranies {
            font-size: 9px;
            font-style: italic;
            margin-bottom: 24px;
            color: #333;
        }

        .cierre {
            font-size: 9.5px;
            margin-bottom: 36px;
            line-height: 1.8;
        }

        /* ── Segunda hoja ── */
        .page-break { page-break-before: always; }

        .detalle-titulo {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 14px;
            padding-bottom: 6px;
            border-bottom: 2px solid #555;
        }

        table.probetas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        table.probetas thead th {
            background: #e8e8e8;
            color: #111;
            font-size: 7px;
            font-weight: bold;
            letter-spacing: 0.4px;
            padding: 5px 6px;
            text-align: center;
            border: 1px solid #bbb;
        }
        table.probetas tbody td {
            padding: 4px 6px;
            font-size: 8px;
            border: 1px solid #bbb;
            vertical-align: middle;
            text-align: center;
        }
        table.probetas tbody tr:nth-child(even) { background: #f4f4f4; }
        table.probetas .td-group {
            background: #e0e0e0 !important;
            font-weight: bold;
            font-size: 8px;
            text-align: left;
            padding: 4px 8px;
            border: 1px solid #aaa;
        }
    </style>
</head>
<body>

@php
$tipoCert  = $obra->tipo_certificacion;

$fecha = $certificado->created_at;
$meses = ['enero','febrero','marzo','abril','mayo','junio',
          'julio','agosto','septiembre','octubre','noviembre','diciembre'];
$fechaStr = $fecha->day . ' de ' . $meses[$fecha->month - 1] . ' de ' . $fecha->year;

function numeroALetras(int $n): string {
    if ($n === 0) return 'cero';
    $u = ['','uno','dos','tres','cuatro','cinco','seis','siete','ocho','nueve',
          'diez','once','doce','trece','catorce','quince','dieciséis','diecisiete',
          'dieciocho','diecinueve','veinte','veintiuno','veintidós','veintitrés',
          'veinticuatro','veinticinco','veintiséis','veintisiete','veintiocho','veintinueve'];
    $d = ['','','veinte','treinta','cuarenta','cincuenta',
          'sesenta','setenta','ochenta','noventa'];
    $c = ['','ciento','doscientos','trescientos','cuatrocientos','quinientos',
          'seiscientos','setecientos','ochocientos','novecientos'];
    $str = '';
    if ($n < 0) { $str = 'menos '; $n = abs($n); }
    if ($n >= 1000000) {
        $mill = intdiv($n, 1000000);
        $str .= ($mill === 1 ? 'un millón ' : numeroALetras($mill) . ' millones ');
        $n %= 1000000;
    }
    if ($n >= 1000) {
        $mil = intdiv($n, 1000);
        $str .= ($mil === 1 ? 'mil ' : numeroALetras($mil) . ' mil ');
        $n %= 1000;
    }
    if ($n >= 100) {
        $str .= ($n === 100 ? 'cien ' : $c[intdiv($n, 100)] . ' ');
        $n %= 100;
    }
    if ($n >= 30) {
        $str .= $d[intdiv($n, 10)];
        if ($n % 10) $str .= ' y ' . $u[$n % 10];
        $str .= ' ';
    } elseif ($n > 0) {
        $str .= $u[$n] . ' ';
    }
    return trim($str);
}

$totalEnLetras = ucfirst(numeroALetras((int) round($totalMonto)));
$cantDetalles  = $certificado->detalles->count();
@endphp

{{-- ══ CABECERA FIJA: solo logo ══ --}}
<div class="page-header">
    @if($logo)
        <img src="{{ $logo }}" alt="Logo">
    @else
        <div class="logo-txt">LEMCO</div>
    @endif
</div>

{{-- ══ PIE FIJO: solo firma ══ --}}
<div class="page-footer">
    @if($firmash)
        <img src="{{ $firmash }}" alt="Firma">
    @endif
</div>

{{-- ══ CUERPO: empieza con la fecha ══ --}}

<div class="col-fecha">
    Fernando de la Mora, {{ $fechaStr }}
</div>

<div class="dest-label">Señores:</div>
<div class="dest-value">{{ $certificado->señores }}</div>

<div class="atte-row"><b>Atte.:</b> {{ $certificado->atte }}</div>
<div class="ref-row">
    <b>Ref.:</b> Control de hormigonado en la Obra {{ $obra->nombre }}
</div>
<div class="cert-nro">
    Certificado N.° {{ str_pad($nroCertificado, 3, '0', STR_PAD_LEFT) }}
</div>

<div class="cuerpo-parrafo">
    A continuación, presentamos los trabajos realizados en el laboratorio LEMCO durante
    los trabajos de control de hormigón en la Obra <strong>{{ $obra->nombre }}</strong>:
</div>

{{-- Tabla de ítems --}}
<table class="items">
    <thead>
        <tr>
            <th style="width:28%">Ítem</th>
            <th style="width:22%">{{ $tipoCert === 1 ? 'Remisión' : 'Informe' }}</th>
            <th style="width:15%">Cant. probetas</th>
            <th style="width:18%">Precio unitario (Gs.)</th>
            <th style="width:17%">Subtotal (Gs.)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($certificado->detalles as $i => $detalle)
        @php
            $probetas = $tipoCert === 1
                ? ($detalle->remision?->probetas->count() ?? 0)
                : ($detalle->informe?->detalles->count() ?? 0);
            $subtotal = $probetas * $certificado->precio_unitario;
        @endphp
        <tr>
            @if($i === 0)
            <td class="td-rowspan" rowspan="{{ $cantDetalles }}">
                Control tecnológico del hormigón con ensayos de resistencia a compresión
            </td>
            @endif

            @if($tipoCert === 1)
                <td class="td-left td-bold">
                    Rem. {{ $detalle->remision ? str_pad($detalle->remision->nro, 4, '0', STR_PAD_LEFT) : '—' }}
                </td>
            @else
                <td class="td-left td-bold">
                    Informe #{{ $detalle->informe ? ($nrosInformes[$detalle->informe->id] ?? $detalle->informe->id) : '—' }}
                </td>
            @endif

            <td>{{ $probetas }}</td>

            @if($i === 0)
            <td class="td-rowspan" rowspan="{{ $cantDetalles }}">
                {{ number_format($certificado->precio_unitario, 0, ',', '.') }}
            </td>
            @endif

            <td>{{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="tr-total">
            <td colspan="2" class="td-left">TOTAL</td>
            <td>{{ $totalProbetas }}</td>
            <td>—</td>
            <td>{{ number_format($totalMonto, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

<div class="son-guaranies">
    Son guaraníes: {{ $totalEnLetras }} (Gs. {{ number_format($totalMonto, 0, ',', '.') }})
</div>

<div class="cierre">
    Sin otro particular, atentamente,
</div>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- SEGUNDA HOJA — Detalle de probetas                                --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<div class="page-break">
    <div class="detalle-titulo">
        Detalle de probetas — Certificado N.° {{ str_pad($nroCertificado, 3, '0', STR_PAD_LEFT) }}
    </div>

    <table class="probetas">
        <thead>
            <tr>
                <th style="width:16%">{{ $tipoCert === 1 ? 'Remisión' : 'Informe / Recepción' }}</th>
                <th style="width:22%">Nombre de probeta</th>
                <th style="width:13%">Fecha de recepción</th>
                <th style="width:20%">Elemento</th>
                <th style="width:8%">Fck (MPa)</th>
                <th style="width:13%">Fecha de moldeo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($certificado->detalles as $detalle)
                @if($tipoCert === 1 && $detalle->remision)
                    @php
                        $rem      = $detalle->remision;
                        $remLabel = 'Rem. ' . str_pad($rem->nro, 4, '0', STR_PAD_LEFT);
                        $fechaRec = $rem->created_at ? $rem->created_at->format('d/m/Y') : '—';
                    @endphp
                    <tr>
                        <td class="td-group" colspan="6">{{ $remLabel }} — Recibida el {{ $fechaRec }}</td>
                    </tr>
                    @foreach($rem->probetas as $probeta)
                    <tr>
                        <td></td>
                        <td style="text-align:left;">{{ $probeta->nombre }}</td>
                        <td>{{ $fechaRec }}</td>
                        <td style="text-align:left;">{{ $probeta->elemento }}</td>
                        <td>{{ $probeta->fck }}</td>
                        <td>{{ $probeta->fecha_moldeo ? \Carbon\Carbon::parse($probeta->fecha_moldeo)->format('d/m/Y') : '—' }}</td>
                    </tr>
                    @endforeach

                @elseif($tipoCert === 2 && $detalle->informe)
                    @php
                        $inf      = $detalle->informe;
                        $rec      = $inf->recepcion;
                        $infNro   = $nrosInformes[$inf->id] ?? $inf->id;
                        $infLabel = 'Informe #' . $infNro;
                        $recLabel = $rec ? 'Rec. ' . str_pad($rec->nro, 4, '0', STR_PAD_LEFT) : '—';
                        $fechaRec = $rec?->created_at ? $rec->created_at->format('d/m/Y') : '—';
                    @endphp
                    <tr>
                        <td class="td-group" colspan="6">{{ $infLabel }} / {{ $recLabel }} — Recibida el {{ $fechaRec }}</td>
                    </tr>
                    @foreach($inf->detalles as $det)
                        @if($det->probeta)
                        <tr>
                            <td></td>
                            <td style="text-align:left;">{{ $det->probeta->nombre }}</td>
                            <td>{{ $fechaRec }}</td>
                            <td style="text-align:left;">{{ $det->probeta->elemento }}</td>
                            <td>{{ $det->probeta->fck }}</td>
                            <td>{{ $det->probeta->fecha_moldeo ? \Carbon\Carbon::parse($det->probeta->fecha_moldeo)->format('d/m/Y') : '—' }}</td>
                        </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
