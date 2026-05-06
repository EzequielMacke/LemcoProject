<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar permisos — {{ $area->descripcion }}</title>
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

        .nav-sep      { width: 1px; height: 18px; background: #e9ecef; }
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
            gap: 16px;
            animation: fadeUp 0.35s ease both;
        }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #b45309; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        .area-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: #fffbeb; border: 1.5px solid #fde68a;
            color: #92400e; border-radius: 99px;
            padding: 4px 12px 4px 8px; font-size: 12.5px; font-weight: 600;
            margin-top: 6px;
        }
        .area-chip svg { width: 12px; height: 12px; }

        /* ── Botón guardar ── */
        .btn-save {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #92400e, #b45309);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 20px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(180,83,9,0.3);
            transition: opacity 0.15s, transform 0.1s;
            white-space: nowrap;
        }
        .btn-save:hover  { opacity: 0.9; transform: translateY(-1px); }
        .btn-save:active { transform: translateY(0); }
        .btn-save svg { width: 14px; height: 14px; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
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
        .table-scroll { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; min-width: 540px; }

        thead th {
            padding: 14px 20px;
            font-size: 11px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.7px;
            background: #f8fafc;
            border-bottom: 1.5px solid #e9ecef;
            text-align: center;
        }
        thead th:first-child { text-align: left; }

        tbody tr {
            border-bottom: 1px solid #f1f3f5;
            transition: background 0.12s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fafafa; }

        tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            text-align: center;
        }
        tbody td:first-child { text-align: left; }

        .modulo-nombre { font-size: 13.5px; font-weight: 600; color: #111827; transition: color 0.15s; }
        .modulo-abrev  { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }

        /* Celda módulo clickeable */
        .td-modulo {
            cursor: pointer;
            user-select: none;
        }
        .td-modulo:hover .modulo-nombre { color: #b45309; }
        .td-modulo:hover .modulo-abrev  { color: #b45309; opacity: .6; }

        /* Encabezado de permiso clickeable */
        thead th.th-perm {
            cursor: pointer;
            user-select: none;
            transition: background 0.15s;
        }
        thead th.th-perm:hover { background: #f1f3f5; }

        /* ── Badges de encabezado ── */
        .perm-badge {
            display: inline-flex; align-items: center;
            font-size: 10.5px; font-weight: 700;
            padding: 3px 9px; border-radius: 99px;
            letter-spacing: 0.3px;
        }
        .perm-ver      { background: #eff6ff; color: #1d4ed8; }
        .perm-agregar  { background: #f0fdf4; color: #15803d; }
        .perm-editar   { background: #fffbeb; color: #b45309; }
        .perm-eliminar { background: #fff1f2; color: #be123c; }

        /* ── Toggle switch ── */
        .toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .toggle input {
            position: absolute;
            opacity: 0; width: 0; height: 0;
        }
        .toggle-track {
            width: 44px; height: 24px;
            background: #e2e8f0;
            border-radius: 99px;
            position: relative;
            transition: background 0.22s;
            flex-shrink: 0;
        }
        .toggle-thumb {
            position: absolute;
            width: 18px; height: 18px;
            background: #fff;
            border-radius: 50%;
            top: 3px; left: 3px;
            transition: transform 0.22s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.18);
        }

        .toggle-ver      { --c: #1d4ed8; }
        .toggle-agregar  { --c: #15803d; }
        .toggle-editar   { --c: #b45309; }
        .toggle-eliminar { --c: #be123c; }

        .toggle input:checked + .toggle-track                { background: var(--c); }
        .toggle input:checked + .toggle-track .toggle-thumb  { transform: translateX(20px); }
        .toggle input:focus-visible + .toggle-track          { outline: 2px solid var(--c); outline-offset: 2px; }

        /* ── Footer móvil ── */
        .form-footer {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 14px;
            padding: 16px 20px;
            display: flex; justify-content: flex-end;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease 0.1s both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .btn-save-header { display: none; }
        }
        @media (min-width: 769px) {
            .form-footer { display: none; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('permisos.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Volver
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Editar permisos</span>
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
            <div class="page-label">Permisos</div>
            <div class="page-heading">Editar permisos</div>
            <div class="area-chip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                </svg>
                {{ $area->descripcion }}
            </div>
        </div>
        <button type="submit" form="form-permisos" class="btn-save btn-save-header">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Guardar permisos
        </button>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Tabla --}}
    <form id="form-permisos" method="POST" action="{{ route('permisos.update', $area) }}">
        @csrf
        <div class="table-card">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th class="th-perm" data-tipo="ver"><span class="perm-badge perm-ver">Ver</span></th>
                            <th class="th-perm" data-tipo="agregar"><span class="perm-badge perm-agregar">Agregar</span></th>
                            <th class="th-perm" data-tipo="editar"><span class="perm-badge perm-editar">Editar</span></th>
                            <th class="th-perm" data-tipo="eliminar"><span class="perm-badge perm-eliminar">Eliminar</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modulos as $modulo)
                        @php $p = $permisos[$modulo->id] ?? null; @endphp
                        <tr>
                            <td class="td-modulo">
                                <div class="modulo-nombre">{{ $modulo->descripcion }}</div>
                                <div class="modulo-abrev">{{ $modulo->abreviacion }}</div>
                            </td>
                            <td>
                                <label class="toggle toggle-ver">
                                    <input type="checkbox" name="permisos[{{ $modulo->id }}][ver]" value="1" {{ $p?->ver === 1 ? 'checked' : '' }}>
                                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                </label>
                            </td>
                            <td>
                                <label class="toggle toggle-agregar">
                                    <input type="checkbox" name="permisos[{{ $modulo->id }}][agregar]" value="1" {{ $p?->agregar === 1 ? 'checked' : '' }}>
                                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                </label>
                            </td>
                            <td>
                                <label class="toggle toggle-editar">
                                    <input type="checkbox" name="permisos[{{ $modulo->id }}][editar]" value="1" {{ $p?->editar === 1 ? 'checked' : '' }}>
                                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                </label>
                            </td>
                            <td>
                                <label class="toggle toggle-eliminar">
                                    <input type="checkbox" name="permisos[{{ $modulo->id }}][eliminar]" value="1" {{ $p?->eliminar === 1 ? 'checked' : '' }}>
                                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- Footer guardar (visible solo en móvil) --}}
    <div class="form-footer">
        <button type="submit" form="form-permisos" class="btn-save">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Guardar permisos
        </button>
    </div>

</main>

<script>
    // Click en módulo → marca/desmarca toda la fila
    document.querySelectorAll('.td-modulo').forEach(td => {
        td.addEventListener('click', () => {
            const cbs = [...td.closest('tr').querySelectorAll('input[type="checkbox"]')];
            const allChecked = cbs.every(cb => cb.checked);
            cbs.forEach(cb => cb.checked = !allChecked);
        });
    });

    // Click en encabezado de permiso → marca/desmarca toda la columna
    document.querySelectorAll('thead th.th-perm').forEach(th => {
        th.addEventListener('click', () => {
            const tipo = th.dataset.tipo;
            const cbs  = [...document.querySelectorAll(`input[name*="[${tipo}]"]`)];
            const allChecked = cbs.every(cb => cb.checked);
            cbs.forEach(cb => cb.checked = !allChecked);
        });
    });
</script>

</body>
</html>
