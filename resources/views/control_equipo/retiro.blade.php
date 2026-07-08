<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retiro de equipos — LemcoProject</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
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
        .page-label   { font-size: 11.5px; font-weight: 600; color: #ea580c; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #c2410c, #ea580c);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(234,88,12,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary svg { width: 14px; height: 14px; }
        .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        .btn-cancel {
            display: inline-flex; align-items: center; gap: 7px;
            background: none; border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 9px 16px; font-size: 13px; font-weight: 500;
            color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; color: #374151; }

        .btn-danger {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #b91c1c, #dc2626);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 10px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(220,38,38,0.3);
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-danger:hover { opacity: 0.9; transform: translateY(-1px); }

        .btn-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 8px;
            border: 1.5px solid #e9ecef; background: #fff;
            cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif;
            padding: 0;
        }
        .btn-icon svg { width: 14px; height: 14px; }
        .btn-icon-delete { color: #dc2626; }
        .btn-icon-delete:hover { background: #fef2f2; border-color: #fecaca; }

        /* ── Alertas ── */
        .alert {
            border-radius: 10px; padding: 12px 16px; font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            animation: fadeUp 0.35s ease both;
        }
        .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; }
        .alert-info    { background: #eff6ff; border: 1.5px solid #bfdbfe; color: #1d4ed8; }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Scanner card ── */
        .scanner-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease 0.04s both;
            display: flex; flex-direction: column; gap: 14px;
        }
        .scanner-head {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
        }
        .scanner-title { font-size: 14px; font-weight: 700; color: #111827; }
        .scanner-sub    { font-size: 12.5px; color: #9ca3af; margin-top: 2px; }

        #qr-reader {
            display: none;
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            border-radius: 14px;
            overflow: hidden;
            border: 1.5px solid #e9ecef;
        }
        #qr-reader.activo { display: block; }
        #qr-reader video { border-radius: 14px; }

        .scanner-placeholder {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 8px; padding: 40px 20px; color: #9ca3af;
            border: 1.5px dashed #e9ecef; border-radius: 14px;
        }
        .scanner-placeholder svg { width: 36px; height: 36px; color: #d1d5db; }
        .scanner-placeholder p { font-size: 13px; }

        /* ── Table card ── */
        .table-card {
            background: #fff;
            border: 1.5px solid #e9ecef;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            animation: fadeUp 0.4s ease 0.08s both;
        }
        .table-card-head {
            padding: 16px 20px;
            border-bottom: 1.5px solid #e9ecef;
            display: flex; align-items: center; justify-content: space-between;
        }
        .table-card-title { font-size: 14px; font-weight: 700; color: #111827; }
        .table-card-count {
            font-size: 11.5px; font-weight: 700; color: #ea580c;
            background: #fff7ed; border-radius: 99px; padding: 3px 10px;
        }

        .table-scroll { overflow-x: auto; }
        table { width: 100%; min-width: 640px; border-collapse: collapse; }
        thead th {
            padding: 12px 16px;
            font-size: 11px; font-weight: 700; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.6px;
            background: #f8fafc;
            border-bottom: 1.5px solid #e9ecef;
            text-align: left;
            white-space: nowrap;
        }
        tbody tr { border-bottom: 1px solid #f1f3f5; }
        tbody tr:last-child { border-bottom: none; }
        tbody td {
            padding: 12px 16px;
            font-size: 13.5px; color: #374151;
            vertical-align: middle;
            white-space: nowrap;
        }
        .td-desc  { font-weight: 500; color: #111827; }
        .td-muted { color: #9ca3af; }
        .th-actions { text-align: right; }
        .td-actions { text-align: right; }

        .empty-state {
            padding: 40px 24px;
            text-align: center; color: #9ca3af;
        }
        .empty-state svg { width: 34px; height: 34px; margin: 0 auto 10px; display: block; color: #d1d5db; }
        .empty-state p { font-size: 13.5px; }

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
            width: 100%; max-width: 420px;
            max-height: calc(100vh - 40px);
            display: flex; flex-direction: column;
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
            flex-shrink: 0;
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

        .modal-body {
            padding: 20px 22px;
            overflow-y: auto;
            display: flex; flex-direction: column; gap: 12px;
        }

        .detalle-row {
            display: flex; justify-content: space-between; align-items: baseline; gap: 12px;
            padding-bottom: 10px; border-bottom: 1px solid #f8fafc;
        }
        .detalle-row:last-child { border-bottom: none; padding-bottom: 0; }
        .detalle-label { font-size: 12px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; flex-shrink: 0; }
        .detalle-value { font-size: 13.5px; font-weight: 600; color: #111827; text-align: right; }
        .detalle-obs { font-size: 12.5px; color: #6b7280; font-style: italic; text-align: right; }

        .modal-foot {
            padding: 16px 22px;
            border-top: 1.5px solid #e9ecef;
            display: flex; justify-content: flex-end; gap: 8px;
            flex-shrink: 0;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .page { padding: 20px 16px 32px; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('control-equipos.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Volver
        </a>
        <div class="nav-sep"></div>
        <span class="navbar-title">Retiro de equipos</span>
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
            <div class="page-label">Control de Equipos</div>
            <div class="page-heading">Retiro</div>
        </div>
    </div>

    {{-- Alerta del escáner (permisos de cámara, QR no encontrado, duplicados) --}}
    <div class="alert alert-error" id="alerta-escaner" style="display: none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        <span id="alerta-escaner-texto">No se pudo acceder a la cámara.</span>
    </div>

    {{-- Escáner --}}
    <div class="scanner-card">
        <div class="scanner-head">
            <div>
                <div class="scanner-title">Escanear código QR</div>
                <div class="scanner-sub">Apuntá la cámara al QR del equipo para agregarlo a la lista de retiro</div>
            </div>
            <button type="button" class="btn-primary" id="btn-escanear" onclick="alternarEscaneo()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5V6a2.25 2.25 0 012.25-2.25h1.5m8.25 0h1.5A2.25 2.25 0 0121 6v1.5m0 9V18a2.25 2.25 0 01-2.25 2.25h-1.5m-8.25 0h-1.5A2.25 2.25 0 013 18v-1.5M3 12h18"/>
                </svg>
                <span id="btn-escanear-texto">Iniciar escaneo</span>
            </button>
        </div>

        <div id="qr-reader"></div>

        <div class="scanner-placeholder" id="scanner-placeholder">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5V6a2.25 2.25 0 012.25-2.25h1.5m8.25 0h1.5A2.25 2.25 0 0121 6v1.5m0 9V18a2.25 2.25 0 01-2.25 2.25h-1.5m-8.25 0h-1.5A2.25 2.25 0 013 18v-1.5M3 12h18"/>
            </svg>
            <p>La cámara aparecerá acá al iniciar el escaneo</p>
        </div>
    </div>

    {{-- Lista de equipos a retirar --}}
    <div class="table-card">
        <div class="table-card-head">
            <span class="table-card-title">Equipos a retirar</span>
            <span class="table-card-count" id="contador-lista">0</span>
        </div>
        <div id="tabla-wrap">
            <div class="empty-state" id="lista-vacia">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125h4.5m-8.25-4.125h12l-.75-3H4.5l-.75 3z"/>
                </svg>
                <p>Todavía no escaneaste ningún equipo</p>
            </div>
            <div class="table-scroll" id="tabla-scroll" style="display: none;">
                <table>
                    <thead>
                        <tr>
                            <th>Identificación</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Categoría</th>
                            <th class="th-actions">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-body"></tbody>
                </table>
            </div>
        </div>
    </div>

</main>

{{-- Modal: Detalle del equipo escaneado --}}
<div class="modal-overlay" id="modal-detalle" onclick="cerrarEnOverlay(event)">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Equipo escaneado</span>
            <button type="button" class="modal-close" onclick="cancelarDetalle()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-body" id="modal-detalle-body">
            <div class="detalle-row">
                <span class="detalle-label">Identificación</span>
                <span class="detalle-value" id="detalle-abreviacion">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Nombre</span>
                <span class="detalle-value" id="detalle-nombre">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Marca</span>
                <span class="detalle-value" id="detalle-marca">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Modelo</span>
                <span class="detalle-value" id="detalle-modelo">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">N° Serie</span>
                <span class="detalle-value" id="detalle-numero-serie">—</span>
            </div>
            <div class="detalle-row">
                <span class="detalle-label">Categoría</span>
                <span class="detalle-value" id="detalle-categoria">—</span>
            </div>
            <div class="detalle-row" id="detalle-obs-row" style="display: none;">
                <span class="detalle-label">Observación</span>
                <span class="detalle-obs" id="detalle-observacion">—</span>
            </div>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn-cancel" onclick="cancelarDetalle()">Cancelar</button>
            <button type="button" class="btn-primary" onclick="confirmarDetalle()">Confirmar</button>
        </div>
    </div>
</div>

<script>
    const urlBuscarQr = @json(route('equipos.buscar-por-qr', ['codigo' => '__CODIGO__']));

    let html5QrCode = null;
    let escaneando = false;
    let procesandoResultado = false;
    let equipoPendiente = null;

    const equiposRetiro = [];

    function mostrarAlertaEscaner(texto) {
        document.getElementById('alerta-escaner-texto').textContent = texto;
        document.getElementById('alerta-escaner').style.display = 'flex';
    }
    function ocultarAlertaEscaner() {
        document.getElementById('alerta-escaner').style.display = 'none';
    }

    function alternarEscaneo() {
        escaneando ? detenerEscaneo() : iniciarEscaneo();
    }

    function iniciarEscaneo() {
        ocultarAlertaEscaner();
        const lector = document.getElementById('qr-reader');
        lector.classList.add('activo');
        document.getElementById('scanner-placeholder').style.display = 'none';

        html5QrCode = new Html5Qrcode('qr-reader');
        html5QrCode.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            onEscaneoExitoso,
            () => {}
        ).then(() => {
            escaneando = true;
            document.getElementById('btn-escanear-texto').textContent = 'Detener escaneo';
        }).catch(() => {
            lector.classList.remove('activo');
            document.getElementById('scanner-placeholder').style.display = 'flex';
            mostrarAlertaEscaner('No se pudo acceder a la cámara. Verificá los permisos del navegador.');
        });
    }

    function detenerEscaneo() {
        if (!html5QrCode) return;
        html5QrCode.stop().then(() => {
            html5QrCode.clear();
            escaneando = false;
            document.getElementById('qr-reader').classList.remove('activo');
            document.getElementById('scanner-placeholder').style.display = 'flex';
            document.getElementById('btn-escanear-texto').textContent = 'Iniciar escaneo';
        });
    }

    function onEscaneoExitoso(codigoDecodificado) {
        if (procesandoResultado) return;
        procesandoResultado = true;

        fetch(urlBuscarQr.replace('__CODIGO__', encodeURIComponent(codigoDecodificado)))
            .then(async (res) => {
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Equipo no encontrado');
                return data;
            })
            .then((equipo) => {
                if (equiposRetiro.some(e => e.id === equipo.id)) {
                    mostrarAlertaEscaner('Ese equipo ya está en la lista de retiro.');
                    procesandoResultado = false;
                    return;
                }
                ocultarAlertaEscaner();
                abrirModalDetalle(equipo);
            })
            .catch((err) => {
                mostrarAlertaEscaner(err.message);
                procesandoResultado = false;
            });
    }

    function abrirModalDetalle(equipo) {
        equipoPendiente = equipo;
        document.getElementById('detalle-abreviacion').textContent  = equipo.abreviacion || '—';
        document.getElementById('detalle-nombre').textContent       = equipo.nombre || '—';
        document.getElementById('detalle-marca').textContent        = equipo.marca || '—';
        document.getElementById('detalle-modelo').textContent       = equipo.modelo || '—';
        document.getElementById('detalle-numero-serie').textContent = equipo.numero_serie || '—';
        document.getElementById('detalle-categoria').textContent    = equipo.categoria || '—';

        const obsRow = document.getElementById('detalle-obs-row');
        if (equipo.observacion) {
            document.getElementById('detalle-observacion').textContent = equipo.observacion;
            obsRow.style.display = 'flex';
        } else {
            obsRow.style.display = 'none';
        }

        document.getElementById('modal-detalle').classList.add('open');
    }

    function cerrarModalDetalle() {
        document.getElementById('modal-detalle').classList.remove('open');
        equipoPendiente = null;
        procesandoResultado = false;
    }

    function cerrarEnOverlay(e) {
        if (e.target === document.getElementById('modal-detalle')) cancelarDetalle();
    }

    function cancelarDetalle() {
        cerrarModalDetalle();
    }

    function confirmarDetalle() {
        if (!equipoPendiente) return;
        equiposRetiro.push(equipoPendiente);
        renderizarLista();
        cerrarModalDetalle();
    }

    function quitarEquipo(id) {
        const idx = equiposRetiro.findIndex(e => e.id === id);
        if (idx !== -1) equiposRetiro.splice(idx, 1);
        renderizarLista();
    }

    function renderizarLista() {
        const cuerpo = document.getElementById('tabla-body');
        const vacio  = document.getElementById('lista-vacia');
        const scroll = document.getElementById('tabla-scroll');

        document.getElementById('contador-lista').textContent = equiposRetiro.length;

        if (equiposRetiro.length === 0) {
            vacio.style.display = 'block';
            scroll.style.display = 'none';
            return;
        }

        vacio.style.display = 'none';
        scroll.style.display = 'block';

        cuerpo.innerHTML = equiposRetiro.map(equipo => `
            <tr>
                <td class="td-muted">${escaparHtml(equipo.abreviacion || '—')}</td>
                <td class="td-desc">${escaparHtml(equipo.nombre || '—')}</td>
                <td>${escaparHtml(equipo.marca || '—')}</td>
                <td>${escaparHtml(equipo.modelo || '—')}</td>
                <td>${escaparHtml(equipo.categoria || '—')}</td>
                <td class="td-actions">
                    <button type="button" class="btn-icon btn-icon-delete" title="Quitar" onclick="quitarEquipo(${equipo.id})">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function escaparHtml(texto) {
        const div = document.createElement('div');
        div.textContent = texto;
        return div.innerHTML;
    }
</script>

</body>
</html>
