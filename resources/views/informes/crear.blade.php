<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar informe — Rem. {{ $remision->nro }}</title>
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
        .navbar-title { font-size: 14px; font-weight: 600; color: #111827; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .navbar-user { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 500; color: #374151; background: #f1f3f5; border: 1.5px solid #e9ecef; padding: 4px 11px 4px 5px; border-radius: 99px; }
        .user-chip { width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #1e40af, #1d4ed8); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0; }

        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 20px; }
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; animation: fadeUp 0.35s ease both; flex-wrap: wrap; }
        .page-label { font-size: 11.5px; font-weight: 600; color: #f59e0b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }
        .page-sub { font-size: 13px; color: #6b7280; margin-top: 3px; }

        /* Info remision */
        .rem-info {
            display: flex; gap: 12px; flex-wrap: wrap;
            animation: fadeUp 0.35s ease 0.05s both;
        }
        .rem-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 7px 13px; font-size: 12.5px; color: #374151;
        }
        .rem-chip strong { color: #0f172a; font-weight: 600; }
        .rem-chip svg { width: 13px; height: 13px; color: #9ca3af; }

        /* Tabla probetas */
        .table-wrap { background: #fff; border: 1.5px solid #e9ecef; border-radius: 14px; overflow: hidden; animation: fadeUp 0.4s ease 0.1s both; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 11px 14px; text-align: left; font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.7px; background: #f8fafc; border-bottom: 1.5px solid #e9ecef; white-space: nowrap; }
        thead th.th-num { width: 44px; text-align: center; }
        thead th.th-actions { width: 90px; }
        tbody tr { border-bottom: 1px solid #f1f3f5; transition: background 0.12s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr.excluida { opacity: 0.35; }
        tbody td { padding: 12px 14px; font-size: 13px; color: #374151; vertical-align: middle; }
        .td-num { font-weight: 700; color: #9ca3af; font-size: 12px; text-align: center; }
        .td-mono { font-variant-numeric: tabular-nums; }

        /* Botón excluir/incluir */
        .btn-excluir {
            display: inline-flex; align-items: center; gap: 5px;
            background: none; border: 1.5px solid #fecdd3; border-radius: 8px;
            padding: 4px 10px; font-size: 11.5px; font-weight: 600; color: #be123c;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s;
        }
        .btn-excluir:hover { background: #fff1f2; }
        .btn-excluir svg { width: 11px; height: 11px; }
        .btn-incluir {
            display: none; align-items: center; gap: 5px;
            background: none; border: 1.5px solid #bbf7d0; border-radius: 8px;
            padding: 4px 10px; font-size: 11.5px; font-weight: 600; color: #15803d;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s;
        }
        .btn-incluir:hover { background: #f0fdf4; }
        .btn-incluir svg { width: 11px; height: 11px; }
        tbody tr.excluida .btn-excluir { display: none; }
        tbody tr.excluida .btn-incluir { display: inline-flex; }

        /* Botón generar (header) */
        .btn-generar {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #b45309, #d97706);
            color: #fff; font-size: 13.5px; font-weight: 600;
            border: none; border-radius: 11px; padding: 10px 22px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 12px rgba(217,119,6,0.35);
            transition: opacity 0.15s, transform 0.15s;
            white-space: nowrap;
        }
        .btn-generar:hover { opacity: 0.92; transform: translateY(-1px); }
        .btn-generar:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }
        .btn-generar svg { width: 15px; height: 15px; }

        .foot-counter { font-size: 13px; color: #6b7280; animation: fadeUp 0.4s ease 0.15s both; }
        .foot-counter strong { color: #0f172a; font-weight: 600; }

        .alert-warn { background: #fffbeb; border: 1.5px solid #fde68a; color: #92400e; border-radius: 10px; padding: 12px 16px; font-size: 13px; display: flex; align-items: center; gap: 10px; }
        .alert-warn svg { width: 16px; height: 16px; flex-shrink: 0; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('informes.index', $obra) }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Informes
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Rem. {{ $remision->nro }} — {{ $obra->nombre }}</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    <div class="page-header">
        <div>
            <div class="page-label">Nuevo informe</div>
            <div class="page-heading">Remisión {{ $remision->nro }}</div>
            <div class="page-sub">Seleccioná las probetas a incluir en el informe</div>
        </div>
        @if(!$probetas->isEmpty())
        <button type="submit" form="form-informe" class="btn-generar" id="btn-generar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            Generar informe
        </button>
        @endif
    </div>

    <div class="rem-info">
        @if($remision->contratista)
        <div class="rem-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
            <strong>{{ $remision->contratista }}</strong>
        </div>
        @endif
        @if($fechaMoldeo)
        <div class="rem-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            Moldeo: <strong>{{ \Carbon\Carbon::parse($fechaMoldeo)->format('d/m/Y') }}</strong>
        </div>
        @endif
        @if($diasEnsayo !== null)
        <div class="rem-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <strong>{{ $diasEnsayo }}</strong>&nbsp;días de ensayo
        </div>
        @endif
        <div class="rem-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/></svg>
            <strong id="contador">{{ $probetas->count() }}</strong>&nbsp;de {{ $probetas->count() }} probeta{{ $probetas->count() !== 1 ? 's' : '' }} incluida{{ $probetas->count() !== 1 ? 's' : '' }}
        </div>
    </div>

    @if($probetas->isEmpty())
    <div class="alert-warn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
        No hay probetas ensayadas disponibles para esta remisión.
    </div>
    @else

    <form method="POST" action="{{ route('informes.store', $obra) }}" id="form-informe">
        @csrf
        <input type="hidden" name="remision_id" value="{{ $remision->id }}">

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th class="th-num">#</th>
                        <th>Nombre</th>
                        <th>Elemento</th>
                        <th>Fecha ensayo</th>
                        <th>Carga rotura</th>
                        <th>Tipo rotura</th>
                        <th class="th-actions"></th>
                    </tr>
                </thead>
                <tbody id="tbody-probetas">
                    @foreach($probetas as $i => $probeta)
                    <tr id="fila-{{ $probeta->id }}">
                        <td class="td-num">{{ $i + 1 }}</td>
                        <td>{{ $probeta->nombre ?? '—' }}</td>
                        <td>{{ $probeta->elemento ?? '—' }}</td>
                        <td class="td-mono">{{ $probeta->fecha_ensayo?->format('d/m/Y') ?? '—' }}</td>
                        <td class="td-mono">{{ $probeta->carga_rotura !== null ? number_format($probeta->carga_rotura, 2).' kN' : '—' }}</td>
                        <td class="td-mono">{{ $probeta->tipo_rotura ?? '—' }}</td>
                        <td>
                            <input type="checkbox" name="probetas[]" value="{{ $probeta->id }}" checked style="display:none" id="chk-{{ $probeta->id }}">
                            <button type="button" class="btn-excluir" onclick="excluir({{ $probeta->id }})">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                Excluir
                            </button>
                            <button type="button" class="btn-incluir" onclick="incluir({{ $probeta->id }})">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                Incluir
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>

    @endif

</main>

<script>
    const total = {{ $probetas->count() }};

    function excluir(id) {
        document.getElementById('fila-' + id).classList.add('excluida');
        document.getElementById('chk-' + id).checked = false;
        actualizarContador();
    }

    function incluir(id) {
        document.getElementById('fila-' + id).classList.remove('excluida');
        document.getElementById('chk-' + id).checked = true;
        actualizarContador();
    }

    function actualizarContador() {
        const incluidas = document.querySelectorAll('#tbody-probetas input[type=checkbox]:checked').length;
        document.getElementById('contador').textContent = incluidas;
        const btn = document.getElementById('btn-generar');
        if (btn) btn.disabled = incluidas === 0;
    }
</script>

</body>
</html>
