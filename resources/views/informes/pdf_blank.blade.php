<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Ensayo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #1a1a1a;
            background: #fff;
            padding: 14px 18px 70px 18px;
        }

        /* ════ CABECERA ════ */
        .cabecera {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
        }
        .cabecera td { vertical-align: middle; }
        .cab-logo  { width: 20%; padding: 6px 10px; border-right: 1.5px solid #000; text-align: center; }
        .cab-logo img { max-height: 48px; max-width: 130px; }
        .cab-logo .logo-txt { font-size: 13px; font-weight: bold; letter-spacing: 2px; }
        .cab-titulo { width: 58%; padding: 8px 14px; border-right: 1.5px solid #000; text-align: center; }
        .cab-titulo .titulo-main { font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; line-height: 1.5; }
        .cab-fl { width: 22%; padding: 6px 10px; text-align: center; }
        .fl-code { font-size: 11px; font-weight: bold; letter-spacing: 1.5px; }
        .fl-rev  { font-size: 8px; font-weight: bold; margin-top: 3px; color: #555; }

        /* ════ BLOQUE INFO ════ */
        .info-bloque {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            border-top: none;
            margin-bottom: 8px;
        }
        .info-bloque td { vertical-align: top; }

        /* Columna izquierda: datos */
        .col-datos { width: 42%; padding: 0; border-right: 1.5px solid #000; }
        .datos-inner { width: 100%; border-collapse: collapse; }
        .datos-inner tr { border-bottom: 1px solid #ddd; }
        .datos-inner tr:last-child { border-bottom: none; }
        .datos-inner td { padding: 3px 8px; font-size: 7.5px; }
        .dato-lbl { width: 38%; font-weight: bold; text-transform: uppercase; font-size: 6.5px; color: #555; }
        .dato-val { color: #000; font-size: 8px; }

        /* Columna central: imagen tipo */
        .col-tipo { width: 30%; padding: 6px; border-right: 1.5px solid #000; text-align: center; }
        .col-tipo img { max-width: 100%; max-height: 90px; }
        .col-tipo .tipo-lbl { font-size: 6.5px; font-weight: bold; text-transform: uppercase; color: #555; margin-bottom: 4px; }

        /* Columna derecha: norma */
        .col-norma { width: 28%; padding: 10px 12px; text-align: center; vertical-align: middle !important; }
        .norma-lbl  { font-size: 6.5px; font-weight: bold; text-transform: uppercase; color: #555; margin-bottom: 6px; }
        .norma-val  { font-size: 11px; font-weight: bold; letter-spacing: 0.5px; line-height: 1.6; }
        .norma-anio { font-size: 9px; font-weight: bold; color: #333; }

        /* ════ TABLA PROBETAS ════ */
        table.probetas {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
        }
        table.probetas thead th {
            background: #d8d8d8;
            font-size: 6.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 4px 4px;
            text-align: center;
            border: 1px solid #888;
            line-height: 1.3;
        }
        table.probetas tbody td {
            padding: 8px 4px;
            font-size: 7.5px;
            text-align: center;
            border: 1px solid #ccc;
            vertical-align: middle;
        }
        table.probetas tbody tr:nth-child(even) { background: #f5f5f5; }
        .td-left { text-align: left !important; }
        .td-bold { font-weight: bold; }
        .td-avg  { background: #e8e8e8 !important; font-weight: bold; font-size: 8px; }

        /* ════ FOOTER FIJO ════ */
        .footer {
            position: fixed;
            bottom: 0;
            left: 18px;
            right: 18px;
        }
        .footer-inner {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-inner td { vertical-align: middle; padding: 5px 8px; }

        .foot-ref { width: 22%; }
        .foot-ref-lbl { font-size: 6.5px; color: #555; text-transform: uppercase; font-weight: bold; }
        .foot-ref-val { font-size: 13px; font-weight: bold; letter-spacing: 0.5px; margin-top: 1px; }

        .foot-firma { width: 40%; text-align: center; }
        .foot-firma img { max-height: 52px; max-width: 200px; }

        .foot-contacto { width: 38%; }
        .contacto-box {
            border: 1.5px solid #333;
            border-radius: 4px;
            padding: 5px 10px;
            background: #f8f8f8;
        }
        .contacto-nombre { font-size: 8px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .contacto-ciudad { font-size: 7px; color: #444; margin-top: 1px; }
        .contacto-sep    { border: none; border-top: 1px solid #ccc; margin: 3px 0; }
        .contacto-mail   { font-size: 7px; color: #1a1a8a; }
        .contacto-tel    { font-size: 7px; margin-top: 1px; }
    </style>
</head>
<body>

{{-- ══ CABECERA ══ --}}
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
            <div class="titulo-main">Ensayo de Compresión Simple</div>
        </td>
        <td class="cab-fl">
            <div class="fl-code">FL-18</div>
            <div class="fl-rev">Rev. 06</div>
        </td>
    </tr>
</table>

{{-- ══ BLOQUE INFO ══ --}}
<table class="info-bloque">
    <tr>
        {{-- Datos generales --}}
        <td class="col-datos">
            <table class="datos-inner">
                <tr>
                    <td class="dato-lbl">Fecha de recepción</td>
                    <td class="dato-val">&nbsp;</td>
                </tr>
                <tr>
                    <td class="dato-lbl">Peticionario</td>
                    <td class="dato-val">&nbsp;</td>
                </tr>
                <tr>
                    <td class="dato-lbl">Contacto</td>
                    <td class="dato-val">&nbsp;</td>
                </tr>
                <tr>
                    <td class="dato-lbl">Obra</td>
                    <td class="dato-val">&nbsp;</td>
                </tr>
                <tr>
                    <td class="dato-lbl">Fecha de ensayo</td>
                    <td class="dato-val">&nbsp;</td>
                </tr>
                <tr>
                    <td class="dato-lbl">Fecha de emisión</td>
                    <td class="dato-val">&nbsp;</td>
                </tr>
            </table>
        </td>

        {{-- Imagen tipo de rotura --}}
        <td class="col-tipo">
            <div class="tipo-lbl">Tipos de rotura</div>
            @if($tipo)
                <img src="{{ $tipo }}" alt="Tipos de rotura">
            @else
                <span style="font-size:7px; color:#999;">(imagen no disponible)</span>
            @endif
        </td>

        {{-- Norma de referencia --}}
        <td class="col-norma">
            <div class="norma-lbl">Norma de referencia</div>
            <div class="norma-val">ASTM C39/C39M</div>
            <div class="norma-anio">2026</div>
        </td>
    </tr>
</table>

{{-- ══ TABLA PROBETAS ══ --}}
<table class="probetas">
    <thead>
        <tr>
            <th>#</th>
            <th>Probeta Nº</th>
            <th>Elemento</th>
            <th>F. Moldeo</th>
            <th>Edad<br>(días)</th>
            <th>Carga rotura<br>(kN)</th>
            <th>Sección<br>(mm²)</th>
            <th>Altura<br>(mm)</th>
            <th>Diámetro<br>(mm)</th>
            <th>Tensión<br>rotura (MPa)</th>
            <th>H/D</th>
            <th>C(H/D)</th>
            <th>Tensión<br>corregida (MPa)</th>
            <th>Tensión<br>promedio (MPa)</th>
            <th>Tipo<br>rotura</th>
            <th>Defecto</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < 8; $i++)
        <tr>
            <td class="td-bold">{{ $i + 1 }}</td>
            <td class="td-left">&nbsp;</td>
            <td class="td-left">&nbsp;</td>
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
            <td class="td-left">&nbsp;</td>
        </tr>
        @endfor
    </tbody>
</table>

{{-- ══ COMENTARIOS ══ --}}
<div style="margin-top:6px; font-size:6.5px; color:#333; line-height:1.5;">
    <div style="margin-bottom:3px;">
        <span style="color:#cc0000; font-weight:bold;">(*)</span>
        Las roturas tipo 5 o 6 indican roturas no satisfactorias, por lo tanto, este resultado no se deberá utilizar para el juzgamiento de la resistencia del hormigón.
    </div>
    <div style="font-style:italic;">
        No se debe reproducir el informe completo ni parte del mismo sin la expresa autorización del laboratorio LEMCO.
    </div>
</div>

{{-- ══ FOOTER FIJO ══ --}}
<div class="footer">
    <table class="footer-inner">
        <tr>
            {{-- Número de informe --}}
            <td class="foot-ref">
                <div class="foot-ref-lbl">Referencia</div>
                <div class="foot-ref-val">Ref.: &nbsp;</div>
            </td>

            {{-- Firma --}}
            <td class="foot-firma">
                @if($firmash)
                    <img src="{{ $firmash }}" alt="Firma">
                @endif
            </td>

            {{-- Contacto --}}
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

</body>
</html>
