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
        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 20px; }

        /* ── Header ── */
        .page-header {
            display: flex; align-items: center; gap: 14px;
            justify-content: flex-start;
            animation: fadeUp 0.35s ease both;
        }
        .header-actions { margin-left: auto; display: flex; gap: 8px; align-items: center; flex-shrink: 0; }

        .page-label { font-size: 11.5px; font-weight: 600; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }
        .badge-estado {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 99px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .badge-activa  { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-anulada { background: #f1f3f5; color: #9ca3af; border: 1.5px solid #e5e7eb; }

        .btn-pdf {
            display: inline-flex; align-items: center; gap: 7px;
            background: #4f46e5; color: #fff;
            border: none; border-radius: 10px;
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif; text-decoration: none;
            box-shadow: 0 3px 10px rgba(79,70,229,0.25);
            transition: opacity 0.15s, transform 0.15s;
            cursor: pointer; flex-shrink: 0;
        }
        .btn-pdf:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn-pdf svg { width: 15px; height: 15px; }

        .btn-email {
            display: inline-flex; align-items: center; gap: 7px;
            background: #fff; color: #374151;
            border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif; text-decoration: none;
            transition: all 0.15s; cursor: pointer; flex-shrink: 0;
        }
        .btn-email:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-email svg { width: 15px; height: 15px; }

        /* ── Modal enviar ── */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.35);
            display: none; align-items: center; justify-content: center;
            z-index: 100; padding: 20px;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: #fff; border-radius: 18px;
            width: 100%; max-width: 480px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            animation: modalIn 0.2s ease both;
            display: flex; flex-direction: column;
            max-height: 90vh;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-head {
            padding: 18px 20px 14px; border-bottom: 1px solid #f1f3f5;
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .modal-title { font-size: 15px; font-weight: 700; color: #0f172a; }
        .modal-close {
            display: flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 8px;
            border: 1.5px solid #e9ecef; background: none;
            cursor: pointer; color: #9ca3af; transition: all 0.15s; padding: 0;
        }
        .modal-close:hover { background: #f1f3f5; color: #374151; }
        .modal-close svg { width: 14px; height: 14px; }
        .modal-body { padding: 16px 20px; overflow-y: auto; flex: 1; }
        .modal-foot {
            padding: 14px 20px; border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
            flex-shrink: 0;
        }

        /* Grupos de destinatarios */
        .group-label {
            font-size: 10.5px; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: 0.8px;
            margin-bottom: 8px; margin-top: 4px;
        }
        .group-label:not(:first-child) { margin-top: 18px; }
        .recipient-row {
            display: flex; align-items: center; gap: 12px;
            padding: 9px 12px; border-radius: 10px;
            border: 1.5px solid #e9ecef; margin-bottom: 6px;
            cursor: pointer; transition: background 0.12s, border-color 0.12s;
            background: #fff;
        }
        .recipient-row:hover { background: #f8faff; border-color: #c7d2fe; }
        .recipient-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: #4f46e5; flex-shrink: 0; cursor: pointer; }
        .recipient-info { flex: 1; min-width: 0; }
        .recipient-name { display: block; font-size: 13px; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .recipient-email { display: block; font-size: 11.5px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .recipient-no-email { font-size: 11.5px; color: #fca5a5; font-style: italic; }
        .empty-group { font-size: 12.5px; color: #9ca3af; padding: 8px 0; font-style: italic; }

        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 8px 16px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; }
        .btn-send {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, #4338ca, #4f46e5);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 9px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(79,70,229,0.3);
            transition: opacity 0.15s;
        }
        .btn-send:hover { opacity: 0.9; }
        .btn-send svg { width: 14px; height: 14px; }

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

    {{-- Alertas --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;color:#15803d;border-radius:10px;padding:12px 16px;font-size:13px;display:flex;align-items:center;gap:10px;">
        <svg style="width:16px;height:16px;flex-shrink:0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#fff1f2;border:1.5px solid #fecdd3;color:#be123c;border-radius:10px;padding:12px 16px;font-size:13px;display:flex;align-items:center;gap:10px;">
        <svg style="width:16px;height:16px;flex-shrink:0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        {{ session('error') }}
    </div>
    @endif

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
        <div class="header-actions">
            <button type="button" class="btn-email" onclick="abrirModal('modal-enviar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
                Enviar por correo
            </button>
            <a href="{{ route('remisiones.pdf', [$obra, $remision]) }}" class="btn-pdf">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Descargar PDF
            </a>
        </div>
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
                            <th>Muestra</th>
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

{{-- ═══ MODAL: Enviar por correo ═══ --}}
<div class="modal-overlay" id="modal-enviar" onclick="cerrarEnOverlay(event,'modal-enviar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Enviar remisión por correo</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-enviar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('remisiones.enviar', [$obra, $remision]) }}">
            @csrf
            <div class="modal-body">

                {{-- Grupo: Usuarios del sistema --}}
                <div class="group-label">Usuarios del sistema</div>
                @forelse($usuarios as $usuario)
                @php
                    $uNombre = trim(($usuario->persona->nombre ?? '') . ' ' . ($usuario->persona->apellido ?? ''));
                    $uCorreo = $usuario->persona->correo ?? null;
                @endphp
                <label class="recipient-row" style="{{ $uCorreo ? '' : 'opacity:0.55;' }}">
                    <input type="checkbox" name="usuarios[]" value="{{ $usuario->id }}"
                        {{ $uCorreo ? 'checked' : 'disabled' }}>
                    <div class="recipient-info">
                        <span class="recipient-name">{{ $uNombre ?: $usuario->nick }}</span>
                        @if($uCorreo)
                            <span class="recipient-email">{{ $uCorreo }}</span>
                        @else
                            <span class="recipient-no-email">Sin correo registrado</span>
                        @endif
                    </div>
                </label>
                @empty
                <p class="empty-group">No hay usuarios con envío habilitado.</p>
                @endforelse

                {{-- Grupo: Contactos de la obra --}}
                <div class="group-label">Contactos de la obra</div>
                @forelse($contactos as $contacto)
                <label class="recipient-row" style="{{ $contacto->correo ? '' : 'opacity:0.55;' }}">
                    <input type="checkbox" name="contactos[]" value="{{ $contacto->id }}"
                        {{ $contacto->correo ? 'checked' : 'disabled' }}>
                    <div class="recipient-info">
                        <span class="recipient-name">{{ trim($contacto->nombre . ' ' . $contacto->apellido) }}</span>
                        @if($contacto->correo)
                            <span class="recipient-email">{{ $contacto->correo }}</span>
                        @else
                            <span class="recipient-no-email">Sin correo registrado</span>
                        @endif
                    </div>
                </label>
                @empty
                <p class="empty-group">No hay contactos registrados para esta obra.</p>
                @endforelse

            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-enviar')">Cancelar</button>
                <button type="submit" class="btn-send">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModal(id)  { document.getElementById(id).classList.add('open'); }
    function cerrarModal(id) { document.getElementById(id).classList.remove('open'); }
    function cerrarEnOverlay(e, id) { if (e.target === document.getElementById(id)) cerrarModal(id); }
</script>

</body>
</html>
