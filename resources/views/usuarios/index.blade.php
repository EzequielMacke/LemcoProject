<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios — LemcoProject</title>
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
        .page-label   { font-size: 11.5px; font-weight: 600; color: #15803d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(21,128,61,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }

        .btn-danger {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #9f1239, #be123c);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(190,18,60,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-danger:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-danger:active { transform: translateY(0); }

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
            padding: 0;
        }
        .btn-icon svg { width: 15px; height: 15px; }
        .btn-icon-gear { color: #6b7280; }
        .btn-icon-gear:hover { background: #f1f5f9; border-color: #d1d5db; color: #374151; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Table card ── */
        .table-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeIn 0.4s ease 0.06s both;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            padding: 12px 16px;
            font-size: 11px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.6px;
            background: #f8fafc;
            border-bottom: 1.5px solid #e9ecef;
            text-align: left;
        }
        .th-actions { text-align: right; }

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
        }

        .td-id      { color: #9ca3af; font-size: 12px; font-weight: 600; width: 52px; }
        .td-nick    { font-weight: 500; color: #111827; }
        .td-sub     { font-size: 11.5px; color: #9ca3af; font-weight: 400; margin-top: 2px; }
        .td-actions { width: 52px; text-align: right; }

        /* ── Gear dropdown ── */
        .gear-wrap { position: relative; display: inline-block; }

        .dropdown {
            display: none;
            position: fixed;
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            min-width: 190px;
            z-index: 200;
            overflow: hidden;
        }
        .dropdown.open { display: block; }

        .dropdown-item {
            display: flex; align-items: center; gap: 9px;
            padding: 10px 14px;
            font-size: 13px; font-weight: 500; color: #374151;
            cursor: pointer; border: none; background: none;
            width: 100%; text-align: left;
            font-family: 'Inter', sans-serif;
            transition: background 0.12s;
        }
        .dropdown-item:hover { background: #f8fafc; }
        .dropdown-item svg { width: 14px; height: 14px; flex-shrink: 0; color: #9ca3af; }

        .dropdown-item-danger { color: #be123c; }
        .dropdown-item-danger:hover { background: #fff1f2; }
        .dropdown-item-danger svg { color: #f87171; }

        .dropdown-item-success { color: #15803d; }
        .dropdown-item-success:hover { background: #f0fdf4; }
        .dropdown-item-success svg { color: #4ade80; }

        .dropdown-sep { height: 1px; background: #f1f3f5; margin: 3px 0; }

        /* ── Estado badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 600; padding: 4px 10px;
            border-radius: 99px;
        }
        .badge svg { width: 7px; height: 7px; }
        .badge-activa   { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-anulada  { background: #f8fafc; color: #9ca3af; border: 1.5px solid #e9ecef; }

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
            cursor: pointer; color: #9ca3af; transition: all 0.15s;
            padding: 0;
        }
        .modal-close:hover { background: #f1f3f5; color: #374151; }
        .modal-close svg { width: 14px; height: 14px; }

        .modal-body { padding: 20px 22px; }

        .modal-desc {
            font-size: 13.5px; color: #374151; line-height: 1.6;
        }
        .modal-desc strong { color: #111827; font-weight: 600; }

        .modal-warn {
            margin-top: 12px;
            background: #fff7ed; border: 1.5px solid #fed7aa;
            border-radius: 10px; padding: 10px 14px;
            font-size: 12.5px; color: #c2410c; line-height: 1.5;
        }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }

        .field input, .field select {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field select {
            cursor: pointer; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
            background-color: #fafafa;
        }
        .field input:focus, .field select:focus {
            border-color: #15803d; background: #fff;
            box-shadow: 0 0 0 3px rgba(21,128,61,0.1);
        }
        .field select.is-invalid { border-color: #f87171; }
        .field-error { font-size: 12px; color: #be123c; }

        .modal-foot {
            padding: 16px 22px;
            border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Toggle envío ── */
        .toggle-wrap { display: flex; align-items: center; justify-content: center; }
        .toggle-switch { position: relative; display: inline-block; width: 36px; height: 20px; cursor: pointer; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
        .toggle-slider {
            position: absolute; inset: 0;
            background: #e5e7eb; border-radius: 99px;
            transition: background 0.2s;
        }
        .toggle-slider::before {
            content: ''; position: absolute;
            width: 14px; height: 14px; border-radius: 50%;
            background: #fff; top: 3px; left: 3px;
            transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.18);
        }
        .toggle-switch input:checked + .toggle-slider { background: #7c3aed; }
        .toggle-switch input:checked + .toggle-slider::before { transform: translateX(16px); }
        .toggle-switch input:disabled + .toggle-slider { opacity: 0.5; cursor: not-allowed; }
        .th-envio, .td-envio { text-align: center; width: 72px; }

        /* ── Toast ── */
        .toast {
            position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%) translateY(20px);
            background: #1e1e2e; color: #fff; font-size: 13px; font-weight: 500;
            padding: 10px 18px; border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            opacity: 0; pointer-events: none;
            transition: opacity 0.2s, transform 0.2s;
            z-index: 999; white-space: nowrap; max-width: 90vw; text-align: center;
        }
        .toast.toast-error { background: #be123c; }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
            .td-id, .th-id, .th-area, .td-area { display: none; }
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
        <span class="navbar-title">Usuarios</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    @php
        $permsUsu      = session('permisos', [])['usu'] ?? [];
        $puedeEditar   = $permsUsu['editar']   ?? false;
        $puedeEliminar = $permsUsu['eliminar'] ?? false;
        $miId          = session('usuario.id');
    @endphp

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">Módulo</div>
            <div class="page-heading">Usuarios</div>
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

    {{-- Tabla --}}
    <div class="table-card">
        @if($usuarios->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            <p>No hay usuarios registrados</p>
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th class="th-id">#</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th class="th-area">Área</th>
                    <th class="th-envio">Envío</th>
                    @if($puedeEditar || $puedeEliminar)
                    <th class="th-actions">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                @php
                    $showInactivar = $puedeEliminar && $usuario->estado === 1 && $usuario->id !== $miId;
                    $showActivar   = $puedeEliminar && $usuario->estado === 2;
                    $showAsignar   = $puedeEditar;
                    $tieneMenu     = $showInactivar || $showActivar || $showAsignar;
                @endphp
                <tr>
                    <td class="td-id">{{ $usuario->id }}</td>
                    <td class="td-nick">
                        {{ $usuario->nick }}
                        @if($usuario->persona && ($usuario->persona->nombre || $usuario->persona->apellido))
                        <div class="td-sub">{{ trim($usuario->persona->nombre . ' ' . $usuario->persona->apellido) }}</div>
                        @endif
                    </td>
                    <td>
                        @if($usuario->estado === 1)
                            <span class="badge badge-activa">
                                <svg viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                                Activo
                            </span>
                        @else
                            <span class="badge badge-anulada">
                                <svg viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                                Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="td-area">{{ $usuario->area->descripcion ?? '—' }}</td>
                    <td class="td-envio">
                        <div class="toggle-wrap">
                            <label class="toggle-switch" title="{{ $puedeEditar ? 'Activar/desactivar envío' : '' }}">
                                <input
                                    type="checkbox"
                                    {{ $usuario->envio ? 'checked' : '' }}
                                    {{ $puedeEditar ? '' : 'disabled' }}
                                    onchange="toggleEnvio(this, {{ $usuario->id }})"
                                >
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </td>
                    @if($puedeEditar || $puedeEliminar)
                    <td class="td-actions">
                        @if($tieneMenu)
                        <div class="gear-wrap">
                            <button
                                class="btn-icon btn-icon-gear"
                                title="Acciones"
                                onclick="toggleDropdown(this)"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                            <div class="dropdown">
                                @if($showInactivar)
                                <button
                                    class="dropdown-item dropdown-item-danger"
                                    onclick="abrirInactivar({{ $usuario->id }}, @js($usuario->nick))"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    Inactivar usuario
                                </button>
                                @endif
                                @if($showActivar)
                                <button
                                    class="dropdown-item dropdown-item-success"
                                    onclick="abrirActivar({{ $usuario->id }}, @js($usuario->nick))"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Activar usuario
                                </button>
                                @endif
                                @if(($showInactivar || $showActivar) && $showAsignar)
                                <div class="dropdown-sep"></div>
                                @endif
                                @if($showAsignar)
                                <button
                                    class="dropdown-item"
                                    onclick="abrirAsignarArea({{ $usuario->id }}, @js($usuario->nick), {{ $usuario->area_id ?? 'null' }})"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                    </svg>
                                    {{ $usuario->area_id ? 'Cambiar área' : 'Asignar área' }}
                                </button>
                                @endif
                            </div>
                        </div>
                        @endif
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</main>

{{-- Modal: Inactivar usuario --}}
@if($puedeEliminar)
<div class="modal-overlay" id="modal-inactivar" onclick="cerrarEnOverlay(event, 'modal-inactivar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Inactivar usuario</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-inactivar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="form-inactivar" action="">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <p class="modal-desc">
                    ¿Estás seguro de que querés inactivar al usuario <strong id="inactivar-nick"></strong>?
                </p>
                <div class="modal-warn">
                    El usuario no podrá iniciar sesión mientras esté inactivo.
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-inactivar')">Cancelar</button>
                <button type="submit" class="btn-danger">Inactivar</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal: Activar usuario --}}
@if($puedeEliminar)
<div class="modal-overlay" id="modal-activar" onclick="cerrarEnOverlay(event, 'modal-activar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Activar usuario</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-activar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="form-activar" action="">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <p class="modal-desc">
                    ¿Querés activar al usuario <strong id="activar-nick"></strong>? Podrá iniciar sesión nuevamente.
                </p>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-activar')">Cancelar</button>
                <button type="submit" class="btn-primary">Activar</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal: Asignar / cambiar área --}}
@if($puedeEditar)
<div class="modal-overlay" id="modal-asignar-area" onclick="cerrarEnOverlay(event, 'modal-asignar-area')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Asignar / cambiar área</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-asignar-area')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="form-asignar-area" action="">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <p class="modal-desc">Usuario: <strong id="asignar-nick"></strong></p>
                <div class="field" style="margin-top: 16px;">
                    <label for="inp-area-id">Área</label>
                    <select
                        id="inp-area-id"
                        name="area_id"
                        class="{{ $errors->has('area_id') ? 'is-invalid' : '' }}"
                    >
                        <option value="">Seleccionar área...</option>
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->descripcion }}</option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-asignar-area')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="toast" id="toast"></div>

<script>
    function mostrarToast(msg, esError = false) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className = 'toast' + (esError ? ' toast-error' : '') + ' show';
        clearTimeout(t._timer);
        t._timer = setTimeout(() => t.classList.remove('show'), 3000);
    }

    function toggleEnvio(checkbox, id) {
        checkbox.disabled = true;
        fetch('/usuarios/' + id + '/envio', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
        .then(r => r.json().then(data => ({ ok: r.ok, data })))
        .then(({ ok, data }) => {
            if (ok) {
                checkbox.checked = data.envio === 1;
                mostrarToast(data.envio === 1 ? 'Envío activado.' : 'Envío desactivado.');
            } else {
                checkbox.checked = !checkbox.checked;
                mostrarToast(data.error, true);
            }
        })
        .catch(() => {
            checkbox.checked = !checkbox.checked;
            mostrarToast('Error de conexión. Intentá de nuevo.', true);
        })
        .finally(() => { checkbox.disabled = false; });
    }

    function abrirModal(id) {
        document.getElementById(id).classList.add('open');
    }
    function cerrarModal(id) {
        document.getElementById(id).classList.remove('open');
    }
    function cerrarEnOverlay(e, id) {
        if (e.target === document.getElementById(id)) cerrarModal(id);
    }

    function toggleDropdown(btn) {
        const dropdown = btn.nextElementSibling;
        const isOpen   = dropdown.classList.contains('open');
        cerrarTodosDropdowns();
        if (!isOpen) {
            const rect = btn.getBoundingClientRect();
            dropdown.style.top   = (rect.bottom + 6) + 'px';
            dropdown.style.right = (window.innerWidth - rect.right) + 'px';
            dropdown.classList.add('open');
        }
    }
    function cerrarTodosDropdowns() {
        document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    }
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.gear-wrap')) cerrarTodosDropdowns();
    });

    function abrirInactivar(id, nick) {
        cerrarTodosDropdowns();
        document.getElementById('inactivar-nick').textContent = nick;
        document.getElementById('form-inactivar').action = '/usuarios/' + id + '/inactivar';
        abrirModal('modal-inactivar');
    }

    function abrirActivar(id, nick) {
        cerrarTodosDropdowns();
        document.getElementById('activar-nick').textContent = nick;
        document.getElementById('form-activar').action = '/usuarios/' + id + '/activar';
        abrirModal('modal-activar');
    }

    function abrirAsignarArea(id, nick, areaId) {
        cerrarTodosDropdowns();
        document.getElementById('asignar-nick').textContent = nick;
        document.getElementById('form-asignar-area').action = '/usuarios/' + id + '/area';
        const select = document.getElementById('inp-area-id');
        select.value = areaId || '';
        abrirModal('modal-asignar-area');
    }

    // Reabrir modal si hubo error de validación en asignar área
    document.addEventListener('DOMContentLoaded', () => {
        @error('area_id')
            abrirModal('modal-asignar-area');
        @enderror
    });
</script>

</body>
</html>
