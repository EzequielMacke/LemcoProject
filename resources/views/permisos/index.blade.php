<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permisos — LemcoProject</title>
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

        .nav-sep    { width: 1px; height: 18px; background: #e9ecef; }
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
        .page-label   { font-size: 11.5px; font-weight: 600; color: #b45309; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }
        .page-sub     { font-size: 13px; color: #6b7280; margin-top: 2px; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-error { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Table card ── */
        .table-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease 0.06s both;
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
        .td-desc    { font-weight: 500; color: #111827; }
        .td-actions { text-align: right; }

        /* ── Estado badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 600; padding: 4px 10px;
            border-radius: 99px;
        }
        .badge svg      { width: 7px; height: 7px; }
        .badge-activa   { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-anulada  { background: #f8fafc; color: #9ca3af; border: 1.5px solid #e9ecef; }

        /* ── Btn editar permisos ── */
        .btn-permisos {
            display: inline-flex; align-items: center; gap: 6px;
            background: #fffbeb; border: 1.5px solid #fde68a;
            color: #b45309; border-radius: 8px;
            padding: 6px 12px; font-size: 12px; font-weight: 600;
            text-decoration: none; font-family: 'Inter', sans-serif;
            transition: all 0.15s; white-space: nowrap;
        }
        .btn-permisos:hover { background: #fef3c7; border-color: #fcd34d; color: #92400e; }
        .btn-permisos svg { width: 13px; height: 13px; flex-shrink: 0; }

        /* ── Empty state ── */
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
            .td-id, .th-id { display: none; }
            .page-sub { display: none; }
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
        <span class="navbar-title">Permisos</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    @php
        $permsper    = session('permisos', [])['per'] ?? [];
        $puedeEditar = $permsper['editar'] ?? false;
    @endphp

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">Módulo</div>
            <div class="page-heading">Permisos</div>
            <div class="page-sub">Seleccioná un área para gestionar sus permisos</div>
        </div>
    </div>

    {{-- Alerta flash --}}
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
        @if($areas->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
            </svg>
            <p>No hay áreas registradas</p>
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th class="th-id">#</th>
                    <th>Área</th>
                    <th>Estado</th>
                    @if($puedeEditar)
                    <th class="th-actions">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($areas as $area)
                <tr>
                    <td class="td-id">{{ $area->id }}</td>
                    <td class="td-desc">{{ $area->descripcion }}</td>
                    <td>
                        @if($area->estado === 1)
                            <span class="badge badge-activa">
                                <svg viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                                Activa
                            </span>
                        @else
                            <span class="badge badge-anulada">
                                <svg viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                                Anulada
                            </span>
                        @endif
                    </td>
                    @if($puedeEditar)
                    <td class="td-actions">
                        <a href="{{ route('permisos.edit', $area) }}" class="btn-permisos">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                            </svg>
                            Editar permisos
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</main>

</body>
</html>
