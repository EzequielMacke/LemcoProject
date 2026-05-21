<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Probetas — LemcoProject</title>
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

        .navbar-right { display: flex; align-items: center; flex-shrink: 0; }
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

        /* ── Página ── */
        .page { padding: 24px; display: flex; flex-direction: column; gap: 20px; }

        /* ── Cabecera ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;
        }
        .page-title { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.4px; }
        .page-title span { color: #1d4ed8; }
        .page-stats { display: flex; align-items: center; gap: 10px; }
        .stat-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 99px; font-size: 12.5px; font-weight: 600;
        }
        .stat-badge svg { width: 12px; height: 12px; flex-shrink: 0; }
        .stat-pend { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .stat-ens  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

        /* ── Tabs ── */
        .tabs-bar {
            display: flex; align-items: center; gap: 4px;
            background: #f1f3f5; border: 1.5px solid #e9ecef;
            border-radius: 12px; padding: 4px; width: fit-content;
        }
        .tab-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 7px 16px; border-radius: 9px; border: none;
            font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif;
            color: #6b7280; background: transparent; cursor: pointer; transition: all 0.15s;
            white-space: nowrap;
        }
        .tab-btn .tab-count {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 20px; height: 20px; padding: 0 5px; border-radius: 99px;
            font-size: 11px; font-weight: 700; background: #e5e7eb; color: #6b7280;
            transition: all 0.15s;
        }
        .tab-btn.active { background: #fff; color: #111827; box-shadow: 0 1px 4px rgba(0,0,0,0.08); }
        .tab-btn.active.tab-pend .tab-count { background: #fde68a; color: #b45309; }
        .tab-btn.active.tab-ens  .tab-count { background: #bbf7d0; color: #15803d; }

        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* ── Empty state ── */
        .empty-state {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 14px;
            padding: 48px 24px; text-align: center; color: #9ca3af;
            font-size: 14px; font-style: italic;
        }

        /* ── Tabla ── */
        .table-wrap {
            overflow-x: auto; border-radius: 14px;
            border: 1.5px solid #e9ecef; background: #fff;
        }
        table { width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap; }
        thead tr { background: #f8fafc; border-bottom: 2px solid #e9ecef; }
        th {
            padding: 10px 14px; text-align: left;
            font-size: 11.5px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        th.th-center { text-align: center; }
        tbody tr { border-bottom: 1px solid #f1f3f5; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fafbff; }
        td { padding: 9px 14px; vertical-align: middle; color: #374151; }
        td.cell-obra   { font-weight: 600; color: #111827; max-width: 180px; overflow: hidden; text-overflow: ellipsis; }
        td.cell-nombre { font-weight: 500; }
        td.cell-center { text-align: center; }

        /* ── Inputs ── */
        .f-text {
            width: 120px; padding: 5px 9px;
            border: 1.5px solid #e9ecef; border-radius: 7px;
            font-size: 12.5px; font-family: 'Inter', sans-serif;
            color: #374151; background: #fff;
            transition: border-color 0.15s, background 0.15s;
        }
        .f-num {
            width: 76px; padding: 5px 9px;
            border: 1.5px solid #e9ecef; border-radius: 7px;
            font-size: 12.5px; font-family: 'Inter', sans-serif;
            color: #374151; background: #fff; text-align: right;
            transition: border-color 0.15s, background 0.15s;
        }
        .f-select {
            width: 68px; padding: 5px 6px;
            border: 1.5px solid #e9ecef; border-radius: 7px;
            font-size: 12.5px; font-family: 'Inter', sans-serif;
            color: #374151; background: #fff; cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
        }
        .f-text:focus, .f-num:focus, .f-select:focus { outline: none; border-color: #93c5fd; }
        .f-text::placeholder, .f-num::placeholder { color: #d1d5db; }
        .f-text:disabled, .f-num:disabled, .f-select:disabled {
            background: #f9fafb; color: #9ca3af; cursor: not-allowed;
        }
        .f-error { border-color: #f87171 !important; background: #fff5f5 !important; }

        /* ── Estado guardando / guardado ── */
        .f-saving { border-color: #93c5fd !important; opacity: 0.6; }

        @keyframes flashSaved {
            0%   { border-color: #34d399; background: #ecfdf5; }
            100% { border-color: #e9ecef; background: #fff; }
        }
        .f-saved { animation: flashSaved 0.9s ease forwards; }

        /* ── Flash al copiar ── */
        @keyframes flashCopy {
            0%   { border-color: #93c5fd; background: #eff6ff; }
            100% { border-color: #e9ecef; background: #fff; }
        }
        .f-copied { animation: flashCopy 0.55s ease forwards; }

        /* ── Botón copiar ── */
        .cell-group { display: inline-flex; align-items: center; gap: 4px; }
        .btn-copy {
            display: flex; align-items: center; justify-content: center;
            width: 22px; height: 22px; flex-shrink: 0; padding: 0;
            border: 1.5px solid #e9ecef; border-radius: 5px;
            background: #fff; color: #9ca3af;
            cursor: pointer; transition: all 0.15s;
        }
        .btn-copy:hover { border-color: #bfdbfe; background: #eff6ff; color: #1d4ed8; }
        .btn-copy svg { width: 11px; height: 11px; pointer-events: none; }
        .btn-copy--ok { border-color: #bbf7d0 !important; background: #f0fdf4 !important; color: #15803d !important; }

        /* ── Toast error ── */
        .toast-error {
            position: fixed; bottom: 24px; right: 24px; z-index: 100;
            background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 10px;
            padding: 12px 18px; font-size: 13px; font-weight: 500; color: #dc2626;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); display: none;
        }
        .toast-error.show { display: flex; align-items: center; gap: 8px; animation: slideUp 0.2s ease; }
        @keyframes slideUp { from { transform: translateY(12px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        /* ── Fila bloqueada (ya en informe) ── */
        tr.row-locked td { background: #f8fafc !important; }
        tr.row-locked .f-text,
        tr.row-locked .f-num,
        tr.row-locked .f-select {
            background: #f1f3f5 !important; color: #9ca3af !important;
            cursor: not-allowed !important; border-color: #e9ecef !important;
        }
        tr.row-locked .btn-copy { display: none; }
        .badge-informe {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 99px;
            background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe;
            white-space: nowrap;
        }
        .badge-informe svg { width: 11px; height: 11px; flex-shrink: 0; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .page { padding: 16px; gap: 16px; }
            .navbar { padding: 0 16px; }
            .user-name { display: none; }
            .navbar-user { padding-right: 5px; }
            .page-title { font-size: 17px; }
        }
        @media (max-width: 540px) {
            .navbar { padding: 0 14px; }
            .page { padding: 12px; gap: 12px; }
            .navbar-title { display: none; }
            .nav-sep { display: none; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('ensayos.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            <span>Agenda</span>
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
    <div class="page-header">
        <h1 class="page-title">
            Probetas del <span>{{ \Carbon\Carbon::parse($fecha)->translatedFormat('j \d\e F Y') }}</span>
        </h1>
        <div class="page-stats">
            <span class="stat-badge stat-pend">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $pendientes->count() }} pendiente{{ $pendientes->count() !== 1 ? 's' : '' }}
            </span>
            <span class="stat-badge stat-ens">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                {{ $ensayadas->count() }} ensayada{{ $ensayadas->count() !== 1 ? 's' : '' }}
            </span>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tabs-bar">
        <button class="tab-btn tab-pend active" onclick="switchTab('pendientes', this)">
            Por ensayar
            <span class="tab-count">{{ $pendientes->count() }}</span>
        </button>
        <button class="tab-btn tab-ens" onclick="switchTab('ensayadas', this)">
            Ensayadas
            <span class="tab-count">{{ $ensayadas->count() }}</span>
        </button>
    </div>

    @php
        $copyIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>';
    @endphp

    {{-- Tab: Por ensayar --}}
    <div id="tab-pendientes" class="tab-content active">
        @if($pendientes->isEmpty())
            <div class="empty-state">No hay probetas pendientes para este día.</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Obra</th>
                            <th>Muestra</th>
                            <th>Defecto</th>
                            <th class="th-center">Carga Rotura</th>
                            <th class="th-center">Tipo Rotura</th>
                            <th class="th-center">Diám Sup 1</th>
                            <th class="th-center">Diám Sup 2</th>
                            <th class="th-center">Diám Inf 1</th>
                            <th class="th-center">Diám Inf 2</th>
                            <th class="th-center">Alt 1</th>
                            <th class="th-center">Alt 2</th>
                            <th class="th-center">Alt 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendientes as $probeta)
                        @php $locked = $probeta->detalles->isNotEmpty(); @endphp
                        <tr data-id="{{ $probeta->id }}" @class(['row-locked' => $locked])>
                            <td class="cell-obra">{{ $probeta->remision->obra->nombre ?? '—' }}</td>
                            <td class="cell-nombre">
                                {{ $probeta->nombre }}
                                @if($locked)
                                    <span class="badge-informe">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                        En informe
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="cell-group">
                                    <input type="text" class="f-text" data-field="defecto" placeholder="Sin defecto" value="{{ $probeta->defecto ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="carga_rotura" placeholder="kN" value="{{ $probeta->carga_rotura ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <select class="f-select" data-field="tipo_rotura" {{ $locked ? 'disabled' : '' }}>
                                        <option value="">—</option>
                                        @for($t = 1; $t <= 6; $t++)
                                            <option value="{{ $t }}" @selected($probeta->tipo_rotura == $t)>{{ $t }}</option>
                                        @endfor
                                    </select>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="diametro_superior_1" placeholder="mm" value="{{ $probeta->diametro_superior_1 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="diametro_superior_2" placeholder="mm" value="{{ $probeta->diametro_superior_2 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="diametro_inferior_1" placeholder="mm" value="{{ $probeta->diametro_inferior_1 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="diametro_inferior_2" placeholder="mm" value="{{ $probeta->diametro_inferior_2 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="altura_1" placeholder="mm" value="{{ $probeta->altura_1 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="altura_2" placeholder="mm" value="{{ $probeta->altura_2 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="altura_3" placeholder="mm" value="{{ $probeta->altura_3 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Tab: Ensayadas --}}
    <div id="tab-ensayadas" class="tab-content">
        @if($ensayadas->isEmpty())
            <div class="empty-state">No hay probetas ensayadas para este día.</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Obra</th>
                            <th>Muestra</th>
                            <th>Defecto</th>
                            <th class="th-center">Carga Rotura</th>
                            <th class="th-center">Tipo Rotura</th>
                            <th class="th-center">Diám Sup 1</th>
                            <th class="th-center">Diám Sup 2</th>
                            <th class="th-center">Diám Inf 1</th>
                            <th class="th-center">Diám Inf 2</th>
                            <th class="th-center">Alt 1</th>
                            <th class="th-center">Alt 2</th>
                            <th class="th-center">Alt 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ensayadas as $probeta)
                        @php $locked = $probeta->detalles->isNotEmpty(); @endphp
                        <tr data-id="{{ $probeta->id }}" @class(['row-locked' => $locked])>
                            <td class="cell-obra">{{ $probeta->remision->obra->nombre ?? '—' }}</td>
                            <td class="cell-nombre">
                                {{ $probeta->nombre }}
                                @if($locked)
                                    <span class="badge-informe">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                        En informe
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="cell-group">
                                    <input type="text" class="f-text" data-field="defecto" placeholder="Sin defecto" value="{{ $probeta->defecto ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="carga_rotura" placeholder="kN" value="{{ $probeta->carga_rotura ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <select class="f-select" data-field="tipo_rotura" {{ $locked ? 'disabled' : '' }}>
                                        <option value="">—</option>
                                        @for($t = 1; $t <= 6; $t++)
                                            <option value="{{ $t }}" @selected($probeta->tipo_rotura == $t)>{{ $t }}</option>
                                        @endfor
                                    </select>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="diametro_superior_1" placeholder="mm" value="{{ $probeta->diametro_superior_1 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="diametro_superior_2" placeholder="mm" value="{{ $probeta->diametro_superior_2 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="diametro_inferior_1" placeholder="mm" value="{{ $probeta->diametro_inferior_1 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="diametro_inferior_2" placeholder="mm" value="{{ $probeta->diametro_inferior_2 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="altura_1" placeholder="mm" value="{{ $probeta->altura_1 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="altura_2" placeholder="mm" value="{{ $probeta->altura_2 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                            <td class="cell-center">
                                <div class="cell-group">
                                    <input type="number" step="0.01" min="0" class="f-num" data-field="altura_3" placeholder="mm" value="{{ $probeta->altura_3 ?? '' }}" {{ $locked ? 'disabled' : '' }}>
                                    <button type="button" class="btn-copy" title="Copiar a todas las filas">{!! $copyIcon !!}</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</main>

{{-- Toast error --}}
<div class="toast-error" id="toast-error">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
    </svg>
    <span id="toast-msg"></span>
</div>

<script>
const CSRF     = document.querySelector('meta[name="csrf-token"]').content;
const timers   = new Map();
const DEBOUNCE = 500;

function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}

function showToast(msg) {
    const t = document.getElementById('toast-error');
    document.getElementById('toast-msg').textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 4000);
}

/* ── Copiar columna ── */
document.addEventListener('click', function(e) {
    const copyBtn = e.target.closest('.btn-copy');
    if (!copyBtn) return;

    const source = copyBtn.closest('.cell-group').querySelector('[data-field]');
    if (!source || source.disabled) return;

    const field  = source.dataset.field;
    const value  = source.value;
    const tbody  = copyBtn.closest('tbody');
    let   copied = 0;

    tbody.querySelectorAll(`[data-field="${field}"]`).forEach(el => {
        if (el === source || el.disabled) return;
        el.value = value;
        el.classList.remove('f-error', 'f-copied');
        void el.offsetWidth;
        el.classList.add('f-copied');
        const r = el.closest('tr[data-id]');
        if (r) scheduleGuardar(r, el);
        copied++;
    });

    if (copied > 0) {
        copyBtn.classList.add('btn-copy--ok');
        setTimeout(() => copyBtn.classList.remove('btn-copy--ok'), 700);
    }
});

/* ── Auto-guardar al cambiar un campo ── */
document.addEventListener('change', function(e) {
    const input = e.target.closest('[data-field]');
    if (!input || input.disabled) return;
    const row = input.closest('tr[data-id]');
    if (row) scheduleGuardar(row, input);
});

function scheduleGuardar(row, changedEl) {
    clearTimeout(timers.get(row.dataset.id));
    timers.set(row.dataset.id, setTimeout(() => guardarFila(row, changedEl), DEBOUNCE));
}

async function guardarFila(row, changedEl) {
    const id     = row.dataset.id;
    const inputs = row.querySelectorAll('[data-field]');

    const data = {};
    inputs.forEach(el => {
        const field = el.dataset.field;
        const val   = el.value.trim();
        el.classList.remove('f-error');
        data[field] = val === '' ? null : (el.type === 'number' ? parseFloat(val) : val);
    });

    changedEl?.classList.add('f-saving');

    try {
        const res = await fetch(`/ensayos/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': CSRF,
            },
            body: JSON.stringify(data),
        });

        changedEl?.classList.remove('f-saving');

        if (!res.ok) {
            const payload = await res.json().catch(() => ({}));
            if (payload.errors) {
                Object.keys(payload.errors).forEach(f => {
                    row.querySelector(`[data-field="${f}"]`)?.classList.add('f-error');
                });
                showToast('Error al guardar. Revisá los campos marcados.');
            } else {
                showToast('Error al guardar. Intentá de nuevo.');
            }
            return;
        }

        if (changedEl) {
            changedEl.classList.remove('f-copied');
            changedEl.classList.add('f-saved');
            setTimeout(() => changedEl.classList.remove('f-saved'), 900);
        }

    } catch {
        changedEl?.classList.remove('f-saving');
        showToast('Error de conexión.');
    }
}
</script>

</body>
</html>
