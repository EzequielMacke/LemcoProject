<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $obra->nombre }} — LemcoProject</title>
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
            max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
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
        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 24px; }

        /* ── Page header ── */
        .page-header {
            display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;
            animation: fadeUp 0.35s ease both;
        }
        .page-label { font-size: 11.5px; font-weight: 600; color: #ea580c; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 22px; font-weight: 700; color: #0f172a; letter-spacing: -0.4px; line-height: 1.25; }

        .page-meta {
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
            margin-top: 8px;
        }
        .meta-item { display: flex; align-items: center; gap: 5px; font-size: 12.5px; color: #6b7280; }
        .meta-item svg { width: 13px; height: 13px; color: #9ca3af; }
        .meta-sep { width: 3px; height: 3px; border-radius: 50%; background: #d1d5db; }

        /* ── Badges ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 99px;
        }
        .badge svg { width: 7px; height: 7px; }
        .badge-activa   { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-inactiva { background: #f8fafc; color: #9ca3af; border: 1.5px solid #e9ecef; }

        /* ── Header actions ── */
        .header-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 14px; font-size: 13px; font-weight: 500;
            color: #374151; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-secondary:hover { background: #f8f9fa; border-color: #d1d5db; }
        .btn-secondary svg { width: 14px; height: 14px; }

        .btn-danger {
            display: inline-flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #fecdd3; border-radius: 10px;
            padding: 9px 14px; font-size: 13px; font-weight: 500;
            color: #be123c; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-danger:hover { background: #fff1f2; border-color: #fca5a5; }
        .btn-danger svg { width: 14px; height: 14px; }

        .btn-success {
            display: inline-flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #bbf7d0; border-radius: 10px;
            padding: 9px 14px; font-size: 13px; font-weight: 500;
            color: #15803d; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-success:hover { background: #f0fdf4; border-color: #86efac; }
        .btn-success svg { width: 14px; height: 14px; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Section label ── */
        .section-label {
            font-size: 11px; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: 0.8px;
            animation: fadeUp 0.38s ease 0.05s both;
        }

        /* ── Cards grid ── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, 190px);
            justify-content: start;
            gap: 14px;
            animation: fadeUp 0.4s ease 0.1s both;
        }

        .menu-card {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 18px;
            padding: 24px 22px 20px; text-decoration: none;
            display: flex; flex-direction: column; gap: 12px;
            position: relative; aspect-ratio: 1 / 1;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .menu-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-color: #d1d5db;
        }
        .menu-card:active { transform: translateY(0); }

        .menu-card::before {
            content: '';
            position: absolute; top: 0; left: 18px; right: 18px;
            height: 2.5px; border-radius: 0 0 4px 4px;
            transition: left 0.2s, right 0.2s;
        }
        .menu-card:hover::before { left: 10px; right: 10px; }

        .card-contactos::before    { background: #0d9488; }
        .card-probetas::before     { background: #4f46e5; }
        .card-certificados::before { background: #059669; }

        .card-icon {
            width: 48px; height: 48px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: transform 0.2s ease;
        }
        .card-icon svg { width: 22px; height: 22px; }
        .menu-card:hover .card-icon { transform: scale(1.07); }

        .icon-contactos    { background: #f0fdfa; color: #0d9488; }
        .icon-probetas     { background: #eef2ff; color: #4f46e5; }
        .icon-certificados { background: #ecfdf5; color: #059669; }

        .card-body { flex: 1; min-height: 0; }
        .card-label { font-size: 15px; font-weight: 700; color: #111827; letter-spacing: -0.2px; margin-bottom: 5px; }
        .card-desc  { font-size: 12.5px; color: #9ca3af; line-height: 1.5; }

        .card-foot { display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .card-foot-label { font-size: 11px; font-weight: 600; color: #d1d5db; text-transform: uppercase; letter-spacing: 0.6px; }
        .card-arrow {
            width: 30px; height: 30px; border-radius: 50%; background: #f1f3f5;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s, transform 0.15s; flex-shrink: 0;
        }
        .card-arrow svg { width: 13px; height: 13px; color: #9ca3af; }
        .menu-card:hover .card-arrow { background: #e9ecef; transform: translateX(2px); }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.35);
            display: none; align-items: center; justify-content: center;
            z-index: 100; padding: 20px;
        }
        .modal-overlay.open { display: flex; }

        .modal {
            background: #fff; border-radius: 18px;
            width: 100%; max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            animation: modalIn 0.2s ease both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-head {
            padding: 20px 22px 16px; border-bottom: 1px solid #f1f3f5;
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
        .field input.is-invalid { border-color: #f87171; }
        .field-error { font-size: 12px; color: #be123c; }

        .modal-foot {
            padding: 16px 22px; border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
        }

        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 16px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #c2410c, #ea580c);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(234,88,12,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 36px; }
            .page-header { flex-direction: row; align-items: flex-start; }
            .header-actions { flex-shrink: 0; gap: 6px; }

            /* Botones solo ícono */
            .btn-secondary,
            .btn-danger,
            .btn-success {
                padding: 7px;
                border-radius: 9px;
                gap: 0;
            }
            .btn-secondary span,
            .btn-danger span,
            .btn-success span { display: none; }
            .btn-secondary svg,
            .btn-danger svg,
            .btn-success svg { width: 16px; height: 16px; }

            /* Cards aplastadas en fila */
            .cards-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            .menu-card {
                flex-direction: row;
                align-items: center;
                aspect-ratio: unset;
                padding: 12px 14px;
                gap: 12px;
                border-radius: 12px;
            }
            /* Acento pasa a barra izquierda */
            .menu-card::before {
                top: 10px; bottom: 10px;
                left: 0; right: auto;
                width: 3px; height: auto;
                border-radius: 0 3px 3px 0;
            }
            .menu-card:hover::before { top: 6px; bottom: 6px; left: 0; right: auto; }

            .card-icon {
                width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
            }
            .card-icon svg { width: 18px; height: 18px; }

            .card-body { flex: 1; min-height: 0; }
            .card-label { font-size: 14px; margin-bottom: 1px; }
            .card-desc  { font-size: 12px; }

            .card-foot { flex-shrink: 0; }
            .card-foot-label { display: none; }
            .card-arrow { width: 26px; height: 26px; }
            .card-arrow svg { width: 11px; height: 11px; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('obras.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Obras
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
            <div class="page-label">Obra</div>
            <div class="page-heading">{{ $obra->nombre }}</div>
            <div class="page-meta">
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
                <span class="meta-sep"></span>
                <span class="meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    {{ $obra->usuario->nick ?? '—' }}
                </span>
                <span class="meta-sep"></span>
                <span class="meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                    {{ $obra->created_at->format('d/m/Y') }}
                </span>
            </div>
        </div>
        <div class="header-actions">
            @if($puedeEditar)
            <button class="btn-secondary" onclick="abrirModal('modal-editar')" title="Editar nombre">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                </svg>
                <span>Editar nombre</span>
            </button>
            @endif
            @if($puedeEliminar && $obra->estado === 1)
            <form method="POST" action="{{ route('obras.inactivar', $obra) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-danger" title="Inactivar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    <span>Inactivar</span>
                </button>
            </form>
            @endif
            @if($puedeEliminar && $obra->estado === 2)
            <form method="POST" action="{{ route('obras.activar', $obra) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-success" title="Activar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Activar</span>
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
    @if(session('error'))
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Secciones --}}
    <div class="section-label">Secciones</div>

    <div class="cards-grid">

        @permiso('CON')
        <a href="{{ route('contactos.index', $obra) }}" class="menu-card card-contactos">
            <div class="card-icon icon-contactos">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                </svg>
            </div>
            <div class="card-body">
                <div class="card-label">Contactos</div>
                <div class="card-desc">Gestión de contactos vinculados a esta obra</div>
            </div>
            <div class="card-foot">
                <span class="card-foot-label">Sección</span>
                <div class="card-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>
        @endpermiso

        @permiso('RPB')
        <a href="{{ route('remisiones.index', $obra) }}" class="menu-card card-probetas">
            <div class="card-icon icon-probetas">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14M5 14.5a2.25 2.25 0 00-.45 1.955l1.8 7.2A2.25 2.25 0 007.8 25.5h8.4a2.25 2.25 0 002.25-1.845l1.8-7.2A2.25 2.25 0 0019 14.5"/>
                </svg>
            </div>
            <div class="card-body">
                <div class="card-label">Recepción de probetas</div>
                <div class="card-desc">Registro y seguimiento de muestras</div>
            </div>
            <div class="card-foot">
                <span class="card-foot-label">Sección</span>
                <div class="card-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>
        @endpermiso

        <a href="#" class="menu-card card-certificados">
            <div class="card-icon icon-certificados">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                </svg>
            </div>
            <div class="card-body">
                <div class="card-label">Certificados</div>
                <div class="card-desc">Documentos y certificaciones emitidas</div>
            </div>
            <div class="card-foot">
                <span class="card-foot-label">Sección</span>
                <div class="card-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>

    </div>

</main>

{{-- Modal: Editar nombre --}}
@if($puedeEditar)
<div class="modal-overlay" id="modal-editar" onclick="cerrarEnOverlay(event, 'modal-editar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Editar nombre</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-editar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('obras.update', $obra) }}">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="field">
                    <label for="inp-nombre">Nombre</label>
                    <input
                        type="text"
                        id="inp-nombre"
                        name="nombre"
                        value="{{ old('nombre', $obra->nombre) }}"
                        placeholder="Nombre de la obra"
                        autocomplete="off"
                        class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                    >
                    @error('nombre')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
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

<script>
    function abrirModal(id)  { document.getElementById(id).classList.add('open'); }
    function cerrarModal(id) { document.getElementById(id).classList.remove('open'); }
    function cerrarEnOverlay(e, id) { if (e.target === document.getElementById(id)) cerrarModal(id); }

    document.addEventListener('DOMContentLoaded', () => {
        @if($errors->any())
            abrirModal('modal-editar');
        @endif
    });
</script>

</body>
</html>
