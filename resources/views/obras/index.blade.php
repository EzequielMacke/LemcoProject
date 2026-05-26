<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obras — LemcoProject</title>
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
            display: flex; align-items: flex-end; justify-content: space-between;
            animation: fadeUp 0.35s ease both;
        }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #15803d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Btn primary ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #c2410c, #ea580c);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(234,88,12,0.3);
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

        /* ── Toolbar (tabs + buscador) ── */
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
            background: #fff7ed; color: #ea580c;
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
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.1);
        }
        .search-input::placeholder { color: #9ca3af; }

        /* ── Cards grid ── */
        .obras-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
            animation: fadeUp 0.4s ease 0.08s both;
        }

        /* ── Obra card ── */
        .obra-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s;
            text-decoration: none; cursor: pointer;
        }
        .obra-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-color: #d1d5db;
        }

        .obra-card-top {
            background: linear-gradient(135deg, #c2410c, #ea580c);
            padding: 22px 20px 18px;
            display: flex; align-items: center; gap: 14px;
        }
        .obra-initial {
            width: 46px; height: 46px; border-radius: 12px;
            background: rgba(255,255,255,0.2);
            border: 1.5px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 19px; font-weight: 700; color: #fff;
            flex-shrink: 0; letter-spacing: -0.5px;
        }
        .obra-card-top-text {}
        .obra-card-top-label {
            font-size: 10.5px; font-weight: 600; color: rgba(255,255,255,0.6);
            text-transform: uppercase; letter-spacing: 0.8px;
        }
        .obra-card-top-name {
            font-size: 14.5px; font-weight: 700; color: #fff;
            margin-top: 2px; line-height: 1.3;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .obra-card-body {
            padding: 14px 18px 16px;
        }
        .obra-meta {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: #6b7280;
        }
        .obra-meta svg { width: 13px; height: 13px; flex-shrink: 0; color: #9ca3af; }

        .obra-card-foot {
            padding: 10px 18px 14px;
            display: flex; align-items: center; justify-content: space-between;
            border-top: 1px solid #f1f3f5;
        }
        .obra-date { font-size: 11.5px; color: #9ca3af; }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11px; font-weight: 600; padding: 3px 9px;
            border-radius: 99px;
        }
        .badge svg { width: 6px; height: 6px; }
        .badge-activa  { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-inactiva{ background: #f8fafc; color: #9ca3af; border: 1.5px solid #e9ecef; }

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
            width: 100%; max-width: 400px;
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

        .modal-body { padding: 20px 22px; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }
        .field input {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field input:focus {
            border-color: #ea580c; background: #fff;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.1);
        }
        .field input.is-invalid,
        .field select.is-invalid { border-color: #f87171; }
        .field-error { font-size: 12px; color: #be123c; }

        .field select {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            appearance: none; -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
            cursor: pointer;
            transition: border-color 0.15s, box-shadow 0.15s, background-color 0.15s;
        }
        .field select:focus {
            border-color: #ea580c; background-color: #fff;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.1);
        }

        .modal-foot {
            padding: 16px 22px;
            border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
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
            .obras-grid { grid-template-columns: 1fr; }
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
        <span class="navbar-title">Obras</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    @php
        $permsObr     = session('permisos', [])['obr'] ?? [];
        $puedeAgregar = $permsObr['agregar'] ?? false;
        $activas      = $obras->where('estado', 1)->count();
        $inactivas    = $obras->where('estado', 2)->count();
    @endphp

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">Módulo</div>
            <div class="page-heading">Obras</div>
        </div>
        @if($puedeAgregar)
        <button class="btn-primary" onclick="abrirModal('modal-nueva')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Nueva obra
        </button>
        @endif
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
                Inactivas
                <span class="tab-count" id="count-inactivas">{{ $inactivas }}</span>
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
                placeholder="Buscar obra..."
                oninput="aplicarFiltros()"
                autocomplete="off"
            >
        </div>
    </div>

    {{-- Cards --}}
    <div class="obras-grid" id="obras-grid">

        @forelse($obras as $obra)
        <a
            href="{{ route('obras.show', $obra) }}"
            class="obra-card"
            data-estado="{{ $obra->estado }}"
            data-nombre="{{ strtolower($obra->nombre) }}"
        >
            <div class="obra-card-top">
                <div class="obra-initial">{{ strtoupper(substr($obra->nombre, 0, 1)) }}</div>
                <div class="obra-card-top-text">
                    <div class="obra-card-top-label">Obra</div>
                    <div class="obra-card-top-name">{{ $obra->nombre }}</div>
                </div>
            </div>
            <div class="obra-card-body">
                <div class="obra-meta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    {{ $obra->usuario->nick ?? '—' }}
                </div>
            </div>
            <div class="obra-card-foot">
                <span class="obra-date">{{ $obra->created_at->format('d/m/Y') }}</span>
                @if($obra->estado === 1)
                    <span class="badge badge-activa">
                        <svg viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                        Activa
                    </span>
                @else
                    <span class="badge badge-inactiva">
                        <svg viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                        Inactiva
                    </span>
                @endif
            </div>
        </a>
        @empty
        {{-- sin datos desde el servidor, el empty state se maneja por JS --}}
        @endforelse

        <div class="empty-state" id="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008z"/>
            </svg>
            <p id="empty-msg">No hay obras en esta categoría</p>
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

        document.querySelectorAll('.obra-card').forEach(card => {
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
                ? 'No se encontraron obras que coincidan con la búsqueda'
                : 'No hay obras en esta categoría';
        } else {
            empty.classList.remove('visible');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        switchTab(1);
        @if($errors->any())
            abrirModal('modal-nueva');
        @endif
    });

    function abrirModal(id) {
        document.getElementById(id).classList.add('open');
    }
    function cerrarModal(id) {
        document.getElementById(id).classList.remove('open');
    }
    function cerrarEnOverlay(e, id) {
        if (e.target === document.getElementById(id)) cerrarModal(id);
    }
</script>

{{-- Modal: Nueva obra --}}
@if($puedeAgregar)
<div class="modal-overlay" id="modal-nueva" onclick="cerrarEnOverlay(event, 'modal-nueva')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Nueva obra</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-nueva')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('obras.store') }}">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label for="inp-nombre">Nombre</label>
                    <input
                        type="text"
                        id="inp-nombre"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        placeholder="Ej: Construcción edificio norte"
                        autocomplete="off"
                        class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                    >
                    @error('nombre')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field" style="margin-top:14px">
                    <label for="inp-tipo-cert">Tipo de certificación</label>
                    <select
                        id="inp-tipo-cert"
                        name="tipo_certificacion"
                        required
                        class="{{ $errors->has('tipo_certificacion') ? 'is-invalid' : '' }}"
                    >
                        <option value="" {{ old('tipo_certificacion') === null ? 'selected' : '' }}>— Sin especificar —</option>
                        <option value="1" {{ old('tipo_certificacion') == 1 ? 'selected' : '' }}>Por remisión</option>
                        <option value="2" {{ old('tipo_certificacion') == 2 ? 'selected' : '' }}>Por informe</option>
                    </select>
                    @error('tipo_certificacion')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field" style="margin-top:14px">
                    <label for="inp-residente">Residente</label>
                    <input
                        type="text"
                        id="inp-residente"
                        name="residente"
                        value="{{ old('residente') }}"
                        placeholder="Nombre del residente (opcional)"
                        autocomplete="off"
                        class="{{ $errors->has('residente') ? 'is-invalid' : '' }}"
                    >
                    @error('residente')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-nueva')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endif

</body>
</html>
