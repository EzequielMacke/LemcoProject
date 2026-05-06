<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áreas — LemcoProject</title>
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

        .nav-sep { width: 1px; height: 18px; background: #e9ecef; }
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
        .page-label   { font-size: 11.5px; font-weight: 600; color: #15803d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #166534, #15803d);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(21,128,61,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary svg { width: 14px; height: 14px; }

        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 16px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }

        .btn-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 8px;
            border: 1.5px solid #e9ecef; background: #fff;
            cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif;
            padding: 0;
        }
        .btn-icon svg { width: 14px; height: 14px; }

        .btn-icon-edit  { color: #1d4ed8; }
        .btn-icon-edit:hover  { background: #eff6ff; border-color: #bfdbfe; }

        .btn-icon-anular  { color: #b45309; }
        .btn-icon-anular:hover  { background: #fffbeb; border-color: #fde68a; }

        .btn-icon-activar { color: #15803d; }
        .btn-icon-activar:hover { background: #f0fdf4; border-color: #bbf7d0; }

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
        .td-actions { width: 80px; text-align: right; }
        .td-actions-inner { display: flex; gap: 6px; justify-content: flex-end; }

        /* ── Estado badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 600; padding: 4px 10px;
            border-radius: 99px;
        }
        .badge svg { width: 7px; height: 7px; }
        .badge-activa   { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-anulada  { background: #f8fafc; color: #9ca3af; border: 1.5px solid #e9ecef; }

        /* ── Empty state ── */
        .empty-state {
            padding: 56px 24px;
            text-align: center; color: #9ca3af;
        }
        .empty-state svg { width: 40px; height: 40px; margin: 0 auto 12px; display: block; color: #d1d5db; }
        .empty-state p   { font-size: 14px; }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.35);
            display: none; align-items: center; justify-content: center;
            z-index: 100; padding: 20px;
        }
        .modal-overlay.open { display: flex; }

        .modal {
            background: #fff;
            border-radius: 18px;
            width: 100%; max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            animation: modalIn 0.2s ease both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-head {
            padding: 20px 22px 16px;
            border-bottom: 1px solid #f1f3f5;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-title { font-size: 15px; font-weight: 700; color: #0f172a; }

        .modal-close {
            display: flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 8px;
            border: 1.5px solid #e9ecef; background: none;
            cursor: pointer; color: #9ca3af; transition: all 0.15s;
            padding: 0;
        }
        .modal-close:hover { background: #f1f3f5; color: #374151; }
        .modal-close svg { width: 14px; height: 14px; }

        .modal-body { padding: 20px 22px; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }
        .field input {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field input:focus {
            border-color: #15803d; background: #fff;
            box-shadow: 0 0 0 3px rgba(21,128,61,0.1);
        }
        .field input.is-invalid { border-color: #f87171; }
        .field-error { font-size: 12px; color: #be123c; }

        .modal-foot {
            padding: 16px 22px;
            border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
            .td-id, .th-id { display: none; }
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
        <span class="navbar-title">Áreas</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    @php
        $permsAre      = session('permisos', [])['are'] ?? [];
        $puedeAgregar  = $permsAre['agregar']  ?? false;
        $puedeEditar   = $permsAre['editar']   ?? false;
        $puedeEliminar = $permsAre['eliminar'] ?? false;
    @endphp

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-label">Módulo</div>
            <div class="page-heading">Áreas</div>
        </div>
        @if($puedeAgregar)
        <button class="btn-primary" onclick="abrirModalAgregar()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Nueva área
        </button>
        @endif
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
    <div class="table-card">
        @if($areas->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
            </svg>
            <p>No hay áreas registradas</p>
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th class="th-id">#</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    @if($puedeEditar || $puedeEliminar)
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
                    @if($puedeEditar || $puedeEliminar)
                    <td class="td-actions">
                        <div class="td-actions-inner">
                            @if($puedeEditar)
                            <button
                                class="btn-icon btn-icon-edit"
                                title="Editar"
                                data-id="{{ $area->id }}"
                                data-descripcion="{{ $area->descripcion }}"
                                onclick="abrirModalEditar(this)"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                </svg>
                            </button>
                            @endif
                            @if($puedeEliminar)
                            <form method="POST" action="{{ route('areas.toggleEstado', $area) }}">
                                @csrf
                                @method('PATCH')
                                @if($area->estado === 1)
                                <button type="submit" class="btn-icon btn-icon-anular" title="Anular">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </button>
                                @else
                                <button type="submit" class="btn-icon btn-icon-activar" title="Activar">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                                @endif
                            </form>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</main>

{{-- Modal: Agregar --}}
@if($puedeAgregar)
<div class="modal-overlay" id="modal-agregar" onclick="cerrarEnOverlay(event, 'modal-agregar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Nueva área</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-agregar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('areas.store') }}">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label for="inp-nueva">Descripción</label>
                    <input
                        type="text"
                        id="inp-nueva"
                        name="descripcion"
                        value="{{ old('descripcion') }}"
                        placeholder="Ej: Sistemas"
                        autocomplete="off"
                        class="{{ $errors->has('descripcion') && !old('_method') ? 'is-invalid' : '' }}"
                    >
                    @if($errors->has('descripcion') && !old('_method'))
                        <span class="field-error">{{ $errors->first('descripcion') }}</span>
                    @endif
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-agregar')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal: Editar --}}
@if($puedeEditar)
<div class="modal-overlay" id="modal-editar" onclick="cerrarEnOverlay(event, 'modal-editar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Editar área</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-editar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="form-editar" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="area_id" id="inp-edit-id">
            <div class="modal-body">
                <div class="field">
                    <label for="inp-editar">Descripción</label>
                    <input
                        type="text"
                        id="inp-editar"
                        name="descripcion"
                        placeholder="Ej: Sistemas"
                        autocomplete="off"
                        class="{{ $errors->has('descripcion') && old('_method') === 'PUT' ? 'is-invalid' : '' }}"
                    >
                    @if($errors->has('descripcion') && old('_method') === 'PUT')
                        <span class="field-error">{{ $errors->first('descripcion') }}</span>
                    @endif
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="cerrarModal('modal-editar')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    function abrirModal(id) {
        document.getElementById(id).classList.add('open');
    }
    function cerrarModal(id) {
        document.getElementById(id).classList.remove('open');
    }
    function cerrarEnOverlay(e, id) {
        if (e.target === document.getElementById(id)) cerrarModal(id);
    }

    function abrirModalAgregar() {
        abrirModal('modal-agregar');
        setTimeout(() => document.getElementById('inp-nueva').focus(), 50);
    }

    function abrirModalEditar(btn) {
        const id          = btn.dataset.id;
        const descripcion = btn.dataset.descripcion;
        document.getElementById('inp-edit-id').value  = id;
        document.getElementById('inp-editar').value   = descripcion;
        document.getElementById('form-editar').action = '/areas/' + id;
        abrirModal('modal-editar');
        setTimeout(() => document.getElementById('inp-editar').focus(), 50);
    }

    // Reabrir modal correcto si hubo error de validación
    document.addEventListener('DOMContentLoaded', () => {
        @if($errors->any() && old('_method') === 'PUT')
            const areaId = @json(old('area_id'));
            const desc   = @json(old('descripcion', ''));
            document.getElementById('inp-editar').value   = desc;
            document.getElementById('form-editar').action = '/areas/' + areaId;
            abrirModal('modal-editar');
        @elseif($errors->any() && !old('_method'))
            abrirModal('modal-agregar');
        @endif
    });
</script>

</body>
</html>
