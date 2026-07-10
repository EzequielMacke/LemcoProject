<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario — LemcoProject</title>
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
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ── */
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 0 24px;
            height: 54px;
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .navbar-left { display: flex; align-items: center; gap: 12px; }

        .btn-back {
            display: flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 8px;
            padding: 6px 11px; font-size: 13px; font-weight: 500;
            color: #6b7280; text-decoration: none;
            transition: all 0.15s;
        }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }

        .nav-sep { width: 1px; height: 18px; background: #e9ecef; }
        .navbar-title { font-size: 14px; font-weight: 600; color: #111827; }

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
        .page {
            flex: 1;
            padding: 28px 24px 40px;
            display: flex; flex-direction: column; gap: 20px;
        }

        /* ── Page header ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            animation: fadeUp 0.35s ease both;
        }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #9333ea; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #6b21a8, #9333ea);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(147,51,234,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary svg { width: 14px; height: 14px; }

        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 16px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }

        .btn-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 8px;
            border: 1.5px solid #e9ecef; background: #fff;
            cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif;
            padding: 0; text-decoration: none;
        }
        .btn-icon svg { width: 14px; height: 14px; }

        .btn-icon-edit { color: #9333ea; }
        .btn-icon-edit:hover { background: #faf5ff; border-color: #e9d5ff; }

        .btn-icon-print { color: #0d9488; }
        .btn-icon-print:hover { background: #f0fdfa; border-color: #99f6e4; }

        .btn-icon-delete { color: #dc2626; }
        .btn-icon-delete:hover { background: #fef2f2; border-color: #fecaca; }

        .btn-icon-sm {
            display: inline-flex; align-items: center; justify-content: center;
            width: 22px; height: 22px; border-radius: 6px; flex-shrink: 0;
            border: 1.5px solid #e9ecef; background: #fff;
            cursor: pointer; transition: all 0.15s; padding: 0;
        }
        .btn-icon-sm svg { width: 12px; height: 12px; }
        .btn-icon-info { color: #dc2626; }
        .btn-icon-info:hover { background: #fef2f2; border-color: #fecaca; }

        .btn-danger {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #b91c1c, #dc2626);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(220,38,38,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-danger:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-danger:active { transform: translateY(0); }

        .modal-desc { font-size: 13.5px; color: #374151; line-height: 1.5; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Toolbar / búsqueda ── */
        .toolbar {
            display: flex; align-items: center; justify-content: flex-end;
            gap: 12px; flex-wrap: wrap;
            animation: fadeUp 0.38s ease 0.04s both;
        }
        .search-wrap {
            position: relative; flex: 1; max-width: 320px;
        }
        .search-icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; pointer-events: none;
            display: flex; align-items: center;
        }
        .search-icon svg { width: 15px; height: 15px; }
        .search-input {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 13px 9px 36px; font-size: 13px; color: #111827;
            background: #fff; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .search-input:focus {
            border-color: #9333ea;
            box-shadow: 0 0 0 3px rgba(147,51,234,0.1);
        }
        .search-input::placeholder { color: #9ca3af; }

        .toggle-wrap {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: #374151; font-weight: 500;
            white-space: nowrap; cursor: pointer; user-select: none;
        }
        .toggle-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
        .toggle-slider {
            position: absolute; inset: 0; cursor: pointer;
            background: #d1d5db; border-radius: 99px; transition: background 0.2s;
        }
        .toggle-slider::before {
            content: ''; position: absolute; height: 16px; width: 16px;
            left: 3px; top: 3px; background: #fff; border-radius: 50%;
            transition: transform 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.15);
        }
        .toggle-switch input:checked + .toggle-slider { background: #9333ea; }
        .toggle-switch input:checked + .toggle-slider::before { transform: translateX(16px); }

        /* ── Table card ── */
        .table-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease 0.06s both;
        }

        .table-scroll { overflow-x: auto; }

        table { width: 100%; min-width: 940px; table-layout: fixed; border-collapse: collapse; }

        thead th {
            padding: 12px 16px;
            font-size: 11px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.6px;
            background: #f8fafc;
            border-bottom: 1.5px solid #e9ecef;
            text-align: left;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #f1f3f5;
            transition: background 0.12s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }

        tbody td {
            padding: 12px 16px;
            font-size: 13.5px; color: #374151;
            vertical-align: middle;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .td-id      { color: #9ca3af; font-size: 12px; font-weight: 600; }
        .td-desc    { white-space: normal; overflow: visible; }
        .td-desc .equipo-nombre {
            font-weight: 500; color: #111827;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .td-desc .equipo-obs {
            font-size: 11px; font-style: italic; color: #9ca3af;
            margin-top: 2px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .td-muted   { color: #9ca3af; }
        .td-cantidad { font-weight: 700; color: #111827; }
        .td-disponible    { color: #15803d; }
        .td-no-disponible { color: #dc2626; }
        .th-actions { text-align: right; }
        .td-actions { text-align: right; overflow: visible; }
        .td-actions-inner { display: flex; gap: 6px; justify-content: flex-end; }

        /* ── Empty state ── */
        .empty-state {
            padding: 56px 24px;
            text-align: center; color: #9ca3af;
        }
        .empty-state svg { width: 40px; height: 40px; margin: 0 auto 12px; display: block; color: #d1d5db; }
        .empty-state p   { font-size: 14px; }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.35);
            display: none; align-items: center; justify-content: center;
            z-index: 100; padding: 20px;
        }
        .modal-overlay.open { display: flex; }

        .modal {
            background: #fff;
            border-radius: 18px;
            width: 100%; max-width: 420px;
            max-height: calc(100vh - 40px);
            display: flex; flex-direction: column;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            animation: modalIn 0.2s ease both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-head {
            padding: 20px 22px 16px;
            border-bottom: 1px solid #f1f3f5;
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .modal-title { font-size: 15px; font-weight: 700; color: #0f172a; }

        .modal-close {
            display: flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 8px;
            border: 1.5px solid #e9ecef; background: none;
            cursor: pointer; color: #9ca3af; transition: all 0.15s;
            padding: 0;
        }
        .modal-close:hover { background: #f1f3f5; color: #374151; }
        .modal-close svg { width: 14px; height: 14px; }

        .modal-body {
            padding: 20px 22px;
            overflow-y: auto;
            display: flex; flex-direction: column; gap: 14px;
        }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }
        .field input, .field select, .field textarea {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field textarea { resize: vertical; min-height: 64px; }
        .field input:focus, .field select:focus, .field textarea:focus {
            border-color: #9333ea; background: #fff;
            box-shadow: 0 0 0 3px rgba(147,51,234,0.1);
        }
        .field input.is-invalid, .field select.is-invalid, .field textarea.is-invalid { border-color: #f87171; }
        .field-error { font-size: 12px; color: #be123c; }
        .field-hint { font-size: 11.5px; color: #9ca3af; }

        .detalle-row {
            display: flex; justify-content: space-between; align-items: baseline; gap: 12px;
            padding-bottom: 10px; border-bottom: 1px solid #f8fafc;
        }
        .detalle-row:last-child { border-bottom: none; padding-bottom: 0; }
        .detalle-label { font-size: 12px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; flex-shrink: 0; }
        .detalle-value { font-size: 13.5px; font-weight: 600; color: #111827; text-align: right; }
        .modal-section-title {
            font-size: 11px; font-weight: 700; color: #9333ea; text-transform: uppercase;
            letter-spacing: 0.6px; padding-top: 6px; margin-top: 2px;
            border-top: 1px dashed #f1f3f5;
        }

        .tabs-bar {
            display: flex; flex-wrap: wrap; gap: 6px;
            padding-bottom: 4px;
        }
        .tab-btn {
            border: 1.5px solid #e9ecef; background: #fff; border-radius: 8px;
            padding: 6px 10px; font-size: 12px; font-weight: 600; color: #6b7280;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s;
        }
        .tab-btn:hover { border-color: #e9d5ff; color: #9333ea; }
        .tab-btn.active { background: #faf5ff; border-color: #9333ea; color: #9333ea; }

        .modal-foot {
            padding: 16px 22px;
            border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
            flex-shrink: 0;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 780px) {
            .page { padding: 20px 16px 32px; }
            .toolbar { flex-direction: column; align-items: stretch; }
            .search-wrap { max-width: 100%; }

            /* Tabla → tarjetas verticales */
            .table-scroll { overflow-x: visible; }
            table { min-width: 0; }
            thead { display: none; }
            table, tbody, tr, td { display: block; width: 100%; }

            tbody { padding: 12px; display: flex; flex-direction: column; gap: 10px; }
            tr.fila-inventario {
                border: 1.5px solid #e9ecef; border-radius: 14px;
                padding: 4px 14px; border-bottom: 1.5px solid #e9ecef;
            }
            tr.fila-inventario:hover { background: #fff; }

            tbody td {
                display: flex; align-items: center; justify-content: space-between; gap: 14px;
                padding: 9px 0; border-bottom: 1px dashed #f1f3f5;
                white-space: normal; overflow: visible; text-align: right;
            }
            tr.fila-inventario td:last-child { border-bottom: none; }
            tbody td::before {
                content: attr(data-label);
                font-size: 11px; font-weight: 700; color: #9ca3af;
                text-transform: uppercase; letter-spacing: 0.5px;
                text-align: left; flex-shrink: 0;
            }

            .td-desc { align-items: flex-start; flex-direction: column; justify-content: flex-start; gap: 4px; }
            .td-desc .equipo-nombre, .td-desc .equipo-obs { white-space: normal; text-align: left; }

            .td-actions { flex-direction: column; align-items: stretch; justify-content: flex-start; gap: 8px; padding-top: 12px; }
            .td-actions::before { content: none; }
            .td-actions-inner { justify-content: flex-end; }

            #fila-sin-resultados { display: block; }
            #fila-sin-resultados td { display: block; text-align: center; }
            #fila-sin-resultados td::before { content: none; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('menu.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Volver
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Inventario</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    @php
        $permsInv      = session('permisos', [])['inv'] ?? [];
        $puedeAgregar  = $permsInv['agregar']  ?? false;
        $puedeEditar   = $permsInv['editar']   ?? false;
        $puedeEliminar = $permsInv['eliminar'] ?? false;
    @endphp

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">Módulo</div>
            <div class="page-heading">Inventario</div>
        </div>
        <div style="display: flex; gap: 8px;">
            @if($inventarios->isNotEmpty())
            <a href="{{ route('equipos.qr-todos') }}" class="btn-cancel">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px; margin-right: 7px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Descargar todos los QR
            </a>
            @endif
            @if($puedeAgregar)
            <button class="btn-primary" onclick="abrirModalAgregar()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nuevo equipo
            </button>
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
    @if(session('error'))
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Buscador --}}
    @if($inventarios->isNotEmpty())
    <div class="toolbar">
        <div class="search-wrap">
            <span class="search-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </span>
            <input
                type="text"
                id="buscador-inventario"
                class="search-input"
                placeholder="Buscar equipo..."
                oninput="aplicarFiltroInventario()"
                autocomplete="off"
            >
        </div>
        <label class="toggle-wrap">
            <span class="toggle-switch">
                <input type="checkbox" id="chk-solo-disponibles" onchange="aplicarFiltroInventario()">
                <span class="toggle-slider"></span>
            </span>
            Mostrar solo disponibles
        </label>
    </div>
    @endif

    {{-- Tabla --}}
    <div class="table-card">
        @if($inventarios->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125h4.5m-8.25-4.125h12l-.75-3H4.5l-.75 3z"/>
            </svg>
            <p>No hay inventario registrado</p>
        </div>
        @else
        <div class="table-scroll">
        <table>
            <colgroup>
                <col style="width: 50px;">
                <col style="width: 110px;">
                <col style="width: 180px;">
                <col style="width: 120px;">
                <col style="width: 120px;">
                <col style="width: 120px;">
                <col style="width: 120px;">
                <col style="width: 90px;">
                <col style="width: 110px;">
                <col style="width: 130px;">
            </colgroup>
            <thead>
                <tr>
                    <th class="th-id">#</th>
                    <th>Identificación</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>N° Serie</th>
                    <th>Categoría</th>
                    <th>Cantidad Existente</th>
                    <th>Cant. Disponible</th>
                    <th class="th-actions">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventarios as $inventario)
                @php
                    $buscar = strtolower(trim(
                        ($inventario->equipo->abreviacion ?? '') . ' ' .
                        ($inventario->equipo->nombre ?? '') . ' ' .
                        ($inventario->equipo->marca->descripcion ?? '') . ' ' .
                        ($inventario->equipo->modelo ?? '') . ' ' .
                        ($inventario->equipo->numero_serie ?? '') . ' ' .
                        ($inventario->equipo->categoria->descripcion ?? '') . ' ' .
                        ($inventario->equipo->observacion ?? '')
                    ));
                @endphp
                <tr class="fila-inventario" data-buscar="{{ $buscar }}" data-disponible="{{ $inventario->cantidad_disponible }}">
                    <td class="td-id" data-label="#">{{ $inventario->id }}</td>
                    <td class="td-muted" data-label="Identificación">{{ $inventario->equipo->abreviacion ?? '—' }}</td>
                    <td class="td-desc" data-label="Equipo">
                        <div class="equipo-nombre">{{ $inventario->equipo->nombre ?? '—' }}</div>
                        @if(!empty($inventario->equipo->observacion))
                        <div class="equipo-obs" title="{{ $inventario->equipo->observacion }}">{{ $inventario->equipo->observacion }}</div>
                        @endif
                    </td>
                    <td data-label="Marca">{{ $inventario->equipo->marca->descripcion ?? '—' }}</td>
                    <td data-label="Modelo">{{ $inventario->equipo->modelo ?? '—' }}</td>
                    <td class="td-muted" data-label="N° Serie">{{ $inventario->equipo->numero_serie ?? '—' }}</td>
                    <td data-label="Categoría">{{ $inventario->equipo->categoria->descripcion ?? '—' }}</td>
                    <td class="td-cantidad" data-label="Cant. Existente">{{ $inventario->cantidad }}</td>
                    <td class="td-cantidad {{ $inventario->cantidad_disponible == 0 ? 'td-no-disponible' : 'td-disponible' }}" data-label="Cant. Disponible">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            {{ $inventario->cantidad_disponible }}
                            @if($inventario->retiros_pendientes->isNotEmpty())
                            <button
                                type="button"
                                class="btn-icon-sm btn-icon-info"
                                title="Ver quién lo retiró"
                                data-abreviacion="{{ $inventario->equipo->abreviacion ?? '—' }}"
                                data-equipo="{{ $inventario->equipo->nombre ?? '—' }}"
                                data-marca="{{ $inventario->equipo->marca->descripcion ?? '—' }}"
                                data-modelo="{{ $inventario->equipo->modelo ?? '—' }}"
                                data-numero-serie="{{ $inventario->equipo->numero_serie ?? '—' }}"
                                data-categoria="{{ $inventario->equipo->categoria->descripcion ?? '—' }}"
                                data-retiros="{{ $inventario->retiros_pendientes->toJson() }}"
                                onclick="abrirModalRetiroInfo(this)"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td class="td-actions">
                        <div class="td-actions-inner">
                            @if($puedeEditar)
                            <button
                                class="btn-icon btn-icon-edit"
                                title="Editar"
                                data-id="{{ $inventario->equipo->id }}"
                                data-nombre="{{ $inventario->equipo->nombre }}"
                                data-marca="{{ $inventario->equipo->marca->descripcion ?? '' }}"
                                data-modelo="{{ $inventario->equipo->modelo }}"
                                data-numero-serie="{{ $inventario->equipo->numero_serie }}"
                                data-tipo-equipo-id="{{ $inventario->equipo->tipo_equipo_id }}"
                                data-categoria="{{ $inventario->equipo->categoria->descripcion ?? '' }}"
                                data-cantidad="{{ $inventario->cantidad }}"
                                data-observacion="{{ $inventario->equipo->observacion }}"
                                onclick="abrirModalEditar(this)"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                </svg>
                            </button>
                            @endif
                            <a
                                href="{{ route('equipos.qr', $inventario->equipo->id) }}"
                                class="btn-icon btn-icon-print"
                                title="Imprimir QR"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/>
                                </svg>
                            </a>
                            @if($puedeEliminar)
                            <button
                                class="btn-icon btn-icon-delete"
                                title="Eliminar"
                                data-id="{{ $inventario->equipo->id }}"
                                data-nombre="{{ $inventario->equipo->nombre }}"
                                onclick="abrirModalEliminar(this)"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr id="fila-sin-resultados" style="display: none;">
                    <td colspan="10" style="text-align: center; padding: 32px; color: #9ca3af;">
                        No se encontraron equipos que coincidan con la búsqueda
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        @endif
    </div>

</main>

{{-- Modal: Nuevo equipo --}}
@if($puedeAgregar)
<div class="modal-overlay" id="modal-agregar" onclick="cerrarEnOverlay(event, 'modal-agregar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Nuevo equipo</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-agregar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('equipos.store') }}">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label for="inp-nombre">Nombre</label>
                    <input
                        type="text"
                        id="inp-nombre"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        placeholder="Ej: Taladro percutor"
                        autocomplete="off"
                        class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                    >
                    @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="inp-marca">Marca</label>
                    <input
                        type="text"
                        id="inp-marca"
                        name="marca"
                        list="lista-marcas"
                        value="{{ old('marca') }}"
                        placeholder="Escriba o seleccione una marca"
                        autocomplete="off"
                        class="{{ $errors->has('marca') ? 'is-invalid' : '' }}"
                    >
                    <datalist id="lista-marcas">
                        @foreach($marcas as $marca)
                        <option value="{{ $marca->descripcion }}">
                        @endforeach
                    </datalist>
                    @error('marca') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="inp-modelo">Modelo</label>
                    <input
                        type="text"
                        id="inp-modelo"
                        name="modelo"
                        value="{{ old('modelo') }}"
                        placeholder="Ej: HR2470"
                        autocomplete="off"
                        class="{{ $errors->has('modelo') ? 'is-invalid' : '' }}"
                    >
                    @error('modelo') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="inp-numero-serie">Número de serie</label>
                    <input
                        type="text"
                        id="inp-numero-serie"
                        name="numero_serie"
                        value="{{ old('numero_serie') }}"
                        placeholder="Ej: SN-00123"
                        autocomplete="off"
                        class="{{ $errors->has('numero_serie') ? 'is-invalid' : '' }}"
                    >
                    @error('numero_serie') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="inp-tipo-equipo">Tipo de equipo</label>
                    <select
                        id="inp-tipo-equipo"
                        name="tipo_equipo_id"
                        required
                        onchange="actualizarCampoCantidad()"
                        class="{{ $errors->has('tipo_equipo_id') ? 'is-invalid' : '' }}"
                    >
                        @foreach($tiposEquipo as $tipo)
                        <option
                            value="{{ $tipo->id }}"
                            data-permite-cantidad="{{ $tipo->descripcion === 'No identificable' ? '1' : '0' }}"
                            {{ (string) old('tipo_equipo_id', '1') === (string) $tipo->id ? 'selected' : '' }}
                        >{{ $tipo->descripcion }}</option>
                        @endforeach
                    </select>
                    @error('tipo_equipo_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="inp-categoria">Categoría</label>
                    <input
                        type="text"
                        id="inp-categoria"
                        name="categoria"
                        list="lista-categorias"
                        value="{{ old('categoria') }}"
                        placeholder="Escriba o seleccione una categoría"
                        autocomplete="off"
                        class="{{ $errors->has('categoria') ? 'is-invalid' : '' }}"
                    >
                    <datalist id="lista-categorias">
                        @foreach($categorias as $categoria)
                        <option value="{{ $categoria->descripcion }}">
                        @endforeach
                    </datalist>
                    @error('categoria') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field" id="campo-cantidad" style="display: none;">
                    <label for="inp-cantidad">Cantidad</label>
                    <input
                        type="number"
                        id="inp-cantidad"
                        name="cantidad"
                        min="1"
                        value="{{ old('cantidad') }}"
                        placeholder="Ej: 10"
                        autocomplete="off"
                        class="{{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                    >
                    <span class="field-hint">Obligatoria para equipos de tipo "No identificable".</span>
                    @error('cantidad') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="inp-observacion">Observación</label>
                    <textarea
                        id="inp-observacion"
                        name="observacion"
                        placeholder="Observaciones adicionales (opcional)"
                        class="{{ $errors->has('observacion') ? 'is-invalid' : '' }}"
                    >{{ old('observacion') }}</textarea>
                    @error('observacion') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-agregar')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal: Editar equipo --}}
@if($puedeEditar)
<div class="modal-overlay" id="modal-editar" onclick="cerrarEnOverlay(event, 'modal-editar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Editar equipo</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-editar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="form-editar" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="equipo_id" id="inp-editar-id">
            <div class="modal-body">
                <div class="field">
                    <label for="inp-editar-nombre">Nombre</label>
                    <input
                        type="text"
                        id="inp-editar-nombre"
                        name="nombre"
                        autocomplete="off"
                        class="{{ $errors->has('nombre') && old('_method') === 'PUT' ? 'is-invalid' : '' }}"
                    >
                    @if($errors->has('nombre') && old('_method') === 'PUT')
                        <span class="field-error">{{ $errors->first('nombre') }}</span>
                    @endif
                </div>

                <div class="field">
                    <label for="inp-editar-marca">Marca</label>
                    <input type="text" id="inp-editar-marca" name="marca" list="lista-marcas" autocomplete="off">
                </div>

                <div class="field">
                    <label for="inp-editar-modelo">Modelo</label>
                    <input type="text" id="inp-editar-modelo" name="modelo" autocomplete="off">
                </div>

                <div class="field">
                    <label for="inp-editar-numero-serie">Número de serie</label>
                    <input type="text" id="inp-editar-numero-serie" name="numero_serie" autocomplete="off">
                </div>

                <div class="field">
                    <label for="inp-editar-tipo-equipo">Tipo de equipo</label>
                    <select
                        id="inp-editar-tipo-equipo"
                        name="tipo_equipo_id"
                        required
                        onchange="actualizarCampoCantidad('editar')"
                        class="{{ $errors->has('tipo_equipo_id') && old('_method') === 'PUT' ? 'is-invalid' : '' }}"
                    >
                        <option value="" disabled>Seleccione...</option>
                        @foreach($tiposEquipo as $tipo)
                        <option value="{{ $tipo->id }}" data-permite-cantidad="{{ $tipo->descripcion === 'No identificable' ? '1' : '0' }}">{{ $tipo->descripcion }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('tipo_equipo_id') && old('_method') === 'PUT')
                        <span class="field-error">{{ $errors->first('tipo_equipo_id') }}</span>
                    @endif
                </div>

                <div class="field">
                    <label for="inp-editar-categoria">Categoría</label>
                    <input type="text" id="inp-editar-categoria" name="categoria" list="lista-categorias" autocomplete="off">
                </div>

                <div class="field" id="campo-editar-cantidad" style="display: none;">
                    <label for="inp-editar-cantidad">Cantidad</label>
                    <input
                        type="number"
                        id="inp-editar-cantidad"
                        name="cantidad"
                        min="1"
                        autocomplete="off"
                        class="{{ $errors->has('cantidad') && old('_method') === 'PUT' ? 'is-invalid' : '' }}"
                    >
                    <span class="field-hint">Obligatoria para equipos de tipo "No identificable".</span>
                    @if($errors->has('cantidad') && old('_method') === 'PUT')
                        <span class="field-error">{{ $errors->first('cantidad') }}</span>
                    @endif
                </div>

                <div class="field">
                    <label for="inp-editar-observacion">Observación</label>
                    <textarea id="inp-editar-observacion" name="observacion" placeholder="Observaciones adicionales (opcional)"></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-editar')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal: Eliminar equipo --}}
@if($puedeEliminar)
<div class="modal-overlay" id="modal-eliminar" onclick="cerrarEnOverlay(event, 'modal-eliminar')">
    <div class="modal" style="max-width: 380px;">
        <div class="modal-head">
            <span class="modal-title">Eliminar equipo</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-eliminar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="form-eliminar" action="">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <p class="modal-desc">
                    ¿Confirmás que querés eliminar el equipo <strong id="txt-eliminar-nombre"></strong>?
                    Esta acción lo quitará del inventario.
                </p>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-eliminar')">Cancelar</button>
                <button type="submit" class="btn-danger">Eliminar</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal: Info de retiro pendiente --}}
<div class="modal-overlay" id="modal-retiro-info" onclick="cerrarEnOverlay(event, 'modal-retiro-info')">
    <div class="modal" style="max-width: 380px;">
        <div class="modal-head">
            <span class="modal-title">Retiro pendiente</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-retiro-info')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="detalle-row">
                <span class="detalle-label">Identificación</span>
                <span class="detalle-value" id="ri-abreviacion">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Equipo</span>
                <span class="detalle-value" id="ri-equipo">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Marca</span>
                <span class="detalle-value" id="ri-marca">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Modelo</span>
                <span class="detalle-value" id="ri-modelo">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">N° Serie</span>
                <span class="detalle-value" id="ri-numero-serie">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Categoría</span>
                <span class="detalle-value" id="ri-categoria">—</span>
            </div>
            <div class="modal-section-title">Retiros pendientes</div>
            <div class="tabs-bar" id="ri-tabs"></div>
            <div class="detalle-row">
                <span class="detalle-label">Obra</span>
                <span class="detalle-value" id="ri-tab-obra">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Retirado por</span>
                <span class="detalle-value" id="ri-tab-retirado-por">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Fecha de retiro</span>
                <span class="detalle-value" id="ri-tab-fecha-retiro">—</span>
            </div>
            <div class="detalle-row" id="ri-tab-cantidad-row" style="display: none;">
                <span class="detalle-label">Cantidad</span>
                <span class="detalle-value" id="ri-tab-cantidad">—</span>
            </div>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn-cancel" onclick="cerrarModal('modal-retiro-info')">Cerrar</button>
        </div>
    </div>
</div>

<script>
    function abrirModal(id) {
        document.getElementById(id).classList.add('open');
    }
    function cerrarModal(id) {
        document.getElementById(id).classList.remove('open');
    }
    function cerrarEnOverlay(e, id) {
        if (e.target === document.getElementById(id)) cerrarModal(id);
    }

    function aplicarFiltroInventario() {
        const q = document.getElementById('buscador-inventario').value.toLowerCase().trim();
        const soloDisponibles = document.getElementById('chk-solo-disponibles').checked;
        let visibles = 0;

        document.querySelectorAll('.fila-inventario').forEach(fila => {
            const coincideBusqueda = !q || fila.dataset.buscar.includes(q);
            const esDisponible = fila.dataset.disponible !== '0';
            const mostrar = coincideBusqueda && (!soloDisponibles || esDisponible);
            fila.style.display = mostrar ? '' : 'none';
            if (mostrar) visibles++;
        });

        document.getElementById('fila-sin-resultados').style.display = visibles === 0 ? '' : 'none';
    }

    function abrirModalAgregar() {
        abrirModal('modal-agregar');
        actualizarCampoCantidad();
        setTimeout(() => document.getElementById('inp-nombre').focus(), 50);
    }

    function abrirModalEditar(btn) {
        document.getElementById('inp-editar-id').value           = btn.dataset.id;
        document.getElementById('inp-editar-nombre').value       = btn.dataset.nombre;
        document.getElementById('inp-editar-marca').value        = btn.dataset.marca;
        document.getElementById('inp-editar-modelo').value       = btn.dataset.modelo;
        document.getElementById('inp-editar-numero-serie').value = btn.dataset.numeroSerie;
        document.getElementById('inp-editar-tipo-equipo').value  = btn.dataset.tipoEquipoId;
        document.getElementById('inp-editar-categoria').value    = btn.dataset.categoria;
        document.getElementById('inp-editar-cantidad').value     = btn.dataset.cantidad;
        document.getElementById('inp-editar-observacion').value  = btn.dataset.observacion;
        document.getElementById('form-editar').action = '/equipos/' + btn.dataset.id;

        actualizarCampoCantidad('editar');
        abrirModal('modal-editar');
        setTimeout(() => document.getElementById('inp-editar-nombre').focus(), 50);
    }

    function abrirModalEliminar(btn) {
        document.getElementById('txt-eliminar-nombre').textContent = btn.dataset.nombre;
        document.getElementById('form-eliminar').action = '/equipos/' + btn.dataset.id + '/eliminar';
        abrirModal('modal-eliminar');
    }

    let riRetirosActuales = [];

    function abrirModalRetiroInfo(btn) {
        document.getElementById('ri-abreviacion').textContent = btn.dataset.abreviacion || '—';
        document.getElementById('ri-equipo').textContent = btn.dataset.equipo || '—';
        document.getElementById('ri-marca').textContent = btn.dataset.marca || '—';
        document.getElementById('ri-modelo').textContent = btn.dataset.modelo || '—';
        document.getElementById('ri-numero-serie').textContent = btn.dataset.numeroSerie || '—';
        document.getElementById('ri-categoria').textContent = btn.dataset.categoria || '—';

        try { riRetirosActuales = JSON.parse(btn.dataset.retiros || '[]'); } catch (e) { riRetirosActuales = []; }

        const cont = document.getElementById('ri-tabs');
        cont.innerHTML = riRetirosActuales.map((r, idx) => `
            <button type="button" class="tab-btn" data-idx="${idx}" onclick="seleccionarTabRetiroInfo(${idx})">
                Retiro ${idx + 1}
            </button>
        `).join('');

        if (riRetirosActuales.length > 0) seleccionarTabRetiroInfo(0);

        abrirModal('modal-retiro-info');
    }

    function seleccionarTabRetiroInfo(idx) {
        const r = riRetirosActuales[idx];
        if (!r) return;

        document.querySelectorAll('#ri-tabs .tab-btn').forEach((btn) => {
            btn.classList.toggle('active', Number(btn.dataset.idx) === idx);
        });

        document.getElementById('ri-tab-obra').textContent = r.obra || '—';
        document.getElementById('ri-tab-retirado-por').textContent = r.retirado_por || '—';
        document.getElementById('ri-tab-fecha-retiro').textContent = r.fecha_retiro || '—';

        const cantidadRow = document.getElementById('ri-tab-cantidad-row');
        if (r.cantidad_retirada !== 1) {
            document.getElementById('ri-tab-cantidad').textContent = `${r.cantidad_devuelta}/${r.cantidad_retirada} (pendiente ${r.cantidad_pendiente})`;
            cantidadRow.style.display = 'flex';
        } else {
            cantidadRow.style.display = 'none';
        }
    }

    function actualizarCampoCantidad(modal = 'agregar') {
        const ids = modal === 'editar'
            ? { select: 'inp-editar-tipo-equipo', campo: 'campo-editar-cantidad', cantidad: 'inp-editar-cantidad' }
            : { select: 'inp-tipo-equipo', campo: 'campo-cantidad', cantidad: 'inp-cantidad' };

        const select   = document.getElementById(ids.select);
        const opcion   = select.options[select.selectedIndex];
        const permite  = opcion?.dataset.permiteCantidad === '1';
        const campo    = document.getElementById(ids.campo);
        const cantidad = document.getElementById(ids.cantidad);

        campo.style.display = permite ? 'flex' : 'none';
        cantidad.required = permite;
        if (!permite) cantidad.value = '';
    }

    // Reabrir modal correcto si hubo error de validación
    document.addEventListener('DOMContentLoaded', () => {
        @if($errors->any() && old('_method') === 'PUT')
            document.getElementById('inp-editar-id').value           = @json(old('equipo_id'));
            document.getElementById('inp-editar-nombre').value       = @json(old('nombre', ''));
            document.getElementById('inp-editar-marca').value        = @json(old('marca', ''));
            document.getElementById('inp-editar-modelo').value       = @json(old('modelo', ''));
            document.getElementById('inp-editar-numero-serie').value = @json(old('numero_serie', ''));
            document.getElementById('inp-editar-tipo-equipo').value  = @json(old('tipo_equipo_id', ''));
            document.getElementById('inp-editar-categoria').value    = @json(old('categoria', ''));
            document.getElementById('inp-editar-cantidad').value     = @json(old('cantidad', ''));
            document.getElementById('inp-editar-observacion').value  = @json(old('observacion', ''));
            document.getElementById('form-editar').action = '/equipos/' + @json(old('equipo_id'));
            actualizarCampoCantidad('editar');
            abrirModal('modal-editar');
        @elseif($errors->any() && !old('_method'))
            abrirModal('modal-agregar');
            actualizarCampoCantidad();
        @endif
    });
</script>

</body>
</html>
