<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción de probetas — {{ $obra->nombre }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #111827;
            display: flex; flex-direction: column;
        }

        /* ── Navbar ── */
        .navbar {
            background: #fff; border-bottom: 1px solid #e9ecef;
            padding: 0 24px; height: 54px;
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .navbar-left { display: flex; align-items: center; gap: 12px; }
        .btn-back {
            display: flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 8px;
            padding: 6px 11px; font-size: 13px; font-weight: 500;
            color: #6b7280; text-decoration: none; transition: all 0.15s;
        }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }
        .nav-sep { width: 1px; height: 18px; background: #e9ecef; }
        .navbar-title {
            font-size: 14px; font-weight: 600; color: #111827;
            max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .navbar-user {
            display: flex; align-items: center; gap: 7px;
            font-size: 13px; font-weight: 500; color: #374151;
            background: #f1f3f5; border: 1.5px solid #e9ecef;
            padding: 4px 11px 4px 5px; border-radius: 99px;
        }
        .user-chip {
            width: 24px; height: 24px; border-radius: 50%;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0;
        }

        /* ── Page ── */
        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 20px; }

        /* ── Header ── */
        .page-header {
            display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;
            animation: fadeUp 0.35s ease both;
        }
        .page-label { font-size: 11.5px; font-weight: 600; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Toolbar: tabs + buscador ── */
        .toolbar {
            display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
            animation: fadeUp 0.35s ease 0.05s both;
        }
        .tabs { display: flex; gap: 4px; }
        .tab-btn {
            display: inline-flex; align-items: center; gap: 7px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 9px;
            padding: 6px 13px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .tab-btn:hover { border-color: #d1d5db; color: #374151; background: #f8f9fa; }
        .tab-btn.active { background: #eef2ff; border-color: #c7d2fe; color: #4338ca; font-weight: 600; }
        .tab-count {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 18px; height: 18px; border-radius: 99px;
            background: #e5e7eb; color: #6b7280;
            font-size: 11px; font-weight: 700; padding: 0 5px;
        }
        .tab-btn.active .tab-count { background: #c7d2fe; color: #3730a3; }

        .search-wrap { position: relative; flex: 1; min-width: 180px; max-width: 320px; }
        .search-icon {
            position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; display: flex; pointer-events: none;
        }
        .search-icon svg { width: 14px; height: 14px; }
        .search-input {
            width: 100%;
            border: 1.5px solid #e9ecef; border-radius: 9px;
            padding: 7px 12px 7px 33px;
            font-size: 13px; color: #111827; background: #fff;
            outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .search-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .search-input::placeholder { color: #9ca3af; }

        /* ── Grid ── */
        .remisiones-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 210px));
            justify-content: start;
            gap: 14px;
            animation: fadeUp 0.4s ease 0.1s both;
        }

        /* ── Card nueva ── */
        .card-nueva {
            background: #fff;
            border: 2px dashed #c7d2fe;
            border-radius: 16px;
            text-decoration: none;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 10px;
            aspect-ratio: 1 / 1;
            transition: border-color 0.18s, background 0.18s;
            color: #4f46e5;
        }
        .card-nueva:hover { border-color: #4f46e5; background: #eef2ff; }
        .card-nueva-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: #eef2ff; display: flex; align-items: center; justify-content: center;
            transition: background 0.18s;
        }
        .card-nueva:hover .card-nueva-icon { background: #e0e7ff; }
        .card-nueva-icon svg { width: 22px; height: 22px; }
        .card-nueva-label { font-size: 13px; font-weight: 600; text-align: center; line-height: 1.4; padding: 0 12px; }

        /* ── Card remision ── */
        .remision-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 16px;
            display: flex; flex-direction: column;
            aspect-ratio: 1 / 1;
            position: relative;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s;
        }
        .remision-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-color: #d1d5db; }

        .remision-card::before {
            content: ''; position: absolute; top: 0; left: 16px; right: 16px;
            height: 2.5px; border-radius: 0 0 4px 4px; background: #4f46e5;
        }
        .remision-card.anulada { background: #f8fafc; opacity: 0.82; }
        .remision-card.anulada::before { background: #9ca3af; }

        .card-seq {
            position: absolute; top: 10px; right: 10px;
            width: 20px; height: 20px; border-radius: 50%;
            background: #eef2ff; color: #4f46e5;
            font-size: 10px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .remision-card.anulada .card-seq { background: #f1f3f5; color: #9ca3af; }

        .card-inner {
            flex: 1; padding: 18px 16px 10px;
            display: flex; flex-direction: column;
            min-height: 0;
        }
        .card-nro {
            font-size: 16px; font-weight: 700; color: #0f172a;
            letter-spacing: -0.3px; margin-bottom: 2px;
            padding-right: 26px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .card-fecha { font-size: 11px; color: #9ca3af; font-weight: 500; margin-bottom: 10px; }

        .card-rows { display: flex; flex-direction: column; gap: 6px; flex: 1; }
        .card-row { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #374151; }
        .card-row svg { width: 13px; height: 13px; flex-shrink: 0; color: #9ca3af; }
        .card-row span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .card-foot {
            padding: 8px 12px;
            border-top: 1px solid #f1f3f5;
            display: flex; align-items: center; justify-content: space-between; gap: 6px;
            flex-shrink: 0;
        }
        .card-probetas {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 600;
            background: #eef2ff; color: #4f46e5;
            padding: 3px 8px; border-radius: 99px;
        }
        .card-probetas svg { width: 11px; height: 11px; }
        .remision-card.anulada .card-probetas { background: #f1f3f5; color: #9ca3af; }

        /* Botones de acción en la tarjeta */
        .card-actions { display: flex; gap: 4px; flex-shrink: 0; }
        .btn-card {
            display: flex; align-items: center; justify-content: center;
            width: 26px; height: 26px; border-radius: 7px;
            border: 1.5px solid; background: none;
            cursor: pointer; transition: all 0.15s; padding: 0;
        }
        .btn-card svg { width: 13px; height: 13px; }
        .btn-card-ver    { border-color: #e0e7ff; color: #4f46e5; text-decoration: none; }
        .btn-card-ver:hover    { background: #eef2ff; border-color: #a5b4fc; }
        .btn-card-editar { border-color: #e0e7ff; color: #4f46e5; text-decoration: none; }
        .btn-card-editar:hover { background: #eef2ff; border-color: #a5b4fc; }
        .btn-card-anular { border-color: #fecdd3; color: #be123c; }
        .btn-card-anular:hover { background: #fff1f2; border-color: #fca5a5; }
        .btn-card-activar { border-color: #bbf7d0; color: #15803d; }
        .btn-card-activar:hover { background: #f0fdf4; border-color: #86efac; }

        /* ── Badge bloqueada (en informe) ── */
        .badge-bloqueada {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 99px;
            background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
            text-transform: uppercase; letter-spacing: 0.4px;
        }
        .badge-bloqueada svg { width: 10px; height: 10px; flex-shrink: 0; }

        /* ── Badge anulada ── */
        .badge-anulada {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 99px;
            background: #f1f3f5; color: #9ca3af; border: 1px solid #e5e7eb;
            text-transform: uppercase; letter-spacing: 0.4px;
        }

        /* ── Badge certificado ── */
        .badge-certificado {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 99px;
            background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;
            letter-spacing: 0.4px;
        }
        .badge-certificado svg { width: 10px; height: 10px; flex-shrink: 0; }

        /* ── Empty state ── */
        .empty-state {
            grid-column: 1 / -1;
            padding: 56px 24px; text-align: center; color: #9ca3af;
        }
        .empty-state svg { width: 40px; height: 40px; margin: 0 auto 12px; display: block; color: #d1d5db; }
        .empty-state p { font-size: 14px; }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.35);
            display: none; align-items: center; justify-content: center;
            z-index: 100; padding: 20px;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: #fff; border-radius: 18px;
            width: 100%; max-width: 380px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            animation: modalIn 0.2s ease both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-head {
            padding: 18px 20px 14px; border-bottom: 1px solid #f1f3f5;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-title { font-size: 15px; font-weight: 700; color: #0f172a; }
        .modal-close {
            display: flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 8px;
            border: 1.5px solid #e9ecef; background: none;
            cursor: pointer; color: #9ca3af; transition: all 0.15s; padding: 0;
        }
        .modal-close:hover { background: #f1f3f5; color: #374151; }
        .modal-close svg { width: 14px; height: 14px; }
        .modal-body { padding: 18px 20px; font-size: 13.5px; color: #374151; line-height: 1.6; }
        .modal-body strong { color: #111827; font-weight: 600; }
        .modal-warn {
            margin-top: 12px; background: #fff7ed; border: 1.5px solid #fed7aa;
            border-radius: 10px; padding: 10px 14px;
            font-size: 12.5px; color: #c2410c; line-height: 1.5;
        }
        .modal-foot {
            padding: 14px 20px; border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
        }
        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 8px 16px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; }
        .btn-danger {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, #9f1239, #be123c);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 9px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(190,18,60,0.3);
            transition: opacity 0.15s;
        }
        .btn-danger:hover { opacity: 0.9; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 36px; }
            .remisiones-grid { grid-template-columns: 1fr 1fr; }
            .toolbar { gap: 10px; }
            .search-wrap { max-width: 100%; }
        }
        @media (max-width: 380px) {
            .remisiones-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('obras.show', $obra) }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Obra
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">{{ $obra->nombre }}</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">Recepción de probetas</div>
            <div class="page-heading">Remisiones</div>
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
    @if(session('error'))
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Toolbar: tabs + buscador --}}
    <div class="toolbar">
        <div class="tabs">
            <button class="tab-btn active" data-tab="1" onclick="switchTab(1)">
                Activas
                <span class="tab-count" id="count-activas">{{ $activas }}</span>
            </button>
            <button class="tab-btn" data-tab="2" onclick="switchTab(2)">
                Anuladas
                <span class="tab-count" id="count-anuladas">{{ $anuladas }}</span>
            </button>
        </div>
        <div class="search-wrap">
            <span class="search-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </span>
            <input
                type="text"
                id="buscador"
                class="search-input"
                placeholder="Buscar por nro, contratista..."
                oninput="aplicarFiltros()"
                autocomplete="off"
            >
        </div>
    </div>

    {{-- Grid --}}
    <div class="remisiones-grid" id="grid">

        {{-- Card nueva (solo en tab Activas) --}}
        @if($puedeAgregar)
        <a href="{{ route('remisiones.create', $obra) }}" class="card-nueva" id="card-nueva">
            <div class="card-nueva-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
            </div>
            <span class="card-nueva-label">Nueva recepción</span>
        </a>
        @endif

        @php $total = $remisiones->count(); @endphp

        @forelse($remisiones as $i => $remision)
        @php
            $creador = $remision->recibidoPor;
            $nombreCreador = ($creador && $creador->persona && ($creador->persona->nombre || $creador->persona->apellido))
                ? trim($creador->persona->nombre . ' ' . $creador->persona->apellido)
                : ($creador->nick ?? '—');
            $esAnulada      = $remision->estado === 2;
            $esCertificada  = $remisionesCertificadasIds->contains($remision->id);
            $bloqueada      = $remision->probetas->some(fn($p) =>
                $p->detalles->isNotEmpty() || (
                    $p->fecha_ensayo !== null && $p->ensayo_por !== null &&
                    $p->defecto !== null && $p->carga_rotura !== null &&
                    $p->tipo_rotura !== null &&
                    $p->diametro_superior_1 !== null && $p->diametro_superior_2 !== null &&
                    $p->diametro_inferior_1 !== null && $p->diametro_inferior_2 !== null &&
                    $p->altura_1 !== null && $p->altura_2 !== null && $p->altura_3 !== null
                )
            );
        @endphp
        <div
            class="remision-card {{ $esAnulada ? 'anulada' : '' }}"
            data-estado="{{ $remision->estado }}"
            data-buscar="{{ strtolower($remision->nro . ' ' . $remision->contratista . ' ' . $nombreCreador) }}"
        >
            <div class="card-seq">{{ $total - $i }}</div>

            <div class="card-inner">
                <div class="card-nro">{{ $remision->nro }}</div>
                <div class="card-fecha">{{ $remision->created_at->format('d/m/Y') }}</div>

                <div class="card-rows">
                    <div class="card-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                        </svg>
                        <span>{{ $remision->contratista }}</span>
                    </div>
                    <div class="card-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        <span>{{ $nombreCreador }}</span>
                    </div>
                </div>
            </div>

            <div class="card-foot">
                @if($esAnulada)
                    <span class="badge-anulada">Anulada</span>
                @elseif($esCertificada)
                    <span class="badge-certificado">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Certificado
                    </span>
                @elseif($bloqueada)
                    <span class="badge-bloqueada">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        En informe
                    </span>
                @else
                    <span class="card-probetas">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/>
                        </svg>
                        {{ $remision->probetas_count ?? 0 }} probetas
                    </span>
                @endif

                <div class="card-actions">
                    <a href="{{ route('remisiones.show', [$obra, $remision]) }}" class="btn-card btn-card-ver" title="Ver remisión">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </a>
                    @if(!$esAnulada && !$bloqueada && !$esCertificada && $puedeEditar)
                    <a href="{{ route('remisiones.edit', [$obra, $remision]) }}" class="btn-card btn-card-editar" title="Editar remisión">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                        </svg>
                    </a>
                    @endif
                    @if(!$esAnulada && !$bloqueada && !$esCertificada && $puedeEliminar)
                    <button
                        class="btn-card btn-card-anular"
                        title="Anular remisión"
                        onclick="abrirAnular({{ $remision->id }}, @js($remision->nro))"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </button>
                    @elseif($esAnulada && $puedeEliminar)
                    <form method="POST" action="{{ route('remisiones.activar', [$obra, $remision]) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-card btn-card-activar" title="Activar remisión">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        @if(!$puedeAgregar)
        <div class="empty-state" id="empty-inicial">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/>
            </svg>
            <p>No hay remisiones registradas</p>
        </div>
        @endif
        @endforelse

        <div class="empty-state" id="empty-tab" style="display:none;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/>
            </svg>
            <p id="empty-tab-msg">No hay remisiones en esta categoría</p>
        </div>
        <div class="empty-state" id="empty-busqueda" style="display:none;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <p>Sin resultados para la búsqueda</p>
        </div>

    </div>

</main>

{{-- Modal: Anular remisión --}}
@if($puedeEliminar)
<div class="modal-overlay" id="modal-anular" onclick="cerrarEnOverlay(event, 'modal-anular')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Anular remisión</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-anular')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="form-anular" action="">
            @csrf @method('PATCH')
            <div class="modal-body">
                ¿Estás seguro de que querés anular la remisión <strong id="anular-nro"></strong>?
                <div class="modal-warn">
                    La remisión quedará inactiva y podrá reactivarse en cualquier momento.
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-anular')">Cancelar</button>
                <button type="submit" class="btn-danger">Anular</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    let tabActual = 1;

    function switchTab(tab) {
        tabActual = tab;
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.toggle('active', parseInt(b.dataset.tab) === tab);
        });
        const cardNueva = document.getElementById('card-nueva');
        if (cardNueva) cardNueva.style.display = tab === 1 ? '' : 'none';
        aplicarFiltros();
    }

    function aplicarFiltros() {
        const q = document.getElementById('buscador').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.remision-card');
        let visiblesTab = 0, visiblesBusqueda = 0;

        cards.forEach(card => {
            const matchTab    = parseInt(card.dataset.estado) === tabActual;
            const matchSearch = !q || card.dataset.buscar.includes(q);
            const mostrar     = matchTab && matchSearch;
            card.style.display = mostrar ? '' : 'none';
            if (matchTab) visiblesTab++;
            if (mostrar)  visiblesBusqueda++;
        });

        const emptyTab      = document.getElementById('empty-tab');
        const emptyBusqueda = document.getElementById('empty-busqueda');

        if (q) {
            emptyTab.style.display      = 'none';
            emptyBusqueda.style.display = visiblesBusqueda === 0 ? 'block' : 'none';
        } else {
            emptyBusqueda.style.display = 'none';
            emptyTab.style.display      = visiblesTab === 0 ? 'block' : 'none';
            if (visiblesTab === 0) {
                document.getElementById('empty-tab-msg').textContent =
                    tabActual === 1 ? 'No hay remisiones activas' : 'No hay remisiones anuladas';
            }
        }
    }

    function abrirModal(id)  { document.getElementById(id).classList.add('open'); }
    function cerrarModal(id) { document.getElementById(id).classList.remove('open'); }
    function cerrarEnOverlay(e, id) { if (e.target === document.getElementById(id)) cerrarModal(id); }

    function abrirAnular(id, nro) {
        document.getElementById('anular-nro').textContent = nro;
        document.getElementById('form-anular').action = '{{ url("/obras/{$obra->id}/remisiones") }}/' + id + '/anular';
        abrirModal('modal-anular');
    }

    document.addEventListener('DOMContentLoaded', () => switchTab(1));
</script>

</body>
</html>
