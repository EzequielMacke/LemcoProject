<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $remision       = $informe->recepcion;
        $primeraProbeta = $informe->detalles->first()?->probeta;
        $fechaEnsayo    = $primeraProbeta?->fecha_ensayo;
    @endphp
    <title>Informe #{{ $nroInforme }} — {{ $obra->nombre }}</title>
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
        .navbar-title { font-size: 14px; font-weight: 600; color: #111827; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .navbar-user { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 500; color: #374151; background: #f1f3f5; border: 1.5px solid #e9ecef; padding: 4px 11px 4px 5px; border-radius: 99px; }
        .user-chip { width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #1e40af, #1d4ed8); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0; }

        .page { flex: 1; padding: 28px 24px 48px; display: flex; flex-direction: column; gap: 24px; }

        /* Header */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; animation: fadeUp 0.35s ease both; flex-wrap: wrap; }
        .page-label { font-size: 11.5px; font-weight: 600; color: #d97706; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .page-heading { font-size: 20px; font-weight: 700; color: #0f172a; letter-spacing: -0.3px; }
        .page-sub { font-size: 13px; color: #6b7280; margin-top: 3px; }

        /* Badge estado */
        .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 99px; }
        .badge svg { width: 11px; height: 11px; }
        .badge-pendiente    { background: #fffbeb; color: #d97706; border: 1.5px solid #fde68a; }
        .badge-enviado      { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
        .badge-verificado   { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
        .badge-certificado  { background: #f5f3ff; color: #6d28d9; border: 1.5px solid #ddd6fe; }

        /* Botones acción */
        .header-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .btn-pdf {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 9px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none;
            box-shadow: 0 3px 10px rgba(29,78,216,0.3);
            transition: opacity 0.15s, transform 0.15s;
        }
        .btn-pdf:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-pdf svg { width: 14px; height: 14px; }
        .btn-verificar {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #15803d, #16a34a);
            color: #fff; font-size: 13px; font-weight: 600;
            border: none; border-radius: 10px; padding: 9px 18px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 3px 10px rgba(21,128,61,0.3);
            transition: opacity 0.15s, transform 0.15s;
        }
        .btn-verificar:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-verificar svg { width: 14px; height: 14px; }
        .btn-email {
            display: inline-flex; align-items: center; gap: 7px;
            background: #fff; color: #374151;
            border: 1.5px solid #e9ecef; border-radius: 10px;
            padding: 8px 16px; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s; cursor: pointer; flex-shrink: 0;
        }
        .btn-email:hover { background: #f8f9fa; border-color: #d1d5db; color: #111827; }
        .btn-email svg { width: 15px; height: 15px; }

        /* Modal enviar */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.35); display: none; align-items: center; justify-content: center; z-index: 100; padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 18px; width: 100%; max-width: 480px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); animation: modalIn 0.2s ease both; display: flex; flex-direction: column; max-height: 90vh; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(10px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .modal-head { padding: 18px 20px 14px; border-bottom: 1px solid #f1f3f5; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .modal-title { font-size: 15px; font-weight: 700; color: #0f172a; }
        .modal-close { display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; border: 1.5px solid #e9ecef; background: none; cursor: pointer; color: #9ca3af; transition: all 0.15s; padding: 0; }
        .modal-close:hover { background: #f1f3f5; color: #374151; }
        .modal-close svg { width: 14px; height: 14px; }
        .modal-body { padding: 16px 20px; overflow-y: auto; flex: 1; }
        .modal-foot { padding: 14px 20px; border-top: 1.5px solid #e9ecef; display: flex; justify-content: flex-end; gap: 8px; flex-shrink: 0; }
        .group-label { font-size: 10.5px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; margin-top: 4px; }
        .group-label:not(:first-child) { margin-top: 18px; }
        .recipient-row { display: flex; align-items: center; gap: 12px; padding: 9px 12px; border-radius: 10px; border: 1.5px solid #e9ecef; margin-bottom: 6px; cursor: pointer; transition: background 0.12s, border-color 0.12s; background: #fff; }
        .recipient-row:hover { background: #f8faff; border-color: #c7d2fe; }
        .recipient-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: #4f46e5; flex-shrink: 0; cursor: pointer; }
        .recipient-info { flex: 1; min-width: 0; }
        .recipient-name { display: block; font-size: 13px; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .recipient-email { display: block; font-size: 11.5px; color: #6b7280; }
        .recipient-no-email { font-size: 11.5px; color: #fca5a5; font-style: italic; }
        .empty-group { font-size: 12.5px; color: #9ca3af; padding: 8px 0; font-style: italic; }
        .btn-cancel { display: inline-flex; align-items: center; background: none; border: 1.5px solid #e9ecef; border-radius: 10px; padding: 8px 16px; font-size: 13px; font-weight: 500; color: #6b7280; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s; }
        .btn-cancel:hover { background: #f8f9fa; border-color: #d1d5db; }
        .btn-send { display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #4338ca, #4f46e5); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 10px; padding: 9px 18px; cursor: pointer; font-family: 'Inter', sans-serif; box-shadow: 0 3px 10px rgba(79,70,229,0.3); transition: opacity 0.15s; }
        .btn-send:hover { opacity: 0.9; }
        .btn-send svg { width: 14px; height: 14px; }

        .btn-pendiente {
            display: inline-flex; align-items: center; gap: 7px;
            background: none; border: 1.5px solid #d1d5db; border-radius: 10px;
            padding: 8px 16px; font-size: 13px; font-weight: 500; color: #6b7280;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.15s;
        }
        .btn-pendiente:hover { background: #f1f3f5; border-color: #9ca3af; color: #374151; }
        .btn-pendiente svg { width: 14px; height: 14px; }

        /* Grupo de info */
        .info-card { background: #fff; border: 1.5px solid #e9ecef; border-radius: 14px; padding: 20px 24px; animation: fadeUp 0.35s ease 0.05s both; }
        .info-card-title { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.7px; margin-bottom: 16px; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px 24px; }
        .info-field label { display: block; font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-field span { font-size: 13.5px; color: #111827; font-weight: 500; }

        /* Tabla */
        .table-card { background: #fff; border: 1.5px solid #e9ecef; border-radius: 14px; overflow: hidden; animation: fadeUp 0.4s ease 0.1s both; }
        .table-card-title { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.7px; padding: 16px 20px 12px; border-bottom: 1.5px solid #e9ecef; }
        .table-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        thead th { padding: 10px 14px; text-align: left; font-size: 10.5px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.6px; background: #f8fafc; border-bottom: 1.5px solid #e9ecef; }
        thead th.th-num { width: 40px; text-align: center; }
        tbody tr { border-bottom: 1px solid #f1f3f5; }
        tbody tr:last-child { border-bottom: none; }
        tbody td { padding: 11px 14px; font-size: 12.5px; color: #374151; vertical-align: middle; }
        .td-num { text-align: center; font-weight: 700; color: #9ca3af; font-size: 12px; }
        .td-mono { font-variant-numeric: tabular-nums; }
        .td-empty { color: #d1d5db; font-style: italic; font-size: 12px; }

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
        <span class="navbar-title">Informe #{{ $nroInforme }} — {{ $obra->nombre }}</span>
    </div>
    <div class="navbar-user">
        <div class="user-chip">{{ strtoupper(substr(session('usuario.nick'), 0, 1)) }}</div>
        {{ session('usuario.nick') }}
    </div>
</nav>

<main class="page">

    <div class="page-header">
        <div>
            <div class="page-label">Informe de ensayo</div>
            <div class="page-heading">Remisión {{ $remision->nro ?? '—' }}</div>
            <div class="page-sub">{{ $obra->nombre }}</div>
        </div>
        <div class="header-actions">
            {{-- Badges: izquierda --}}
            @if(!$informe->verificado && !$informe->enviado && !$esCertificado)
                <span class="badge badge-pendiente">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Pendiente
                </span>
            @endif
            @if($informe->verificado)
                <span class="badge badge-verificado">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Verificado
                </span>
            @endif
            @if($informe->enviado)
                <span class="badge badge-enviado">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                    Enviado
                </span>
            @endif
            @if($esCertificado)
                <span class="badge badge-certificado">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Certificado
                </span>
            @endif

            {{-- Botones: derecha --}}
            @if($informe->verificado)
                @if(!$esCertificado)
                @permiso('INF', 'editar')
                <form method="POST" action="{{ route('informes.pendiente', [$obra, $informe]) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-pendiente">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                        Marcar como pendiente
                    </button>
                </form>
                @endpermiso
                @endif
                <button type="button" class="btn-email" onclick="abrirModal('modal-enviar')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    Enviar por correo
                </button>
                <a href="{{ route('informes.pdf', [$obra, $informe]) }}" class="btn-pdf">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Descargar PDF
                </a>
            @else
                @if(!$esCertificado)
                @permiso('INF', 'editar')
                <form method="POST" action="{{ route('informes.verificar', [$obra, $informe]) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-verificar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Verificar
                    </button>
                </form>
                @endpermiso
                @endif
            @endif
        </div>
    </div>

    {{-- Grupo 1: Datos generales --}}
    <div class="info-card">
        <div class="info-card-title">Datos generales</div>
        <div class="info-grid">
            <div class="info-field">
                <label>Fecha de recepción</label>
                <span>{{ $remision?->created_at?->format('d/m/Y') ?? '—' }}</span>
            </div>
            <div class="info-field">
                <label>Peticionario</label>
                <span>{{ $remision->contratista ?? '—' }}</span>
            </div>
            <div class="info-field">
                <label>Contacto</label>
                <span>{{ $obra->residente ?? '—' }}</span>
            </div>
            <div class="info-field">
                <label>Obra</label>
                <span>{{ $obra->nombre }}</span>
            </div>
            <div class="info-field">
                <label>Fecha de ensayo</label>
                <span>{{ $fechaEnsayo?->format('d/m/Y') ?? '—' }}</span>
            </div>
            <div class="info-field">
                <label>Fecha de emisión</label>
                <span>{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Grupo 2: Tabla de probetas --}}
    <div class="table-card">
        <div class="table-card-title">Probetas ensayadas</div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th class="th-num">#</th>
                        <th>Nombre</th>
                        <th>Elemento</th>
                        <th>Fecha moldeo</th>
                        <th>Edad (días)</th>
                        <th>Carga rotura</th>
                        <th>Sección</th>
                        <th>Altura</th>
                        <th>Diámetro</th>
                        <th>Tensión rotura</th>
                        <th>H/D</th>
                        <th>C(H/D)</th>
                        <th>Tensión corregida</th>
                        <th>Tensión promedio</th>
                        <th>Tipo rotura</th>
                        <th>Defecto</th>
                    </tr>
                </thead>
                @php
                    // Pre-calcular todos los valores por fila
                    $rows = $informe->detalles->map(function ($detalle) {
                        $p = $detalle->probeta;

                        $dProm = $seccion = null;
                        if ($p->diametro_superior_1 !== null && $p->diametro_superior_2 !== null
                            && $p->diametro_inferior_1 !== null && $p->diametro_inferior_2 !== null) {
                            $dProm   = ($p->diametro_superior_1 + $p->diametro_superior_2 + $p->diametro_inferior_1 + $p->diametro_inferior_2) / 4;
                            $seccion = M_PI * ($dProm / 2) ** 2;
                        }

                        $altura = null;
                        if ($p->altura_1 !== null && $p->altura_2 !== null && $p->altura_3 !== null) {
                            $altura = ($p->altura_1 + $p->altura_2 + $p->altura_3) / 3;
                        }

                        $tension = ($seccion !== null && $seccion > 0 && $p->carga_rotura !== null)
                            ? $p->carga_rotura / $seccion * 1000 : null;

                        $hd = ($altura !== null && $dProm !== null && $dProm > 0)
                            ? min($altura / $dProm, 2) : null;

                        $chd = null;
                        if ($hd !== null) {
                            if      ($hd <= 1.00) $chd = 0.8700;
                            elseif  ($hd <= 1.25) $chd = 0.8700 + ($hd - 1.00) * 0.24;
                            elseif  ($hd <= 1.50) $chd = 0.9300 + ($hd - 1.25) * 0.12;
                            elseif  ($hd <= 1.75) $chd = 0.9600 + ($hd - 1.50) * 0.08;
                            else                  $chd = 1.0000;
                        }

                        $tensionCorregida = ($tension !== null && $chd !== null) ? $tension * $chd : null;
                        $noSatisfactoria  = in_array($p->tipo_rotura, [5, 6]);

                        return [
                            'probeta'          => $p,
                            'dProm'            => $dProm,
                            'seccion'          => $seccion,
                            'altura'           => $altura,
                            'tension'          => $tension,
                            'hd'               => $hd,
                            'chd'              => $chd,
                            'tensionCorregida' => $tensionCorregida,
                            'noSatisfactoria'  => $noSatisfactoria,
                            'mixer'            => $p->mixer ?? '__sin_mixer__',
                        ];
                    });

                    // Agrupar por mixer — excluir tipo 5 o 6 del promedio
                    $rowsConPromedio = $rows
                        ->groupBy('mixer')
                        ->flatMap(function ($grupo) {
                            $validos  = $grupo->filter(fn($r) => $r['tensionCorregida'] !== null && !$r['noSatisfactoria'])->pluck('tensionCorregida');
                            $promedio = $validos->isNotEmpty() ? $validos->avg() : null;
                            $span     = $grupo->count();
                            return $grupo->values()->map(function ($row, $idx) use ($promedio, $span) {
                                $row['tensionPromedio'] = $promedio;
                                $row['rowspan']         = $idx === 0 ? $span : 0;
                                return $row;
                            });
                        })
                        ->values();
                @endphp
                <tbody>
                    @foreach($rowsConPromedio as $i => $row)
                    @php $p = $row['probeta']; @endphp
                    <tr>
                        <td class="td-num">
                            {{ $i + 1 }}
                        </td>
                        <td>{{ $p->nombre ?? '—' }}@if($row['noSatisfactoria'])<span style="color:#dc2626;font-weight:700;">*</span>@endif</td>
                        <td>{{ $p->elemento ?? '—' }}</td>
                        <td class="td-mono">{{ $p->fecha_moldeo?->format('d/m/Y') ?? '—' }}</td>
                        <td class="td-mono">{{ ($p->fecha_moldeo && $p->fecha_ensayo) ? $p->fecha_moldeo->diffInDays($p->fecha_ensayo) : '—' }}</td>
                        <td class="td-mono">{{ $p->carga_rotura !== null ? number_format($p->carga_rotura, 2).' kN' : '—' }}</td>
                        <td class="td-mono">{{ $row['seccion'] !== null ? number_format($row['seccion'], 2) : '—' }}</td>
                        <td class="td-mono">{{ $row['altura'] !== null ? number_format($row['altura'], 2) : '—' }}</td>
                        <td class="td-mono">{{ $row['dProm'] !== null ? number_format($row['dProm'], 2) : '—' }}</td>
                        <td class="td-mono">{{ $row['tension'] !== null ? number_format($row['tension'], 2) : '—' }}</td>
                        <td class="td-mono">{{ $row['hd'] !== null ? number_format($row['hd'], 2) : '—' }}</td>
                        <td class="td-mono">{{ $row['chd'] !== null ? number_format($row['chd'], 4) : '—' }}</td>
                        <td class="td-mono">{{ $row['tensionCorregida'] !== null ? number_format($row['tensionCorregida'], 2) : '—' }}</td>
                        @if($row['rowspan'] > 0)
                        <td class="td-mono" rowspan="{{ $row['rowspan'] }}" style="vertical-align:middle; text-align:center; background:#f8fafc; font-weight:600;">
                            {{ $row['tensionPromedio'] !== null ? number_format($row['tensionPromedio'], 2) : '—' }}
                        </td>
                        @endif
                        <td class="td-mono">{{ $p->tipo_rotura ?? '—' }}</td>
                        <td>{{ $p->defecto ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</main>

{{-- ═══ MODAL: Enviar por correo ═══ --}}
<div class="modal-overlay" id="modal-enviar" onclick="cerrarEnOverlay(event,'modal-enviar')">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-title">Enviar informe por correo</span>
            <button type="button" class="modal-close" onclick="cerrarModal('modal-enviar')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('informes.enviar', [$obra, $informe]) }}">
            @csrf
            <div class="modal-body">
                <div class="group-label">Usuarios del sistema</div>
                @forelse($usuarios as $usuario)
                @php
                    $uNombre = trim(($usuario->persona->nombre ?? '') . ' ' . ($usuario->persona->apellido ?? ''));
                    $uCorreo = $usuario->persona->correo ?? null;
                @endphp
                <label class="recipient-row" style="{{ $uCorreo ? '' : 'opacity:0.55;' }}">
                    <input type="checkbox" name="usuarios[]" value="{{ $usuario->id }}" {{ $uCorreo ? 'checked' : 'disabled' }}>
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

                <div class="group-label">Contactos de la obra</div>
                @forelse($contactos as $contacto)
                <label class="recipient-row" style="{{ $contacto->correo ? '' : 'opacity:0.55;' }}">
                    <input type="checkbox" name="contactos[]" value="{{ $contacto->id }}" {{ $contacto->correo ? 'checked' : 'disabled' }}>
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
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
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
