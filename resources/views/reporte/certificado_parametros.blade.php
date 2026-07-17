<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de certificados — LemcoProject</title>
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
        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 24px; align-items: center; }

        /* ── Page header ── */
        .page-header { width: 100%; max-width: 620px; animation: fadeUp 0.35s ease both; }
        .page-label   { font-size: 11.5px; font-weight: 600; color: #16a34a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Card / Sección ── */
        .section-card {
            width: 100%; max-width: 620px;
            background: #fff; border: 1.5px solid #e9ecef; border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            animation: fadeUp 0.38s ease 0.05s both;
        }
        .section-title {
            font-size: 13px; font-weight: 700; color: #374151;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid #f1f3f5;
            display: flex; align-items: center; gap: 8px;
        }
        .section-title svg { width: 15px; height: 15px; color: #16a34a; }

        /* ── Fields grid ── */
        .fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px; }
        .field-full  { grid-column: 1 / -1; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 600; color: #374151; }
        .field select,
        .field input {
            width: 100%; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 13px; font-size: 13.5px; color: #111827;
            background: #fafafa; outline: none; font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field select:focus,
        .field input:focus { border-color: #16a34a; background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,0.1); }
        .field-hint { font-size: 11.5px; color: #9ca3af; }

        /* ── Toggle rango / mes ── */
        .modo-toggle {
            display: inline-flex; background: #f1f3f5; border: 1.5px solid #e9ecef;
            border-radius: 10px; padding: 3px; gap: 3px; margin-bottom: 4px;
        }
        .modo-btn {
            border: none; background: none; border-radius: 8px;
            padding: 7px 14px; font-size: 12.5px; font-weight: 600;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .modo-btn.activo { background: #fff; color: #15803d; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .modo-panel { display: none; }
        .modo-panel.activo { display: contents; }

        /* ── Footer actions ── */
        .form-actions {
            width: 100%; max-width: 620px;
            display: flex; align-items: center; justify-content: flex-end; gap: 10px;
            animation: fadeUp 0.42s ease 0.1s both;
        }
        .btn-cancel {
            display: inline-flex; align-items: center;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 10px 18px; font-size: 13px; font-weight: 500;
            color: #6b7280; text-decoration: none; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #15803d, #16a34a);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 22px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(22,163,74,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary svg { width: 14px; height: 14px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            .page { padding: 20px 16px 40px; }
            .fields-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('reporte.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Reportes
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Reporte de certificados</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-label">Reportes</div>
        <div class="page-heading">Certificados por obra y fecha</div>
    </div>

    <form method="GET" action="{{ route('reporte.certificado.pdf') }}" target="_blank" style="width:100%; display:flex; flex-direction:column; align-items:center; gap:24px;">

        <div class="section-card">
            <div class="section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
                Parámetros del reporte
            </div>
            <div class="fields-grid">
                <div class="field field-full">
                    <label for="obra_buscar">Obra</label>
                    <input
                        type="text"
                        id="obra_buscar"
                        list="lista-obras"
                        placeholder="Escriba para filtrar o deje vacío para todas las obras"
                        autocomplete="off"
                        oninput="actualizarObraId()"
                        onchange="actualizarObraId()"
                    >
                    <datalist id="lista-obras">
                        @foreach($obras as $obra)
                            <option data-id="{{ $obra->id }}" value="{{ $obra->nombre }}">
                        @endforeach
                    </datalist>
                    <input type="hidden" id="obra_id" name="obra_id" value="">
                    <span class="field-hint">Dejá el campo vacío para incluir certificados de cualquier obra.</span>
                </div>

                <div class="field field-full">
                    <label>Período</label>
                    <div class="modo-toggle">
                        <button type="button" class="modo-btn activo" id="btn-modo-rango" onclick="cambiarModo('rango')">Rango de fechas</button>
                        <button type="button" class="modo-btn" id="btn-modo-mes" onclick="cambiarModo('mes')">Por mes</button>
                    </div>
                </div>

                <div class="modo-panel activo fields-grid" id="panel-rango" style="grid-column: 1 / -1; padding: 0;">
                    <div class="field">
                        <label for="fecha_desde">Fecha desde</label>
                        <input type="date" id="fecha_desde" name="fecha_desde">
                    </div>

                    <div class="field">
                        <label for="fecha_hasta">Fecha hasta</label>
                        <input type="date" id="fecha_hasta" name="fecha_hasta">
                    </div>
                </div>

                <div class="modo-panel" id="panel-mes" style="grid-column: 1 / -1; padding: 0;">
                    <div class="field field-full">
                        <label for="mes">Mes</label>
                        <input type="month" id="mes" name="mes" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('reporte.index') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l-6-6m6 6l6-6"/>
                </svg>
                Generar PDF
            </button>
        </div>

    </form>

</main>

<script>
    function cambiarModo(modo) {
        const esRango = modo === 'rango';

        document.getElementById('panel-rango').classList.toggle('activo', esRango);
        document.getElementById('panel-mes').classList.toggle('activo', !esRango);
        document.getElementById('btn-modo-rango').classList.toggle('activo', esRango);
        document.getElementById('btn-modo-mes').classList.toggle('activo', !esRango);

        document.getElementById('fecha_desde').disabled = !esRango;
        document.getElementById('fecha_hasta').disabled = !esRango;
        document.getElementById('mes').disabled = esRango;
    }

    function actualizarObraId() {
        const input   = document.getElementById('obra_buscar');
        const hidden  = document.getElementById('obra_id');
        const options = document.querySelectorAll('#lista-obras option');
        let encontrado = '';
        options.forEach(function (opt) {
            if (opt.value === input.value) encontrado = opt.dataset.id;
        });
        hidden.value = encontrado;
    }
</script>

</body>
</html>
