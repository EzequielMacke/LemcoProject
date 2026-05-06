<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú — LemcoProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #111827;
        }

        body {
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
        .brand {
            display: flex; align-items: center; gap: 9px;
            text-decoration: none;
        }
        .brand-icon {
            width: 30px; height: 30px; border-radius: 7px;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(29,78,216,0.3);
            flex-shrink: 0;
        }
        .brand-icon svg { width: 15px; height: 15px; color: #fff; }
        .brand-name { font-size: 14px; font-weight: 700; color: #111827; }

        .navbar-right { display: flex; align-items: center; gap: 10px; }
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
            font-size: 10px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .user-name { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px; }
        .btn-logout {
            display: flex; align-items: center; gap: 5px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 8px;
            padding: 6px 11px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s; white-space: nowrap;
        }
        .btn-logout:hover { background: #fff0f0; border-color: #fca5a5; color: #dc2626; }
        .btn-logout svg { width: 13px; height: 13px; flex-shrink: 0; }
        .btn-logout-text { display: inline; }

        /* ── Página ── */
        .page {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 28px 24px 24px;
            gap: 22px;
        }

        /* Greeting */
        .greeting {
            flex-shrink: 0;
            animation: fadeUp 0.35s ease both;
        }
        .greeting-label {
            font-size: 11.5px; font-weight: 600;
            color: #1d4ed8; text-transform: uppercase;
            letter-spacing: 1px; margin-bottom: 5px;
        }
        .greeting h1 {
            font-size: 22px; font-weight: 700; color: #0f172a;
            letter-spacing: -0.4px; margin-bottom: 3px;
        }
        .greeting p { font-size: 13.5px; color: #6b7280; }

        /* Grid — auto-fill, izquierda, cuadradas */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, 190px);
            justify-content: start;
            gap: 14px;
            width: 100%;
        }

        /* Card */
        .menu-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            padding: 24px 22px 20px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            aspect-ratio: 1 / 1;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease both;
        }
        .menu-card:nth-child(1) { animation-delay: 0.06s; }
        .menu-card:nth-child(2) { animation-delay: 0.12s; }
        .menu-card:nth-child(3) { animation-delay: 0.18s; }
        .menu-card:nth-child(4) { animation-delay: 0.24s; }
        .menu-card:nth-child(5) { animation-delay: 0.30s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .menu-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-color: #d1d5db;
        }
        .menu-card:active { transform: translateY(0); }

        /* Acento superior */
        .menu-card::before {
            content: '';
            position: absolute; top: 0; left: 18px; right: 18px;
            height: 2.5px; border-radius: 0 0 4px 4px;
            transition: left 0.2s, right 0.2s;
        }
        .menu-card:hover::before { left: 10px; right: 10px; }
        .card-personas::before { background: #1d4ed8; }
        .card-areas::before    { background: #15803d; }
        .card-permisos::before { background: #b45309; }
        .card-usuarios::before { background: #0e7490; }
        .card-obras::before    { background: #ea580c; }
        .card-envios::before   { background: #7c3aed; }

        /* Ícono */
        .card-icon {
            width: 48px; height: 48px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .card-icon svg { width: 22px; height: 22px; }
        .menu-card:hover .card-icon { transform: scale(1.07); }

        .icon-personas { background: #eff6ff; color: #1d4ed8; }
        .icon-areas    { background: #f0fdf4; color: #15803d; }
        .icon-permisos { background: #fffbeb; color: #b45309; }
        .icon-usuarios { background: #f0f9ff; color: #0e7490; }
        .icon-obras    { background: #fff7ed; color: #ea580c; }
        .icon-envios   { background: #f5f3ff; color: #7c3aed; }

        /* Texto — crece para llenar el espacio */
        .card-body { flex: 1; min-height: 0; }
        .card-label { font-size: 15px; font-weight: 700; color: #111827; letter-spacing: -0.2px; margin-bottom: 5px; }
        .card-desc  { font-size: 12.5px; color: #9ca3af; line-height: 1.5; }

        /* Footer */
        .card-foot {
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .card-foot-label {
            font-size: 11px; font-weight: 600; color: #d1d5db;
            text-transform: uppercase; letter-spacing: 0.6px;
        }
        .card-arrow {
            width: 30px; height: 30px; border-radius: 50%;
            background: #f1f3f5;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s, transform 0.15s;
            flex-shrink: 0;
        }
        .card-arrow svg { width: 13px; height: 13px; color: #9ca3af; }
        .menu-card:hover .card-arrow {
            background: #e9ecef;
            transform: translateX(2px);
        }

        /* Badge */
        .badge-alert {
            position: absolute; top: 14px; right: 14px;
            min-width: 22px; height: 22px; padding: 0 7px;
            background: #dc2626; color: #fff;
            font-size: 11px; font-weight: 700; border-radius: 99px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(220,38,38,0.35);
            animation: badgePop 0.35s cubic-bezier(0.34,1.56,0.64,1) 0.4s both;
        }
        @keyframes badgePop {
            from { transform: scale(0); }
            to   { transform: scale(1); }
        }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
            width: 100%;
        }
        .alert-error { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Responsive: tablet ── */
        @media (max-width: 768px) {
            .user-name { display: none; }
            .btn-logout-text { display: none; }
            .btn-logout { padding: 6px 8px; }
            .greeting h1 { font-size: 19px; }
        }

        /* ── Responsive: móvil ── */
        @media (max-width: 600px) {
            html, body { height: auto; }

            .page {
                padding: 20px 16px 24px;
                gap: 18px;
                flex: none;
            }

            .cards-grid {
                flex: none;
                grid-template-columns: 1fr;
                grid-template-rows: auto;
                gap: 12px;
            }

            .menu-card {
                flex-direction: row;
                align-items: center;
                padding: 18px 18px;
                gap: 16px;
                border-radius: 14px;
                aspect-ratio: unset;
            }

            /* En móvil, ocultar acento superior y poner acento izquierdo */
            .menu-card::before {
                top: 14px; bottom: 14px;
                left: 0; right: auto;
                width: 3px; height: auto;
                border-radius: 0 4px 4px 0;
                transition: none;
            }
            .menu-card:hover::before { left: 0; right: auto; }

            .card-icon {
                width: 44px; height: 44px; border-radius: 12px;
                flex-shrink: 0;
            }
            .card-icon svg { width: 20px; height: 20px; }

            .card-body { flex: 1; }
            .card-label { font-size: 14px; margin-bottom: 3px; }
            .card-desc  { font-size: 12px; }

            .card-foot { flex-direction: column; align-items: flex-end; gap: 4px; }
            .card-foot-label { display: none; }

            .menu-card:hover { transform: none; }
            .menu-card:hover .card-icon { transform: none; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <a href="#" class="brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
            </svg>
        </div>
        <span class="brand-name">LemcoProject</span>
    </a>
    <div class="navbar-right">
        <div class="navbar-user">
            <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
            <span class="user-name">{{ session('usuario.nick') }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                </svg>
                <span class="btn-logout-text">Cerrar sesión</span>
            </button>
        </form>
    </div>
</nav>

{{-- Contenido --}}
<main class="page">

    <div class="greeting">
        <div class="greeting-label">Panel principal</div>
        <h1>Bienvenido, {{ session('usuario.nick') }}</h1>
        <p>Seleccioná un módulo para continuar</p>
    </div>

    @if (session('error'))
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="cards-grid">

        @permiso('DAT')
        <a href="{{ route('personas.index') }}" class="menu-card card-personas">
            @if ($datosFaltantes > 0)
                <span class="badge-alert">{{ $datosFaltantes }}</span>
            @endif
            <div class="card-icon icon-personas">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
            </div>
            <div class="card-body">
                <div class="card-label">Datos personas</div>
                <div class="card-desc">Gestión de información personal del equipo</div>
            </div>
            <div class="card-foot">
                <span class="card-foot-label">Módulo</span>
                <div class="card-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>
        @endpermiso

        @permiso('ARE')
        <a href="{{ route('areas.index') }}" class="menu-card card-areas">
            <div class="card-icon icon-areas">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                </svg>
            </div>
            <div class="card-body">
                <div class="card-label">Áreas</div>
                <div class="card-desc">Administración de áreas y sectores del sistema</div>
            </div>
            <div class="card-foot">
                <span class="card-foot-label">Módulo</span>
                <div class="card-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>
        @endpermiso

        @permiso('PER')
        <a href="{{ route('permisos.index') }}" class="menu-card card-permisos">
            <div class="card-icon icon-permisos">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
            </div>
            <div class="card-body">
                <div class="card-label">Permisos</div>
                <div class="card-desc">Control de acceso y roles por módulo</div>
            </div>
            <div class="card-foot">
                <span class="card-foot-label">Módulo</span>
                <div class="card-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>
        @endpermiso

        @permiso('USU')
        <a href="{{ route('usuarios.index') }}" class="menu-card card-usuarios">
            <div class="card-icon icon-usuarios">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="card-body">
                <div class="card-label">Usuarios</div>
                <div class="card-desc">Gestión de cuentas y accesos al sistema</div>
            </div>
            <div class="card-foot">
                <span class="card-foot-label">Módulo</span>
                <div class="card-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </a>
        @endpermiso

        @permiso('OBR')
        <a href="{{ route('obras.index') }}" class="menu-card card-obras">
            <div class="card-icon icon-obras">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                </svg>
            </div>
            <div class="card-body">
                <div class="card-label">Obras</div>
                <div class="card-desc">Seguimiento y gestión de proyectos y obras</div>
            </div>
            <div class="card-foot">
                <span class="card-foot-label">Módulo</span>
                <div class="card-arrow">
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
