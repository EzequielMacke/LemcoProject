<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes — LemcoProject</title>
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
        .page-label   { font-size: 11.5px; font-weight: 600; color: #16a34a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

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
        .accion-card:nth-child(3) { animation-delay: 0.18s; }

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
        .card-certificado::before { background: #16a34a; }

        .accion-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .accion-icon svg { width: 24px; height: 24px; }
        .accion-card:hover .accion-icon { transform: scale(1.07); }

        .icon-certificado { background: #f0fdf4; color: #16a34a; }

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
        <span class="navbar-title">Reportes</span>
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
            <div class="page-heading">Reportes</div>
        </div>
    </div>

    {{-- Acciones --}}
    <div class="acciones-grid">
        @permiso('REC')
        <a href="{{ route('reporte.certificado.parametros') }}" class="accion-card card-certificado">
            <div class="accion-icon icon-certificado">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
            </div>
            <div class="accion-body">
                <div class="accion-label">Certificado</div>
                <div class="accion-desc">Generar el reporte de certificados</div>
            </div>
            <div class="accion-foot">
                <span class="accion-foot-label">Reporte</span>
                <div class="accion-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>
        @endpermiso
    </div>

</main>

</body>
</html>
