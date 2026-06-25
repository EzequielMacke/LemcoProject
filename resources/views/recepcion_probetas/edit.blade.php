<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar remisión — {{ $remision->nro }} — {{ $obra->nombre }}</title>
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
        .page {
            flex: 1; padding: 28px 24px 48px;
            display: flex; flex-direction: column; gap: 24px;
        }

        /* ── Header ── */
        .page-header { animation: fadeUp 0.35s ease both; }
        .page-label { font-size: 11.5px; font-weight: 600; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }
        .page-nro { font-family: 'Courier New', monospace; font-size: 13px; font-weight: 700; color: #4f46e5; margin-top: 2px; }
        .page-sub { font-size: 13px; color: #6b7280; margin-top: 3px; }

        /* ── Alerta ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-error { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Sección ── */
        .section {
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 16px;
            overflow: hidden; animation: fadeUp 0.35s ease 0.05s both;
        }
        .section-head {
            padding: 14px 20px; border-bottom: 1px solid #f1f3f5;
            display: flex; align-items: center; gap: 10px;
        }
        .section-icon {
            width: 32px; height: 32px; border-radius: 9px;
            background: #eef2ff; display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .section-icon svg { width: 16px; height: 16px; color: #4f46e5; }
        .section-title { font-size: 14px; font-weight: 700; color: #0f172a; flex: 1; }

        /* ── Sección 1: datos ── */
        .section-body-datos {
            padding: 20px; display: flex; flex-direction: column; gap: 14px;
        }
        .datos-row { display: flex; align-items: flex-start; gap: 16px; }
        .field { display: flex; flex-direction: column; gap: 5px; }
        .field-nro { flex: 0 0 160px; }
        .field-contratista { flex: 1; }
        .field-entregado { flex: 0 0 200px; }
        .field-observacion { flex: 1; }
        .field label {
            font-size: 12px; font-weight: 600; color: #374151;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .field label span { color: #ef4444; margin-left: 2px; }
        .field input, .field textarea {
            border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 13px; font-size: 13.5px; color: #111827;
            font-family: 'Inter', sans-serif; background: #fff;
            outline: none; transition: border-color 0.15s, box-shadow 0.15s;
            width: 100%;
        }
        .field input:focus, .field textarea:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .field input::placeholder, .field textarea::placeholder { color: #9ca3af; }
        .field input.is-invalid, .field textarea.is-invalid { border-color: #fca5a5; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
        .field textarea { resize: none; height: 38px; line-height: 1.4; }
        .field-error { font-size: 11.5px; color: #ef4444; }
        .field-hint { font-size: 11.5px; color: #9ca3af; }
        .input-nro { font-family: 'Courier New', monospace; font-size: 15px; font-weight: 700; letter-spacing: 2px; color: #0f172a; }

        /* ── Botón agregar mixer ── */
        .btn-agregar {
            display: inline-flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #c7d2fe; border-radius: 8px;
            padding: 6px 12px; font-size: 12.5px; font-weight: 600;
            color: #4f46e5; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s; flex-shrink: 0;
        }
        .btn-agregar:hover { background: #eef2ff; border-color: #a5b4fc; }
        .btn-agregar svg { width: 13px; height: 13px; }

        /* ── Grupos ── */
        .grupos-wrap {
            display: flex; flex-direction: column;
            gap: 12px; padding: 0;
        }
        .grupos-wrap.con-grupos { padding: 16px 16px 0; }

        .empty-muestras {
            padding: 40px 20px; text-align: center; color: #9ca3af;
            display: flex; flex-direction: column; align-items: center; gap: 10px;
        }
        .empty-muestras svg { width: 36px; height: 36px; color: #d1d5db; }
        .empty-muestras p { font-size: 13px; }

        /* ── Grupo ── */
        .grupo {
            display: flex; align-items: stretch;
            border: 1.5px solid #e9ecef; border-radius: 12px;
            overflow: hidden; position: relative;
        }

        /* Panel izquierdo: campos del mixer */
        .grupo-left {
            width: 340px; flex-shrink: 0;
            border-right: 1.5px solid #e9ecef;
            background: #fafbff;
            display: flex; flex-direction: column;
        }

        /* Filas dentro del panel izquierdo */
        .gl-row {
            display: flex; align-items: stretch;
            border-bottom: 1px solid #f1f3f5;
            flex-shrink: 0;
        }
        .gl-row:last-child { border-bottom: none; }

        .gl-field {
            padding: 10px 13px;
            display: flex; flex-direction: column; gap: 5px;
            flex: 1;
        }
        .gl-field + .gl-field { border-left: 1px solid #f1f3f5; }

        .gl-field-header {
            display: flex; align-items: center; justify-content: space-between; gap: 4px;
        }
        .gl-label {
            font-size: 10.5px; font-weight: 600; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.5px;
            white-space: nowrap;
        }
        .gl-req { color: #ef4444; margin-left: 2px; }
        .btn-copiar {
            width: 16px; height: 16px; border-radius: 4px;
            border: 1px solid #e5e7eb; background: none;
            cursor: pointer; color: #9ca3af;
            display: flex; align-items: center; justify-content: center;
            padding: 0; transition: all 0.15s; flex-shrink: 0;
        }
        .btn-copiar:hover { border-color: #a5b4fc; color: #4f46e5; background: #eef2ff; }
        .btn-copiar svg { width: 9px; height: 9px; }

        /* Inputs compactos del panel */
        .gl-input {
            border: 1.5px solid #e9ecef; border-radius: 7px;
            padding: 6px 9px; font-size: 13px; color: #111827;
            font-family: 'Inter', sans-serif; background: #fff;
            outline: none; width: 100%;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .gl-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .gl-input::placeholder { color: #b0b7c3; font-size: 12px; }
        .gl-input-mixer {
            font-family: 'Courier New', monospace;
            font-weight: 700; letter-spacing: 1px; font-size: 13px;
        }
        .gl-input-cant { text-align: center; font-weight: 700; }
        .gl-input-fck  { text-align: center; font-weight: 600; }

        /* Anchos fijos para campos pequeños */
        .gl-field-cant  { flex: 0 0 72px; }
        .gl-field-fck   { flex: 0 0 80px; }
        .gl-field-hora  { flex: 0 0 110px; }

        /* Panel derecho: nombres de muestras */
        .grupo-muestras { flex: 1; display: flex; flex-direction: column; }
        .muestra-row {
            display: flex; align-items: center; gap: 12px;
            padding: 8px 14px; min-height: 44px;
            border-bottom: 1px solid #f8fafc;
        }
        .muestra-row:last-child { border-bottom: none; }
        .muestra-nombre {
            font-family: 'Courier New', monospace; font-size: 13px; font-weight: 700;
            color: #4338ca; background: #eef2ff;
            padding: 3px 10px; border-radius: 6px;
            min-width: 96px; text-align: center; letter-spacing: 0.5px;
            flex-shrink: 0;
        }
        .muestra-edad-wrap {
            display: flex; align-items: center; gap: 6px;
        }
        .muestra-edad-label {
            font-size: 11px; color: #9ca3af; font-weight: 500; white-space: nowrap;
        }
        .muestra-edad-input {
            border: 1.5px solid #e9ecef; border-radius: 7px;
            padding: 5px 8px; font-size: 13px; font-weight: 600; color: #111827;
            font-family: 'Inter', sans-serif; background: #fff;
            outline: none; width: 64px; text-align: center;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .muestra-edad-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .muestra-edad-suffix {
            font-size: 11px; color: #9ca3af; font-weight: 500;
        }

        /* Botón eliminar grupo */
        .btn-eliminar-grupo {
            position: absolute; top: 8px; right: 8px;
            width: 22px; height: 22px; border-radius: 6px;
            border: 1.5px solid #e9ecef; background: #fff;
            cursor: pointer; color: #9ca3af;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s; padding: 0;
        }
        .btn-eliminar-grupo:hover { border-color: #fca5a5; color: #be123c; background: #fff1f2; }
        .btn-eliminar-grupo svg { width: 11px; height: 11px; }

        /* ── Footer sección muestras ── */
        .section-foot {
            padding: 12px 16px;
            border-top: 1px solid #f1f3f5;
        }

        /* ── Footer form ── */
        .form-foot {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            animation: fadeUp 0.35s ease 0.1s both;
        }
        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 18px; font-size: 13px; font-weight: 500;
            color: #6b7280; text-decoration: none; transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }
        .btn-submit {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #4338ca, #4f46e5);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 9px 20px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(79,70,229,0.3);
            transition: opacity 0.15s;
        }
        .btn-submit:hover { opacity: 0.9; }
        .btn-submit svg { width: 15px; height: 15px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Mobile ── */
        @media (max-width: 640px) {
            .navbar { padding: 0 16px; }
            .page { padding: 20px 16px 36px; gap: 20px; }
            .datos-row { flex-direction: column; }
            .field-nro, .field-entregado { flex: unset; width: 100%; }
            .grupo { flex-direction: column; }
            .grupo-left { width: 100%; border-right: none; border-bottom: 1.5px solid #e9ecef; }
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

    <div class="page-header">
        <div class="page-label">Recepción de probetas</div>
        <div class="page-heading">Editar remisión</div>
        <div class="page-nro">{{ $remision->nro }}</div>
        <div class="page-sub">{{ $obra->nombre }}</div>
    </div>

    @if($errors->any())
    <div class="alert alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        Revisá los campos marcados antes de continuar.
    </div>
    @endif

    <form method="POST" action="{{ route('remisiones.update', [$obra, $remision]) }}" id="form-remision">
        @csrf
        @method('PUT')

        {{-- Sección 1: Datos de la remisión --}}
        <div class="section">
            <div class="section-head">
                <div class="section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                </div>
                <span class="section-title">Datos de la remisión</span>
            </div>
            <div class="section-body-datos">
                <div class="datos-row">
                    <div class="field field-nro">
                        <label>N° remisión <span>*</span></label>
                        <input
                            type="text"
                            name="nro"
                            value="{{ old('nro', $remision->nro) }}"
                            class="input-nro {{ $errors->has('nro') ? 'is-invalid' : '' }}"
                            maxlength="7" pattern="\d{7}"
                            autocomplete="off" inputmode="numeric"
                            oninput="formatearNro(this)" required
                        >
                        @error('nro')
                            <span class="field-error">{{ $message }}</span>
                        @else
                            <span class="field-hint">Formato: 0000000</span>
                        @enderror
                    </div>
                    <div class="field field-contratista">
                        <label>Contratista <span>*</span></label>
                        <input
                            type="text"
                            name="contratista"
                            value="{{ old('contratista', $remision->contratista) }}"
                            placeholder="Nombre del contratista"
                            class="{{ $errors->has('contratista') ? 'is-invalid' : '' }}"
                            autocomplete="off" required
                        >
                        @error('contratista')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="datos-row">
                    <div class="field field-entregado">
                        <label>Entregado por <span>*</span></label>
                        <input
                            type="text"
                            name="entregado_por"
                            value="{{ old('entregado_por', $remision->entregado_por) }}"
                            placeholder="Nombre de quien entrega"
                            autocomplete="off" required
                        >
                    </div>
                    <div class="field field-observacion">
                        <label>Observación</label>
                        <textarea
                            name="observacion"
                            placeholder="Observaciones adicionales..."
                        >{{ old('observacion', $remision->observacion) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección 2: Muestras --}}
        <div class="section">
            <div class="section-head">
                <div class="section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/>
                    </svg>
                </div>
                <span class="section-title">Muestras</span>
                <button type="button" class="btn-agregar" onclick="agregarGrupo()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Agregar
                </button>
            </div>
            <div class="grupos-wrap" id="grupos-container">
                <div class="empty-muestras" id="empty-muestras">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M5 14.5h14"/>
                    </svg>
                    <p>Todavía no hay muestras cargadas</p>
                </div>
            </div>
            <div class="section-foot" id="section-foot-agregar" style="display:none">
                <button type="button" class="btn-agregar" onclick="agregarGrupo()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Agregar
                </button>
            </div>
        </div>

        <div class="form-foot">
            <a href="{{ route('remisiones.index', $obra) }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Guardar cambios
            </button>
        </div>

    </form>

</main>

<script>
    let grupoCont = 0;

    function formatearNro(input) {
        input.value = input.value.replace(/\D/g, '').slice(0, 7);
    }

    function formatearFck(input) {
        input.value = input.value.replace(/\D/g, '').slice(0, 2);
    }

    function agregarGrupo(inicial = null) {
        const id = ++grupoCont;
        const container = document.getElementById('grupos-container');
        document.getElementById('empty-muestras').style.display = 'none';
        container.classList.add('con-grupos');
        document.getElementById('section-foot-agregar').style.display = '';

        const hoy = new Date().toISOString().split('T')[0];

        const div = document.createElement('div');
        div.className = 'grupo';
        div.id = `grupo-${id}`;
        div.innerHTML = `
            <div class="grupo-left">

                <div class="gl-row">
                    <div class="gl-field">
                        <span class="gl-label">Mixer <span class="gl-req">*</span></span>
                        <input type="text" name="grupos[${id}][mixer]"
                            class="gl-input gl-input-mixer"
                            placeholder="N° mixer" autocomplete="off" required
                            oninput="actualizarGrupo(${id})">
                    </div>
                    <div class="gl-field gl-field-cant">
                        <span class="gl-label">Muestras <span class="gl-req">*</span></span>
                        <input type="number" name="grupos[${id}][cant]"
                            class="gl-input gl-input-cant"
                            min="1" max="26" value="1" required
                            oninput="actualizarGrupo(${id})">
                    </div>
                </div>

                <div class="gl-row">
                    <div class="gl-field">
                        <div class="gl-field-header">
                            <span class="gl-label">Concretera <span class="gl-req">*</span></span>
                            <button type="button" class="btn-copiar" onclick="copiarCampo('concretera', ${id})" title="Copiar a todos">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                        <input type="text" name="grupos[${id}][concretera]"
                            class="gl-input" placeholder="Nombre concretera" autocomplete="off" required>
                    </div>
                </div>

                <div class="gl-row">
                    <div class="gl-field gl-field-fck">
                        <div class="gl-field-header">
                            <span class="gl-label">Fck (MPa) <span class="gl-req">*</span></span>
                            <button type="button" class="btn-copiar" onclick="copiarCampo('fck', ${id})" title="Copiar a todos">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                        <input type="number" name="grupos[${id}][fck]"
                            class="gl-input gl-input-fck"
                            placeholder="25" min="1" max="99" step="1" inputmode="numeric"
                            maxlength="2" oninput="formatearFck(this)" required>
                    </div>
                    <div class="gl-field">
                        <div class="gl-field-header">
                            <span class="gl-label">Elemento <span class="gl-req">*</span></span>
                            <button type="button" class="btn-copiar" onclick="copiarCampo('elemento', ${id})" title="Copiar a todos">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                        <input type="text" name="grupos[${id}][elemento]"
                            class="gl-input" placeholder="Ej: Losa, Viga..." autocomplete="off" required>
                    </div>
                </div>

                <div class="gl-row">
                    <div class="gl-field">
                        <div class="gl-field-header">
                            <span class="gl-label">Fecha de moldeo <span class="gl-req">*</span></span>
                            <button type="button" class="btn-copiar" onclick="copiarCampo('fecha_moldeo', ${id})" title="Copiar a todos">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                        <input type="date" name="grupos[${id}][fecha_moldeo]"
                            class="gl-input" value="${hoy}" required>
                    </div>
                    <div class="gl-field gl-field-hora">
                        <div class="gl-field-header">
                            <span class="gl-label">Hora <span class="gl-req">*</span></span>
                            <button type="button" class="btn-copiar" onclick="copiarCampo('hora_moldeo', ${id})" title="Copiar a todos">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                        <input type="time" name="grupos[${id}][hora_moldeo]"
                            class="gl-input" required>
                    </div>
                </div>

            </div>

            <div class="grupo-muestras" id="muestras-${id}"></div>

            <button type="button" class="btn-eliminar-grupo" onclick="eliminarGrupo(${id})" title="Quitar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        container.appendChild(div);

        if (inicial) {
            div.querySelector('.gl-input-mixer').value = inicial.mixer;
            div.querySelector(`[name="grupos[${id}][concretera]"]`).value = inicial.concretera;
            div.querySelector(`[name="grupos[${id}][fck]"]`).value = inicial.fck;
            div.querySelector(`[name="grupos[${id}][elemento]"]`).value = inicial.elemento;
            div.querySelector(`[name="grupos[${id}][fecha_moldeo]"]`).value = inicial.fecha_moldeo;
            div.querySelector(`[name="grupos[${id}][hora_moldeo]"]`).value = inicial.hora_moldeo;
            div.querySelector('.gl-input-cant').value = inicial.muestras.length;
        } else {
            div.querySelector('.gl-input-mixer').focus();
        }

        actualizarGrupo(id);

        if (inicial) {
            inicial.muestras.forEach((muestra, i) => {
                const input = div.querySelector(`[data-idx="${i}"]`);
                if (input) input.value = muestra.edad_ensayo;
            });
        }
    }

    function actualizarGrupo(id) {
        const grupo = document.getElementById(`grupo-${id}`);
        const mixer = grupo.querySelector('.gl-input-mixer').value.trim();
        const cant  = Math.min(Math.max(parseInt(grupo.querySelector('.gl-input-cant').value) || 1, 1), 26);
        const panel = document.getElementById(`muestras-${id}`);

        const edadesActuales = {};
        panel.querySelectorAll('.muestra-edad-input').forEach(input => {
            edadesActuales[input.dataset.idx] = input.value;
        });

        panel.innerHTML = '';
        for (let i = 0; i < cant; i++) {
            const letra  = String.fromCharCode(65 + i);
            const nombre = mixer ? `${mixer}-${letra}` : `-${letra}`;
            const edad   = edadesActuales[i] ?? '';
            const row = document.createElement('div');
            row.className = 'muestra-row';
            row.innerHTML = `
                <span class="muestra-nombre">${nombre}</span>
                <div class="muestra-edad-wrap">
                    <span class="muestra-edad-label">Edad ensayo <span style="color:#ef4444">*</span></span>
                    <input
                        type="number"
                        name="grupos[${id}][muestras][${i}][edad_ensayo]"
                        class="muestra-edad-input"
                        data-idx="${i}"
                        value="${edad}"
                        min="1" step="1" inputmode="numeric"
                        placeholder="—" required
                    >
                    <span class="muestra-edad-suffix">días</span>
                </div>
            `;
            panel.appendChild(row);
        }
    }

    function copiarCampo(campo, idOrigen) {
        const origen = document.querySelector(`[name="grupos[${idOrigen}][${campo}]"]`);
        if (!origen) return;
        const valor = origen.value;
        document.querySelectorAll(`.grupo`).forEach(grupo => {
            const input = grupo.querySelector(`input[name*="[${campo}]"]`);
            if (input) input.value = valor;
        });
        origen.focus();
    }

    function eliminarGrupo(id) {
        document.getElementById(`grupo-${id}`).remove();
        const container = document.getElementById('grupos-container');
        if (!container.querySelector('.grupo')) {
            container.classList.remove('con-grupos');
            document.getElementById('empty-muestras').style.display = '';
            document.getElementById('section-foot-agregar').style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const gruposIniciales = @json($grupos);
        gruposIniciales.forEach(g => agregarGrupo(g));
    });
</script>

</body>
</html>
