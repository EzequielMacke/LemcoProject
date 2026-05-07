<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remisión {{ $remision->nro }} — {{ $obra->nombre }}</title>
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
            max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
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
        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 20px; max-width: 1100px; width: 100%; margin: 0 auto; }

        /* ── Header ── */
        .page-header {
            display: flex; align-items: center; gap: 14px;
            animation: fadeUp 0.35s ease both;
        }
        .page-label { font-size: 11.5px; font-weight: 600; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }
        .badge-estado {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 99px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .badge-activa  { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-anulada { background: #f1f3f5; color: #9ca3af; border: 1.5px solid #e5e7eb; }

        /* ── Panel ── */
        .panel {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 16px;
            overflow: hidden;
            animation: fadeUp 0.35s ease 0.05s both;
        }
        .panel-header {
            padding: 14px 20px; border-bottom: 1px solid #f1f3f5;
            display: flex; align-items: center; gap: 10px;
        }
        .panel-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: #eef2ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .panel-icon svg { width: 15px; height: 15px; color: #4f46e5; }
        .panel-title { font-size: 13.5px; font-weight: 700; color: #0f172a; }

        /* ── Data grid ── */
        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 0;
        }
        .data-item {
            padding: 16px 20px;
            border-right: 1px solid #f1f3f5;
            border-bottom: 1px solid #f1f3f5;
        }
        .data-item:last-child { border-right: none; }
        .data-item.full { grid-column: 1 / -1; border-right: none; }
        .data-label {
            font-size: 10.5px; font-weight: 600; color: #9ca3af;
            text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 5px;
        }
        .data-value {
            font-size: 13.5px; font-weight: 500; color: #111827;
            line-height: 1.4;
        }
        .data-value.muted { color: #9ca3af; font-style: italic; }

        /* ── Tabla probetas ── */
        .panel-table { animation: fadeUp 0.35s ease 0.1s both; }

        .table-wrap { overflow-x: auto; }
        table {
            width: 100%; border-collapse: collapse;
            font-size: 13px;
        }
        thead th {
            padding: 11px 16px;
            font-size: 10.5px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.7px;
            text-align: left;
            background: #f8fafc; border-bottom: 1.5px solid #e9ecef;
            white-space: nowrap;
        }
        tbody td {
            padding: 12px 16px;
            color: #374151; border-bottom: 1px solid #f1f3f5;
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafbff; }

        .td-nombre {
            font-weight: 600; color: #0f172a;
            font-family: 'Inter', monospace; letter-spacing: 0.3px;
        }
        .td-fck {
            display: inline-flex; align-items: center;
            background: #eef2ff; color: #4338ca;
            font-size: 12px; font-weight: 700;
            padding: 3px 9px; border-radius: 99px;
        }
        .td-edad {
            display: inline-flex; align-items: center;
            background: #fef9c3; color: #854d0e;
            font-size: 12px; font-weight: 600;
            padding: 3px 9px; border-radius: 99px;
        }

        /* ── Empty table ── */
        .empty-table {
            padding: 40px 20px; text-align: center; color: #9ca3af;
        }
        .empty-table svg { width: 32px; height: 32px; margin: 0 auto 10px; display: block; color: #d1d5db; }
        .empty-table p { font-size: 13px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .page { padding: 20px 16px 36px; }
            .data-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 400px) {
            .data-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('remisiones.index', $obra) }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Remisiones
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

    @php
        $recibio = $remision->recibidoPor;
        $nombreRecibio = ($recibio && $recibio->persona && ($recibio->persona->nombre || $recibio->persona->apellido))
            ? trim($recibio->persona->nombre . ' ' . $recibio->persona->apellido)
            : ($recibio->nick ?? '—');
        $esAnulada = $remision->estado === 2;
    @endphp

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">Recepción de probetas</div>
            <div class="page-heading">Remisión {{ $remision->nro }}</div>
        </div>
        @if($esAnulada)
            <span class="badge-estado badge-anulada">Anulada</span>
        @else
            <span class="badge-estado badge-activa">Activa</span>
        @endif
    </div>

    {{-- Datos generales --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <span class="panel-title">Datos de la remisión</span>
        </div>
        <div class="data-grid">
            <div class="data-item">
                <div class="data-label">Nro. de recepción</div>
                <div class="data-value">{{ $remision->nro }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Obra</div>
                <div class="data-value">{{ $obra->nombre }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Contratista</div>
                <div class="data-value">{{ $remision->contratista }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Fecha</div>
                <div class="data-value">{{ $remision->created_at->format('d/m/Y') }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Entregado por</div>
                <div class="data-value">{{ $remision->entregado_por }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Recibido por</div>
                <div class="data-value">{{ $nombreRecibio }}</div>
            </div>
            <div class="data-item full">
                <div class="data-label">Observación</div>
                @if($remision->observacion)
                    <div class="data-value">{{ $remision->observacion }}</div>
                @else
                    <div class="data-value muted">Sin observaciones</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabla de probetas --}}
    <div class="panel panel-table">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/>
                </svg>
            </div>
            <span class="panel-title">Probetas &mdash; {{ $remision->probetas->count() }} en total</span>
        </div>
        <div class="table-wrap">
            @if($remision->probetas->isEmpty())
                <div class="empty-table">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/>
                    </svg>
                    <p>No hay probetas registradas en esta remisión</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Concretera</th>
                            <th>fck (MPa)</th>
                            <th>Fecha moldeo</th>
                            <th>Hora</th>
                            <th>Mixer</th>
                            <th>Edad ensayo (días)</th>
                            <th>Elemento</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($remision->probetas as $probeta)
                        <tr>
                            <td>{{ $probeta->concretera }}</td>
                            <td><span class="td-fck">{{ $probeta->fck }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($probeta->fecha_moldeo)->format('d/m/Y') }}</td>
                            <td>{{ substr($probeta->hora_moldeo, 0, 5) }}</td>
                            <td>{{ $probeta->mixer }}</td>
                            <td><span class="td-edad">{{ $probeta->edad_ensayo }}d</span></td>
                            <td>{{ $probeta->elemento }}</td>
                            <td class="td-nombre">{{ $probeta->nombre }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</main>

</body>
</html>
