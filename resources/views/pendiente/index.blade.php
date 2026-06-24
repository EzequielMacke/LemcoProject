<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendientes — LemcoProject</title>
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

        .page-header { animation: fadeUp 0.35s ease both; }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #4338ca; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Grid de categorías ── */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 16px;
        }

        /* ── Card de categoría ── */
        .category-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease 0.06s both;
            display: flex;
            flex-direction: column;
        }

        .category-head {
            display: flex; align-items: center; gap: 12px;
            padding: 18px 20px;
            border-bottom: 1.5px solid #e9ecef;
        }
        .category-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: #eef2ff; color: #4338ca;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .category-icon svg { width: 20px; height: 20px; }
        .category-icon.teal { background: #f0fdfa; color: #0f766e; }
        .category-icon.amber { background: #fffbeb; color: #b45309; }
        .category-title-wrap { flex: 1; min-width: 0; }
        .category-title { font-size: 14.5px; font-weight: 700; color: #111827; }
        .category-subtitle { font-size: 12px; color: #9ca3af; margin-top: 1px; }
        .category-count {
            font-size: 11.5px; font-weight: 700; color: #4338ca;
            background: #eef2ff; padding: 4px 10px; border-radius: 99px;
            flex-shrink: 0;
        }
        .category-count.teal { color: #0f766e; background: #f0fdfa; }
        .category-count.amber { color: #b45309; background: #fffbeb; }

        .category-list {
            display: flex; flex-direction: column;
            max-height: 340px; overflow-y: auto;
        }

        .date-row {
            display: flex; align-items: center; gap: 12px;
            padding: 13px 20px;
            text-decoration: none;
            border-bottom: 1px solid #f1f3f5;
            transition: background 0.12s;
        }
        .date-row:last-child { border-bottom: none; }
        .date-row:hover { background: #f8fafc; }
        .date-row-disabled { cursor: default; }
        .date-row-disabled:hover { background: none; }

        .date-info { flex: 1; min-width: 0; }
        .date-main { font-size: 13.5px; font-weight: 600; color: #111827; text-transform: capitalize; }
        .date-sub  { font-size: 11.5px; color: #9ca3af; margin-top: 1px; }

        .date-badge {
            font-size: 11px; font-weight: 700; color: #b45309;
            background: #fffbeb; border: 1.5px solid #fde68a;
            padding: 3px 9px; border-radius: 99px;
            flex-shrink: 0; white-space: nowrap;
        }

        .date-arrow {
            width: 26px; height: 26px; border-radius: 50%;
            background: #f1f3f5;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s, transform 0.15s;
            flex-shrink: 0;
        }
        .date-arrow svg { width: 11px; height: 11px; color: #9ca3af; }
        .date-row:hover .date-arrow { background: #e9ecef; transform: translateX(2px); }

        /* ── Empty state ── */
        .empty-state {
            padding: 40px 24px;
            text-align: center; color: #9ca3af;
        }
        .empty-state svg { width: 34px; height: 34px; margin: 0 auto 10px; display: block; color: #d1d5db; }
        .empty-state p   { font-size: 13px; }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
            .categories-grid { grid-template-columns: 1fr; }
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
        <span class="navbar-title">Pendientes</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    <div class="page-header">
        <div class="page-label">Módulo</div>
        <div class="page-heading">Pendientes</div>
    </div>

    <div class="categories-grid">

        {{-- Categoría: Ensayos de compresión pendientes --}}
        @permiso('ENS')
        <div class="category-card">
            <div class="category-head">
                <div class="category-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                    </svg>
                </div>
                <div class="category-title-wrap">
                    <div class="category-title">Ensayos de compresión pendientes</div>
                    <div class="category-subtitle">Agrupados por fecha de ensayo</div>
                </div>
                <span class="category-count">{{ $ensayosPendientes->sum('cantidad') }}</span>
            </div>

            <div class="category-list">
                @if($ensayosPendientes->isEmpty())
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>No hay ensayos de compresión pendientes</p>
                    </div>
                @else
                    @php $puedeAgregarEnsayo = session('permisos', [])['ens']['agregar'] ?? false; @endphp
                    @foreach($ensayosPendientes as $item)
                        @if($puedeAgregarEnsayo)
                        <a href="{{ route('ensayos.create', $item['fecha']) }}" class="date-row">
                            <div class="date-info">
                                <div class="date-main">{{ \Carbon\Carbon::parse($item['fecha'])->locale('es')->translatedFormat('l d \d\e F \d\e Y') }}</div>
                                <div class="date-sub">{{ \Carbon\Carbon::parse($item['fecha'])->format('d/m/Y') }}</div>
                            </div>
                            <span class="date-badge">{{ $item['cantidad'] }} {{ $item['cantidad'] === 1 ? 'probeta' : 'probetas' }}</span>
                            <div class="date-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </div>
                        </a>
                        @else
                        <div class="date-row date-row-disabled">
                            <div class="date-info">
                                <div class="date-main">{{ \Carbon\Carbon::parse($item['fecha'])->locale('es')->translatedFormat('l d \d\e F \d\e Y') }}</div>
                                <div class="date-sub">{{ \Carbon\Carbon::parse($item['fecha'])->format('d/m/Y') }}</div>
                            </div>
                            <span class="date-badge">{{ $item['cantidad'] }} {{ $item['cantidad'] === 1 ? 'probeta' : 'probetas' }}</span>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        @endpermiso

        {{-- Categoría: Informes pendientes --}}
        @permiso('INF')
        <div class="category-card">
            <div class="category-head">
                <div class="category-icon teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-1.519-2.231L12 17.25m-3.75-9V18a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 18V9.75M9.75 3.104a48.554 48.554 0 00-2.25.111c-1.026.092-1.875.93-1.875 1.959v9.252M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L7.65 11.95"/>
                    </svg>
                </div>
                <div class="category-title-wrap">
                    <div class="category-title">Informes pendientes</div>
                    <div class="category-subtitle">Agrupados por obra · solo probetas ensayadas</div>
                </div>
                <span class="category-count teal">{{ $informesPendientes->sum('cantidad') }}</span>
            </div>

            <div class="category-list">
                @if($informesPendientes->isEmpty())
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>No hay informes pendientes</p>
                    </div>
                @else
                    @php $puedeAgregarInforme = session('permisos', [])['inf']['agregar'] ?? false; @endphp
                    @foreach($informesPendientes as $item)
                        @if($puedeAgregarInforme)
                        <a href="{{ route('informes.index', $item['obra']) }}" class="date-row">
                            <div class="date-info">
                                <div class="date-main">{{ $item['obra']->nombre }}</div>
                            </div>
                            <span class="date-badge">{{ $item['cantidad'] }} {{ $item['cantidad'] === 1 ? 'probeta' : 'probetas' }}</span>
                            <div class="date-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </div>
                        </a>
                        @else
                        <div class="date-row date-row-disabled">
                            <div class="date-info">
                                <div class="date-main">{{ $item['obra']->nombre }}</div>
                            </div>
                            <span class="date-badge">{{ $item['cantidad'] }} {{ $item['cantidad'] === 1 ? 'probeta' : 'probetas' }}</span>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        @endpermiso

        {{-- Categoría: Certificados pendientes --}}
        @permiso('CER')
        <div class="category-card">
            <div class="category-head">
                <div class="category-icon amber">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                    </svg>
                </div>
                <div class="category-title-wrap">
                    <div class="category-title">Certificados pendientes</div>
                    <div class="category-subtitle">Agrupados por obra</div>
                </div>
                <span class="category-count amber">{{ $certificadosPendientes->sum('cantidad') }}</span>
            </div>

            <div class="category-list">
                @if($certificadosPendientes->isEmpty())
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>No hay certificados pendientes</p>
                    </div>
                @else
                    @php $puedeAgregarCertificado = session('permisos', [])['cer']['agregar'] ?? false; @endphp
                    @foreach($certificadosPendientes as $item)
                        @if($puedeAgregarCertificado)
                        <a href="{{ route('certificacion.index', $item['obra']) }}" class="date-row">
                            <div class="date-info">
                                <div class="date-main">{{ $item['obra']->nombre }}</div>
                            </div>
                            <span class="date-badge">{{ $item['cantidad'] }} {{ $item['cantidad'] === 1 ? 'probeta' : 'probetas' }}</span>
                            <div class="date-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </div>
                        </a>
                        @else
                        <div class="date-row date-row-disabled">
                            <div class="date-info">
                                <div class="date-main">{{ $item['obra']->nombre }}</div>
                            </div>
                            <span class="date-badge">{{ $item['cantidad'] }} {{ $item['cantidad'] === 1 ? 'probeta' : 'probetas' }}</span>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        @endpermiso

    </div>

</main>

</body>
</html>
