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
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #111827;
        }
        body { display: flex; flex-direction: column; }

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
            font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .btn-logout {
            display: flex; align-items: center; gap: 5px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 8px;
            padding: 6px 11px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-logout:hover { background: #fff0f0; border-color: #fca5a5; color: #dc2626; }
        .btn-logout svg { width: 13px; height: 13px; }

        /* ── Página ── */
        .page {
            flex: 1;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-height: 0;
        }

        /* ── Cabecera del calendario ── */
        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .cal-nav {
            display: flex; align-items: center; gap: 8px;
        }
        .btn-nav {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 10px;
            border: 1.5px solid #e9ecef; background: #fff;
            color: #374151; text-decoration: none;
            transition: all 0.15s; flex-shrink: 0;
        }
        .btn-nav:hover { background: #f1f3f5; border-color: #d1d5db; }
        .btn-nav svg { width: 15px; height: 15px; }

        .cal-titulo {
            font-size: 20px; font-weight: 700; color: #0f172a;
            letter-spacing: -0.4px; white-space: nowrap;
        }

        .cal-selects {
            display: flex; align-items: center; gap: 8px;
        }
        .cal-selects select {
            appearance: none;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%239ca3af'/%3E%3C/svg%3E") no-repeat right 10px center;
            border: 1.5px solid #e9ecef; border-radius: 9px;
            padding: 7px 32px 7px 12px;
            font-size: 13px; font-weight: 500; color: #374151;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: border-color 0.15s;
        }
        .cal-selects select:focus { outline: none; border-color: #93c5fd; }
        .btn-hoy {
            display: inline-flex; align-items: center; gap: 5px;
            background: #eff6ff; color: #1d4ed8;
            border: 1.5px solid #bfdbfe; border-radius: 9px;
            padding: 7px 13px; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif; cursor: pointer;
            text-decoration: none; transition: all 0.15s;
        }
        .btn-hoy:hover { background: #dbeafe; border-color: #93c5fd; }

        /* ── Leyenda ── */
        .leyenda {
            display: flex; align-items: center; gap: 16px;
        }
        .leyenda-item {
            display: flex; align-items: center; gap: 6px;
            font-size: 12.5px; color: #6b7280;
        }
        .leyenda-dot {
            width: 10px; height: 10px; border-radius: 50%;
        }
        .leyenda-dot.ensayadas  { background: #16a34a; }
        .leyenda-dot.porEnsayar { background: #d97706; }

        /* ── Calendario ── */
        .calendar-wrap {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            overflow: hidden;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .cal-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-bottom: 1.5px solid #f1f3f5;
        }
        .cal-weekday {
            padding: 12px 8px;
            text-align: center;
            font-size: 11.5px; font-weight: 700;
            color: #9ca3af; text-transform: uppercase; letter-spacing: 0.6px;
        }
        .cal-weekday.weekend { color: #d1d5db; }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            flex: 1;
        }

        .cal-cell {
            border-right: 1px solid #f1f3f5;
            border-bottom: 1px solid #f1f3f5;
            padding: 12px;
            min-height: 130px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
            transition: background 0.12s;
        }
        .cal-cell:nth-child(7n) { border-right: none; }
        .cal-cell.fuera-mes {
            background: #fafafa;
        }
        .cal-cell.hoy {
            background: #eff6ff;
        }
        .cal-cell.tiene-datos:not(.fuera-mes):not(.hoy) {
            background: #fefefe;
        }

        .cell-num-wrap {
            display: flex; align-items: center; justify-content: space-between;
        }
        .cell-num {
            width: 30px; height: 30px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            font-size: 14px; font-weight: 600; color: #374151;
            flex-shrink: 0;
        }
        .fuera-mes .cell-num { color: #d1d5db; font-weight: 500; }
        .hoy .cell-num {
            background: #1d4ed8; color: #fff;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(29,78,216,0.35);
        }

        .cell-badges {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex: 1;
            justify-content: flex-end;
        }
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 9px; border-radius: 99px;
            font-size: 12px; font-weight: 600;
            width: fit-content;
        }
        .badge svg { width: 11px; height: 11px; flex-shrink: 0; }
        .badge-ens {
            background: #f0fdf4; color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .badge-pend {
            background: #fffbeb; color: #b45309;
            border: 1px solid #fde68a;
        }

        /* Indicador superior para días con datos */
        .cell-indicator {
            position: absolute; top: 0; left: 12px; right: 12px;
            height: 2.5px; border-radius: 0 0 3px 3px;
        }
        .tiene-datos:not(.fuera-mes) .cell-indicator { background: #e11d48; }
        .solo-ensayadas:not(.fuera-mes) .cell-indicator { background: #16a34a; }
        .solo-pendientes:not(.fuera-mes) .cell-indicator { background: #d97706; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .page { padding: 16px; gap: 16px; }
            .cal-titulo { font-size: 16px; }
            .cal-selects { display: none; }
            .cal-cell { min-height: 80px; padding: 8px; }
            .cell-num { width: 26px; height: 26px; font-size: 13px; }
            .badge { padding: 3px 6px; font-size: 11px; }
            .leyenda { display: none; }
        }
        @media (max-width: 500px) {
            .cal-cell { min-height: 60px; padding: 6px; gap: 4px; }
            .badge svg { display: none; }
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
            Menú
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Ensayos de compresión</span>
    </div>
    <div class="navbar-right">
        <div class="navbar-user">
            <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
            <span>{{ session('usuario.nick') }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</nav>

<main class="page">

    {{-- Cabecera del calendario --}}
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

        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            {{-- Selectores mes/año --}}
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

            {{-- Botón hoy --}}
            <a href="{{ route('ensayos.index') }}" class="btn-hoy">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                Hoy
            </a>

            {{-- Leyenda --}}
            <div class="leyenda">
                <div class="leyenda-item">
                    <div class="leyenda-dot ensayadas"></div>
                    Ensayadas
                </div>
                <div class="leyenda-item">
                    <div class="leyenda-dot porEnsayar"></div>
                    Por ensayar
                </div>
            </div>
        </div>
    </div>

    {{-- Grilla del calendario --}}
    <div class="calendar-wrap">
        <div class="cal-weekdays">
            @foreach(['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'] as $i => $dia)
                <div class="cal-weekday {{ $i >= 5 ? 'weekend' : '' }}">{{ $dia }}</div>
            @endforeach
        </div>

        <div class="cal-grid">
            @foreach($celdas as $celda)
                @php
                    $datos      = $datosPorDia[$celda['fecha']] ?? null;
                    $esHoy      = $celda['fecha'] === $hoy;
                    $tieneDatos = $datos !== null && ($datos['ensayadas'] + $datos['porEnsayar']) > 0;

                    $clases = 'cal-cell';
                    if (!$celda['esMes'])   $clases .= ' fuera-mes';
                    if ($esHoy)             $clases .= ' hoy';
                    if ($tieneDatos)        $clases .= ' tiene-datos';

                    $soloPend = $tieneDatos && $datos['ensayadas'] === 0;
                    $soloEns  = $tieneDatos && $datos['porEnsayar'] === 0;
                    if ($soloPend) $clases .= ' solo-pendientes';
                    if ($soloEns)  $clases .= ' solo-ensayadas';
                @endphp
                <div class="{{ $clases }}">
                    <div class="cell-indicator"></div>
                    <div class="cell-num-wrap">
                        <div class="cell-num">{{ $celda['dia'] }}</div>
                    </div>
                    @if($tieneDatos)
                        <div class="cell-badges">
                            @if($datos['ensayadas'] > 0)
                                <span class="badge badge-ens">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                    {{ $datos['ensayadas'] }} ensayada{{ $datos['ensayadas'] !== 1 ? 's' : '' }}
                                </span>
                            @endif
                            @if($datos['porEnsayar'] > 0)
                                <span class="badge badge-pend">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $datos['porEnsayar'] }} pendiente{{ $datos['porEnsayar'] !== 1 ? 's' : '' }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</main>

</body>
</html>
