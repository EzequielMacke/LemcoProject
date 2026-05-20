<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; background: #f9fafb; margin: 0; padding: 0; }
        .wrap { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 10px; border: 1px solid #e5e7eb; overflow: hidden; }
        .header { background: #b45309; padding: 24px 32px; }
        .header-label { font-size: 11px; font-weight: bold; color: #fde68a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .header-title { font-size: 20px; font-weight: bold; color: #fff; }
        .body { padding: 28px 32px; }
        .body p { margin: 0 0 14px; line-height: 1.6; color: #374151; }
        .data-row { display: flex; gap: 8px; margin-bottom: 8px; }
        .data-label { font-size: 11px; font-weight: bold; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; min-width: 110px; padding-top: 1px; }
        .data-value { font-size: 13px; font-weight: 600; color: #111827; }
        .divider { border: none; border-top: 1px solid #f1f3f5; margin: 20px 0; }
        .footer { padding: 16px 32px; background: #f8fafc; border-top: 1px solid #f1f3f5; font-size: 11px; color: #9ca3af; }
    </style>
</head>
<body>
@php
    $remision       = $informe->recepcion;
    $primeraProbeta = $informe->detalles->first()?->probeta;
    $fechaEnsayo    = $primeraProbeta?->fecha_ensayo;
    $diasEnsayo     = ($primeraProbeta?->fecha_moldeo && $fechaEnsayo)
        ? $primeraProbeta->fecha_moldeo->diffInDays($fechaEnsayo)
        : null;
@endphp
<div class="wrap">
    <div class="header">
        <div class="header-label">Informe de ensayo de compresión</div>
        <div class="header-title">{{ $obra->nombre }}</div>
    </div>
    <div class="body">
        <p>Se adjunta el informe de ensayo de compresión simple de probetas cilíndricas con los siguientes datos:</p>

        <div class="data-row">
            <span class="data-label">Obra</span>
            <span class="data-value">{{ $obra->nombre }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Peticionario</span>
            <span class="data-value">{{ $remision->contratista ?? '—' }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Fecha de ensayo</span>
            <span class="data-value">{{ $fechaEnsayo?->format('d/m/Y') ?? '—' }}</span>
        </div>
        @if($diasEnsayo !== null)
        <div class="data-row">
            <span class="data-label">Días de ensayo</span>
            <span class="data-value">{{ $diasEnsayo }} días</span>
        </div>
        @endif
        <div class="data-row">
            <span class="data-label">Probetas</span>
            <span class="data-value">{{ $informe->detalles->count() }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Fecha de emisión</span>
            <span class="data-value">{{ now()->format('d/m/Y') }}</span>
        </div>

        <hr class="divider">
        <p style="font-size:12px; color:#6b7280;">El PDF con el informe completo se encuentra adjunto a este correo.</p>
    </div>
    <div class="footer">LEMCO &mdash; Laboratorio de Ensayos de Materiales y Control de Obras</div>
</div>
</body>
</html>
