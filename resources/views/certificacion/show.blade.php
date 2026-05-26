<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado #{{ $nroCertificado }} — {{ $obra->nombre }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { min-height: 100vh; font-family: 'Inter', sans-serif; background: #f8fafc; color: #111827; display: flex; flex-direction: column; }

        /* ── Navbar ── */
        .navbar { background: #fff; border-bottom: 1px solid #e9ecef; padding: 0 24px; height: 54px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .navbar-left { display: flex; align-items: center; gap: 12px; }
        .btn-back { display: flex; align-items: center; gap: 6px; background: none; border: 1.5px solid #e9ecef; border-radius: 8px; padding: 6px 11px; font-size: 13px; font-weight: 500; color: #6b7280; text-decoration: none; transition: all 0.15s; }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }
        .nav-sep { width: 1px; height: 18px; background: #e9ecef; }
        .navbar-title { font-size: 14px; font-weight: 600; color: #111827; }
        .navbar-user { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 500; color: #374151; background: #f1f3f5; border: 1.5px solid #e9ecef; padding: 4px 11px 4px 5px; border-radius: 99px; }
        .user-chip { width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #1e40af, #1d4ed8); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0; }

        /* ── Page ── */
        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 24px; }

        /* ── Page header ── */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; animation: fadeUp 0.35s ease both; }
        .page-label  { font-size: 11.5px; font-weight: 600; color: #059669; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Chips ── */
        .chips { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
        .chip { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 99px; }
        .chip svg { width: 11px; height: 11px; }
        .chip-verde  { background: #ecfdf5; color: #059669; border: 1.5px solid #a7f3d0; }
        .chip-gris   { background: #f8fafc; color: #9ca3af; border: 1.5px solid #e9ecef; }
        .chip-amber  { background: #fffbeb; color: #d97706; border: 1.5px solid #fde68a; }

        /* ── Header actions ── */
        .header-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; flex-wrap: wrap; }

        .btn-pdf {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 9px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none;
            box-shadow: 0 3px 10px rgba(29,78,216,0.3);
            transition: opacity 0.15s, transform 0.15s;
        }
        .btn-pdf:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-pdf svg { width: 14px; height: 14px; }

        .btn-verificar {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #15803d, #16a34a);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 9px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(21,128,61,0.3);
            transition: opacity 0.15s, transform 0.15s;
        }
        .btn-verificar:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-verificar svg { width: 14px; height: 14px; }

        .btn-email {
            display: inline-flex; align-items: center; gap: 7px;
            background: #fff; color: #374151;
            border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s; cursor: pointer; flex-shrink: 0;
        }
        .btn-email:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-email svg { width: 15px; height: 15px; }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 8px 14px; font-size: 13px; font-weight: 500;
            color: #374151; text-decoration: none; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-secondary:hover { background: #f8f9fa; border-color: #d1d5db; }
        .btn-secondary svg { width: 14px; height: 14px; }

        .btn-pendiente {
            display: inline-flex; align-items: center; gap: 7px;
            background: none; border: 1.5px solid #d1d5db; border-radius: 10px;
            padding: 8px 16px; font-size: 13px; font-weight: 500; color: #6b7280;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s;
        }
        .btn-pendiente:hover { background: #f1f3f5; border-color: #9ca3af; color: #374151; }
        .btn-pendiente svg { width: 14px; height: 14px; }

        /* ── Modal enviar ── */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.35); display: none; align-items: center; justify-content: center; z-index: 100; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 18px; width: 100%; max-width: 480px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); animation: modalIn 0.2s ease both; display: flex; flex-direction: column; max-height: 90vh; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(10px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .modal-head { padding: 18px 20px 14px; border-bottom: 1px solid #f1f3f5; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .modal-title { font-size: 15px; font-weight: 700; color: #0f172a; }
        .modal-close { display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; border: 1.5px solid #e9ecef; background: none; cursor: pointer; color: #9ca3af; transition: all 0.15s; padding: 0; }
        .modal-close:hover { background: #f1f3f5; color: #374151; }
        .modal-close svg { width: 14px; height: 14px; }
        .modal-body { padding: 16px 20px; overflow-y: auto; flex: 1; }
        .modal-foot { padding: 14px 20px; border-top: 1.5px solid #e9ecef; display: flex; justify-content: flex-end; gap: 8px; flex-shrink: 0; }
        .group-label { font-size: 10.5px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; margin-top: 4px; }
        .group-label:not(:first-child) { margin-top: 18px; }
        .recipient-row { display: flex; align-items: center; gap: 12px; padding: 9px 12px; border-radius: 10px; border: 1.5px solid #e9ecef; margin-bottom: 6px; cursor: pointer; transition: background 0.12s, border-color 0.12s; background: #fff; }
        .recipient-row:hover { background: #f8faff; border-color: #c7d2fe; }
        .recipient-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: #4f46e5; flex-shrink: 0; cursor: pointer; }
        .recipient-info { flex: 1; min-width: 0; }
        .recipient-name { display: block; font-size: 13px; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .recipient-email { display: block; font-size: 11.5px; color: #6b7280; }
        .recipient-no-email { font-size: 11.5px; color: #fca5a5; font-style: italic; }
        .empty-group { font-size: 12.5px; color: #9ca3af; padding: 8px 0; font-style: italic; }
        .btn-cancel { display: inline-flex; align-items: center; background: none; border: 1.5px solid #e9ecef; border-radius: 10px; padding: 8px 16px; font-size: 13px; font-weight: 500; color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s; }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; }
        .btn-send { display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #4338ca, #4f46e5); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 10px; padding: 9px 18px; cursor: pointer; font-family: 'Inter', sans-serif; box-shadow: 0 3px 10px rgba(79,70,229,0.3); transition: opacity 0.15s; }
        .btn-send:hover { opacity: 0.9; }
        .btn-send svg { width: 14px; height: 14px; }

        /* ── Alertas ── */
        .alert { border-radius: 10px; padding: 12px 16px; font-size: 13px; display: flex; align-items: center; gap: 10px; animation: fadeUp 0.35s ease both; }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Cabecera card ── */
        .info-card {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 16px;
            padding: 0; overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            animation: fadeUp 0.38s ease 0.05s both;
        }
        .info-card-head {
            padding: 14px 20px;
            background: #f8fafc;
            border-bottom: 1.5px solid #e9ecef;
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .info-card-head svg { width: 14px; height: 14px; color: #059669; }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 0;
        }
        .info-cell {
            padding: 16px 20px;
            border-right: 1px solid #f1f3f5;
            border-bottom: 1px solid #f1f3f5;
        }
        .info-cell:last-child { border-right: none; }
        .info-cell-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-cell-value { font-size: 14px; font-weight: 600; color: #111827; }
        .info-cell-value.precio { color: #059669; font-size: 15px; }

        /* ── Tabla detalles ── */
        .table-section { animation: fadeUp 0.4s ease 0.1s both; }
        .table-section-head {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .table-section-head svg { width: 14px; height: 14px; color: #059669; }
        .items-badge { font-size: 11.5px; font-weight: 700; color: #059669; background: #ecfdf5; border: 1.5px solid #a7f3d0; padding: 2px 10px; border-radius: 99px; margin-left: auto; }

        .table-wrap { border: 1.5px solid #e9ecef; border-radius: 14px; overflow: hidden; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f8fafc; border-bottom: 1.5px solid #e9ecef; }
        thead th { padding: 10px 16px; font-size: 11.5px; font-weight: 700; color: #6b7280; text-align: left; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
        thead th.th-center { text-align: center; }
        tbody tr { border-bottom: 1px solid #f1f3f5; transition: background 0.12s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fafafa; }
        td { padding: 13px 16px; font-size: 13px; color: #374151; vertical-align: middle; }
        td.td-nro   { font-weight: 700; color: #0f172a; }
        td.td-center { text-align: center; }
        td.td-mono  { font-family: 'SF Mono', 'Fira Code', monospace; font-size: 12px; }

        /* ── Resumen total ── */
        .resumen {
            display: flex; justify-content: flex-end;
            animation: fadeUp 0.42s ease 0.15s both;
        }
        .resumen-box {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 14px;
            padding: 16px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            display: flex; flex-direction: column; gap: 8px; min-width: 240px;
        }
        .resumen-row { display: flex; justify-content: space-between; align-items: center; gap: 24px; font-size: 13px; color: #374151; }
        .resumen-row.total { font-weight: 700; font-size: 14px; color: #0f172a; padding-top: 8px; border-top: 1.5px solid #e9ecef; }
        .resumen-val { font-weight: 600; color: #059669; }
        .resumen-row.total .resumen-val { font-size: 16px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            .page { padding: 20px 16px 40px; }
            .page-header { flex-direction: column; gap: 12px; }
            .info-grid { grid-template-columns: 1fr 1fr; }
            .resumen { justify-content: stretch; }
            .resumen-box { width: 100%; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('certificacion.index', $obra) }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Certificación
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Certificado #{{ $nroCertificado }}</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    @php
        $tipoCert     = $obra->tipo_certificacion;
        $totalProbetas = 0;
        foreach ($certificado->detalles as $d) {
            if ($tipoCert === 1 && $d->remision) {
                $totalProbetas += $d->remision->probetas->count();
            } elseif ($tipoCert === 2 && $d->informe) {
                $totalProbetas += $d->informe->detalles->count();
            }
        }
        $totalItems = $certificado->detalles->count();
        $totalMonto = $totalProbetas * $certificado->precio_unitario;
    @endphp

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">{{ $obra->nombre }} — Certificación</div>
            <div class="page-heading">Certificado #{{ $nroCertificado }}</div>
            <div class="chips">
                @if($certificado->verificado)
                    <span class="chip chip-verde">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Verificado
                    </span>
                @else
                    <span class="chip chip-amber">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Sin verificar
                    </span>
                @endif
                @if($certificado->enviado)
                    <span class="chip chip-verde">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                        Enviado
                    </span>
                @else
                    <span class="chip chip-gris">No enviado</span>
                @endif
                <span class="chip chip-gris">{{ $certificado->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="header-actions">
            @if($certificado->verificado)
                {{-- Quitar verificación --}}
                <form method="POST" action="{{ route('certificacion.desverificar', [$obra, $certificado]) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-pendiente">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>
                        </svg>
                        Marcar como pendiente
                    </button>
                </form>
                {{-- Enviar por correo --}}
                <button type="button" class="btn-email" onclick="abrirModal('modal-enviar')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    Enviar por correo
                </button>
                {{-- Descargar PDF --}}
                <a href="{{ route('certificacion.pdf', [$obra, $certificado]) }}" class="btn-pdf">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    Descargar PDF
                </a>
            @else
                {{-- Editar --}}
                <a href="{{ route('certificacion.edit', [$obra, $certificado]) }}" class="btn-secondary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                    </svg>
                    Editar
                </a>
                {{-- Verificar --}}
                <form method="POST" action="{{ route('certificacion.verificar', [$obra, $certificado]) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-verificar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Verificar
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Datos del certificado ── --}}
    <div class="info-card">
        <div class="info-card-head">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            Datos del certificado
        </div>
        <div class="info-grid">
            <div class="info-cell">
                <div class="info-cell-label">Señores</div>
                <div class="info-cell-value">{{ $certificado->señores }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">Atte.</div>
                <div class="info-cell-value">{{ $certificado->atte }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">Precio unitario</div>
                <div class="info-cell-value precio">Gs. {{ number_format($certificado->precio_unitario, 0, ',', '.') }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">Tipo de certificación</div>
                <div class="info-cell-value">{{ $tipoCert === 1 ? 'Por remisión' : 'Por informe' }}</div>
            </div>
        </div>
    </div>

    {{-- ── Tabla de detalles ── --}}
    <div class="table-section">
        <div class="table-section-head">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
            </svg>
            {{ $tipoCert === 1 ? 'Remisiones' : 'Informes' }} incluidos
            <span class="items-badge">{{ $totalItems }} ítem{{ $totalItems !== 1 ? 's' : '' }}</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ $tipoCert === 1 ? 'Remisión' : 'Informe' }}</th>
                        <th>Fecha</th>
                        @if($tipoCert === 1)
                            <th>Contratista</th>
                        @else
                            <th>Recepción</th>
                        @endif
                        <th class="th-center">Probetas</th>
                        <th class="th-center">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificado->detalles as $i => $detalle)
                    @php
                        $probetas  = $tipoCert === 1
                            ? ($detalle->remision?->probetas->count() ?? 0)
                            : ($detalle->informe?->detalles->count() ?? 0);
                        $subtotal  = $probetas * $certificado->precio_unitario;
                    @endphp
                    <tr>
                        <td class="td-nro">{{ $i + 1 }}</td>

                        @if($tipoCert === 1)
                            <td class="td-nro">
                                Rem. {{ $detalle->remision ? str_pad($detalle->remision->nro, 4, '0', STR_PAD_LEFT) : '—' }}
                            </td>
                            <td>{{ $detalle->remision?->created_at->format('d/m/Y') ?? '—' }}</td>
                            <td>{{ $detalle->remision?->contratista ?? '—' }}</td>
                        @else
                            <td class="td-nro">
                                Informe #{{ $detalle->informe ? ($nrosInformes[$detalle->informe->id] ?? $detalle->informe->id) : '—' }}
                            </td>
                            <td>{{ $detalle->informe?->created_at->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                {{ $detalle->informe?->recepcion
                                    ? 'Rem. ' . str_pad($detalle->informe->recepcion->nro, 4, '0', STR_PAD_LEFT)
                                    : '—' }}
                            </td>
                        @endif

                        <td class="td-center">{{ $probetas }}</td>
                        <td class="td-center td-mono">Gs. {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Resumen ── --}}
    <div class="resumen">
        <div class="resumen-box">
            <div class="resumen-row">
                <span>Ítems incluidos</span>
                <span class="resumen-val">{{ $totalItems }}</span>
            </div>
            <div class="resumen-row">
                <span>Total probetas</span>
                <span class="resumen-val">{{ $totalProbetas }}</span>
            </div>
            <div class="resumen-row">
                <span>Precio unitario</span>
                <span class="resumen-val">Gs. {{ number_format($certificado->precio_unitario, 0, ',', '.') }}</span>
            </div>
            <div class="resumen-row total">
                <span>Total</span>
                <span class="resumen-val">Gs. {{ number_format($totalMonto, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

</main>

{{-- ═══ MODAL: Enviar por correo ═══ --}}
<div class="modal-overlay" id="modal-enviar" onclick="cerrarEnOverlay(event,'modal-enviar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Enviar certificado por correo</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-enviar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('certificacion.enviar', [$obra, $certificado]) }}">
            @csrf
            <div class="modal-body">
                <div class="group-label">Usuarios del sistema</div>
                @forelse($usuarios as $usuario)
                @php
                    $uNombre = trim(($usuario->persona->nombre ?? '') . ' ' . ($usuario->persona->apellido ?? ''));
                    $uCorreo = $usuario->persona->correo ?? null;
                @endphp
                <label class="recipient-row" style="{{ $uCorreo ? '' : 'opacity:0.55;' }}">
                    <input type="checkbox" name="usuarios[]" value="{{ $usuario->id }}" {{ $uCorreo ? 'checked' : 'disabled' }}>
                    <div class="recipient-info">
                        <span class="recipient-name">{{ $uNombre ?: $usuario->nick }}</span>
                        @if($uCorreo)
                            <span class="recipient-email">{{ $uCorreo }}</span>
                        @else
                            <span class="recipient-no-email">Sin correo registrado</span>
                        @endif
                    </div>
                </label>
                @empty
                <p class="empty-group">No hay usuarios con envío habilitado.</p>
                @endforelse

                <div class="group-label">Contactos de la obra</div>
                @forelse($contactos as $contacto)
                <label class="recipient-row" style="{{ $contacto->correo ? '' : 'opacity:0.55;' }}">
                    <input type="checkbox" name="contactos[]" value="{{ $contacto->id }}" {{ $contacto->correo ? 'checked' : 'disabled' }}>
                    <div class="recipient-info">
                        <span class="recipient-name">{{ trim($contacto->nombre . ' ' . $contacto->apellido) }}</span>
                        @if($contacto->correo)
                            <span class="recipient-email">{{ $contacto->correo }}</span>
                        @else
                            <span class="recipient-no-email">Sin correo registrado</span>
                        @endif
                    </div>
                </label>
                @empty
                <p class="empty-group">No hay contactos registrados para esta obra.</p>
                @endforelse
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-enviar')">Cancelar</button>
                <button type="submit" class="btn-send">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModal(id)  { document.getElementById(id).classList.add('open'); }
    function cerrarModal(id) { document.getElementById(id).classList.remove('open'); }
    function cerrarEnOverlay(e, id) { if (e.target === document.getElementById(id)) cerrarModal(id); }
</script>

</body>
</html>
