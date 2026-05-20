<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes — {{ $obra->nombre }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { min-height: 100vh; font-family: 'Inter', sans-serif; background: #f8fafc; color: #111827; display: flex; flex-direction: column; }

        .navbar { background: #fff; border-bottom: 1px solid #e9ecef; padding: 0 24px; height: 54px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .navbar-left { display: flex; align-items: center; gap: 12px; }
        .btn-back { display: flex; align-items: center; gap: 6px; background: none; border: 1.5px solid #e9ecef; border-radius: 8px; padding: 6px 11px; font-size: 13px; font-weight: 500; color: #6b7280; text-decoration: none; transition: all 0.15s; }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }
        .nav-sep { width: 1px; height: 18px; background: #e9ecef; }
        .navbar-title { font-size: 14px; font-weight: 600; color: #111827; max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .navbar-user { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 500; color: #374151; background: #f1f3f5; border: 1.5px solid #e9ecef; padding: 4px 11px 4px 5px; border-radius: 99px; }
        .user-chip { width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #1e40af, #1d4ed8); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0; }

        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 20px; }
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; animation: fadeUp 0.35s ease both; }
        .page-label { font-size: 11.5px; font-weight: 600; color: #d97706; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        .alert { border-radius: 10px; padding: 12px 16px; font-size: 13px; display: flex; align-items: center; gap: 10px; animation: fadeUp 0.35s ease both; }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* Tabs */
        .tabs { display: flex; gap: 4px; border-bottom: 2px solid #e9ecef; animation: fadeUp 0.35s ease both; }
        .tab-btn { display: flex; align-items: center; gap: 7px; padding: 9px 16px 11px; font-size: 13.5px; font-weight: 500; color: #6b7280; background: none; border: none; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: color 0.15s, border-color 0.15s; font-family: 'Inter', sans-serif; }
        .tab-btn:hover { color: #374151; }
        .tab-btn.active { color: #d97706; border-bottom-color: #d97706; font-weight: 600; }
        .tab-count { display: inline-flex; align-items: center; justify-content: center; min-width: 20px; height: 20px; padding: 0 6px; border-radius: 99px; font-size: 11px; font-weight: 700; }
        .tab-btn.active .tab-count { background: #fffbeb; color: #d97706; }
        .tab-btn:not(.active) .tab-count { background: #f1f3f5; color: #9ca3af; }

        .tab-panel { display: none; animation: fadeUp 0.25s ease both; }
        .tab-panel.active { display: block; }

        /* Grid compartido */
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 210px)); justify-content: start; gap: 14px; }

        /* Card base */
        .inf-card {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 16px;
            display: flex; flex-direction: column; min-height: 210px;
            position: relative;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s;
        }
        .inf-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-color: #d1d5db; }
        .inf-card::before { content: ''; position: absolute; top: 0; left: 16px; right: 16px; height: 2.5px; border-radius: 0 0 4px 4px; }
        .inf-card.pendiente::before { background: #f59e0b; }
        .inf-card.generado::before  { background: #d97706; }

        /* Card link (pendientes) */
        a.inf-card { text-decoration: none; color: inherit; cursor: pointer; }

        .card-seq { position: absolute; top: 10px; right: 10px; width: 20px; height: 20px; border-radius: 50%; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .inf-card.pendiente .card-seq { background: #fffbeb; color: #f59e0b; }
        .inf-card.generado  .card-seq { background: #fffbeb; color: #d97706; }

        .card-inner { flex: 1; padding: 18px 16px 10px; display: flex; flex-direction: column; min-height: 0; }
        .card-nro { font-size: 15px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; margin-bottom: 2px; padding-right: 26px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .card-fecha { font-size: 11px; color: #9ca3af; font-weight: 500; margin-bottom: 10px; }
        .card-rows { display: flex; flex-direction: column; gap: 6px; flex: 1; }
        .card-row { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #374151; }
        .card-row svg { width: 13px; height: 13px; flex-shrink: 0; color: #9ca3af; }
        .card-row span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .card-foot { padding: 8px 12px; border-top: 1px solid #f1f3f5; display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-shrink: 0; flex-wrap: wrap; }

        .chip { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 99px; }
        .chip svg { width: 11px; height: 11px; }
        .chip-amber { background: #fffbeb; color: #d97706; }

        .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 10.5px; font-weight: 600; padding: 2px 8px; border-radius: 99px; }
        .badge svg { width: 10px; height: 10px; }
        .badge-pendiente  { background: #fffbeb; color: #d97706; border: 1.5px solid #fde68a; }
        .badge-enviado    { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
        .badge-verificado { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }

        .card-arrow { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; color: #f59e0b; }
        .card-arrow svg { width: 12px; height: 12px; }

        .btn-card { display: flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 7px; border: 1.5px solid; background: none; cursor: pointer; transition: all 0.15s; padding: 0; }
        .btn-card svg { width: 13px; height: 13px; }
        .btn-card-eliminar { border-color: #fecdd3; color: #be123c; }
        .btn-card-eliminar:hover { background: #fff1f2; border-color: #fca5a5; }

        /* Empty state */
        .empty-state { padding: 56px 24px; text-align: center; color: #9ca3af; }
        .empty-state svg { width: 40px; height: 40px; margin: 0 auto 12px; display: block; color: #d1d5db; }
        .empty-state p { font-size: 14px; }

        /* Modal */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.35); display: none; align-items: center; justify-content: center; z-index: 100; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 18px; width: 100%; max-width: 380px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); animation: modalIn 0.2s ease both; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(10px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .modal-head { padding: 18px 20px 14px; border-bottom: 1px solid #f1f3f5; display: flex; align-items: center; justify-content: space-between; }
        .modal-title { font-size: 15px; font-weight: 700; color: #0f172a; }
        .modal-close { display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; border: 1.5px solid #e9ecef; background: none; cursor: pointer; color: #9ca3af; transition: all 0.15s; padding: 0; }
        .modal-close:hover { background: #f1f3f5; color: #374151; }
        .modal-close svg { width: 14px; height: 14px; }
        .modal-body { padding: 18px 20px; font-size: 13.5px; color: #374151; line-height: 1.6; }
        .modal-body strong { color: #111827; font-weight: 600; }
        .modal-warn { margin-top: 12px; background: #fff1f2; border: 1.5px solid #fecdd3; border-radius: 10px; padding: 10px 14px; font-size: 12.5px; color: #be123c; line-height: 1.5; }
        .modal-foot { padding: 14px 20px; border-top: 1.5px solid #e9ecef; display: flex; justify-content: flex-end; gap: 8px; }
        .btn-cancel { display: inline-flex; align-items: center; background: none; border: 1.5px solid #e9ecef; border-radius: 10px; padding: 8px 16px; font-size: 13px; font-weight: 500; color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s; }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; }
        .btn-danger { display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #9f1239, #be123c); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 10px; padding: 9px 18px; cursor: pointer; font-family: 'Inter', sans-serif; box-shadow: 0 3px 10px rgba(190,18,60,0.3); transition: opacity 0.15s; }
        .btn-danger:hover { opacity: 0.9; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 600px) { .page { padding: 20px 16px 36px; } .cards-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 380px) { .cards-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('obras.show', $obra) }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Obra
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

    <div class="page-header">
        <div>
            <div class="page-label">Informes</div>
            <div class="page-heading">Informes de ensayo</div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="tabs">
        <button class="tab-btn active" onclick="setTab('pendientes')">
            Pendientes <span class="tab-count">{{ $pendientes->count() }}</span>
        </button>
        <button class="tab-btn" onclick="setTab('generados')">
            Generados <span class="tab-count">{{ $informes->count() }}</span>
        </button>
    </div>

    {{-- Pendientes --}}
    <div class="tab-panel active" id="panel-pendientes">
        @if($pendientes->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>No hay informes pendientes de generar.</p>
        </div>
        @else
        <div class="cards-grid">
            @foreach($pendientes as $i => $pendiente)
            @php $rem = $pendiente->remision; @endphp
            <a class="inf-card pendiente" href="{{ route('informes.crear', [$obra, $rem, 'fecha_moldeo' => $pendiente->fecha_moldeo?->format('Y-m-d'), 'dias_ensayo' => $pendiente->dias_ensayo]) }}">
                <div class="card-seq">{{ $i + 1 }}</div>
                <div class="card-inner">
                    <div class="card-nro">Rem. {{ $rem->nro ?? '—' }}</div>
                    <div class="card-fecha">
                        Moldeo: {{ $pendiente->fecha_moldeo?->format('d/m/Y') ?? '—' }}
                    </div>
                    <div class="card-rows">
                        <div class="card-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                            <span>{{ $rem->contratista ?? '—' }}</span>
                        </div>
                        <div class="card-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $pendiente->dias_ensayo !== null ? $pendiente->dias_ensayo.' días' : '—' }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-foot">
                    <span class="chip chip-amber">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/></svg>
                        {{ $pendiente->total }} prob.
                    </span>
                    <span class="card-arrow">
                        Ver detalle
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Generados --}}
    <div class="tab-panel" id="panel-generados">
        @if($informes->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            <p>No hay informes generados aún.</p>
        </div>
        @else
        <div class="cards-grid">
            @foreach($informes as $i => $informe)
            @php
                $remision = $informe->recepcion;
                $total = $informes->count();
                $primeraProbeta = $informe->detalles->first()?->probeta;
                $fechaMoldeoInf = $primeraProbeta?->fecha_moldeo;
                $diasEnsayoInf  = ($primeraProbeta?->fecha_moldeo && $primeraProbeta?->fecha_ensayo)
                    ? $primeraProbeta->fecha_moldeo->diffInDays($primeraProbeta->fecha_ensayo)
                    : null;
            @endphp
            <div class="inf-card generado" style="cursor:pointer" onclick="window.location='{{ route('informes.show', [$obra, $informe]) }}'"  >
                <div class="card-seq">{{ $total - $i }}</div>
                <div class="card-inner">
                    <div class="card-nro">Rem. {{ $remision->nro ?? '—' }}</div>
                    <div class="card-fecha">Moldeo: {{ $fechaMoldeoInf?->format('d/m/Y') ?? '—' }}</div>
                    <div style="margin-bottom:10px; display:flex; gap:5px; flex-wrap:wrap;">
                        @if(!$informe->verificado && !$informe->enviado)
                            <span class="badge badge-pendiente"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Pendiente</span>
                        @endif
                        @if($informe->verificado)
                            <span class="badge badge-verificado"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Verificado</span>
                        @endif
                        @if($informe->enviado)
                            <span class="badge badge-enviado"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>Enviado</span>
                        @endif
                    </div>
                    <div class="card-rows">
                        <div class="card-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                            <span>{{ $remision->contratista ?? '—' }}</span>
                        </div>
                        <div class="card-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $diasEnsayoInf !== null ? $diasEnsayoInf.' días' : '—' }}</span>
                        </div>
                        <div class="card-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <span>{{ $informe->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-foot">
                    <span class="chip chip-amber">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/></svg>
                        {{ $informe->detalles_count }} prob.
                    </span>
                    @permiso('INF', 'eliminar')
                    <button class="btn-card btn-card-eliminar" title="Eliminar informe"
                        onclick="event.stopPropagation(); abrirEliminar({{ $informe->id }}, @js($remision->nro ?? '—'))">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    </button>
                    @endpermiso
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</main>

@permiso('INF', 'eliminar')
<div class="modal-overlay" id="modal-eliminar" onclick="cerrarEnOverlay(event, 'modal-eliminar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Eliminar informe</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-eliminar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" id="form-eliminar" action="">
            @csrf @method('DELETE')
            <div class="modal-body">
                ¿Estás seguro de que querés eliminar el informe de la remisión <strong id="eliminar-nro"></strong>?
                <div class="modal-warn">Se eliminarán el informe y todos sus detalles. Esta acción no se puede deshacer.</div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-eliminar')">Cancelar</button>
                <button type="submit" class="btn-danger">Eliminar</button>
            </div>
        </form>
    </div>
</div>
@endpermiso

<script>
    function setTab(name) {
        document.querySelectorAll('.tab-btn').forEach((btn, i) => {
            btn.classList.toggle('active', ['pendientes','generados'][i] === name);
        });
        document.querySelectorAll('.tab-panel').forEach(p => {
            p.classList.toggle('active', p.id === 'panel-' + name);
        });
    }
    function abrirModal(id)  { document.getElementById(id).classList.add('open'); }
    function cerrarModal(id) { document.getElementById(id).classList.remove('open'); }
    function cerrarEnOverlay(e, id) { if (e.target === document.getElementById(id)) cerrarModal(id); }
    function abrirEliminar(id, nro) {
        document.getElementById('eliminar-nro').textContent = nro;
        document.getElementById('form-eliminar').action = '{{ url("/obras/{$obra->id}/informes") }}/' + id;
        abrirModal('modal-eliminar');
    }
</script>

</body>
</html>
