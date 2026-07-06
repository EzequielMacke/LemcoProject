<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador general — LemcoProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { min-height: 100vh; font-family: 'Inter', sans-serif; background: #f8fafc; color: #111827; display: flex; flex-direction: column; }

        /* ── Navbar ── */
        .navbar { background: #fff; border-bottom: 1px solid #e9ecef; padding: 0 24px; height: 54px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .navbar-left { display: flex; align-items: center; gap: 12px; }
        .btn-back { display: flex; align-items: center; gap: 6px; background: none; border: 1.5px solid #e9ecef; border-radius: 8px; padding: 6px 11px; font-size: 13px; font-weight: 500; color: #6b7280; text-decoration: none; transition: all 0.15s; }
        .btn-back:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-back svg { width: 13px; height: 13px; }
        .nav-sep { width: 1px; height: 18px; background: #e9ecef; }
        .navbar-title { font-size: 14px; font-weight: 600; color: #111827; }
        .navbar-user { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 500; color: #374151; background: #f1f3f5; border: 1.5px solid #e9ecef; padding: 4px 11px 4px 5px; border-radius: 99px; }
        .user-chip { width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #1e40af, #1d4ed8); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0; }

        /* ── Page ── */
        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 16px; min-width: 0; min-height: 0; }
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; animation: fadeUp 0.35s ease both; }
        .page-label { font-size: 11.5px; font-weight: 600; color: #0d9488; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }
        .page-hint { font-size: 12px; color: #9ca3af; margin-top: 4px; }

        /* ── Toolbar ── */
        .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; animation: fadeUp 0.38s ease 0.03s both; flex-shrink: 0; }
        .results-count { font-size: 12.5px; color: #9ca3af; font-weight: 500; }
        .toolbar-actions { display: flex; align-items: center; gap: 8px; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #0f766e, #0d9488);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 9px 16px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(13,148,136,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary svg { width: 13px; height: 13px; }
        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 8px 14px; font-size: 13px; font-weight: 500;
            color: #6b7280; text-decoration: none; transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }

        /* ── Tabla con filtros en cabecera: tamaño fijo + scroll propio ── */
        .results-table-wrap {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 16px;
            overflow: auto; box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.42s ease 0.06s both;
            height: 62vh; min-height: 380px;
            cursor: grab;
            scrollbar-color: #cbd5e1 #f1f3f5;
        }
        .results-table-wrap.dragging { cursor: grabbing; user-select: none; }
        .results-table-wrap::-webkit-scrollbar { width: 14px; height: 14px; }
        .results-table-wrap::-webkit-scrollbar-track { background: #f1f3f5; }
        .results-table-wrap::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; border: 3px solid #f1f3f5; }
        .results-table-wrap::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .results-table-wrap::-webkit-scrollbar-corner { background: #f1f3f5; }

        table.results-table { border-collapse: separate; border-spacing: 0; font-size: 12.5px; table-layout: fixed; }

        .results-table thead th {
            text-align: left; padding: 8px 10px; background: #f8fafc;
            border-bottom: 1.5px solid #e9ecef; vertical-align: top;
            white-space: nowrap; overflow: hidden;
            position: sticky; top: 0; z-index: 3;
        }
        .th-sort {
            display: flex; align-items: center; gap: 4px; cursor: pointer;
            font-size: 10.5px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.4px; color: #6b7280; padding: 3px 2px 7px;
            user-select: none; transition: color 0.15s;
        }
        .th-sort:hover { color: #0d9488; }
        .sort-ind { font-size: 9px; color: #0d9488; display: inline-flex; align-items: flex-start; }
        .sort-ind sup { font-size: 8px; margin-left: 1px; }

        .th-filter {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 7px;
            padding: 5px 7px; font-size: 12px; color: #111827;
            background: #fff; outline: none; font-family: 'Inter', sans-serif;
            font-weight: 400; text-transform: none; letter-spacing: normal;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .th-filter:focus { border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13,148,136,0.1); }
        select.th-filter { cursor: pointer; }

        .results-table tbody td {
            padding: 9px 10px; border-bottom: 1px solid #f1f3f5; color: #374151;
            vertical-align: middle; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .results-table tbody tr:last-child td { border-bottom: none; }
        .results-table tbody tr:hover td { background: #f8fafc; }
        .cell-strong { color: #111827; font-weight: 600; }
        .cell-muted { color: #9ca3af; }

        /* Primera columna fija: ancla de referencia al desplazar horizontalmente */
        .results-table th:first-child, .results-table td:first-child {
            position: sticky; left: 0; background: #fff;
        }
        .results-table thead th:first-child { z-index: 4; background: #f8fafc; }
        .results-table tbody tr:hover td:first-child { background: #f1f5f9; }

        .btn-ver { text-decoration: none; }

        /* ── Badges ── */
        .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 10.5px; font-weight: 600; padding: 2px 8px; border-radius: 99px; white-space: nowrap; }
        .badge-ok      { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-off     { background: #f8fafc; color: #9ca3af; border: 1.5px solid #e9ecef; }
        .badge-pend    { background: #fffbeb; color: #d97706; border: 1.5px solid #fde68a; }
        .badge-info    { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
        .badge-cert    { background: #f5f3ff; color: #6d28d9; border: 1.5px solid #ddd6fe; }

        /* ── Empty state ── */
        .empty-state { padding: 56px 24px; text-align: center; color: #9ca3af; }
        .empty-state svg { width: 40px; height: 40px; margin: 0 auto 12px; display: block; color: #d1d5db; }
        .empty-state p { font-size: 14px; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 36px; }
            .results-table-wrap { height: 70vh; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('menu.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Volver
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Buscador general</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    <div class="page-header">
        <div>
            <div class="page-label">Buscador</div>
            <div class="page-heading">Probetas</div>
            <div class="page-hint">Filtrá escribiendo en cada columna. Click en el título ordena; Shift+click agrega un criterio de orden adicional. Arrastrá la tabla para desplazarte.</div>
        </div>
    </div>

    @php
        $columnas = [
            ['key' => 'nombre',              'label' => 'Nombre',           'type' => 'text',   'width' => 110],
            ['key' => 'obra',                'label' => 'Obra',             'type' => 'text',   'width' => 170],
            ['key' => 'remision',            'label' => 'Remisión',         'type' => 'text',   'width' => 100],
            ['key' => 'mixer',               'label' => 'Mixer',            'type' => 'text',   'width' => 90],
            ['key' => 'concretera',          'label' => 'Concretera',       'type' => 'text',   'width' => 130],
            ['key' => 'fck',                 'label' => "F'ck",             'type' => 'text',   'width' => 75],
            ['key' => 'elemento',            'label' => 'Elemento',         'type' => 'text',   'width' => 120],
            ['key' => 'fecha_moldeo',        'label' => 'Fecha moldeo',     'type' => 'date',   'width' => 130],
            ['key' => 'hora_moldeo',         'label' => 'Hora moldeo',      'type' => 'text',   'width' => 100],
            ['key' => 'edad_ensayo',         'label' => 'Edad ensayo',      'type' => 'text',   'width' => 100],
            ['key' => 'fecha_programada',    'label' => 'Fecha programada', 'type' => 'date',   'width' => 135],
            ['key' => 'defecto',             'label' => 'Defecto',          'type' => 'text',   'width' => 110],
            ['key' => 'carga_rotura',        'label' => 'Carga rotura',     'type' => 'text',   'width' => 110],
            ['key' => 'tipo_rotura',         'label' => 'Tipo rotura',      'type' => 'select', 'width' => 100, 'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]],
            ['key' => 'diametro_superior_1', 'label' => 'Ø sup. 1',         'type' => 'text',   'width' => 90],
            ['key' => 'diametro_superior_2', 'label' => 'Ø sup. 2',         'type' => 'text',   'width' => 90],
            ['key' => 'diametro_inferior_1', 'label' => 'Ø inf. 1',         'type' => 'text',   'width' => 90],
            ['key' => 'diametro_inferior_2', 'label' => 'Ø inf. 2',         'type' => 'text',   'width' => 90],
            ['key' => 'altura_1',            'label' => 'Alt. 1',           'type' => 'text',   'width' => 85],
            ['key' => 'altura_2',            'label' => 'Alt. 2',           'type' => 'text',   'width' => 85],
            ['key' => 'altura_3',            'label' => 'Alt. 3',           'type' => 'text',   'width' => 85],
            ['key' => 'ensayado_por',        'label' => 'Ensayado por',     'type' => 'text',   'width' => 160],
            ['key' => 'estado_ensayo',       'label' => 'Estado',           'type' => 'select', 'width' => 115, 'options' => ['ensayada' => 'Ensayada', 'pendiente' => 'Pendiente']],
            ['key' => 'informe',             'label' => 'Informe',          'type' => 'select', 'width' => 115, 'options' => ['con_informe' => 'En informe', 'sin_informe' => 'Sin informe']],
            ['key' => 'certificado',         'label' => 'Certificado',      'type' => 'select', 'width' => 125, 'options' => ['certificada' => 'Certificada', 'no_certificada' => 'No certificada']],
        ];
        $anchoTotal = collect($columnas)->sum('width');
    @endphp

    <form method="GET" action="{{ route('buscador.index') }}" id="search-form">
        <input type="hidden" name="sort" id="sort-field" value="{{ $sortValue }}">

        <div class="toolbar">
            <span class="results-count">{{ $resultados->count() }} probeta(s)</span>
            <div class="toolbar-actions">
                <button type="submit" class="btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Buscar
                </button>
                <a href="{{ route('buscador.index') }}" class="btn-cancel">Limpiar todo</a>
            </div>
        </div>

        <div class="results-table-wrap" id="table-wrap" style="margin-top: 12px;">
            <table class="results-table" style="width: {{ $anchoTotal }}px;">
                <colgroup>
                    @foreach($columnas as $col)
                    <col style="width: {{ $col['width'] }}px;">
                    @endforeach
                </colgroup>
                <thead>
                    <tr>
                        @foreach($columnas as $col)
                        @php $st = $ordenPorClave[$col['key']] ?? null; @endphp
                        <th>
                            <div class="th-sort" onclick="toggleSort(event, '{{ $col['key'] }}')">
                                <span>{{ $col['label'] }}</span>
                                @if($st)
                                <span class="sort-ind">
                                    {{ $st['dir'] === 'asc' ? '▲' : '▼' }}@if(count($ordenPorClave) > 1)<sup>{{ $st['pos'] }}</sup>@endif
                                </span>
                                @endif
                            </div>
                            @if($col['type'] === 'text')
                                <input type="text" name="f_{{ $col['key'] }}" value="{{ $filtros[$col['key']] ?? '' }}" class="th-filter" placeholder="Filtrar..." list="dl-{{ $col['key'] }}" autocomplete="off">
                                <datalist id="dl-{{ $col['key'] }}">
                                    @foreach($sugerencias[$col['key']] ?? [] as $valor)
                                    <option value="{{ $valor }}"></option>
                                    @endforeach
                                </datalist>
                            @elseif($col['type'] === 'date')
                                <input type="date" name="f_{{ $col['key'] }}" value="{{ $filtros[$col['key']] ?? '' }}" class="th-filter" onchange="this.form.submit()">
                            @elseif($col['type'] === 'select')
                                <select name="f_{{ $col['key'] }}" class="th-filter" onchange="this.form.submit()">
                                    <option value="">Todas</option>
                                    @foreach($col['options'] as $val => $lbl)
                                    <option value="{{ $val }}" @selected(($filtros[$col['key']] ?? '') == $val)>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($resultados as $p)
                    <tr>
                        <td class="cell-strong">{{ $p->nombre }}</td>
                        <td>{{ $p->obra_nombre }}</td>
                        <td>{{ $p->remision_nro }}</td>
                        <td>{{ $p->mixer }}</td>
                        <td>{{ $p->concretera }}</td>
                        <td>{{ $p->fck }}</td>
                        <td>{{ $p->elemento }}</td>
                        <td>{{ $p->fecha_moldeo?->format('d/m/Y') ?? '—' }}</td>
                        <td>{{ $p->hora_moldeo ? substr($p->hora_moldeo, 0, 5) : '—' }}</td>
                        <td>{{ $p->edad_ensayo !== null ? $p->edad_ensayo.' días' : '—' }}</td>
                        <td class="cell-muted">{{ $p->fecha_programada ? \Carbon\Carbon::parse($p->fecha_programada)->format('d/m/Y') : '—' }}</td>
                        <td>{{ $p->defecto ?? '—' }}</td>
                        <td>{{ $p->carga_rotura !== null ? number_format($p->carga_rotura, 2) : '—' }}</td>
                        <td>{{ $p->tipo_rotura ?? '—' }}</td>
                        <td>{{ $p->diametro_superior_1 ?? '—' }}</td>
                        <td>{{ $p->diametro_superior_2 ?? '—' }}</td>
                        <td>{{ $p->diametro_inferior_1 ?? '—' }}</td>
                        <td>{{ $p->diametro_inferior_2 ?? '—' }}</td>
                        <td>{{ $p->altura_1 ?? '—' }}</td>
                        <td>{{ $p->altura_2 ?? '—' }}</td>
                        <td>{{ $p->altura_3 ?? '—' }}</td>
                        <td>{{ $p->ensayado_por_nombre ?? '—' }}</td>
                        <td>
                            @if($p->es_ensayada == 1)
                                <span class="badge badge-ok">Ensayada</span>
                            @else
                                <span class="badge badge-pend">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            @if($p->informe_id && $p->obra_id)
                            <a href="{{ route('informes.show', [$p->obra_id, $p->informe_id]) }}" class="btn-ver">
                                <span class="badge badge-info">En informe</span>
                            </a>
                            @else
                                <span class="badge badge-off">Sin informe</span>
                            @endif
                        </td>
                        <td>
                            @if($p->certificado_id && $p->obra_id)
                            <a href="{{ route('certificacion.show', [$p->obra_id, $p->certificado_id]) }}" class="btn-ver">
                                <span class="badge badge-cert">Certificada</span>
                            </a>
                            @else
                                <span class="badge badge-off">No certificada</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($columnas) }}" style="white-space: normal;">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                                <p>{{ $huboBusqueda ? 'Sin resultados para los filtros aplicados' : 'No hay probetas registradas' }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

</main>

<script>
    function toggleSort(e, key) {
        const hidden = document.getElementById('sort-field');
        let spec = hidden.value
            ? hidden.value.split(',').map(s => { const [k, d] = s.split(':'); return { k, d }; })
            : [];

        const idx = spec.findIndex(s => s.k === key);

        if (!e.shiftKey) {
            if (spec.length === 1 && idx === 0) {
                spec[0].d = spec[0].d === 'asc' ? 'desc' : 'asc';
            } else {
                spec = [{ k: key, d: 'asc' }];
            }
        } else if (idx === -1) {
            spec.push({ k: key, d: 'asc' });
        } else if (spec[idx].d === 'asc') {
            spec[idx].d = 'desc';
        } else {
            spec.splice(idx, 1);
        }

        hidden.value = spec.map(s => s.k + ':' + s.d).join(',');
        document.getElementById('search-form').submit();
    }

    (function () {
        const wrap = document.getElementById('table-wrap');
        let arrastrando = false, startX = 0, startY = 0, scrollLeft = 0, scrollTop = 0;

        wrap.addEventListener('mousedown', (e) => {
            if (e.target.closest('input, select, button, a, .th-sort')) return;
            arrastrando = true;
            wrap.classList.add('dragging');
            startX = e.pageX;
            startY = e.pageY;
            scrollLeft = wrap.scrollLeft;
            scrollTop = wrap.scrollTop;
        });
        window.addEventListener('mouseup', () => {
            arrastrando = false;
            wrap.classList.remove('dragging');
        });
        wrap.addEventListener('mouseleave', () => {
            arrastrando = false;
            wrap.classList.remove('dragging');
        });
        wrap.addEventListener('mousemove', (e) => {
            if (!arrastrando) return;
            e.preventDefault();
            wrap.scrollLeft = scrollLeft - (e.pageX - startX);
            wrap.scrollTop = scrollTop - (e.pageY - startY);
        });
    })();
</script>

</body>
</html>
