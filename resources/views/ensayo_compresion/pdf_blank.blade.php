<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planilla Ensayo Compresión</title>
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
            padding: 9px 4px;
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

    </style>
</head>
<body>

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
                <div class="fl-rev">REV 04</div>
            </div>
        </td>
    </tr>
</table>

{{-- ═══ DATOS GENERALES ═══ --}}
<table class="datos">
    <tr>
        <td style="width:58%;">
            <div class="campo-valor">&nbsp;</div>
            <div class="campo-label">Obra</div>
        </td>
        <td style="width:42%;">
            <div class="campo-valor">&nbsp;</div>
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
        @for ($i = 0; $i < 12; $i++)
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endfor
    </tbody>
</table>


</body>
</html>
