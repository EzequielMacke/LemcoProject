<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar certificado #{{ $nroCertificado }} — {{ $obra->nombre }}</title>
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
        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 24px; }

        /* ── Page header ── */
        .page-header { animation: fadeUp 0.35s ease both; }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #059669; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Alertas ── */
        .alert { border-radius: 10px; padding: 12px 16px; font-size: 13px; display: flex; align-items: center; gap: 10px; }
        .alert-error { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Section card ── */
        .section-card { background: #fff; border: 1.5px solid #e9ecef; border-radius: 16px; padding: 22px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); animation: fadeUp 0.38s ease 0.05s both; }
        .section-title { font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1.5px solid #f1f3f5; display: flex; align-items: center; gap: 8px; }
        .section-title svg { width: 15px; height: 15px; color: #059669; }

        /* ── Fields ── */
        .fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px; }
        .field-full  { grid-column: 1 / -1; }
        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }
        .field input { width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px; padding: 10px 13px; font-size: 13.5px; color: #111827; background: #fafafa; outline: none; font-family: 'Inter', sans-serif; transition: border-color 0.15s, box-shadow 0.15s, background 0.15s; }
        .field input:focus { border-color: #059669; background: #fff; box-shadow: 0 0 0 3px rgba(5,150,105,0.1); }
        .field input.is-invalid { border-color: #f87171; }
        .field-error { font-size: 12px; color: #be123c; }

        /* ── Tabla ── */
        .table-section { animation: fadeUp 0.4s ease 0.1s both; }
        .table-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 10px; }
        .table-label { font-size: 13px; font-weight: 700; color: #374151; display: flex; align-items: center; gap: 8px; }
        .table-label svg { width: 15px; height: 15px; color: #059669; }
        .table-header-right { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .items-count { font-size: 12px; font-weight: 600; color: #059669; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 3px 10px; border-radius: 99px; }

        /* Leyenda */
        .leyenda { display: flex; align-items: center; gap: 12px; font-size: 11.5px; color: #6b7280; }
        .leyenda-item { display: flex; align-items: center; gap: 5px; }
        .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .dot-actual { background: #059669; }
        .dot-nuevo  { background: #0369a1; }

        .table-wrap { border: 1.5px solid #e9ecef; border-radius: 14px; overflow: hidden; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f8fafc; border-bottom: 1.5px solid #e9ecef; }
        thead th { padding: 10px 16px; font-size: 11.5px; font-weight: 700; color: #6b7280; text-align: left; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid #f1f3f5; transition: background 0.12s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover:not(.excluido) { background: #fafafa; }
        tbody tr.excluido { opacity: 0.35; background: #f8fafc; }
        td { padding: 12px 16px; font-size: 13px; color: #374151; vertical-align: middle; }
        td.td-nro { font-weight: 700; color: #0f172a; }
        td.td-center { text-align: center; }

        /* indicador lateral de fila actual */
        tbody tr.es-actual { border-left: 3px solid #059669; }
        tbody tr.es-nuevo  { border-left: 3px solid #0ea5e9; }

        .badge-nuevo { display: inline-flex; align-items: center; font-size: 10px; font-weight: 700; color: #0369a1; background: #e0f2fe; border: 1px solid #bae6fd; padding: 2px 7px; border-radius: 99px; margin-left: 6px; vertical-align: middle; }

        /* ── Btns excluir/incluir ── */
        .btn-excluir { display: inline-flex; align-items: center; gap: 5px; background: none; border: 1.5px solid #fecdd3; border-radius: 8px; padding: 5px 10px; font-size: 12px; font-weight: 600; color: #be123c; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s; white-space: nowrap; }
        .btn-excluir:hover { background: #fff1f2; }
        .btn-excluir svg { width: 12px; height: 12px; }
        .btn-restaurar { display: none; align-items: center; gap: 5px; background: none; border: 1.5px solid #bbf7d0; border-radius: 8px; padding: 5px 10px; font-size: 12px; font-weight: 600; color: #15803d; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s; white-space: nowrap; }
        .btn-restaurar:hover { background: #f0fdf4; }
        .btn-restaurar svg { width: 12px; height: 12px; }
        tbody tr.excluido .btn-excluir  { display: none; }
        tbody tr.excluido .btn-restaurar { display: inline-flex; }

        .table-empty { padding: 36px; text-align: center; color: #9ca3af; font-size: 13px; }
        .table-empty svg { width: 32px; height: 32px; margin: 0 auto 10px; display: block; color: #d1d5db; }

        .alert-items-vacio { display: none; background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; border-radius: 10px; padding: 10px 14px; font-size: 12.5px; font-weight: 500; margin-top: 10px; }
        .alert-items-vacio.visible { display: block; }

        /* ── Footer actions ── */
        .form-actions { display: flex; align-items: center; justify-content: flex-end; gap: 10px; animation: fadeUp 0.42s ease 0.15s both; }
        .btn-cancel { display: inline-flex; align-items: center; background: none; border: 1.5px solid #e9ecef; border-radius: 10px; padding: 10px 18px; font-size: 13px; font-weight: 500; color: #6b7280; text-decoration: none; font-family: 'Inter', sans-serif; transition: all 0.15s; }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }
        .btn-primary { display: inline-flex; align-items: center; gap: 7px; background: linear-gradient(135deg, #047857, #059669); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 10px; padding: 10px 22px; cursor: pointer; font-family: 'Inter', sans-serif; box-shadow: 0 3px 10px rgba(5,150,105,0.3); transition: opacity 0.15s, transform 0.1s; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary svg { width: 14px; height: 14px; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 640px) { .page { padding: 20px 16px 40px; } .fields-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('certificacion.show', [$obra, $certificado]) }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Certificado #{{ $nroCertificado }}
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Editar certificado</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    @php
        $tipoCert   = $obra->tipo_certificacion;
        $labelItem  = $tipoCert === 1 ? 'remisión' : 'informe';
        $labelItems = $tipoCert === 1 ? 'Remisiones' : 'Informes';
    @endphp

    <div class="page-header">
        <div class="page-label">Certificación — {{ $obra->nombre }}</div>
        <div class="page-heading">Editar certificado #{{ $nroCertificado }}</div>
    </div>

    @if($errors->any())
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('certificacion.update', [$obra, $certificado]) }}" id="form-cert">
        @csrf
        @method('PUT')

        {{-- Cabecera --}}
        <div class="section-card">
            <div class="section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                Datos del certificado
            </div>
            <div class="fields-grid">
                <div class="field">
                    <label for="precio_unitario">Precio unitario</label>
                    <input type="number" id="precio_unitario" name="precio_unitario"
                        value="{{ old('precio_unitario', $certificado->precio_unitario) }}"
                        placeholder="0.00" step="0.01" min="0" autocomplete="off"
                        class="{{ $errors->has('precio_unitario') ? 'is-invalid' : '' }}">
                    @error('precio_unitario')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="atte">Atte.</label>
                    <input type="text" id="atte" name="atte"
                        value="{{ old('atte', $certificado->atte) }}"
                        placeholder="Nombre / firma" autocomplete="off"
                        class="{{ $errors->has('atte') ? 'is-invalid' : '' }}">
                    @error('atte')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field field-full">
                    <label for="señores">Señores</label>
                    <input type="text" id="señores" name="señores"
                        value="{{ old('señores', $certificado->señores) }}"
                        placeholder="Destinatario del certificado" autocomplete="off"
                        class="{{ $errors->has('señores') ? 'is-invalid' : '' }}">
                    @error('señores')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        {{-- Tabla de ítems --}}
        <div class="table-section">
            <div class="table-header">
                <div class="table-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
                    </svg>
                    {{ $labelItems }} del certificado
                </div>
                <div class="table-header-right">
                    <div class="leyenda">
                        <div class="leyenda-item"><div class="dot dot-actual"></div> Ya incluido</div>
                        <div class="leyenda-item"><div class="dot dot-nuevo"></div> Nuevo disponible</div>
                    </div>
                    <span class="items-count" id="items-count">
                        {{ $items->count() }} incluido{{ $items->count() !== 1 ? 's' : '' }}
                    </span>
                </div>
            </div>

            @if($items->isEmpty())
                <div class="table-wrap">
                    <div class="table-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        No hay {{ $labelItem }}s disponibles
                    </div>
                </div>
            @else
                <div class="table-wrap">
                    <table id="tabla-items">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ $tipoCert === 1 ? 'Remisión' : 'Informe' }}</th>
                                <th>Fecha</th>
                                <th>{{ $tipoCert === 1 ? 'Contratista' : 'Recepción' }}</th>
                                <th class="td-center">Probetas</th>
                                <th class="td-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $i => $item)
                            @php $esActual = $idsActuales->contains($item->id); @endphp
                            <tr data-id="{{ $item->id }}" class="{{ $esActual ? 'es-actual' : 'es-nuevo' }}">
                                <input type="hidden" name="items[]" value="{{ $item->id }}" class="input-item">

                                <td class="td-nro">{{ $i + 1 }}</td>

                                @if($tipoCert === 1)
                                    <td class="td-nro">
                                        Rem. {{ str_pad($item->nro, 4, '0', STR_PAD_LEFT) }}
                                        @if(!$esActual)<span class="badge-nuevo">Nuevo</span>@endif
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $item->contratista ?? '—' }}</td>
                                    <td class="td-center">{{ $item->probetas_count }}</td>
                                @else
                                    <td class="td-nro">
                                        Informe #{{ $nrosInformes[$item->id] ?? $item->id }}
                                        @if(!$esActual)<span class="badge-nuevo">Nuevo</span>@endif
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $item->recepcion ? 'Rem. '.str_pad($item->recepcion->nro, 4, '0', STR_PAD_LEFT) : '—' }}</td>
                                    <td class="td-center">{{ $item->detalles_count }}</td>
                                @endif

                                <td class="td-center">
                                    <button type="button" class="btn-excluir" onclick="excluir(this)">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Excluir
                                    </button>
                                    <button type="button" class="btn-restaurar" onclick="restaurar(this)">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Incluir
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="alert-items-vacio" id="alert-items-vacio">
                    Debe incluir al menos un ítem para guardar el certificado.
                </div>
            @endif
        </div>

        {{-- Acciones --}}
        <div class="form-actions">
            <a href="{{ route('certificacion.show', [$obra, $certificado]) }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Guardar cambios
            </button>
        </div>

    </form>

</main>

<script>
    function actualizarContador() {
        const total   = document.querySelectorAll('#tabla-items tbody tr:not(.excluido)').length;
        const el      = document.getElementById('items-count');
        const alertEl = document.getElementById('alert-items-vacio');
        if (el) el.textContent = total + ' incluido' + (total !== 1 ? 's' : '');
        if (alertEl) alertEl.classList.toggle('visible', total === 0);
    }

    function excluir(btn) {
        const tr = btn.closest('tr');
        tr.querySelector('.input-item').disabled = true;
        tr.classList.add('excluido');
        actualizarContador();
    }

    function restaurar(btn) {
        const tr = btn.closest('tr');
        tr.querySelector('.input-item').disabled = false;
        tr.classList.remove('excluido');
        actualizarContador();
    }

    document.getElementById('form-cert')?.addEventListener('submit', function (e) {
        const incluidos = document.querySelectorAll('#tabla-items tbody tr:not(.excluido)').length;
        if (incluidos === 0) {
            e.preventDefault();
            const alertEl = document.getElementById('alert-items-vacio');
            if (alertEl) { alertEl.classList.add('visible'); alertEl.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
        }
    });
</script>

</body>
</html>
