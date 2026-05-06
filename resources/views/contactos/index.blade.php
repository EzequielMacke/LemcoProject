<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos — {{ $obra->nombre }}</title>
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
            color: #6b7280; text-decoration: none; transition: all 0.15s;
        }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }

        .nav-sep { width: 1px; height: 18px; background: #e9ecef; }
        .navbar-title {
            font-size: 14px; font-weight: 600; color: #111827;
            max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
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
        .page {
            flex: 1;
            padding: 28px 24px 40px;
            display: flex; flex-direction: column; gap: 20px;
        }

        /* ── Page header ── */
        .page-header {
            display: flex; align-items: flex-end; justify-content: space-between;
            animation: fadeUp 0.35s ease both;
        }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #0d9488; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Btn primary ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #0f766e, #0d9488);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(13,148,136,0.3);
            transition: opacity 0.15s, transform 0.1s;
            text-decoration: none; white-space: nowrap;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary svg { width: 14px; height: 14px; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Toolbar ── */
        .toolbar {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; flex-wrap: wrap;
            animation: fadeUp 0.38s ease 0.04s both;
        }

        /* Tabs */
        .tabs {
            display: flex; gap: 3px;
            background: #f1f3f5;
            border: 1.5px solid #e9ecef;
            border-radius: 12px;
            padding: 4px;
            flex-shrink: 0;
        }
        .tab-btn {
            display: flex; align-items: center; gap: 7px;
            padding: 7px 16px; border-radius: 9px;
            font-size: 13px; font-weight: 500; color: #6b7280;
            border: none; background: none; cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s; white-space: nowrap;
        }
        .tab-btn.active {
            background: #fff;
            color: #111827;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        .tab-count {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 20px; height: 20px; padding: 0 6px;
            border-radius: 99px; font-size: 11px; font-weight: 700;
            background: #e9ecef; color: #6b7280;
            transition: all 0.15s;
        }
        .tab-btn.active .tab-count {
            background: #ccfbf1; color: #0d9488;
        }

        /* Search */
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
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
        }
        .search-input::placeholder { color: #9ca3af; }

        /* ── Cards grid ── */
        .contactos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 16px;
            animation: fadeUp 0.4s ease 0.08s both;
        }

        /* ── Contacto card ── */
        .contacto-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s;
        }
        .contacto-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-color: #d1d5db;
        }

        /* Top activo: teal */
        .contacto-card:not(.inactivo) .card-top {
            background: linear-gradient(135deg, #0f766e, #0d9488);
        }
        /* Top inactivo: gris */
        .contacto-card.inactivo .card-top {
            background: linear-gradient(135deg, #4b5563, #6b7280);
        }
        .contacto-card.inactivo {
            background: #f8fafc;
            opacity: 0.82;
        }

        .card-top {
            padding: 20px 18px 16px;
            display: flex; align-items: center; gap: 13px;
            position: relative;
        }
        .card-initial {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(255,255,255,0.2);
            border: 1.5px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700; color: #fff;
            flex-shrink: 0; letter-spacing: -0.5px;
        }
        .card-top-label {
            font-size: 10.5px; font-weight: 600; color: rgba(255,255,255,0.6);
            text-transform: uppercase; letter-spacing: 0.8px;
        }
        .card-top-name {
            font-size: 14px; font-weight: 700; color: #fff;
            margin-top: 2px; line-height: 1.3;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-body {
            padding: 12px 18px 10px;
        }
        .card-meta {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: #6b7280;
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .card-meta svg { width: 13px; height: 13px; flex-shrink: 0; color: #9ca3af; }

        .card-foot {
            padding: 10px 18px 13px;
            border-top: 1px solid #f1f3f5;
            display: flex; align-items: center; justify-content: space-between; gap: 8px;
        }
        .foot-left { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; }
        .card-date { font-size: 11.5px; color: #9ca3af; }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 600; padding: 3px 9px;
            border-radius: 99px;
        }
        .badge svg { width: 6px; height: 6px; }
        .badge-activo   { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-inactivo { background: #f8fafc; color: #9ca3af; border: 1.5px solid #e9ecef; }

        /* ── Action buttons ── */
        .foot-actions { display: flex; align-items: center; gap: 5px; flex-shrink: 0; }

        .btn-action {
            display: inline-flex; align-items: center; gap: 4px;
            border-radius: 7px; padding: 4px 9px;
            font-size: 11.5px; font-weight: 600;
            border: 1.5px solid; cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s; white-space: nowrap;
        }
        .btn-action svg { width: 11px; height: 11px; }

        .btn-edit {
            background: none; border-color: #e9ecef; color: #374151;
        }
        .btn-edit:hover { background: #f1f3f5; border-color: #d1d5db; }

        .btn-anular {
            background: none; border-color: #fecdd3; color: #be123c;
        }
        .btn-anular:hover { background: #fff1f2; border-color: #fca5a5; }

        .btn-activar {
            background: none; border-color: #bbf7d0; color: #15803d;
        }
        .btn-activar:hover { background: #f0fdf4; border-color: #86efac; }

        .btn-compartir {
            position: absolute; top: 8px; right: 8px;
            background: rgba(255,255,255,0.15); border: none; color: rgba(255,255,255,0.75);
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            padding: 0; cursor: pointer;
            transition: background 0.18s, color 0.18s;
        }
        .btn-compartir svg { width: 14px; height: 14px; flex-shrink: 0; }
        .btn-compartir:hover { background: rgba(255,255,255,0.3); color: #fff; }

        /* ── Select en modal ── */
        .field select {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 36px 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            cursor: pointer; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }
        .field select:focus {
            border-color: #0d9488; background-color: #fff;
            box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
        }
        .field select.is-invalid { border-color: #f87171; }

        .modal-compartir-desc {
            padding: 14px 22px 0;
            font-size: 13px; color: #6b7280; line-height: 1.5;
        }
        .modal-compartir-desc strong { color: #111827; }

        /* ── Empty state ── */
        .empty-state {
            grid-column: 1 / -1;
            padding: 56px 24px;
            text-align: center; color: #9ca3af;
            display: none;
        }
        .empty-state svg { width: 40px; height: 40px; margin: 0 auto 12px; display: block; color: #d1d5db; }
        .empty-state p  { font-size: 14px; }
        .empty-state.visible { display: block; }

        /* ── Btn cancel ── */
        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 16px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }

        .btn-danger {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, #be123c, #e11d48);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(225,29,72,0.25);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-danger:hover { opacity: 0.9; transform: translateY(-1px); }

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

        .modal-body { padding: 20px 22px; display: flex; flex-direction: column; gap: 14px; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }
        .field input {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field input:focus {
            border-color: #0d9488; background: #fff;
            box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
        }
        .field input.is-invalid { border-color: #f87171; }
        .field-error { font-size: 12px; color: #be123c; }

        .fields-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .modal-foot {
            padding: 16px 22px;
            border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
        }

        /* Anular modal */
        .modal-anular-body {
            padding: 20px 22px;
            font-size: 13.5px; color: #374151; line-height: 1.6;
        }
        .anular-nombre {
            font-weight: 700; color: #111827;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
            .toolbar { flex-direction: column; align-items: stretch; }
            .search-wrap { max-width: 100%; }
            .contactos-grid { grid-template-columns: 1fr; }
            .fields-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('obras.show', $obra) }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            {{ $obra->nombre }}
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Contactos</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    @php
        $activos   = $contactos->where('estado', 1)->count();
        $inactivos = $contactos->where('estado', 2)->count();
    @endphp

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">{{ $obra->nombre }}</div>
            <div class="page-heading">Contactos</div>
        </div>
        @permiso('CON', 'agregar')
        <button class="btn-primary" onclick="abrirModal('modal-nuevo')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Agregar contacto
        </button>
        @endpermiso
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
                Activos
                <span class="tab-count" id="count-activos">{{ $activos }}</span>
            </button>
            <button class="tab-btn" data-tab="2" onclick="switchTab(2)">
                Inactivos
                <span class="tab-count" id="count-inactivos">{{ $inactivos }}</span>
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
                placeholder="Buscar contacto..."
                oninput="aplicarFiltros()"
                autocomplete="off"
            >
        </div>
    </div>

    {{-- Cards --}}
    <div class="contactos-grid" id="contactos-grid">

        @forelse($contactos as $contacto)
        <div
            class="contacto-card {{ $contacto->estado == 2 ? 'inactivo' : '' }}"
            data-estado="{{ $contacto->estado }}"
            data-nombre="{{ strtolower($contacto->nombre . ' ' . $contacto->apellido) }}"
        >
            <div class="card-top">
                <div class="card-initial">
                    {{ strtoupper(substr($contacto->nombre, 0, 1)) }}{{ strtoupper(substr($contacto->apellido, 0, 1)) }}
                </div>
                <div>
                    <div class="card-top-label">Contacto</div>
                    <div class="card-top-name">{{ $contacto->nombre }} {{ $contacto->apellido }}</div>
                </div>
                @if($puedeAgregar && $obrasDisponibles->isNotEmpty())
                <button
                    class="btn-compartir"
                    title="Compartir contacto"
                    onclick="abrirCompartir({{ $contacto->id }}, '{{ addslashes($contacto->nombre) }}', '{{ addslashes($contacto->apellido) }}')"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/>
                    </svg>
                </button>
                @endif
            </div>
            <div class="card-body">
                <div class="card-meta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    {{ $contacto->correo }}
                </div>
            </div>
            <div class="card-foot">
                <div class="foot-left">
                    <span class="card-date">{{ $contacto->created_at->format('d/m/Y') }}</span>
                    @if($contacto->estado === 1)
                        <span class="badge badge-activo">
                            <svg viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                            Activo
                        </span>
                    @else
                        <span class="badge badge-inactivo">
                            <svg viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                            Inactivo
                        </span>
                    @endif
                </div>
                <div class="foot-actions">
                    @permiso('CON', 'editar')
                    <button
                        class="btn-action btn-edit"
                        onclick="abrirEditar({{ $contacto->id }}, '{{ addslashes($contacto->nombre) }}', '{{ addslashes($contacto->apellido) }}', '{{ addslashes($contacto->correo) }}')"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                        </svg>
                        Editar
                    </button>
                    @endpermiso
                    @permiso('CON', 'eliminar')
                    @if($contacto->estado == 1)
                    <button
                        class="btn-action btn-anular"
                        onclick="abrirAnular({{ $contacto->id }}, '{{ addslashes($contacto->nombre) }}', '{{ addslashes($contacto->apellido) }}')"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        Anular
                    </button>
                    @elseif($contacto->estado == 2)
                    <form method="POST" action="{{ route('contactos.activar', [$obra, $contacto]) }}" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-action btn-activar">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Activar
                        </button>
                    </form>
                    @endif
                    @endpermiso
                </div>
            </div>
        </div>
        @empty
        @endforelse

        <div class="empty-state" id="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <p id="empty-msg">No hay contactos en esta categoría</p>
        </div>

    </div>

</main>

<script>
    let tabActual = 1;

    function switchTab(tab) {
        tabActual = tab;
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.toggle('active', parseInt(b.dataset.tab) === tab);
        });
        aplicarFiltros();
    }

    function aplicarFiltros() {
        const q = document.getElementById('buscador').value.toLowerCase().trim();
        let visibles = 0;

        document.querySelectorAll('.contacto-card').forEach(card => {
            const matchTab    = parseInt(card.dataset.estado) === tabActual;
            const matchSearch = !q || card.dataset.nombre.includes(q);
            const mostrar     = matchTab && matchSearch;
            card.style.display = mostrar ? '' : 'none';
            if (mostrar) visibles++;
        });

        const empty = document.getElementById('empty-state');
        const msg   = document.getElementById('empty-msg');
        if (visibles === 0) {
            empty.classList.add('visible');
            msg.textContent = q
                ? 'No se encontraron contactos que coincidan'
                : 'No hay contactos en esta categoría';
        } else {
            empty.classList.remove('visible');
        }
    }

    function abrirEditar(id, nombre, apellido, correo) {
        document.getElementById('edit-nombre').value   = nombre;
        document.getElementById('edit-apellido').value = apellido;
        document.getElementById('edit-correo').value   = correo;
        document.getElementById('edit-contacto-id').value = id;
        document.getElementById('form-editar').action  = '/obras/{{ $obra->id }}/contactos/' + id;
        abrirModal('modal-editar');
    }

    function abrirAnular(id, nombre, apellido) {
        document.getElementById('anular-nombre').textContent = nombre + ' ' + apellido;
        document.getElementById('form-anular').action = '/obras/{{ $obra->id }}/contactos/' + id + '/anular';
        abrirModal('modal-anular');
    }

    function abrirCompartir(id, nombre, apellido) {
        document.getElementById('compartir-contacto-nombre').textContent = nombre + ' ' + apellido;
        document.getElementById('form-compartir').action = '/obras/{{ $obra->id }}/contactos/' + id + '/copiar';
        document.getElementById('compartir-obra-destino').value = '';
        abrirModal('modal-compartir');
    }

    function abrirModal(id)  { document.getElementById(id).classList.add('open'); }
    function cerrarModal(id) { document.getElementById(id).classList.remove('open'); }
    function cerrarEnOverlay(e, id) { if (e.target === document.getElementById(id)) cerrarModal(id); }

    document.addEventListener('DOMContentLoaded', () => {
        switchTab(1);

        @if($errors->any())
            @if(old('_origen') === 'editar')
                var cid = '{{ old('_contacto_id') }}';
                document.getElementById('form-editar').action = '/obras/{{ $obra->id }}/contactos/' + cid;
                abrirModal('modal-editar');
            @else
                abrirModal('modal-nuevo');
            @endif
        @endif
    });
</script>

{{-- Modal: Agregar contacto --}}
@permiso('CON', 'agregar')
<div class="modal-overlay" id="modal-nuevo" onclick="cerrarEnOverlay(event, 'modal-nuevo')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Agregar contacto</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-nuevo')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('contactos.store', $obra) }}">
            @csrf
            <input type="hidden" name="_origen" value="nuevo">
            <div class="modal-body">
                <div class="fields-row">
                    <div class="field">
                        <label for="inp-nombre">Nombre</label>
                        <input
                            type="text"
                            id="inp-nombre"
                            name="nombre"
                            value="{{ old('_origen') === 'nuevo' ? old('nombre') : '' }}"
                            placeholder="Juan"
                            autocomplete="off"
                            class="{{ $errors->has('nombre') && old('_origen') === 'nuevo' ? 'is-invalid' : '' }}"
                        >
                        @if($errors->has('nombre') && old('_origen') === 'nuevo')
                            <span class="field-error">{{ $errors->first('nombre') }}</span>
                        @endif
                    </div>
                    <div class="field">
                        <label for="inp-apellido">Apellido</label>
                        <input
                            type="text"
                            id="inp-apellido"
                            name="apellido"
                            value="{{ old('_origen') === 'nuevo' ? old('apellido') : '' }}"
                            placeholder="Pérez"
                            autocomplete="off"
                            class="{{ $errors->has('apellido') && old('_origen') === 'nuevo' ? 'is-invalid' : '' }}"
                        >
                        @if($errors->has('apellido') && old('_origen') === 'nuevo')
                            <span class="field-error">{{ $errors->first('apellido') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field">
                    <label for="inp-correo">Correo electrónico</label>
                    <input
                        type="email"
                        id="inp-correo"
                        name="correo"
                        value="{{ old('_origen') === 'nuevo' ? old('correo') : '' }}"
                        placeholder="juan@ejemplo.com"
                        autocomplete="off"
                        class="{{ $errors->has('correo') && old('_origen') === 'nuevo' ? 'is-invalid' : '' }}"
                    >
                    @if($errors->has('correo') && old('_origen') === 'nuevo')
                        <span class="field-error">{{ $errors->first('correo') }}</span>
                    @endif
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-nuevo')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endpermiso

{{-- Modal: Editar contacto --}}
@permiso('CON', 'editar')
<div class="modal-overlay" id="modal-editar" onclick="cerrarEnOverlay(event, 'modal-editar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Editar contacto</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-editar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="form-editar" action="#">
            @csrf
            @method('PUT')
            <input type="hidden" name="_origen" value="editar">
            <input type="hidden" name="_contacto_id" id="edit-contacto-id" value="{{ old('_contacto_id') }}">
            <div class="modal-body">
                <div class="fields-row">
                    <div class="field">
                        <label for="edit-nombre">Nombre</label>
                        <input
                            type="text"
                            id="edit-nombre"
                            name="nombre"
                            value="{{ old('_origen') === 'editar' ? old('nombre') : '' }}"
                            placeholder="Juan"
                            autocomplete="off"
                            class="{{ $errors->has('nombre') && old('_origen') === 'editar' ? 'is-invalid' : '' }}"
                        >
                        @if($errors->has('nombre') && old('_origen') === 'editar')
                            <span class="field-error">{{ $errors->first('nombre') }}</span>
                        @endif
                    </div>
                    <div class="field">
                        <label for="edit-apellido">Apellido</label>
                        <input
                            type="text"
                            id="edit-apellido"
                            name="apellido"
                            value="{{ old('_origen') === 'editar' ? old('apellido') : '' }}"
                            placeholder="Pérez"
                            autocomplete="off"
                            class="{{ $errors->has('apellido') && old('_origen') === 'editar' ? 'is-invalid' : '' }}"
                        >
                        @if($errors->has('apellido') && old('_origen') === 'editar')
                            <span class="field-error">{{ $errors->first('apellido') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field">
                    <label for="edit-correo">Correo electrónico</label>
                    <input
                        type="email"
                        id="edit-correo"
                        name="correo"
                        value="{{ old('_origen') === 'editar' ? old('correo') : '' }}"
                        placeholder="juan@ejemplo.com"
                        autocomplete="off"
                        class="{{ $errors->has('correo') && old('_origen') === 'editar' ? 'is-invalid' : '' }}"
                    >
                    @if($errors->has('correo') && old('_origen') === 'editar')
                        <span class="field-error">{{ $errors->first('correo') }}</span>
                    @endif
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-editar')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
@endpermiso

{{-- Modal: Compartir a otra obra --}}
@permiso('CON', 'agregar')
@if($obrasDisponibles->isNotEmpty())
<div class="modal-overlay" id="modal-compartir" onclick="cerrarEnOverlay(event, 'modal-compartir')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Compartir contacto</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-compartir')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-compartir-desc">
            Se creará una copia activa de <strong id="compartir-contacto-nombre"></strong> en la obra que selecciones.
        </div>
        <form method="POST" id="form-compartir" action="#">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label for="compartir-obra-destino">Obra destino</label>
                    <select id="compartir-obra-destino" name="obra_destino_id">
                        <option value="" disabled selected>Seleccioná una obra...</option>
                        @foreach($obrasDisponibles as $obraOpt)
                            <option value="{{ $obraOpt->id }}">{{ $obraOpt->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-compartir')">Cancelar</button>
                <button type="submit" class="btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/>
                    </svg>
                    Compartir
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endpermiso

{{-- Modal: Confirmar anular --}}
@permiso('CON', 'eliminar')
<div class="modal-overlay" id="modal-anular" onclick="cerrarEnOverlay(event, 'modal-anular')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Anular contacto</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-anular')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-anular-body">
            ¿Estás seguro de que querés anular a <span class="anular-nombre" id="anular-nombre"></span>? El contacto quedará inactivo.
        </div>
        <form method="POST" id="form-anular" action="#">
            @csrf
            @method('PATCH')
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-anular')">Cancelar</button>
                <button type="submit" class="btn-danger">Anular</button>
            </div>
        </form>
    </div>
</div>
@endpermiso

</body>
</html>
