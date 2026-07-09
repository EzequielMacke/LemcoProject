<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Control de Equipos — LemcoProject</title>
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
        .page-label   { font-size: 11.5px; font-weight: 600; color: #0284c7; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Buscador ── */
        .toolbar {
            display: flex; align-items: center; justify-content: flex-end;
            animation: fadeUp 0.38s ease 0.04s both;
        }
        .search-wrap { position: relative; flex: 1; max-width: 360px; }
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
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2,132,199,0.1);
        }
        .search-input::placeholder { color: #9ca3af; }

        /* ── Tarjetas de registro ── */
        .registros-grid {
            display: flex; flex-direction: column; gap: 16px;
        }

        .registro-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-left: 5px solid #d1d5db;
            border-radius: 16px;
            padding: 20px 22px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease both;
        }
        .registro-card.estado-devuelto { border-left-color: #16a34a; background: #f6fdf8; }
        .registro-card.estado-pendiente { border-left-color: #dc2626; background: #fffafa; }

        .registro-head {
            display: flex; align-items: flex-start; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
            padding-bottom: 14px; margin-bottom: 14px;
            border-bottom: 1px solid #f1f3f5;
        }
        .registro-obra { font-size: 16px; font-weight: 700; color: #111827; letter-spacing: -0.2px; }
        .registro-meta {
            display: flex; flex-wrap: wrap; gap: 4px 18px;
            margin-top: 6px; font-size: 12.5px; color: #6b7280;
        }
        .registro-meta span b { color: #374151; font-weight: 600; }

        .badge {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11.5px; font-weight: 700;
            padding: 5px 12px; border-radius: 99px;
            white-space: nowrap;
        }
        .badge svg { width: 12px; height: 12px; }
        .badge-verde    { background: #dcfce7; color: #15803d; }
        .badge-rojo     { background: #fee2e2; color: #b91c1c; }
        .badge-amarillo { background: #fef3c7; color: #b45309; }

        .registro-detalles { display: flex; flex-direction: column; gap: 8px; }
        .detalle-equipo {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; padding: 10px 14px;
            background: #f8fafc; border-radius: 10px;
        }
        .detalle-equipo-info { display: flex; align-items: baseline; gap: 10px; min-width: 0; }
        .detalle-equipo-id { font-size: 11.5px; font-weight: 700; color: #9ca3af; flex-shrink: 0; }
        .detalle-equipo-nombre { font-size: 13.5px; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .detalle-equipo-marca { font-size: 12.5px; color: #9ca3af; flex-shrink: 0; }
        .detalle-equipo-cantidad { font-size: 12px; font-weight: 600; color: #6b7280; flex-shrink: 0; }

        .empty-state {
            padding: 56px 24px;
            text-align: center; color: #9ca3af;
        }
        .empty-state svg { width: 40px; height: 40px; margin: 0 auto 12px; display: block; color: #d1d5db; }
        .empty-state p   { font-size: 14px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
            .search-wrap { max-width: 100%; }
            .detalle-equipo { flex-direction: column; align-items: flex-start; gap: 6px; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('control-equipos.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Volver
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Registros de Control de Equipos</span>
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
            <div class="page-label">Control de Equipos</div>
            <div class="page-heading">Registros</div>
        </div>
    </div>

    {{-- Buscador --}}
    @if($retiros->isNotEmpty())
    <div class="toolbar">
        <div class="search-wrap">
            <span class="search-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </span>
            <input
                type="text"
                id="buscador-registros"
                class="search-input"
                placeholder="Buscar por obra, retirado por o equipo..."
                oninput="aplicarFiltroRegistros()"
                autocomplete="off"
            >
        </div>
    </div>
    @endif

    {{-- Tarjetas --}}
    @if($retiros->isEmpty())
    <div class="registro-card">
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125h4.5m-8.25-4.125h12l-.75-3H4.5l-.75 3z"/>
            </svg>
            <p>Todavía no hay retiros registrados</p>
        </div>
    </div>
    @else
    <div class="registros-grid" id="registros-grid">
        @foreach($retiros as $retiro)
        @php
            $devuelto = ! is_null($retiro->fecha_devolucion);
            $buscar = strtolower(trim(
                ($retiro->obraRetiro->descripcion ?? '') . ' ' .
                ($retiro->funcionarioRetiro->descripcion ?? '') . ' ' .
                $retiro->detalles->map(fn ($d) => ($d->equipo->nombre ?? '') . ' ' . ($d->equipo->abreviacion ?? '') . ' ' . ($d->equipo->marca->descripcion ?? ''))->implode(' ')
            ));
        @endphp
        <div class="registro-card {{ $devuelto ? 'estado-devuelto' : 'estado-pendiente' }} fila-registro" data-buscar="{{ $buscar }}">
            <div class="registro-head">
                <div>
                    <div class="registro-obra">{{ $retiro->obraRetiro->descripcion ?? '—' }}</div>
                    <div class="registro-meta">
                        <span>Retirado por <b>{{ $retiro->funcionarioRetiro->descripcion ?? '—' }}</b></span>
                        <span>Fecha de retiro <b>{{ $retiro->fecha_retiro?->format('d/m/Y') ?? '—' }}</b></span>
                        <span>Fecha de devolución <b>{{ $retiro->fecha_devolucion?->format('d/m/Y') ?? '—' }}</b></span>
                    </div>
                </div>
                @if($devuelto)
                <span class="badge badge-verde">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                    Devuelto
                </span>
                @else
                <span class="badge badge-rojo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    Pendiente
                </span>
                @endif
            </div>
            <div class="registro-detalles">
                @foreach($retiro->detalles as $detalle)
                @php
                    $detalleDevuelto = ! is_null($detalle->fecha_devolucion);
                    $cantidadRetirada = $detalle->cantidad_retirada ?? 1;
                    $cantidadDevuelta = $detalle->cantidad_devuelta ?? 0;
                    $cantidadPendiente = max(0, $cantidadRetirada - $cantidadDevuelta);
                    $esPorCantidad = (int) ($detalle->equipo->tipo_equipo_id ?? 0) === 2;
                @endphp
                <div class="detalle-equipo">
                    <div class="detalle-equipo-info">
                        <span class="detalle-equipo-id">{{ $detalle->equipo->abreviacion ?? '—' }}</span>
                        <span class="detalle-equipo-nombre">{{ $detalle->equipo->nombre ?? 'Equipo eliminado' }}</span>
                        <span class="detalle-equipo-marca">{{ $detalle->equipo->marca->descripcion ?? '' }}</span>
                        @if($esPorCantidad)
                        <span class="detalle-equipo-cantidad">Cant. {{ $cantidadDevuelta }}/{{ $cantidadRetirada }}</span>
                        @endif
                    </div>
                    @if($detalleDevuelto)
                    <span class="badge badge-verde">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Devuelto {{ $detalle->fecha_devolucion?->format('d/m/Y') }}
                    </span>
                    @elseif($esPorCantidad && $cantidadDevuelta > 0)
                    <span class="badge badge-amarillo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        Parcial ({{ $cantidadPendiente }} pendiente)
                    </span>
                    @else
                    <span class="badge badge-rojo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        Pendiente
                    </span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="registro-card" id="tarjeta-sin-resultados" style="display: none;">
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <p>No se encontraron registros con ese criterio</p>
            </div>
        </div>
    </div>
    @endif

</main>

<script>
    function aplicarFiltroRegistros() {
        const q = document.getElementById('buscador-registros').value.toLowerCase().trim();
        let visibles = 0;

        document.querySelectorAll('.fila-registro').forEach(tarjeta => {
            const mostrar = !q || tarjeta.dataset.buscar.includes(q);
            tarjeta.style.display = mostrar ? '' : 'none';
            if (mostrar) visibles++;
        });

        document.getElementById('tarjeta-sin-resultados').style.display = visibles === 0 ? '' : 'none';
    }
</script>

</body>
</html>
