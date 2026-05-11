<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ensayos de compresión — LemcoProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #111827;
        }

        /* ── Navbar ── */
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 0 24px;
            height: 54px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
        .navbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .btn-back {
            display: flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 8px;
            padding: 6px 11px; font-size: 13px; font-weight: 500;
            color: #6b7280; text-decoration: none; transition: all 0.15s; flex-shrink: 0;
        }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }
        .nav-sep { width: 1px; height: 18px; background: #e9ecef; flex-shrink: 0; }
        .navbar-title { font-size: 14px; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .navbar-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
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
        .btn-logout {
            display: flex; align-items: center; gap: 5px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 8px;
            padding: 6px 11px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s;
        }
        .btn-logout:hover { background: #fff0f0; border-color: #fca5a5; color: #dc2626; }
        .btn-logout svg { width: 13px; height: 13px; flex-shrink: 0; }

        /* ── Página ── */
        .page { padding: 24px; display: flex; flex-direction: column; gap: 20px; }

        /* ── Cabecera ── */
        .cal-header {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; flex-wrap: wrap;
        }
        .cal-nav { display: flex; align-items: center; gap: 8px; }
        .btn-nav {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 10px;
            border: 1.5px solid #e9ecef; background: #fff;
            color: #374151; text-decoration: none; transition: all 0.15s; flex-shrink: 0;
        }
        .btn-nav:hover { background: #f1f3f5; border-color: #d1d5db; }
        .btn-nav svg { width: 15px; height: 15px; }
        .cal-titulo { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.4px; white-space: nowrap; }

        .cal-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .cal-selects { display: flex; align-items: center; gap: 8px; }
        .cal-selects select {
            appearance: none;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%239ca3af'/%3E%3C/svg%3E") no-repeat right 10px center;
            border: 1.5px solid #e9ecef; border-radius: 9px;
            padding: 7px 30px 7px 11px; font-size: 13px; font-weight: 500; color: #374151;
            font-family: 'Inter', sans-serif; cursor: pointer; transition: border-color 0.15s;
        }
        .cal-selects select:focus { outline: none; border-color: #93c5fd; }
        .btn-hoy {
            display: inline-flex; align-items: center; gap: 5px;
            background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; border-radius: 9px;
            padding: 7px 13px; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif; text-decoration: none; transition: all 0.15s; flex-shrink: 0;
        }
        .btn-hoy:hover { background: #dbeafe; border-color: #93c5fd; }
        .btn-hoy svg { width: 14px; height: 14px; }

        .btn-pdf-dia {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px; border-radius: 7px;
            border: 1.5px solid #fca5a5; background: #fef2f2;
            color: #dc2626; font-size: 12px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; flex-shrink: 0;
        }
        .btn-pdf-dia:hover { background: #fee2e2; border-color: #f87171; }
        .btn-pdf-dia svg { width: 11px; height: 11px; flex-shrink: 0; }

        .leyenda { display: flex; align-items: center; gap: 14px; }
        .leyenda-item { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: #6b7280; }
        .leyenda-dot { width: 10px; height: 10px; border-radius: 50%; }
        .leyenda-dot.ensayadas  { background: #16a34a; }
        .leyenda-dot.porEnsayar { background: #d97706; }

        /* ── Lista agenda ── */
        .agenda { display: flex; flex-direction: column; gap: 6px; }

        .agenda-day {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-left: 4px solid #e9ecef;
            border-radius: 14px;
            padding: 14px 18px;
            display: flex; align-items: center; gap: 16px;
            transition: box-shadow 0.12s;
        }
        .agenda-day:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.06); }

        .agenda-day.dia-hoy       { background: #eff6ff; border-color: #bfdbfe; border-left-color: #1d4ed8; }
        .agenda-day.dia-mixto     { border-left-color: #e11d48; }
        .agenda-day.dia-solo-ens  { border-left-color: #16a34a; }
        .agenda-day.dia-solo-pend { border-left-color: #d97706; }
        .agenda-day.dia-vacio     { background: #fafafa; border-color: #f1f3f5; border-left-color: #f1f3f5; padding: 10px 18px; }
        .agenda-day.dia-vacio.dia-hoy { background: #eff6ff; border-color: #bfdbfe; border-left-color: #1d4ed8; padding: 14px 18px; }

        .agenda-fecha {
            display: flex; flex-direction: column; align-items: center;
            gap: 3px; min-width: 44px; flex-shrink: 0;
        }
        .agenda-num {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700; color: #374151;
        }
        .dia-hoy .agenda-num { background: #1d4ed8; color: #fff; box-shadow: 0 2px 8px rgba(29,78,216,0.3); }
        .dia-vacio .agenda-num { font-size: 14px; color: #9ca3af; font-weight: 500; }
        .agenda-nombre {
            font-size: 10px; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .dia-hoy .agenda-nombre { color: #1d4ed8; }

        .agenda-sep { width: 1px; align-self: stretch; background: #e9ecef; flex-shrink: 0; }
        .dia-vacio:not(.dia-hoy) .agenda-sep { display: none; }

        .agenda-contenido { display: flex; flex-wrap: wrap; gap: 7px; flex: 1; align-items: center; }

        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 11px; border-radius: 99px;
            font-size: 12.5px; font-weight: 600;
        }
        .badge svg { width: 12px; height: 12px; flex-shrink: 0; }
        .badge-ens  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-pend { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }

        .agenda-vacio-txt { font-size: 12.5px; color: #d1d5db; font-style: italic; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .page { padding: 16px; gap: 16px; }
            .user-name { display: none; }
            .navbar-user { padding-right: 5px; }
            .btn-logout span { display: none; }
            .btn-logout { padding: 6px 9px; }
            .leyenda { display: none; }
            .cal-titulo { font-size: 17px; }
        }

        @media (max-width: 540px) {
            .navbar { padding: 0 14px; }
            .page { padding: 12px; gap: 12px; }
            .navbar-title { display: none; }
            .nav-sep { display: none; }
            .cal-selects { display: none; }
            .cal-titulo { font-size: 15px; }
            .btn-nav { width: 32px; height: 32px; }
            .btn-hoy span { display: none; }
            .btn-hoy { padding: 7px 9px; }
            .agenda-day { padding: 12px 14px; gap: 12px; border-radius: 12px; }
            .agenda-day.dia-vacio { padding: 8px 14px; }
            .agenda-num { width: 32px; height: 32px; font-size: 15px; }
            .badge { padding: 4px 9px; font-size: 12px; }
        }

        /* ── Día clickable ── */
        .agenda-day.dia-link { cursor: pointer; }
        .agenda-day.dia-link:hover {
            box-shadow: 0 4px 14px rgba(0,0,0,0.09);
            transform: translateY(-1px);
        }

        @media (max-width: 380px) {
            .navbar { padding: 0 10px; }
            .page { padding: 10px; gap: 10px; }
            .btn-back span { display: none; }
            .btn-back { padding: 6px 8px; }
            .agenda-day { padding: 10px 12px; gap: 10px; border-radius: 10px; }
            .agenda-day.dia-vacio { padding: 7px 12px; }
            .agenda-num { width: 28px; height: 28px; font-size: 13px; }
            .badge { padding: 3px 8px; font-size: 11.5px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('menu.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            <span>Menú</span>
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Ensayos de compresión</span>
    </div>
    <div class="navbar-right">
        <div class="navbar-user">
            <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
            <span class="user-name">{{ session('usuario.nick') }}</span>
        </div>
    </div>
</nav>

<main class="page">

    {{-- Cabecera --}}
    <div class="cal-header">
        <div class="cal-nav">
            <a href="{{ route('ensayos.index', ['mes' => $prevMes, 'anio' => $prevAnio]) }}" class="btn-nav" title="Mes anterior">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>
            <span class="cal-titulo">
                {{ \Carbon\Carbon::create($anio, $mes, 1)->translatedFormat('F Y') }}
            </span>
            <a href="{{ route('ensayos.index', ['mes' => $nextMes, 'anio' => $nextAnio]) }}" class="btn-nav" title="Mes siguiente">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </a>
        </div>

        <div class="cal-actions">
            <form method="GET" action="{{ route('ensayos.index') }}" class="cal-selects">
                <select name="mes" onchange="this.form.submit()">
                    @foreach(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $i => $nombre)
                        <option value="{{ $i + 1 }}" @selected($mes === $i + 1)>{{ $nombre }}</option>
                    @endforeach
                </select>
                <select name="anio" onchange="this.form.submit()">
                    @for($y = now()->year - 3; $y <= now()->year + 2; $y++)
                        <option value="{{ $y }}" @selected($anio === $y)>{{ $y }}</option>
                    @endfor
                </select>
            </form>

            <a href="{{ route('ensayos.index') }}" class="btn-hoy" title="Ir al mes actual">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                <span>Hoy</span>
            </a>


            <div class="leyenda">
                <div class="leyenda-item"><div class="leyenda-dot ensayadas"></div>Ensayadas</div>
                <div class="leyenda-item"><div class="leyenda-dot porEnsayar"></div>Por ensayar</div>
            </div>
        </div>
    </div>

    {{-- Lista --}}
    <div class="agenda">
        @php
            $nombresDia = ['', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        @endphp

        @foreach($celdas as $celda)
            @if(!$celda['esMes']) @continue @endif

            @php
                $datos    = $datosPorDia[$celda['fecha']] ?? null;
                $esHoy    = $celda['fecha'] === $hoy;
                $hayDatos = $datos && ($datos['ensayadas'] + $datos['porEnsayar']) > 0;
                $soloPend = $hayDatos && $datos['ensayadas']  === 0;
                $soloEns  = $hayDatos && $datos['porEnsayar'] === 0;
                $diaSem   = \Carbon\Carbon::parse($celda['fecha'])->dayOfWeekIso;

                $cls = 'agenda-day';
                if ($esHoy && !$hayDatos) $cls .= ' dia-hoy dia-vacio';
                elseif ($esHoy)           $cls .= ' dia-hoy';
                elseif (!$hayDatos)       $cls .= ' dia-vacio';
                elseif ($soloPend)        $cls .= ' dia-solo-pend';
                elseif ($soloEns)         $cls .= ' dia-solo-ens';
                else                      $cls .= ' dia-mixto';
            @endphp

            <div class="{{ $cls }}{{ $hayDatos ? ' dia-link' : '' }}"
                 @if($hayDatos) onclick="location.href='{{ route('ensayos.create', ['fecha' => $celda['fecha']]) }}'" @endif>

                <div class="agenda-fecha">
                    <div class="agenda-num">{{ $celda['dia'] }}</div>
                    <span class="agenda-nombre">{{ $nombresDia[$diaSem] }}</span>
                </div>

                <div class="agenda-sep"></div>

                <div class="agenda-contenido">
                    @if($hayDatos)
                        @if($datos['ensayadas'] > 0)
                            <span class="badge badge-ens">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                                {{ $datos['ensayadas'] }} Ensayada{{ $datos['ensayadas'] !== 1 ? 's' : '' }}
                            </span>
                        @endif
                        @if($datos['porEnsayar'] > 0)
                            <span class="badge badge-pend">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $datos['porEnsayar'] }} Pendiente{{ $datos['porEnsayar'] !== 1 ? 's' : '' }}
                            </span>
                        @endif
                        @if($datos['ensayadas'] > 0)
                            <a href="{{ route('ensayos.pdf-todas', ['fecha' => $celda['fecha']]) }}"
                               class="btn-pdf-dia"
                               onclick="event.stopPropagation()"
                               title="Descargar PDF de resultados">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                                PDF
                            </a>
                        @endif
                    @else
                        <span class="agenda-vacio-txt">Sin ensayos programados</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</main>

</body>
</html>
