<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructivo de uso — LemcoProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            font-family: 'Inter', sans-serif;
            background: #eef1f5;
            color: #111827;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ── Barra de impresión ── */
        .print-bar {
            position: sticky; top: 0; z-index: 10;
            background: #fff; border-bottom: 1px solid #e5e7eb;
            padding: 10px 24px;
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
        }
        .print-bar-txt { font-size: 13px; color: #6b7280; }
        .print-bar-actions { display: flex; gap: 8px; }
        .pb-btn {
            display: inline-flex; align-items: center; gap: 6px;
            border-radius: 8px; padding: 8px 14px; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif; cursor: pointer; text-decoration: none;
            border: 1.5px solid #e5e7eb; background: #fff; color: #374151;
        }
        .pb-btn.primary { background: #1d4ed8; border-color: #1d4ed8; color: #fff; }
        .pb-btn svg { width: 14px; height: 14px; }

        /* ── Hoja A4 ── */
        .sheet {
            width: 210mm; min-height: 297mm;
            margin: 24px auto; padding: 16mm 15mm;
            background: #fff;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }

        /* ── Portada ── */
        .cover { display: flex; flex-direction: column; justify-content: space-between; }
        .cover-top { display: flex; align-items: center; gap: 12px; }
        .cover-logo {
            width: 46px; height: 46px; border-radius: 11px;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            display: flex; align-items: center; justify-content: center; color: #fff;
        }
        .cover-logo svg { width: 24px; height: 24px; }
        .cover-brand { font-size: 18px; font-weight: 700; }
        .cover-mid { margin: 60px 0 40px; }
        .cover-kicker { font-size: 12px; font-weight: 700; color: #1d4ed8; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 10px; }
        .cover-title { font-size: 40px; font-weight: 700; letter-spacing: -1px; line-height: 1.1; margin-bottom: 14px; }
        .cover-sub { font-size: 15px; color: #6b7280; max-width: 480px; line-height: 1.6; }

        .toc { border-top: 2px solid #111827; padding-top: 14px; }
        .toc-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin-bottom: 10px; }
        .toc ol { list-style: none; columns: 2; column-gap: 28px; }
        .toc li {
            font-size: 13px; padding: 6px 0; border-bottom: 1px dashed #e5e7eb;
            display: flex; gap: 10px; break-inside: avoid;
        }
        .toc li span { color: #1d4ed8; font-weight: 700; min-width: 20px; }
        .cover-foot { font-size: 11.5px; color: #9ca3af; display: flex; justify-content: space-between; margin-top: 30px; }

        /* ── Encabezado de sección ── */
        .sec-head { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 2px solid #111827; }
        .sec-num {
            width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
            background: #1d4ed8; color: #fff; font-weight: 700; font-size: 17px;
            display: flex; align-items: center; justify-content: center;
        }
        .sec-title { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; }
        .sec-desc { font-size: 13px; color: #6b7280; margin-top: 3px; line-height: 1.5; }
        .sec-perm {
            margin-left: auto; flex-shrink: 0;
            font-size: 10.5px; font-weight: 700; color: #6b7280;
            background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 99px; padding: 3px 10px;
        }

        h3.sub { font-size: 15px; font-weight: 700; margin: 18px 0 8px; display: flex; align-items: center; gap: 8px; }
        h3.sub::before { content: ''; width: 4px; height: 16px; border-radius: 2px; background: #1d4ed8; }
        p.txt { font-size: 12.5px; line-height: 1.6; color: #374151; margin-bottom: 8px; }

        /* ── Pasos ── */
        .steps { list-style: none; margin: 10px 0 6px; }
        .steps li {
            display: flex; gap: 10px; align-items: flex-start;
            font-size: 12.5px; line-height: 1.55; color: #374151; padding: 4px 0;
        }
        .steps li b { color: #111827; }

        /* ── Marcadores numerados ── */
        .mk {
            display: inline-flex; align-items: center; justify-content: center;
            width: 19px; height: 19px; border-radius: 50%; flex-shrink: 0;
            background: #dc2626; color: #fff; font-size: 10.5px; font-weight: 700;
            box-shadow: 0 0 0 2px #fff, 0 0 0 3.5px #dc2626;
            vertical-align: middle;
        }
        .mk-abs { position: absolute; top: -9px; right: -9px; z-index: 2; }
        .rel { position: relative; }

        /* ── Cajas de nota ── */
        .tip, .warn {
            border-radius: 9px; padding: 10px 13px; font-size: 12px; line-height: 1.55;
            margin: 10px 0; display: flex; gap: 9px;
        }
        .tip  { background: #eff6ff; border: 1.5px solid #bfdbfe; color: #1e3a8a; }
        .warn { background: #fffbeb; border: 1.5px solid #fde68a; color: #92400e; }
        .tip b, .warn b { font-weight: 700; }

        /* ── Pantalla simulada ── */
        .screen {
            border: 1.5px solid #d1d5db; border-radius: 12px; overflow: hidden;
            background: #f8fafc; margin: 10px 0 12px;
            break-inside: avoid; page-break-inside: avoid;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .screen-bar {
            display: flex; align-items: center; gap: 6px;
            background: #e5e7eb; padding: 6px 10px;
        }
        .screen-bar i { width: 8px; height: 8px; border-radius: 50%; background: #9ca3af; display: block; }
        .screen-bar i:nth-child(1) { background: #f87171; }
        .screen-bar i:nth-child(2) { background: #fbbf24; }
        .screen-bar i:nth-child(3) { background: #34d399; }
        .screen-url {
            margin-left: 8px; flex: 1; background: #fff; border-radius: 5px;
            font-size: 10.5px; color: #6b7280; padding: 3px 9px;
        }

        .app-nav {
            background: #fff; border-bottom: 1px solid #e9ecef;
            height: 40px; padding: 0 14px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .app-nav-left { display: flex; align-items: center; gap: 9px; font-size: 12px; }
        .app-back {
            display: inline-flex; align-items: center; gap: 4px;
            border: 1.5px solid #e9ecef; border-radius: 7px; padding: 3px 8px;
            font-size: 11px; font-weight: 500; color: #6b7280;
        }
        .app-sep { width: 1px; height: 16px; background: #e5e7eb; }
        .app-title { font-weight: 600; color: #111827; }
        .app-brand { display: flex; align-items: center; gap: 7px; font-weight: 700; }
        .app-brand-icon { width: 22px; height: 22px; border-radius: 6px; background: linear-gradient(135deg, #1e40af, #1d4ed8); }
        .app-user {
            display: flex; align-items: center; gap: 6px;
            background: #f1f3f5; border: 1.5px solid #e9ecef; border-radius: 99px;
            padding: 2px 9px 2px 3px; font-size: 11px; font-weight: 500;
        }
        .app-user-chip {
            width: 18px; height: 18px; border-radius: 50%;
            background: linear-gradient(135deg, #1e40af, #1d4ed8); color: #fff;
            font-size: 9px; font-weight: 700; display: flex; align-items: center; justify-content: center;
        }
        .app-body { padding: 14px; }

        .pg-label { font-size: 9.5px; font-weight: 700; color: #1d4ed8; text-transform: uppercase; letter-spacing: 1px; }
        .pg-heading { font-size: 16px; font-weight: 700; color: #0f172a; margin: 2px 0 1px; }
        .pg-sub { font-size: 11px; color: #6b7280; }
        .pg-row { display: flex; align-items: flex-end; justify-content: space-between; gap: 10px; margin-bottom: 12px; }

        /* Formularios simulados */
        .panel { background: #fff; border: 1.5px solid #e9ecef; border-radius: 10px; padding: 12px; margin-bottom: 10px; }
        .panel-title { font-size: 11.5px; font-weight: 700; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .fgrid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .fgrid.c3 { grid-template-columns: 1fr 1fr 1fr; }
        .fgrid.c4 { grid-template-columns: repeat(4, 1fr); }
        .fgrid .full { grid-column: 1 / -1; }
        .fld { display: flex; flex-direction: column; gap: 4px; }
        .fld label { font-size: 10.5px; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 5px; }
        .fld label .req { color: #ef4444; }
        .fld input, .fld select, .fld textarea {
            font-family: 'Inter', sans-serif; font-size: 11px; color: #111827;
            border: 1.5px solid #e5e7eb; border-radius: 7px; padding: 6px 8px;
            background: #fff; width: 100%; pointer-events: none;
        }
        .fld input::placeholder, .fld textarea::placeholder { color: #9ca3af; }
        .fld textarea { resize: none; height: 46px; }
        .fld .hint { font-size: 9.5px; color: #9ca3af; }

        /* Botones simulados */
        .b {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 10.5px; font-weight: 600; border-radius: 7px; padding: 5px 10px;
            border: 1.5px solid #e5e7eb; background: #fff; color: #374151; white-space: nowrap;
        }
        .b-primary { background: #1d4ed8; border-color: #1d4ed8; color: #fff; }
        .b-success { background: #16a34a; border-color: #16a34a; color: #fff; }
        .b-danger  { background: #fff1f2; border-color: #fecdd3; color: #be123c; }
        .b-excel   { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .b-violet  { background: #7c3aed; border-color: #7c3aed; color: #fff; }
        .b-sm { padding: 3px 7px; font-size: 9.5px; }
        .actions { display: flex; gap: 6px; justify-content: flex-end; flex-wrap: wrap; align-items: center; }

        /* Tablas simuladas */
        .tbl { width: 100%; border-collapse: collapse; background: #fff; border: 1.5px solid #e9ecef; border-radius: 10px; overflow: hidden; font-size: 10.5px; }
        .tbl th { background: #f8fafc; text-align: left; font-weight: 600; color: #6b7280; padding: 6px 8px; border-bottom: 1px solid #e9ecef; font-size: 9.5px; text-transform: uppercase; letter-spacing: 0.3px; }
        .tbl td { padding: 6px 8px; border-bottom: 1px solid #f1f3f5; color: #374151; vertical-align: middle; }
        .tbl tr:last-child td { border-bottom: none; }
        .tbl input, .tbl select {
            font-family: 'Inter', sans-serif; font-size: 10px; width: 100%;
            border: 1.5px solid #e5e7eb; border-radius: 5px; padding: 3px 5px; background: #fff; pointer-events: none;
        }
        .tbl .c { text-align: center; }

        /* Badges / chips */
        .bdg { display: inline-flex; align-items: center; gap: 4px; font-size: 9.5px; font-weight: 600; border-radius: 99px; padding: 2px 8px; }
        .bdg-green  { background: #dcfce7; color: #15803d; }
        .bdg-red    { background: #fee2e2; color: #b91c1c; }
        .bdg-amber  { background: #fef3c7; color: #b45309; }
        .bdg-blue   { background: #dbeafe; color: #1d4ed8; }
        .bdg-violet { background: #ede9fe; color: #6d28d9; }
        .bdg-gray   { background: #f3f4f6; color: #4b5563; }

        /* Tarjetas de menú simuladas */
        .mgrid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
        .mcard {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 11px;
            padding: 10px; position: relative; min-height: 78px;
        }
        .mcard::before { content: ''; position: absolute; top: 0; left: 10px; right: 10px; height: 2px; border-radius: 0 0 3px 3px; background: var(--c, #1d4ed8); }
        .mcard-icon { width: 22px; height: 22px; border-radius: 6px; background: var(--bg, #eff6ff); margin-bottom: 6px; }
        .mcard-label { font-size: 10.5px; font-weight: 700; }
        .mcard-desc { font-size: 9px; color: #9ca3af; line-height: 1.35; margin-top: 2px; }
        .mcard .badge-n {
            position: absolute; top: 7px; right: 7px; background: #dc2626; color: #fff;
            font-size: 8.5px; font-weight: 700; border-radius: 99px; padding: 1px 5px;
        }

        /* Pestañas */
        .tabs { display: flex; gap: 4px; border-bottom: 1.5px solid #e5e7eb; margin-bottom: 10px; }
        .tab { font-size: 10.5px; font-weight: 600; color: #6b7280; padding: 5px 10px; border-bottom: 2px solid transparent; margin-bottom: -1.5px; }
        .tab.on { color: #1d4ed8; border-color: #1d4ed8; }
        .tab .n { background: #f3f4f6; border-radius: 99px; padding: 0 6px; margin-left: 4px; font-size: 9px; }

        /* Agenda */
        .day { display: flex; align-items: center; gap: 10px; background: #fff; border: 1.5px solid #e9ecef; border-radius: 9px; padding: 7px 10px; margin-bottom: 5px; }
        .day-num { font-size: 15px; font-weight: 700; width: 26px; text-align: center; }
        .day-name { font-size: 9px; color: #9ca3af; display: block; text-align: center; }
        .day-sep { width: 1px; height: 26px; background: #e5e7eb; }
        .day-body { display: flex; gap: 6px; align-items: center; flex: 1; font-size: 10.5px; color: #9ca3af; }
        .day.pend { border-left: 3px solid #f59e0b; }
        .day.mix  { border-left: 3px solid #1d4ed8; }
        .day.ok   { border-left: 3px solid #16a34a; }

        /* Muestras recepción */
        .grupo { display: grid; grid-template-columns: 1.4fr 1fr; gap: 10px; border: 1.5px dashed #cbd5e1; border-radius: 10px; padding: 10px; background: #fff; position: relative; }
        .muestra { display: flex; align-items: center; justify-content: space-between; gap: 6px; font-size: 10.5px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 6px; padding: 4px 7px; margin-bottom: 4px; }
        .muestra b { font-weight: 700; }
        .muestra input { width: 44px; font-size: 10px; border: 1.5px solid #e5e7eb; border-radius: 5px; padding: 2px 4px; pointer-events: none; }
        .copy { display: inline-flex; width: 15px; height: 15px; border-radius: 4px; background: #eff6ff; color: #1d4ed8; align-items: center; justify-content: center; font-size: 8px; }

        /* Tarjetas informe */
        .igrid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .icard { background: #fff; border: 1.5px solid #e9ecef; border-radius: 10px; padding: 10px; font-size: 10px; color: #6b7280; position: relative; }
        .icard .t { font-size: 12px; font-weight: 700; color: #111827; }
        .icard .r { margin-top: 3px; }
        .icard .f { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; padding-top: 6px; border-top: 1px solid #f1f3f5; }

        /* Toggles permisos */
        .tg { display: inline-block; width: 26px; height: 14px; border-radius: 99px; background: #d1d5db; position: relative; }
        .tg::after { content: ''; position: absolute; top: 2px; left: 2px; width: 10px; height: 10px; border-radius: 50%; background: #fff; }
        .tg.on { background: #16a34a; }
        .tg.on::after { left: 14px; }

        /* Flujo */
        .flow { display: flex; align-items: stretch; gap: 0; margin: 12px 0; }
        .flow-step { flex: 1; background: #fff; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 9px; text-align: center; }
        .flow-step .fs-n { font-size: 9px; font-weight: 700; color: #1d4ed8; text-transform: uppercase; letter-spacing: 0.6px; }
        .flow-step .fs-t { font-size: 11.5px; font-weight: 700; margin: 3px 0; }
        .flow-step .fs-d { font-size: 9.5px; color: #6b7280; line-height: 1.4; }
        .flow-arrow { display: flex; align-items: center; padding: 0 4px; color: #9ca3af; font-weight: 700; }

        .two { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .modal-sim {
            background: #fff; border: 1.5px solid #e5e7eb; border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12); max-width: 380px; margin: 4px auto; overflow: hidden;
        }
        .modal-sim-head { padding: 10px 12px; border-bottom: 1px solid #f1f3f5; font-size: 12px; font-weight: 700; }
        .modal-sim-body { padding: 12px; display: flex; flex-direction: column; gap: 9px; }
        .modal-sim-foot { padding: 9px 12px; border-top: 1px solid #f1f3f5; display: flex; justify-content: flex-end; gap: 6px; background: #fafafa; }
        .overlay { background: rgba(15,23,42,0.35); padding: 16px; }

        .chk { display: flex; align-items: center; gap: 7px; font-size: 10.5px; padding: 4px 0; }
        .chk i { width: 12px; height: 12px; border: 1.5px solid #9ca3af; border-radius: 3px; display: inline-block; }
        .chk i.on { background: #1d4ed8; border-color: #1d4ed8; }

        .gloss { width: 100%; border-collapse: collapse; font-size: 11.5px; margin-top: 6px; }
        .gloss td { padding: 7px 8px; border-bottom: 1px solid #f1f3f5; vertical-align: top; line-height: 1.5; }
        .gloss td:first-child { width: 130px; font-weight: 600; white-space: nowrap; }

        .doc-foot { margin-top: 18px; padding-top: 8px; border-top: 1px solid #e5e7eb; font-size: 10px; color: #9ca3af; display: flex; justify-content: space-between; }

        /* ── Impresión ── */
        @page { size: A4; margin: 0; }
        @media print {
            html, body { background: #fff; }
            .no-print { display: none !important; }
            .sheet { margin: 0; box-shadow: none; width: auto; min-height: 297mm; page-break-after: always; break-after: page; }
            .sheet:last-child { page-break-after: auto; break-after: auto; }
        }

        @media screen and (max-width: 860px) {
            .sheet { width: auto; margin: 12px; padding: 20px 16px; min-height: 0; }
            .mgrid { grid-template-columns: repeat(2, 1fr); }
            .igrid { grid-template-columns: 1fr 1fr; }
            .two, .toc ol { grid-template-columns: 1fr; columns: 1; }
            .print-bar-txt { display: none; }
        }
    </style>
</head>
<body>

{{-- Barra superior (no se imprime) --}}
<div class="print-bar no-print">
    <span class="print-bar-txt">Vista de impresión · En el diálogo elegí <b>“Guardar como PDF”</b>, tamaño <b>A4</b> y activá <b>“Gráficos de fondo”</b>.</span>
    <div class="print-bar-actions">
        <a href="{{ route('menu.index') }}" class="pb-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Menú
        </a>
        <button type="button" class="pb-btn primary" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/></svg>
            Imprimir / Guardar PDF
        </button>
    </div>
</div>

{{-- ════════════════════ PORTADA ════════════════════ --}}
<section class="sheet cover">
    <div>
        <div class="cover-top">
            <div class="cover-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
            </div>
            <span class="cover-brand">LemcoProject</span>
        </div>

        <div class="cover-mid">
            <div class="cover-kicker">Manual de usuario</div>
            <h1 class="cover-title">Instructivo de uso<br>del sistema</h1>
            <p class="cover-sub">
                Guía paso a paso para operar el sistema: recepción de probetas, ensayos de compresión,
                informes, certificación, control de equipos y administración de usuarios.
            </p>
        </div>

        <div class="toc">
            <div class="toc-title">Contenido</div>
            <ol>
                <li><span>1</span> Flujo general de trabajo</li>
                <li><span>2</span> Ingreso al sistema y registro</li>
                <li><span>3</span> Menú principal</li>
                <li><span>4</span> Datos personales</li>
                <li><span>5</span> Obras</li>
                <li><span>6</span> Contactos de la obra</li>
                <li><span>7</span> Recepción de probetas (remisiones)</li>
                <li><span>8</span> Ensayos de compresión</li>
                <li><span>9</span> Informes de ensayo</li>
                <li><span>10</span> Certificación</li>
                <li><span>11</span> Pendientes</li>
                <li><span>12</span> Buscador general</li>
                <li><span>13</span> Inventario de equipos</li>
                <li><span>14</span> Control de equipos</li>
                <li><span>15</span> Reportes</li>
                <li><span>16</span> Administración: áreas, usuarios y permisos</li>
                <li><span>17</span> Glosario de estados</li>
            </ol>
        </div>
    </div>

    <div class="cover-foot">
        <span>LemcoProject · Instructivo de uso</span>
        <span>Versión {{ now()->format('d/m/Y') }}</span>
    </div>
</section>

{{-- ════════════════════ 1. FLUJO GENERAL ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">1</div>
        <div>
            <div class="sec-title">Flujo general de trabajo</div>
            <div class="sec-desc">Cómo se encadenan los módulos desde que llega una probeta hasta que se certifica.</div>
        </div>
    </div>

    <div class="flow">
        <div class="flow-step"><div class="fs-n">Paso 1</div><div class="fs-t">Obra</div><div class="fs-d">Se crea la obra y sus contactos</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-step"><div class="fs-n">Paso 2</div><div class="fs-t">Remisión</div><div class="fs-d">Se reciben y registran las probetas</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-step"><div class="fs-n">Paso 3</div><div class="fs-t">Ensayo</div><div class="fs-d">Se cargan los resultados el día programado</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-step"><div class="fs-n">Paso 4</div><div class="fs-t">Informe</div><div class="fs-d">Se genera, verifica y envía</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-step"><div class="fs-n">Paso 5</div><div class="fs-t">Certificado</div><div class="fs-d">Se factura lo realizado</div></div>
    </div>

    <p class="txt">
        Cada probeta registrada en una remisión tiene una <b>edad de ensayo</b> (en días). El sistema calcula
        automáticamente la <b>fecha programada</b> de ensayo sumando esa edad a la fecha de moldeo, y la
        muestra en la agenda del módulo <b>Compresión</b> y en <b>Pendientes</b>.
    </p>
    <p class="txt">
        Una vez ensayadas, las probetas aparecen como <b>pendientes de informe</b> dentro de la obra. Al generar
        el informe quedan bloqueadas para edición. Finalmente, las remisiones o informes (según el tipo de
        certificación de la obra) se incluyen en un <b>certificado</b>.
    </p>

    <h3 class="sub">Elementos comunes en todas las pantallas</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras</span></div>
        <div class="app-nav">
            <div class="app-nav-left">
                <span class="app-back rel">← Volver <span class="mk mk-abs">1</span></span>
                <span class="app-sep"></span>
                <span class="app-title rel">Obras <span class="mk mk-abs" style="right:-22px">2</span></span>
            </div>
            <span class="app-user rel"><span class="app-user-chip">J</span> jperez <span class="mk mk-abs">3</span></span>
        </div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Módulo</div><div class="pg-heading">Obras</div></div>
                <span class="b b-primary rel">+ Nueva obra <span class="mk mk-abs">4</span></span>
            </div>
            <div class="panel rel" style="background:#f0fdf4;border-color:#bbf7d0;color:#15803d;font-size:11px;margin:0">
                ✓ La obra se creó correctamente. <span class="mk mk-abs">5</span>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span><b>Volver:</b> regresa a la pantalla anterior (generalmente al menú).</span></li>
        <li><span class="mk">2</span><span><b>Título:</b> indica en qué módulo estás.</span></li>
        <li><span class="mk">3</span><span><b>Usuario:</b> muestra con qué usuario iniciaste sesión.</span></li>
        <li><span class="mk">4</span><span><b>Botón principal:</b> acción de alta del módulo (solo visible si tenés permiso de <i>Agregar</i>).</span></li>
        <li><span class="mk">5</span><span><b>Mensajes:</b> en verde las acciones exitosas, en rojo los errores o validaciones.</span></li>
    </ol>

    <div class="tip"><span>ℹ</span><span><b>Permisos:</b> lo que ves en cada pantalla depende de los permisos del área a la que pertenece tu usuario (Ver, Agregar, Editar, Eliminar). Si te falta un módulo o un botón, pedile al administrador que revise tus permisos (sección 16).</span></div>
</section>

{{-- ════════════════════ 2. LOGIN ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">2</div>
        <div>
            <div class="sec-title">Ingreso al sistema y registro</div>
            <div class="sec-desc">Iniciar sesión con tu usuario o crear una cuenta nueva.</div>
        </div>
    </div>

    <div class="two">
        <div>
            <h3 class="sub">Iniciar sesión</h3>
            <div class="screen">
                <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / login</span></div>
                <div class="app-body" style="padding:18px">
                    <div class="panel" style="padding:16px">
                        <div class="pg-heading" style="margin-bottom:2px">Bienvenido</div>
                        <div class="pg-sub" style="margin-bottom:12px">Ingresá tus credenciales</div>
                        <div class="fld rel" style="margin-bottom:9px">
                            <label>Usuario <span class="mk">1</span></label>
                            <input type="text" value="jperez" readonly tabindex="-1">
                        </div>
                        <div class="fld" style="margin-bottom:12px">
                            <label>Contraseña <span class="mk">2</span></label>
                            <input type="password" value="secreto" readonly tabindex="-1">
                        </div>
                        <span class="b b-primary" style="width:100%;justify-content:center">Ingresar <span class="mk">3</span></span>
                        <div style="text-align:center;margin-top:10px;font-size:10.5px;color:#1d4ed8;font-weight:600">Crear cuenta <span class="mk">4</span></div>
                    </div>
                </div>
            </div>
            <ol class="steps">
                <li><span class="mk">1</span><span>Escribí tu <b>usuario</b> (nick).</span></li>
                <li><span class="mk">2</span><span>Escribí tu <b>contraseña</b>.</span></li>
                <li><span class="mk">3</span><span>Presioná <b>Ingresar</b>. Vas a ver el menú principal.</span></li>
                <li><span class="mk">4</span><span>Si no tenés cuenta, usá <b>Crear cuenta</b>.</span></li>
            </ol>
        </div>

        <div>
            <h3 class="sub">Crear cuenta</h3>
            <div class="screen">
                <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / usuarios / crear</span></div>
                <div class="app-body" style="padding:18px">
                    <div class="panel" style="padding:16px">
                        <div class="fld" style="margin-bottom:9px">
                            <label>Nick <span class="mk">1</span></label>
                            <input type="text" placeholder="Ej: jperez" readonly tabindex="-1">
                        </div>
                        <div class="fld" style="margin-bottom:9px">
                            <label>Contraseña <span class="mk">2</span></label>
                            <input type="password" placeholder="Mínimo 6 caracteres" readonly tabindex="-1">
                        </div>
                        <div class="fld" style="margin-bottom:12px">
                            <label>Confirmar contraseña</label>
                            <input type="password" placeholder="Repetí la contraseña" readonly tabindex="-1">
                        </div>
                        <span class="b b-primary" style="width:100%;justify-content:center">Crear usuario <span class="mk">3</span></span>
                    </div>
                </div>
            </div>
            <ol class="steps">
                <li><span class="mk">1</span><span>Elegí un <b>nick</b>. El sistema avisa al instante si ya está en uso.</span></li>
                <li><span class="mk">2</span><span>Ingresá una contraseña de <b>mínimo 6 caracteres</b> y repetila.</span></li>
                <li><span class="mk">3</span><span>Presioná <b>Crear usuario</b>.</span></li>
            </ol>
        </div>
    </div>

    <div class="warn"><span>⚠</span><span><b>Importante:</b> una cuenta nueva no tiene área asignada, por lo que no verá módulos hasta que un administrador le asigne un área desde <b>Usuarios</b> (sección 16).</span></div>

    <h3 class="sub">Cerrar sesión</h3>
    <p class="txt">Desde el menú principal, presioná <b>Cerrar sesión</b> en la esquina superior derecha. Hacelo siempre al terminar si usás una computadora compartida.</p>
</section>

{{-- ════════════════════ 3. MENÚ ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">3</div>
        <div>
            <div class="sec-title">Menú principal</div>
            <div class="sec-desc">Punto de partida para acceder a todos los módulos.</div>
        </div>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / menu</span></div>
        <div class="app-nav">
            <div class="app-brand"><span class="app-brand-icon"></span> LemcoProject</div>
            <div style="display:flex;gap:6px;align-items:center">
                <span class="app-user"><span class="app-user-chip">J</span> jperez</span>
                <span class="b b-sm rel">Cerrar sesión <span class="mk mk-abs">3</span></span>
            </div>
        </div>
        <div class="app-body">
            <div class="pg-label">Panel principal</div>
            <div class="pg-heading">Bienvenido, jperez</div>
            <div class="pg-sub" style="margin-bottom:12px">Seleccioná un módulo para continuar</div>
            <div class="mgrid">
                <div class="mcard" style="--c:#1d4ed8;--bg:#eff6ff"><span class="badge-n">3</span><div class="mcard-icon"></div><div class="mcard-label">Datos personas <span class="mk">2</span></div><div class="mcard-desc">Información personal</div></div>
                <div class="mcard" style="--c:#15803d;--bg:#f0fdf4"><div class="mcard-icon"></div><div class="mcard-label">Áreas</div><div class="mcard-desc">Áreas y sectores</div></div>
                <div class="mcard" style="--c:#b45309;--bg:#fffbeb"><div class="mcard-icon"></div><div class="mcard-label">Permisos</div><div class="mcard-desc">Acceso por módulo</div></div>
                <div class="mcard" style="--c:#0e7490;--bg:#f0f9ff"><div class="mcard-icon"></div><div class="mcard-label">Usuarios</div><div class="mcard-desc">Cuentas y accesos</div></div>
                <div class="mcard rel" style="--c:#ea580c;--bg:#fff7ed"><span class="mk mk-abs">1</span><div class="mcard-icon"></div><div class="mcard-label">Obras</div><div class="mcard-desc">Proyectos y obras</div></div>
                <div class="mcard" style="--c:#e11d48;--bg:#fff1f2"><div class="mcard-icon"></div><div class="mcard-label">Compresión</div><div class="mcard-desc">Ensayos de compresión</div></div>
                <div class="mcard" style="--c:#4338ca;--bg:#eef2ff"><div class="mcard-icon"></div><div class="mcard-label">Pendientes</div><div class="mcard-desc">A la espera de revisión</div></div>
                <div class="mcard" style="--c:#0d9488;--bg:#f0fdfa"><div class="mcard-icon"></div><div class="mcard-label">Buscador general</div><div class="mcard-desc">Búsqueda de probetas</div></div>
                <div class="mcard" style="--c:#9333ea;--bg:#faf5ff"><div class="mcard-icon"></div><div class="mcard-label">Inventario</div><div class="mcard-desc">Stock de equipos</div></div>
                <div class="mcard" style="--c:#0284c7;--bg:#f0f9ff"><div class="mcard-icon"></div><div class="mcard-label">Control de Equipos</div><div class="mcard-desc">Retiros y devoluciones</div></div>
                <div class="mcard" style="--c:#16a34a;--bg:#f0fdf4"><div class="mcard-icon"></div><div class="mcard-label">Reporte</div><div class="mcard-desc">Reportes gerenciales</div></div>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>Hacé clic en cualquier <b>tarjeta</b> para entrar al módulo. Solo aparecen los módulos que tu área tiene habilitados.</span></li>
        <li><span class="mk">2</span><span>El <b>número rojo</b> sobre “Datos personas” indica cuántos de tus datos personales faltan completar.</span></li>
        <li><span class="mk">3</span><span><b>Cerrar sesión</b> termina tu sesión de trabajo.</span></li>
    </ol>

    <h3 class="sub">Resumen de módulos</h3>
    <table class="gloss">
        <tr><td>Datos personas</td><td>Tus datos personales (nombre, CI, cargo, título). Se usan en firmas de informes y certificados.</td></tr>
        <tr><td>Obras</td><td>Alta de obras y acceso a contactos, remisiones, informes y certificación de cada una.</td></tr>
        <tr><td>Compresión</td><td>Agenda mensual de ensayos y carga de resultados de rotura.</td></tr>
        <tr><td>Pendientes</td><td>Resumen de ensayos, informes y certificados por hacer.</td></tr>
        <tr><td>Buscador general</td><td>Tabla filtrable con todas las probetas del sistema.</td></tr>
        <tr><td>Inventario</td><td>Alta y control de stock de equipos, con código QR.</td></tr>
        <tr><td>Control de Equipos</td><td>Registro de retiros y devoluciones de equipos por obra.</td></tr>
        <tr><td>Reporte</td><td>Reportes en PDF (por ejemplo, de certificados por período).</td></tr>
        <tr><td>Áreas / Permisos / Usuarios</td><td>Administración de accesos al sistema.</td></tr>
    </table>
</section>

{{-- ════════════════════ 4. DATOS PERSONALES ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">4</div>
        <div>
            <div class="sec-title">Datos personales</div>
            <div class="sec-desc">Completá tu información para que aparezca correctamente en los documentos.</div>
        </div>
        <span class="sec-perm">Menú → Datos personas</span>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / personas</span></div>
        <div class="app-nav">
            <div class="app-nav-left"><span class="app-back">← Volver</span><span class="app-sep"></span><span class="app-title">Datos personales</span></div>
            <span class="app-user"><span class="app-user-chip">J</span> jperez</span>
        </div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Mi perfil</div><div class="pg-heading">Datos personales</div></div>
                <span class="bdg bdg-amber rel">Sin datos <span class="mk mk-abs">1</span></span>
            </div>
            <div class="panel">
                <div class="fgrid">
                    <div class="fld"><label>Nombre <span class="mk">2</span></label><input type="text" value="Juan" readonly tabindex="-1"></div>
                    <div class="fld"><label>Apellido</label><input type="text" value="Pérez" readonly tabindex="-1"></div>
                    <div class="fld"><label>CI</label><input type="text" placeholder="Ej: 12345678" readonly tabindex="-1"></div>
                    <div class="fld"><label>Fecha de nacimiento</label><input type="date" readonly tabindex="-1"></div>
                    <div class="fld full"><label>Correo electrónico</label><input type="text" placeholder="Ej: juan&#64;correo.com" readonly tabindex="-1"></div>
                    <div class="fld"><label>Cargo <span class="mk">3</span></label><input type="text" placeholder="Ej: Gerente de sistemas" readonly tabindex="-1"></div>
                    <div class="fld"><label>Título</label><input type="text" placeholder="Ej: Dr. Ing. Lic." readonly tabindex="-1"></div>
                </div>
                <div class="actions" style="margin-top:12px;justify-content:space-between">
                    <span style="font-size:10px;color:#9ca3af">Todos los campos son opcionales</span>
                    <span class="b b-primary">Guardar cambios <span class="mk">4</span></span>
                </div>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>El indicador muestra <b>“Datos cargados”</b> o <b>“Sin datos”</b>.</span></li>
        <li><span class="mk">2</span><span>Completá nombre, apellido, CI, fecha de nacimiento y correo.</span></li>
        <li><span class="mk">3</span><span><b>Cargo</b> y <b>Título</b> se imprimen junto a tu firma en informes y certificados.</span></li>
        <li><span class="mk">4</span><span>Presioná <b>Guardar cambios</b>.</span></li>
    </ol>
</section>

{{-- ════════════════════ 5. OBRAS ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">5</div>
        <div>
            <div class="sec-title">Obras</div>
            <div class="sec-desc">Cada obra agrupa sus contactos, remisiones, informes y certificados.</div>
        </div>
        <span class="sec-perm">Permiso OBR</span>
    </div>

    <h3 class="sub">Listado y alta de obras</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras</span></div>
        <div class="app-nav">
            <div class="app-nav-left"><span class="app-back">← Volver</span><span class="app-sep"></span><span class="app-title">Obras</span></div>
            <span class="app-user"><span class="app-user-chip">J</span> jperez</span>
        </div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Módulo</div><div class="pg-heading">Obras</div></div>
                <span class="b b-primary">+ Nueva obra <span class="mk">1</span></span>
            </div>
            <div style="display:flex;gap:8px;margin-bottom:10px;align-items:center">
                <div class="fld" style="flex:1"><input type="text" placeholder="Buscar obra..." readonly tabindex="-1"></div>
                <span class="mk">2</span>
                <div class="tabs" style="margin:0;border:none"><span class="tab on">Activas</span><span class="tab">Inactivas</span></div>
            </div>
            <table class="tbl">
                <tr><th>Nombre</th><th>Residente</th><th>Estado</th></tr>
                <tr><td><b>Edificio Torre Norte</b> <span class="mk">3</span></td><td>Ing. Gómez</td><td><span class="bdg bdg-green">Activa</span></td></tr>
                <tr><td><b>Puente Ruta 2</b></td><td>—</td><td><span class="bdg bdg-green">Activa</span></td></tr>
            </table>
        </div>
    </div>

    <div class="two">
        <div>
            <div class="overlay" style="border-radius:12px">
                <div class="modal-sim">
                    <div class="modal-sim-head">Nueva obra</div>
                    <div class="modal-sim-body">
                        <div class="fld"><label>Nombre <span class="req">*</span></label><input type="text" placeholder="Ej: Construcción edificio norte" readonly tabindex="-1"></div>
                        <div class="fld"><label>Tipo de certificación <span class="mk">4</span></label>
                            <select tabindex="-1"><option>Por remisión</option></select>
                        </div>
                        <div class="fld"><label>Residente</label><input type="text" placeholder="Nombre del residente (opcional)" readonly tabindex="-1"></div>
                    </div>
                    <div class="modal-sim-foot"><span class="b">Cancelar</span><span class="b b-primary">Guardar</span></div>
                </div>
            </div>
        </div>
        <div>
            <ol class="steps">
                <li><span class="mk">1</span><span><b>Nueva obra</b> abre el formulario de alta.</span></li>
                <li><span class="mk">2</span><span>Usá el <b>buscador</b> y las pestañas <b>Activas / Inactivas</b> para encontrar obras.</span></li>
                <li><span class="mk">3</span><span>Hacé clic en el nombre para <b>abrir la obra</b>.</span></li>
                <li><span class="mk">4</span><span>El <b>tipo de certificación</b> define qué se certifica:
                    <br>• <b>Por remisión:</b> se facturan las remisiones recibidas.
                    <br>• <b>Por informe:</b> se facturan los informes emitidos.</span></li>
            </ol>
            <div class="warn"><span>⚠</span><span>Elegí bien el tipo de certificación al crear la obra: determina cómo se arman sus certificados.</span></div>
        </div>
    </div>

    <h3 class="sub">Detalle de la obra</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12</span></div>
        <div class="app-nav">
            <div class="app-nav-left"><span class="app-back">← Obras</span><span class="app-sep"></span><span class="app-title">Edificio Torre Norte</span></div>
            <span class="app-user"><span class="app-user-chip">J</span> jperez</span>
        </div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-heading">Edificio Torre Norte <span class="bdg bdg-green">Activa</span></div><div class="pg-sub">Residente: Ing. Gómez</div></div>
                <div class="actions"><span class="b">Editar <span class="mk">5</span></span><span class="b b-danger">Inactivar</span><span class="b b-excel">⬇ Excel <span class="mk">6</span></span></div>
            </div>
            <div class="pg-label" style="color:#9ca3af;margin-bottom:6px">Secciones <span class="mk">7</span></div>
            <div class="mgrid">
                <div class="mcard" style="--c:#0e7490;--bg:#f0f9ff"><div class="mcard-icon"></div><div class="mcard-label">Contactos</div><div class="mcard-desc">Contactos vinculados</div></div>
                <div class="mcard" style="--c:#ea580c;--bg:#fff7ed"><div class="mcard-icon"></div><div class="mcard-label">Recepción de probetas</div><div class="mcard-desc">Registro de muestras</div></div>
                <div class="mcard" style="--c:#7c3aed;--bg:#f5f3ff"><div class="mcard-icon"></div><div class="mcard-label">Informes</div><div class="mcard-desc">Informes de ensayo</div></div>
                <div class="mcard" style="--c:#16a34a;--bg:#f0fdf4"><div class="mcard-icon"></div><div class="mcard-label">Certificación</div><div class="mcard-desc">Certificados de obra</div></div>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">5</span><span><b>Editar</b> permite cambiar nombre y residente. <b>Inactivar / Activar</b> oculta o recupera la obra.</span></li>
        <li><span class="mk">6</span><span><b>Excel</b> descarga una planilla con todas las probetas de la obra.</span></li>
        <li><span class="mk">7</span><span>Desde las <b>secciones</b> accedés a contactos, remisiones, informes y certificación (secciones 6, 7, 9 y 10).</span></li>
    </ol>
</section>

{{-- ════════════════════ 6. CONTACTOS ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">6</div>
        <div>
            <div class="sec-title">Contactos de la obra</div>
            <div class="sec-desc">Personas a quienes se envían remisiones, informes y certificados por correo.</div>
        </div>
        <span class="sec-perm">Obra → Contactos · Permiso CON</span>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12 / contactos</span></div>
        <div class="app-nav">
            <div class="app-nav-left"><span class="app-back">← Obra</span><span class="app-sep"></span><span class="app-title">Contactos</span></div>
            <span class="app-user"><span class="app-user-chip">J</span> jperez</span>
        </div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Edificio Torre Norte</div><div class="pg-heading">Contactos</div></div>
                <span class="b b-primary">+ Agregar contacto <span class="mk">1</span></span>
            </div>
            <div style="display:flex;gap:8px;margin-bottom:10px">
                <div class="fld" style="flex:1"><input type="text" placeholder="Buscar contacto..." readonly tabindex="-1"></div>
                <div class="tabs" style="margin:0;border:none"><span class="tab on">Activos</span><span class="tab">Inactivos</span></div>
            </div>
            <table class="tbl">
                <tr><th>Nombre</th><th>Correo</th><th>Estado</th><th class="c">Acciones</th></tr>
                <tr><td><b>Ana López</b></td><td>ana.lopez&#64;constructora.com</td><td><span class="bdg bdg-green">Activo</span></td>
                    <td class="c"><span class="b b-sm">Editar <span class="mk">2</span></span> <span class="b b-sm">Compartir <span class="mk">3</span></span> <span class="b b-sm b-danger">Anular <span class="mk">4</span></span></td></tr>
            </table>
        </div>
    </div>

    <div class="two">
        <div class="overlay" style="border-radius:12px">
            <div class="modal-sim">
                <div class="modal-sim-head">Agregar contacto</div>
                <div class="modal-sim-body">
                    <div class="fgrid">
                        <div class="fld"><label>Nombre</label><input type="text" placeholder="Juan" readonly tabindex="-1"></div>
                        <div class="fld"><label>Apellido</label><input type="text" placeholder="Pérez" readonly tabindex="-1"></div>
                    </div>
                    <div class="fld"><label>Correo electrónico</label><input type="text" placeholder="juan&#64;ejemplo.com" readonly tabindex="-1"></div>
                </div>
                <div class="modal-sim-foot"><span class="b">Cancelar</span><span class="b b-primary">Guardar</span></div>
            </div>
        </div>
        <div>
            <ol class="steps">
                <li><span class="mk">1</span><span><b>Agregar contacto:</b> cargá nombre, apellido y correo.</span></li>
                <li><span class="mk">2</span><span><b>Editar:</b> corrige los datos del contacto.</span></li>
                <li><span class="mk">3</span><span><b>Compartir:</b> copia el contacto a otra obra eligiendo la <b>Obra destino</b>.</span></li>
                <li><span class="mk">4</span><span><b>Anular:</b> lo pasa a inactivos (se puede volver a <b>Activar</b>).</span></li>
            </ol>
            <div class="tip"><span>ℹ</span><span>Los contactos <b>sin correo</b> aparecen deshabilitados al momento de enviar documentos por e-mail.</span></div>
        </div>
    </div>
</section>

{{-- ════════════════════ 7. RECEPCIÓN DE PROBETAS ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">7</div>
        <div>
            <div class="sec-title">Recepción de probetas (remisiones)</div>
            <div class="sec-desc">Registro de las probetas que llegan al laboratorio.</div>
        </div>
        <span class="sec-perm">Obra → Recepción de probetas · Permiso RPB</span>
    </div>

    <h3 class="sub">Nueva remisión — datos generales</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12 / remisiones / create</span></div>
        <div class="app-nav">
            <div class="app-nav-left"><span class="app-back">← Remisiones</span><span class="app-sep"></span><span class="app-title">Nueva remisión</span></div>
            <span class="app-user"><span class="app-user-chip">J</span> jperez</span>
        </div>
        <div class="app-body">
            <div class="pg-label">Recepción de probetas</div>
            <div class="pg-heading">Nueva remisión</div>
            <div class="pg-sub" style="margin-bottom:10px">Edificio Torre Norte</div>
            <div class="panel">
                <div class="panel-title">Datos de la remisión</div>
                <div class="fgrid">
                    <div class="fld"><label>N° remisión <span class="req">*</span> <span class="mk">1</span></label><input type="text" value="0000154" readonly tabindex="-1"><span class="hint">Formato: 0000000</span></div>
                    <div class="fld"><label>Contratista <span class="req">*</span></label><input type="text" placeholder="Nombre del contratista" readonly tabindex="-1"></div>
                    <div class="fld"><label>Entregado por <span class="req">*</span></label><input type="text" placeholder="Nombre de quien entrega" readonly tabindex="-1"></div>
                    <div class="fld"><label>Observación</label><textarea placeholder="Observaciones adicionales..." readonly tabindex="-1"></textarea></div>
                </div>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>El <b>N° de remisión</b> se propone automáticamente (7 dígitos). Podés modificarlo si corresponde. Completá <b>Contratista</b> y <b>Entregado por</b>.</span></li>
    </ol>

    <h3 class="sub">Nueva remisión — muestras</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12 / remisiones / create</span></div>
        <div class="app-body">
            <div class="panel">
                <div class="panel-title" style="justify-content:space-between">Muestras <span class="b b-primary b-sm">+ Agregar <span class="mk">2</span></span></div>
                <div class="grupo">
                    <span class="mk mk-abs" style="right:-9px;top:-9px">✕</span>
                    <div>
                        <div class="fgrid" style="grid-template-columns:2fr 1fr">
                            <div class="fld"><label>Mixer <span class="req">*</span></label><input type="text" value="M-45" readonly tabindex="-1"></div>
                            <div class="fld"><label>Muestras <span class="req">*</span> <span class="mk">3</span></label><input type="number" value="3" readonly tabindex="-1"></div>
                            <div class="fld" style="grid-column:1/-1"><label>Concretera <span class="req">*</span> <span class="copy">⧉</span> <span class="mk">4</span></label><input type="text" value="Hormigonera Sur" readonly tabindex="-1"></div>
                            <div class="fld"><label>Elemento <span class="req">*</span> <span class="copy">⧉</span></label><input type="text" value="Losa" readonly tabindex="-1"></div>
                            <div class="fld"><label>Fck (MPa) <span class="req">*</span> <span class="copy">⧉</span></label><input type="number" value="25" readonly tabindex="-1"></div>
                            <div class="fld"><label>Fecha de moldeo <span class="req">*</span> <span class="copy">⧉</span></label><input type="text" value="06/10/2026" readonly tabindex="-1"></div>
                            <div class="fld"><label>Hora <span class="req">*</span> <span class="copy">⧉</span></label><input type="text" value="09:30" readonly tabindex="-1"></div>
                        </div>
                    </div>
                    <div>
                        <div style="font-size:10px;font-weight:600;color:#6b7280;margin-bottom:5px">Probetas generadas <span class="mk">5</span></div>
                        <div class="muestra"><b>M-45-A</b><span>Edad ensayo <input type="text" value="7" readonly tabindex="-1"> días</span></div>
                        <div class="muestra"><b>M-45-B</b><span>Edad ensayo <input type="text" value="28" readonly tabindex="-1"> días</span></div>
                        <div class="muestra"><b>M-45-C</b><span>Edad ensayo <input type="text" value="28" readonly tabindex="-1"> días</span></div>
                    </div>
                </div>
            </div>
            <div class="actions"><span class="b">Cancelar</span><span class="b b-primary">+ Guardar <span class="mk">6</span></span></div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">2</span><span><b>Agregar</b> crea un grupo de muestras (un grupo por mixer / camión). Podés agregar varios grupos; la <b>✕</b> quita un grupo.</span></li>
        <li><span class="mk">3</span><span>Indicá el <b>mixer</b> y la <b>cantidad de muestras</b> (1 a 26).</span></li>
        <li><span class="mk">4</span><span>El ícono <b>⧉ Copiar a todos</b> replica ese valor (concretera, Fck, elemento, fecha u hora) en todos los grupos.</span></li>
        <li><span class="mk">5</span><span>Las probetas se nombran solas: <b>mixer-A, mixer-B…</b> Para cada una indicá la <b>edad de ensayo</b> en días; con eso se agenda el ensayo.</span></li>
        <li><span class="mk">6</span><span>Presioná <b>Guardar</b>.</span></li>
    </ol>
</section>

<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">7</div>
        <div>
            <div class="sec-title">Recepción de probetas (continuación)</div>
            <div class="sec-desc">Listado de remisiones, envío por correo y PDF.</div>
        </div>
    </div>

    <h3 class="sub">Listado de remisiones</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12 / remisiones</span></div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Edificio Torre Norte</div><div class="pg-heading">Remisiones</div></div>
                <span class="b b-primary">+ Nueva remisión</span>
            </div>
            <div style="display:flex;gap:8px;margin-bottom:10px">
                <div class="fld" style="flex:1"><input type="text" placeholder="Buscar por nro, contratista..." readonly tabindex="-1"></div>
                <div class="tabs" style="margin:0;border:none"><span class="tab on">Activas</span><span class="tab">Anuladas</span></div>
            </div>
            <table class="tbl">
                <tr><th>N°</th><th>Contratista</th><th>Estado</th><th class="c">Acciones</th></tr>
                <tr><td><b>0000154</b></td><td>Constructora Sur</td><td><span class="bdg bdg-blue">Enviado</span> <span class="bdg bdg-violet">En informe</span> <span class="mk">1</span></td>
                    <td class="c"><span class="b b-sm">Ver <span class="mk">2</span></span> <span class="b b-sm">Editar</span> <span class="b b-sm b-danger">Anular</span></td></tr>
                <tr><td><b>0000153</b></td><td>Constructora Sur</td><td><span class="bdg bdg-green">Certificado</span></td>
                    <td class="c"><span class="b b-sm">Ver</span></td></tr>
            </table>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>Las etiquetas muestran si la remisión fue <b>Enviada</b> por correo, si sus probetas están <b>En informe</b> y si ya fue <b>Certificada</b>.</span></li>
        <li><span class="mk">2</span><span><b>Ver</b> abre el detalle. <b>Editar</b> modifica datos y muestras. <b>Anular</b> la deja inactiva (se puede reactivar).</span></li>
    </ol>

    <h3 class="sub">Detalle: PDF y envío por correo</h3>
    <div class="two">
        <div class="screen" style="margin:0">
            <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">… / remisiones / 154</span></div>
            <div class="app-body">
                <div class="pg-row">
                    <div class="pg-heading">Remisión 0000154</div>
                </div>
                <div class="actions" style="justify-content:flex-start;margin-bottom:10px">
                    <span class="b b-violet">Enviar por correo <span class="mk">3</span></span>
                    <span class="b">Descargar PDF <span class="mk">4</span></span>
                </div>
                <table class="tbl">
                    <tr><th>Muestra</th><th>Elemento</th><th>Edad</th></tr>
                    <tr><td>M-45-A</td><td>Losa</td><td>7</td></tr>
                    <tr><td>M-45-B</td><td>Losa</td><td>28</td></tr>
                </table>
            </div>
        </div>
        <div class="overlay" style="border-radius:12px">
            <div class="modal-sim">
                <div class="modal-sim-head">Enviar por correo</div>
                <div class="modal-sim-body" style="gap:2px">
                    <div class="pg-label" style="color:#6b7280">Usuarios del sistema</div>
                    <div class="chk"><i class="on"></i> Laboratorio — lab&#64;lemco.com</div>
                    <div class="pg-label" style="color:#6b7280;margin-top:6px">Contactos de la obra <span class="mk">5</span></div>
                    <div class="chk"><i class="on"></i> Ana López — ana.lopez&#64;constructora.com</div>
                    <div class="chk" style="opacity:.5"><i></i> Pedro Ruiz — Sin correo registrado</div>
                </div>
                <div class="modal-sim-foot"><span class="b">Cancelar</span><span class="b b-primary">Enviar</span></div>
            </div>
        </div>
    </div>
    <ol class="steps" style="margin-top:12px">
        <li><span class="mk">3</span><span><b>Enviar por correo</b> abre la selección de destinatarios.</span></li>
        <li><span class="mk">4</span><span><b>Descargar PDF</b> genera el comprobante de recepción.</span></li>
        <li><span class="mk">5</span><span>Marcá los destinatarios: <b>usuarios del sistema</b> con envío habilitado y <b>contactos de la obra</b>. Luego presioná <b>Enviar</b>.</span></li>
    </ol>
    <div class="warn"><span>⚠</span><span>Una vez que las probetas de una remisión se incluyen en un informe, esas probetas ya no se pueden modificar.</span></div>
</section>

{{-- ════════════════════ 8. ENSAYOS ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">8</div>
        <div>
            <div class="sec-title">Ensayos de compresión</div>
            <div class="sec-desc">Agenda mensual y carga de resultados de rotura.</div>
        </div>
        <span class="sec-perm">Menú → Compresión · Permiso ENS</span>
    </div>

    <h3 class="sub">Agenda del mes</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / ensayos</span></div>
        <div class="app-nav">
            <div class="app-nav-left"><span class="app-back">← Menú</span><span class="app-sep"></span><span class="app-title">Ensayos de compresión</span></div>
            <span class="app-user"><span class="app-user-chip">J</span> jperez</span>
        </div>
        <div class="app-body">
            <div class="pg-row" style="align-items:center">
                <div style="display:flex;align-items:center;gap:8px"><span class="b b-sm">‹</span><b style="font-size:14px">octubre 2026</b><span class="b b-sm">›</span> <span class="mk">1</span></div>
                <div class="actions">
                    <div class="fld" style="width:90px"><select tabindex="-1"><option>Octubre</option></select></div>
                    <div class="fld" style="width:64px"><select tabindex="-1"><option>2026</option></select></div>
                    <span class="b">Hoy</span>
                    <span class="bdg bdg-green">● Ensayadas</span><span class="bdg bdg-amber">● Por ensayar</span>
                </div>
            </div>
            <div class="day ok"><div><span class="day-num">6</span><span class="day-name">Mar</span></div><div class="day-sep"></div><div class="day-body"><span class="bdg bdg-green">✓ 4 Ensayadas</span> <span class="b b-sm">PDF <span class="mk">3</span></span></div></div>
            <div class="day mix"><div><span class="day-num">7</span><span class="day-name">Mié</span></div><div class="day-sep"></div><div class="day-body"><span class="bdg bdg-green">✓ 2 Ensayadas</span><span class="bdg bdg-amber">◷ 5 Pendientes</span> <span class="mk">2</span> <span class="b b-sm">PDF</span></div></div>
            <div class="day"><div><span class="day-num">8</span><span class="day-name">Jue</span></div><div class="day-sep"></div><div class="day-body">Sin ensayos programados</div></div>
            <div class="day pend"><div><span class="day-num">9</span><span class="day-name">Vie</span></div><div class="day-sep"></div><div class="day-body"><span class="bdg bdg-amber">◷ 3 Pendientes</span></div></div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>Navegá entre meses con las flechas, los selectores de <b>mes/año</b> o el botón <b>Hoy</b>.</span></li>
        <li><span class="mk">2</span><span>Cada día muestra cuántas probetas están <b>ensayadas</b> y cuántas <b>pendientes</b>. Hacé clic en el día para cargar resultados.</span></li>
        <li><span class="mk">3</span><span><b>PDF</b> descarga la planilla de resultados de ese día.</span></li>
    </ol>
</section>

<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">8</div>
        <div>
            <div class="sec-title">Ensayos de compresión (continuación)</div>
            <div class="sec-desc">Carga de resultados de un día.</div>
        </div>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / ensayos / 2026-10-07</span></div>
        <div class="app-nav">
            <div class="app-nav-left"><span class="app-back">← Agenda</span><span class="app-sep"></span><span class="app-title">Ensayos de compresión</span></div>
            <span class="app-user"><span class="app-user-chip">J</span> jperez</span>
        </div>
        <div class="app-body">
            <div class="pg-row">
                <div class="pg-heading">Probetas del <span style="color:#1d4ed8">7 de octubre 2026</span></div>
                <div class="actions"><span class="bdg bdg-amber">5 pendientes</span><span class="bdg bdg-green">2 ensayadas</span></div>
            </div>
            <div class="tabs"><span class="tab on">Por ensayar <span class="n">5</span></span><span class="tab">Ensayadas <span class="n">2</span></span> <span class="mk" style="margin-left:6px">1</span></div>
            <table class="tbl">
                <tr><th>Obra</th><th>Muestra</th><th>Defecto</th><th class="c">Carga rotura</th><th class="c">Tipo</th><th class="c">Ø Sup 1</th><th class="c">Ø Sup 2</th><th class="c">Ø Inf 1</th><th class="c">Ø Inf 2</th><th class="c">Alt 1</th><th class="c">Alt 2</th><th class="c">Alt 3</th></tr>
                <tr>
                    <td>Torre Norte</td><td><b>M-45-A</b></td>
                    <td><input type="text" value="Ninguno" readonly tabindex="-1"></td>
                    <td><input type="text" value="412.5" readonly tabindex="-1"></td>
                    <td><select tabindex="-1"><option>2</option></select></td>
                    <td><input type="text" value="150.1" readonly tabindex="-1"></td>
                    <td><input type="text" value="150.0" readonly tabindex="-1"></td>
                    <td><input type="text" value="150.2" readonly tabindex="-1"></td>
                    <td><input type="text" value="149.9" readonly tabindex="-1"></td>
                    <td><input type="text" value="300" readonly tabindex="-1"></td>
                    <td><input type="text" value="301" readonly tabindex="-1"></td>
                    <td><input type="text" value="300" readonly tabindex="-1"></td>
                </tr>
                <tr>
                    <td>Torre Norte</td><td><b>M-45-B</b></td>
                    <td><input type="text" placeholder="Sin defecto" readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="kN" readonly tabindex="-1"></td>
                    <td><select tabindex="-1"><option>—</option></select></td>
                    <td><input type="text" placeholder="mm" readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="mm" readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="mm" readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="mm" readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="mm" readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="mm" readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="mm" readonly tabindex="-1"></td>
                </tr>
                <tr>
                    <td>Puente R2</td><td><b>C-12-A</b> <span class="bdg bdg-gray">🔒 En informe</span></td>
                    <td colspan="10" style="color:#9ca3af;font-size:10px">Fila bloqueada — la probeta ya forma parte de un informe <span class="mk">4</span></td>
                </tr>
            </table>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>Pestaña <b>Por ensayar</b>: probetas pendientes del día. Pestaña <b>Ensayadas</b>: las que ya tienen resultado (también se pueden corregir).</span></li>
        <li><span class="mk">2</span><span>Cargá por cada probeta: <b>Defecto</b>, <b>Carga de rotura</b> (kN), <b>Tipo de rotura</b> (1 a 6), <b>dos diámetros superiores</b>, <b>dos inferiores</b> y <b>tres alturas</b> (mm).</span></li>
        <li><span class="mk">3</span><span><b>Guardado automático:</b> no hay botón Guardar. Cada fila se guarda sola al modificar un campo. Si algo falla, aparece un aviso y el campo se marca en rojo.</span></li>
        <li><span class="mk">4</span><span>Las probetas que ya están en un informe aparecen <b>bloqueadas</b>.</span></li>
    </ol>
    <div class="tip"><span>ℹ</span><span><b>Copiar a todas las filas:</b> junto a la mayoría de los campos hay un botón ⧉ que copia ese valor a todas las probetas de la tabla. Útil cuando todas tienen el mismo diámetro o altura.</span></div>
    <div class="warn"><span>⚠</span><span>Una probeta pasa a <b>Ensayadas</b> (y queda disponible para el informe) recién cuando están completos <b>todos</b> los campos de la fila, <b>incluido Defecto</b>. Si no tiene defecto, escribí por ejemplo “Ninguno”. Si se borra algún campo, vuelve a <b>Por ensayar</b>.</span></div>
</section>

{{-- ════════════════════ 9. INFORMES ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">9</div>
        <div>
            <div class="sec-title">Informes de ensayo</div>
            <div class="sec-desc">Generar, verificar y enviar el informe con los resultados.</div>
        </div>
        <span class="sec-perm">Obra → Informes · Permiso INF</span>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12 / informes</span></div>
        <div class="app-body">
            <div class="pg-label">Informes</div>
            <div class="pg-heading" style="margin-bottom:10px">Informes de ensayo</div>
            <div class="tabs"><span class="tab on">Pendientes <span class="n">2</span></span><span class="tab">Generados <span class="n">5</span></span> <span class="mk" style="margin-left:6px">1</span></div>
            <div class="igrid">
                <div class="icard"><div class="t">Rem. 0000154</div><div class="r">Moldeo: 06/10/2026</div><div class="r">🏢 Constructora Sur</div><div class="r">◷ 7 días</div>
                    <div class="f"><span class="bdg bdg-amber">2 prob.</span><span style="color:#1d4ed8;font-weight:600">Ver detalle → <span class="mk">2</span></span></div></div>
                <div class="icard"><div class="t">Rem. 0000150</div><div class="r">Moldeo: 08/09/2026</div><div class="r">🏢 Constructora Sur</div><div class="r">◷ 28 días</div>
                    <div class="f"><span class="bdg bdg-amber">3 prob.</span><span style="color:#1d4ed8;font-weight:600">Ver detalle →</span></div></div>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span><b>Pendientes:</b> grupos de probetas ya ensayadas, agrupadas por remisión, fecha de moldeo y edad. <b>Generados:</b> informes ya emitidos.</span></li>
        <li><span class="mk">2</span><span>Hacé clic en una tarjeta pendiente para crear el informe.</span></li>
    </ol>

    <h3 class="sub">Nuevo informe</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">… / informes / pendientes / 154</span></div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Nuevo informe</div><div class="pg-heading">Rem. 0000154</div><div class="pg-sub">Seleccioná las probetas a incluir en el informe</div></div>
                <span class="b b-primary">Generar informe <span class="mk">4</span></span>
            </div>
            <table class="tbl">
                <tr><th>#</th><th>Nombre</th><th>Elemento</th><th>Fecha ensayo</th><th>Carga rotura</th><th>Tipo rotura</th><th class="c"></th></tr>
                <tr><td>1</td><td><b>M-45-A</b></td><td>Losa</td><td>13/10/2026</td><td>412.5</td><td>2</td><td class="c"><span class="b b-sm b-danger">Excluir <span class="mk">3</span></span></td></tr>
                <tr style="opacity:.5"><td>2</td><td><b>M-45-D</b></td><td>Losa</td><td>13/10/2026</td><td>398.0</td><td>3</td><td class="c"><span class="b b-sm">Incluir</span></td></tr>
            </table>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">3</span><span>Por defecto se incluyen todas las probetas. Usá <b>Excluir / Incluir</b> para elegir cuáles van en el informe.</span></li>
        <li><span class="mk">4</span><span>Presioná <b>Generar informe</b>. El sistema calcula sección, tensión de rotura, relación H/D, corrección y promedio.</span></li>
    </ol>
</section>

<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">9</div>
        <div>
            <div class="sec-title">Informes de ensayo (continuación)</div>
            <div class="sec-desc">Revisión, verificación y envío.</div>
        </div>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12 / informes / 31</span></div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-heading">Informe de ensayo</div>
                    <div style="display:flex;gap:4px;margin-top:3px"><span class="bdg bdg-amber">Pendiente</span> <span class="mk">1</span></div></div>
                <div class="actions">
                    <span class="b b-success">✓ Verificar <span class="mk">2</span></span>
                    <span class="b b-violet">Enviar por correo <span class="mk">3</span></span>
                    <span class="b">Descargar PDF <span class="mk">4</span></span>
                </div>
            </div>
            <div class="panel">
                <div class="panel-title">Datos generales</div>
                <div class="fgrid c3">
                    <div class="fld"><label>Fecha de recepción</label><input type="text" value="06/10/2026" readonly tabindex="-1"></div>
                    <div class="fld"><label>Peticionario</label><input type="text" value="Constructora Sur" readonly tabindex="-1"></div>
                    <div class="fld"><label>Contacto</label><input type="text" value="Ana López" readonly tabindex="-1"></div>
                    <div class="fld"><label>Obra</label><input type="text" value="Edificio Torre Norte" readonly tabindex="-1"></div>
                    <div class="fld"><label>Fecha de ensayo</label><input type="text" value="13/10/2026" readonly tabindex="-1"></div>
                    <div class="fld"><label>Fecha de emisión</label><input type="text" value="14/10/2026" readonly tabindex="-1"></div>
                </div>
            </div>
            <table class="tbl">
                <tr><th>Nombre</th><th>Edad</th><th>Carga</th><th>Sección</th><th>Tensión</th><th>H/D</th><th>C(H/D)</th><th>T. corregida</th><th>T. promedio</th></tr>
                <tr><td>M-45-A</td><td>7</td><td>412.5</td><td>176.7</td><td>23.3</td><td>2.00</td><td>1.00</td><td>23.3</td><td>23.3</td></tr>
            </table>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>El estado del informe: <b>Pendiente</b>, <b>Verificado</b>, <b>Enviado</b> y/o <b>Certificado</b>.</span></li>
        <li><span class="mk">2</span><span><b>Verificar</b>: confirma que los datos fueron revisados. Si hay que corregir algo, usá <b>Marcar como pendiente</b>.</span></li>
        <li><span class="mk">3</span><span><b>Enviar por correo</b>: igual que en remisiones, se eligen usuarios y contactos de la obra y se presiona <b>Enviar</b>.</span></li>
        <li><span class="mk">4</span><span><b>Descargar PDF</b>: genera el informe para imprimir o archivar.</span></li>
    </ol>
    <div class="warn"><span>⚠</span><span><b>Eliminar un informe</b> (ícono de papelera en la lista de Generados) libera sus probetas para volver a editarlas. No se puede eliminar un informe que ya fue <b>certificado</b>.</span></div>
</section>

{{-- ════════════════════ 10. CERTIFICACIÓN ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">10</div>
        <div>
            <div class="sec-title">Certificación</div>
            <div class="sec-desc">Certificado de lo realizado en la obra, por remisión o por informe.</div>
        </div>
        <span class="sec-perm">Obra → Certificación · Permiso CER</span>
    </div>

    <h3 class="sub">Nuevo certificado</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12 / certificacion / crear</span></div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Certificación</div><div class="pg-heading">Nuevo certificado</div></div>
            </div>
            <div class="panel">
                <div class="panel-title">Datos del certificado <span class="mk">1</span></div>
                <div class="fgrid c4">
                    <div class="fld"><label>Número</label><input type="text" value="18" readonly tabindex="-1"></div>
                    <div class="fld"><label>Precio unitario</label><input type="text" placeholder="0.00" readonly tabindex="-1"></div>
                    <div class="fld"><label>Atte.</label><input type="text" placeholder="Nombre / firma" readonly tabindex="-1"></div>
                    <div class="fld"><label>Señores</label><input type="text" placeholder="Destinatario del certificado" readonly tabindex="-1"></div>
                </div>
            </div>
            <table class="tbl">
                <tr><th>#</th><th>Remisión</th><th>Fecha</th><th>Contratista</th><th class="c">Probetas</th><th class="c">Acción</th></tr>
                <tr><td>1</td><td><b>0000150</b></td><td>08/09/2026</td><td>Constructora Sur</td><td class="c">6</td><td class="c"><span class="b b-sm b-danger">Excluir <span class="mk">2</span></span></td></tr>
                <tr><td>2</td><td><b>0000154</b></td><td>06/10/2026</td><td>Constructora Sur</td><td class="c">3</td><td class="c"><span class="b b-sm b-danger">Excluir</span></td></tr>
            </table>
            <div class="actions" style="margin-top:10px"><span class="b">Cancelar</span><span class="b b-primary">Guardar certificado <span class="mk">3</span></span></div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>Completá <b>Número</b>, <b>Precio unitario</b> (por probeta), <b>Atte.</b> (firma) y <b>Señores</b> (destinatario).</span></li>
        <li><span class="mk">2</span><span>La tabla lista los ítems aún no certificados: <b>remisiones</b> u <b>informes</b> según el tipo de certificación de la obra. Excluí los que no correspondan.</span></li>
        <li><span class="mk">3</span><span>Presioná <b>Guardar certificado</b>. Debe haber al menos un ítem incluido.</span></li>
    </ol>

    <h3 class="sub">Detalle del certificado</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / obras / 12 / certificacion / 18</span></div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-heading">Certificado N° 18</div><div style="display:flex;gap:4px;margin-top:3px"><span class="bdg bdg-amber">Sin verificar</span><span class="bdg bdg-gray">No enviado</span></div></div>
                <div class="actions">
                    <span class="b">Editar <span class="mk">4</span></span>
                    <span class="b b-success">✓ Verificar</span>
                    <span class="b b-violet">Enviar por correo</span>
                    <span class="b">Descargar PDF</span>
                </div>
            </div>
            <div class="fgrid c3">
                <div class="panel" style="margin:0;text-align:center"><div class="pg-sub">Total probetas</div><b>9</b></div>
                <div class="panel" style="margin:0;text-align:center"><div class="pg-sub">Precio unitario</div><b>150.000</b></div>
                <div class="panel" style="margin:0;text-align:center"><div class="pg-sub">Total <span class="mk">5</span></div><b>1.350.000</b></div>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">4</span><span><b>Editar</b> permite cambiar datos e incluir ítems nuevos (marcados como “Nuevo disponible”). Luego <b>Verificar</b>, <b>Enviar por correo</b> o <b>Descargar PDF</b>, igual que en informes.</span></li>
        <li><span class="mk">5</span><span>El total se calcula como <b>total de probetas × precio unitario</b>.</span></li>
    </ol>
</section>

{{-- ════════════════════ 11. PENDIENTES ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">11</div>
        <div>
            <div class="sec-title">Pendientes</div>
            <div class="sec-desc">Tablero con todo lo que falta hacer, en un solo lugar.</div>
        </div>
        <span class="sec-perm">Menú → Pendientes · Permiso PEN</span>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / pendientes</span></div>
        <div class="app-body">
            <div class="pg-label">Módulo</div>
            <div class="pg-heading" style="margin-bottom:10px">Pendientes</div>
            <div class="fgrid c3">
                <div class="panel" style="margin:0">
                    <div class="panel-title" style="justify-content:space-between">Ensayos de compresión pendientes <span class="bdg bdg-red">8</span></div>
                    <div class="pg-sub" style="margin-bottom:6px">Agrupados por fecha de ensayo <span class="mk">1</span></div>
                    <div class="muestra"><span><b>miércoles 07 de octubre</b><br><span style="color:#9ca3af">07/10/2026</span></span><span class="bdg bdg-amber">5 probetas</span></div>
                    <div class="muestra"><span><b>viernes 09 de octubre</b><br><span style="color:#9ca3af">09/10/2026</span></span><span class="bdg bdg-amber">3 probetas</span></div>
                </div>
                <div class="panel" style="margin:0">
                    <div class="panel-title" style="justify-content:space-between">Informes pendientes <span class="bdg bdg-blue">5</span></div>
                    <div class="pg-sub" style="margin-bottom:6px">Agrupados por obra <span class="mk">2</span></div>
                    <div class="muestra"><b>Edificio Torre Norte</b><span class="bdg bdg-blue">5 probetas</span></div>
                </div>
                <div class="panel" style="margin:0">
                    <div class="panel-title" style="justify-content:space-between">Certificados pendientes <span class="bdg bdg-amber">9</span></div>
                    <div class="pg-sub" style="margin-bottom:6px">Agrupados por obra <span class="mk">3</span></div>
                    <div class="muestra"><b>Puente Ruta 2</b><span class="bdg bdg-amber">9 probetas</span></div>
                </div>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span><b>Ensayos pendientes:</b> clic en una fecha para ir directo a la carga de resultados de ese día.</span></li>
        <li><span class="mk">2</span><span><b>Informes pendientes:</b> clic en la obra para ir a sus informes por generar.</span></li>
        <li><span class="mk">3</span><span><b>Certificados pendientes:</b> clic en la obra para ir a su certificación.</span></li>
    </ol>
    <div class="tip"><span>ℹ</span><span>Si una fila aparece en gris y no se puede hacer clic, tu usuario no tiene permiso de <b>Agregar</b> en ese módulo.</span></div>

    {{-- ════════════════════ 12. BUSCADOR ════════════════════ --}}
    <div class="sec-head" style="margin-top:22px">
        <div class="sec-num">12</div>
        <div>
            <div class="sec-title">Buscador general</div>
            <div class="sec-desc">Tabla con todas las probetas, filtrable por cualquier columna.</div>
        </div>
        <span class="sec-perm">Menú → Buscador general · Permiso BUS</span>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / buscador</span></div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Buscador</div><div class="pg-heading">Probetas</div></div>
                <div class="actions"><span style="font-size:10.5px;color:#6b7280">124 probeta(s)</span><span class="b b-primary">Buscar <span class="mk">2</span></span><span class="b">Limpiar todo</span></div>
            </div>
            <table class="tbl">
                <tr><th>Nombre ▲ <span class="mk">3</span></th><th>Obra</th><th>Remisión</th><th>Fecha moldeo</th><th>Estado</th><th>Informe</th></tr>
                <tr>
                    <td><input type="text" value="M-45" readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="Filtrar..." readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="Filtrar..." readonly tabindex="-1"></td>
                    <td><input type="text" placeholder="dd/mm/aaaa" readonly tabindex="-1"></td>
                    <td><select tabindex="-1"><option>Todas</option></select></td>
                    <td><select tabindex="-1"><option>Todas</option></select></td>
                </tr>
                <tr><td><b>M-45-A</b> <span class="mk">1</span></td><td>Torre Norte</td><td>0000154</td><td>06/10/2026</td><td>Ensayada</td><td>En informe</td></tr>
                <tr><td><b>M-45-B</b></td><td>Torre Norte</td><td>0000154</td><td>06/10/2026</td><td>Pendiente</td><td>Sin informe</td></tr>
            </table>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>Debajo de cada título hay un <b>filtro</b>: texto, fecha o lista. Escribí y presioná Enter o <b>Buscar</b>.</span></li>
        <li><span class="mk">2</span><span><b>Limpiar todo</b> quita todos los filtros.</span></li>
        <li><span class="mk">3</span><span>Clic en un título <b>ordena</b>; <b>Shift + clic</b> agrega un segundo criterio. Arrastrá la tabla para desplazarte a los costados.</span></li>
    </ol>
    <div class="tip"><span>ℹ</span><span>Con permiso de <b>Editar</b> en el buscador, hacé <b>doble clic</b> sobre una celda para corregir el dato directamente (mixer, concretera, edad, resultados, etc.).</span></div>
</section>

{{-- ════════════════════ 13. INVENTARIO ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">13</div>
        <div>
            <div class="sec-title">Inventario de equipos</div>
            <div class="sec-desc">Alta de equipos, stock disponible y códigos QR.</div>
        </div>
        <span class="sec-perm">Menú → Inventario · Permiso INV</span>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / inventario</span></div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Módulo</div><div class="pg-heading">Inventario</div></div>
                <div class="actions"><span class="b">Descargar todos los QR <span class="mk">5</span></span><span class="b b-primary">+ Nuevo equipo <span class="mk">1</span></span></div>
            </div>
            <div style="display:flex;gap:8px;margin-bottom:10px;align-items:center">
                <div class="fld" style="flex:1"><input type="text" placeholder="Buscar equipo..." readonly tabindex="-1"></div>
                <div class="chk"><i></i> Mostrar solo disponibles <span class="mk">2</span></div>
            </div>
            <table class="tbl">
                <tr><th>Identificación</th><th>Equipo</th><th>Marca</th><th>Modelo</th><th>Categoría</th><th class="c">Existente</th><th class="c">Disponible</th><th class="c">Acción</th></tr>
                <tr><td>HER-001</td><td>Taladro percutor</td><td>Makita</td><td>HR2470</td><td>Herramientas</td><td class="c">4</td><td class="c">3</td>
                    <td class="c"><span class="b b-sm">👁 <span class="mk">3</span></span> <span class="b b-sm">✎</span> <span class="b b-sm">QR <span class="mk">4</span></span> <span class="b b-sm b-danger">🗑</span></td></tr>
            </table>
        </div>
    </div>

    <div class="two">
        <div class="overlay" style="border-radius:12px">
            <div class="modal-sim" style="max-width:none">
                <div class="modal-sim-head">Nuevo equipo</div>
                <div class="modal-sim-body">
                    <div class="fgrid">
                        <div class="fld"><label>Nombre</label><input type="text" placeholder="Ej: Taladro percutor" readonly tabindex="-1"></div>
                        <div class="fld"><label>Marca</label><input type="text" placeholder="Escriba o seleccione" readonly tabindex="-1"></div>
                        <div class="fld"><label>Modelo</label><input type="text" placeholder="Ej: HR2470" readonly tabindex="-1"></div>
                        <div class="fld"><label>Número de serie</label><input type="text" placeholder="Ej: SN-00123" readonly tabindex="-1"></div>
                        <div class="fld"><label>Tipo de equipo</label><select tabindex="-1"><option>Seleccione…</option></select></div>
                        <div class="fld"><label>Categoría</label><input type="text" placeholder="Escriba o seleccione" readonly tabindex="-1"></div>
                        <div class="fld"><label>Cantidad</label><input type="text" placeholder="Ej: 10" readonly tabindex="-1"></div>
                        <div class="fld"><label>Observación</label><input type="text" placeholder="Opcional" readonly tabindex="-1"></div>
                    </div>
                </div>
                <div class="modal-sim-foot"><span class="b">Cancelar</span><span class="b b-primary">Guardar</span></div>
            </div>
        </div>
        <div>
            <ol class="steps">
                <li><span class="mk">1</span><span><b>Nuevo equipo:</b> completá los datos. En <b>Marca</b> y <b>Categoría</b> podés elegir una existente o escribir una nueva.</span></li>
                <li><span class="mk">2</span><span><b>Mostrar solo disponibles</b> oculta los equipos sin stock libre.</span></li>
                <li><span class="mk">3</span><span>El ojo muestra <b>quién retiró</b> el equipo y para qué obra.</span></li>
                <li><span class="mk">4</span><span><b>QR</b> imprime la etiqueta del equipo; se usa para escanearlo en retiros y devoluciones.</span></li>
                <li><span class="mk">5</span><span><b>Descargar todos los QR</b> genera todas las etiquetas juntas.</span></li>
            </ol>
        </div>
    </div>
</section>

{{-- ════════════════════ 14. CONTROL DE EQUIPOS ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">14</div>
        <div>
            <div class="sec-title">Control de equipos</div>
            <div class="sec-desc">Registrar salidas (retiro) y regresos (devolución) de equipos.</div>
        </div>
        <span class="sec-perm">Menú → Control de Equipos · Permiso CVE</span>
    </div>

    <p class="txt">Al entrar al módulo verás dos acciones: <b>Retiro</b> y <b>Devolución</b>, y el botón <b>Ver registros</b> con el historial.</p>

    <h3 class="sub">Retiro de equipos</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / control-equipos / retiro</span></div>
        <div class="app-body">
            <div class="panel">
                <div class="panel-title">Datos del retiro <span class="mk">1</span></div>
                <div class="fgrid">
                    <div class="fld"><label>Obra</label><input type="text" placeholder="Escriba o seleccione una obra" readonly tabindex="-1"></div>
                    <div class="fld"><label>Retirado por</label><input type="text" placeholder="Escriba o seleccione quién retira" readonly tabindex="-1"></div>
                </div>
            </div>
            <div class="panel" style="display:flex;justify-content:space-between;align-items:center">
                <div><div class="panel-title" style="margin:0">Escanear código QR</div><div class="pg-sub">Apuntá la cámara al QR del equipo para agregarlo a la lista</div></div>
                <span class="b b-primary">Iniciar escaneo <span class="mk">2</span></span>
            </div>
            <div class="panel" style="margin-bottom:6px">
                <div class="panel-title">Equipos a retirar <span class="bdg bdg-blue">1</span> <span class="mk">3</span></div>
                <table class="tbl">
                    <tr><th>Identificación</th><th>Equipo</th><th>Marca</th><th>Modelo</th><th>Categoría</th><th class="c">Cantidad</th><th class="c">Acción</th></tr>
                    <tr><td>HER-001</td><td>Taladro percutor</td><td>Makita</td><td>HR2470</td><td>Herramientas</td><td class="c">1</td><td class="c"><span class="b b-sm b-danger">Quitar</span></td></tr>
                </table>
            </div>
            <div class="actions"><span class="b b-primary">✓ Guardar retiro <span class="mk">4</span></span></div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>Elegí la <b>obra</b> y la persona que <b>retira</b>.</span></li>
        <li><span class="mk">2</span><span><b>Iniciar escaneo</b> activa la cámara. Apuntá al QR del equipo; si el equipo tiene más de una unidad, se pide la <b>cantidad a retirar</b> y se presiona <b>Confirmar</b>.</span></li>
        <li><span class="mk">3</span><span>Los equipos escaneados se acumulan en la lista. <b>Quitar</b> elimina uno.</span></li>
        <li><span class="mk">4</span><span><b>Guardar retiro</b> registra la salida y descuenta el stock disponible.</span></li>
    </ol>

    <h3 class="sub">Devolución y registros</h3>
    <p class="txt">
        La <b>Devolución</b> funciona igual: escaneás el QR del equipo, el sistema muestra la obra y quién lo retiró,
        indicás la <b>cantidad a devolver</b>, confirmás y guardás. En <b>Ver registros</b> se consulta el historial,
        con buscador por obra, persona o equipo, y el estado <span class="bdg bdg-green">Devuelto</span> o <span class="bdg bdg-amber">Pendiente</span>.
    </p>
    <div class="warn"><span>⚠</span><span>Un equipo que tiene una <b>devolución pendiente</b> no puede volver a retirarse hasta que se devuelva. Para usar la cámara, el navegador debe tener permiso de acceso a la cámara.</span></div>
</section>

{{-- ════════════════════ 15. REPORTES ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">15</div>
        <div>
            <div class="sec-title">Reportes</div>
            <div class="sec-desc">Reportes gerenciales en PDF.</div>
        </div>
        <span class="sec-perm">Menú → Reporte · Permiso REP / REC</span>
    </div>

    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / reportes / certificado</span></div>
        <div class="app-body">
            <div class="panel">
                <div class="panel-title">Parámetros del reporte</div>
                <div class="fgrid">
                    <div class="fld full"><label>Obra <span class="mk">1</span></label><input type="text" placeholder="Escriba para filtrar o deje vacío para todas las obras" readonly tabindex="-1"></div>
                    <div class="fld full"><label>Período <span class="mk">2</span></label>
                        <div style="display:flex;gap:6px"><span class="b b-primary b-sm">Rango de fechas</span><span class="b b-sm">Mes</span></div></div>
                    <div class="fld"><label>Fecha desde</label><input type="text" value="01/09/2026" readonly tabindex="-1"></div>
                    <div class="fld"><label>Fecha hasta</label><input type="text" value="30/09/2026" readonly tabindex="-1"></div>
                </div>
                <div class="actions" style="margin-top:10px"><span class="b b-primary">Generar PDF <span class="mk">3</span></span></div>
            </div>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>En el reporte <b>Certificado</b>, elegí una obra o dejá vacío para incluir todas.</span></li>
        <li><span class="mk">2</span><span>Elegí el <b>período</b>: por rango de fechas (desde / hasta) o por mes.</span></li>
        <li><span class="mk">3</span><span><b>Generar PDF</b> descarga el reporte.</span></li>
    </ol>

    {{-- ════════════════════ 16. ADMINISTRACIÓN ════════════════════ --}}
    <div class="sec-head" style="margin-top:22px">
        <div class="sec-num">16</div>
        <div>
            <div class="sec-title">Administración: áreas, usuarios y permisos</div>
            <div class="sec-desc">Los permisos se asignan por área; cada usuario pertenece a un área.</div>
        </div>
        <span class="sec-perm">Permisos ARE · USU · PER</span>
    </div>

    <div class="flow" style="margin-top:4px">
        <div class="flow-step"><div class="fs-n">1</div><div class="fs-t">Crear el área</div><div class="fs-d">Menú → Áreas → Nueva área</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-step"><div class="fs-n">2</div><div class="fs-t">Darle permisos</div><div class="fs-d">Menú → Permisos → Editar permisos</div></div>
        <div class="flow-arrow">→</div>
        <div class="flow-step"><div class="fs-n">3</div><div class="fs-t">Asignar usuarios</div><div class="fs-d">Menú → Usuarios → Área</div></div>
    </div>

    <h3 class="sub">Áreas</h3>
    <p class="txt">Presioná <b>Nueva área</b>, escribí la <b>Descripción</b> (ej.: “Laboratorio”) y guardá. Desde la tabla podés <b>Editar</b>, <b>Anular</b> o <b>Activar</b> un área.</p>
</section>

<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">16</div>
        <div>
            <div class="sec-title">Administración (continuación)</div>
            <div class="sec-desc">Permisos por módulo y gestión de usuarios.</div>
        </div>
    </div>

    <h3 class="sub">Permisos de un área</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / permisos / 2 / editar</span></div>
        <div class="app-body">
            <div class="pg-row">
                <div><div class="pg-label">Permisos</div><div class="pg-heading">Laboratorio</div></div>
                <span class="b b-primary">Guardar permisos <span class="mk">3</span></span>
            </div>
            <table class="tbl">
                <tr><th>Módulo</th><th class="c"><span class="bdg bdg-blue">Ver</span></th><th class="c"><span class="bdg bdg-green">Agregar</span></th><th class="c"><span class="bdg bdg-amber">Editar</span></th><th class="c"><span class="bdg bdg-red">Eliminar</span> <span class="mk">2</span></th></tr>
                <tr><td><b>Obras</b><br><span style="color:#9ca3af">OBR</span> <span class="mk">1</span></td><td class="c"><span class="tg on"></span></td><td class="c"><span class="tg on"></span></td><td class="c"><span class="tg on"></span></td><td class="c"><span class="tg"></span></td></tr>
                <tr><td><b>Ensayos de compresión</b><br><span style="color:#9ca3af">ENS</span></td><td class="c"><span class="tg on"></span></td><td class="c"><span class="tg on"></span></td><td class="c"><span class="tg on"></span></td><td class="c"><span class="tg"></span></td></tr>
                <tr><td><b>Usuarios</b><br><span style="color:#9ca3af">USU</span></td><td class="c"><span class="tg"></span></td><td class="c"><span class="tg"></span></td><td class="c"><span class="tg"></span></td><td class="c"><span class="tg"></span></td></tr>
            </table>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span>Cada fila es un <b>módulo</b> del sistema (con su abreviatura).</span></li>
        <li><span class="mk">2</span><span>Activá los interruptores: <b>Ver</b> (entrar y consultar), <b>Agregar</b> (crear), <b>Editar</b> (modificar, verificar, enviar) y <b>Eliminar</b> (anular, inactivar, borrar).</span></li>
        <li><span class="mk">3</span><span>Presioná <b>Guardar permisos</b>. Los cambios se aplican al volver a iniciar sesión.</span></li>
    </ol>

    <h3 class="sub">Usuarios</h3>
    <div class="screen">
        <div class="screen-bar"><i></i><i></i><i></i><span class="screen-url">lemco / usuarios</span></div>
        <div class="app-body">
            <table class="tbl">
                <tr><th>#</th><th>Usuario</th><th>Estado</th><th>Área <span class="mk">1</span></th><th class="c">Envío <span class="mk">2</span></th><th class="c">Acciones <span class="mk">3</span></th></tr>
                <tr><td>1</td><td><b>jperez</b></td><td><span class="bdg bdg-green">Activo</span></td><td><div class="fld"><select tabindex="-1"><option>Laboratorio</option></select></div></td><td class="c"><span class="tg on"></span></td><td class="c"><span class="b b-sm">⋯</span></td></tr>
                <tr><td>2</td><td><b>mgomez</b></td><td><span class="bdg bdg-red">Inactivo</span></td><td><div class="fld"><select tabindex="-1"><option>Sin área</option></select></div></td><td class="c"><span class="tg"></span></td><td class="c"><span class="b b-sm">⋯</span></td></tr>
            </table>
        </div>
    </div>
    <ol class="steps">
        <li><span class="mk">1</span><span><b>Área:</b> asigná el área del usuario; define qué módulos ve y qué puede hacer.</span></li>
        <li><span class="mk">2</span><span><b>Envío:</b> si está activo, el usuario aparece como destinatario en los envíos por correo (remisiones, informes y certificados).</span></li>
        <li><span class="mk">3</span><span><b>Acciones:</b> <b>Inactivar usuario</b> le impide iniciar sesión; <b>Activar usuario</b> lo habilita de nuevo.</span></li>
    </ol>
</section>

{{-- ════════════════════ 17. GLOSARIO ════════════════════ --}}
<section class="sheet">
    <div class="sec-head">
        <div class="sec-num">17</div>
        <div>
            <div class="sec-title">Glosario de estados</div>
            <div class="sec-desc">Qué significa cada etiqueta que aparece en el sistema.</div>
        </div>
    </div>

    <table class="gloss">
        <tr><td><span class="bdg bdg-green">Activa / Activo</span></td><td>El registro (obra, contacto, área, usuario) está en uso.</td></tr>
        <tr><td><span class="bdg bdg-red">Inactiva / Anulada</span></td><td>El registro fue dado de baja. Puede reactivarse desde la pestaña correspondiente.</td></tr>
        <tr><td><span class="bdg bdg-amber">Por ensayar / Pendiente</span></td><td>La probeta todavía no tiene resultado de rotura cargado.</td></tr>
        <tr><td><span class="bdg bdg-green">Ensayada</span></td><td>La probeta tiene carga de rotura y está lista para informe.</td></tr>
        <tr><td><span class="bdg bdg-gray">🔒 En informe</span></td><td>La probeta forma parte de un informe generado; sus datos quedan bloqueados.</td></tr>
        <tr><td><span class="bdg bdg-amber">Pendiente (informe)</span></td><td>Informe generado pero aún no verificado ni enviado.</td></tr>
        <tr><td><span class="bdg bdg-green">Verificado</span></td><td>Un responsable revisó y aprobó el informe o certificado.</td></tr>
        <tr><td><span class="bdg bdg-blue">Enviado</span></td><td>El documento ya fue enviado por correo a los destinatarios.</td></tr>
        <tr><td><span class="bdg bdg-violet">Certificado</span></td><td>La remisión o informe ya está incluido en un certificado.</td></tr>
        <tr><td><span class="bdg bdg-amber">Devolución pendiente</span></td><td>Equipo retirado que aún no fue devuelto.</td></tr>
        <tr><td><span class="bdg bdg-green">Devuelto</span></td><td>Equipo retirado que ya regresó al inventario.</td></tr>
    </table>

    <h3 class="sub">Preguntas frecuentes</h3>
    <table class="gloss">
        <tr><td>No veo un módulo</td><td>Tu área no tiene permiso <b>Ver</b> en ese módulo. Consultá con el administrador.</td></tr>
        <tr><td>No puedo editar una probeta</td><td>Ya forma parte de un informe. Si es necesario corregirla, se debe eliminar el informe (si no está certificado) y volver a generarlo.</td></tr>
        <tr><td>Un contacto no aparece para enviar correo</td><td>El contacto no tiene correo cargado o está anulado. Editalo en <b>Contactos</b> de la obra.</td></tr>
        <tr><td>No aparece un ensayo en la agenda</td><td>Revisá la <b>fecha de moldeo</b> y la <b>edad de ensayo</b> de la probeta en la remisión o en el buscador.</td></tr>
        <tr><td>La cámara no escanea</td><td>Permití el acceso a la cámara en el navegador y verificá que haya buena luz sobre el QR.</td></tr>
    </table>

    <div class="doc-foot">
        <span>LemcoProject · Instructivo de uso</span>
        <span>Generado el {{ now()->format('d/m/Y') }}</span>
    </div>
</section>

</body>
</html>
