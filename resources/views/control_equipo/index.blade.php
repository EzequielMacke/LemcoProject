<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Equipos — LemcoProject</title>
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
            display: flex; flex-direction: column; gap: 22px;
        }

        /* ── Page header ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            animation: fadeUp 0.35s ease both;
        }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #0284c7; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        .btn-outline {
            display: inline-flex; align-items: center; gap: 7px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 16px; font-size: 13px; font-weight: 500;
            color: #374151; text-decoration: none; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-outline:hover { background: #f8f9fa; border-color: #d1d5db; }
        .btn-outline svg { width: 14px; height: 14px; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Grid de acciones ── */
        .acciones-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            max-width: 640px;
        }

        .accion-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            padding: 28px 26px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
            overflow: hidden;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease both;
        }
        .accion-card:nth-child(1) { animation-delay: 0.06s; }
        .accion-card:nth-child(2) { animation-delay: 0.12s; }

        .accion-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-color: #d1d5db;
        }
        .accion-card:active { transform: translateY(0); }

        .accion-card::before {
            content: '';
            position: absolute; top: 0; left: 22px; right: 22px;
            height: 2.5px; border-radius: 0 0 4px 4px;
            transition: left 0.2s, right 0.2s;
        }
        .accion-card:hover::before { left: 12px; right: 12px; }
        .card-retiro::before     { background: #ea580c; }
        .card-devolucion::before { background: #15803d; }

        .accion-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .accion-icon svg { width: 24px; height: 24px; }
        .accion-card:hover .accion-icon { transform: scale(1.07); }

        .icon-retiro     { background: #fff7ed; color: #ea580c; }
        .icon-devolucion { background: #f0fdf4; color: #15803d; }

        .accion-body { flex: 1; }
        .accion-label { font-size: 16px; font-weight: 700; color: #111827; letter-spacing: -0.2px; margin-bottom: 5px; }
        .accion-desc  { font-size: 12.5px; color: #9ca3af; line-height: 1.5; }

        .accion-foot {
            display: flex; align-items: center; justify-content: space-between;
        }
        .accion-foot-label {
            font-size: 11px; font-weight: 600; color: #d1d5db;
            text-transform: uppercase; letter-spacing: 0.6px;
        }
        .accion-arrow {
            width: 32px; height: 32px; border-radius: 50%;
            background: #f1f3f5;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s, transform 0.15s;
            flex-shrink: 0;
        }
        .accion-arrow svg { width: 14px; height: 14px; color: #9ca3af; }
        .accion-card:hover .accion-arrow {
            background: #e9ecef;
            transform: translateX(2px);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
            .acciones-grid { grid-template-columns: 1fr; }
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
        <span class="navbar-title">Control de Equipos</span>
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
            <div class="page-label">Módulo</div>
            <div class="page-heading">Control de Equipos</div>
        </div>
        <a href="{{ route('control-equipos.registros') }}" class="btn-outline">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Ver registros
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Acciones --}}
    <div class="acciones-grid">
        <a href="{{ route('control-equipos.retiro') }}" class="accion-card card-retiro">
            <div class="accion-icon icon-retiro">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75A2.25 2.25 0 001.5 12.75v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
            </div>
            <div class="accion-body">
                <div class="accion-label">Retiro</div>
                <div class="accion-desc">Registrar la salida de un equipo del inventario</div>
            </div>
            <div class="accion-foot">
                <span class="accion-foot-label">Acción</span>
                <div class="accion-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>

        <a href="{{ route('control-equipos.devolucion') }}" class="accion-card card-devolucion">
            <div class="accion-icon icon-devolucion">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>
                </svg>
            </div>
            <div class="accion-body">
                <div class="accion-label">Devolución</div>
                <div class="accion-desc">Registrar el ingreso de un equipo retirado</div>
            </div>
            <div class="accion-foot">
                <span class="accion-foot-label">Acción</span>
                <div class="accion-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>
    </div>

</main>

</body>
</html>
