<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; background: #f9fafb; margin: 0; padding: 0; }
        .wrap { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 10px; border: 1px solid #e5e7eb; overflow: hidden; }
        .header { background: #047857; padding: 24px 32px; }
        .header-label { font-size: 11px; font-weight: bold; color: #a7f3d0; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
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
<div class="wrap">
    <div class="header">
        <div class="header-label">Certificado de control de hormigonado</div>
        <div class="header-title">{{ $obra->nombre }}</div>
    </div>
    <div class="body">
        <p>Se adjunta el certificado de control de hormigonado con los siguientes datos:</p>

        <div class="data-row">
            <span class="data-label">Certificado</span>
            <span class="data-value">#{{ str_pad($nroCertificado, 3, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Obra</span>
            <span class="data-value">{{ $obra->nombre }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Señores</span>
            <span class="data-value">{{ $certificado->señores }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Ítems</span>
            <span class="data-value">{{ $certificado->detalles->count() }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Fecha</span>
            <span class="data-value">{{ $certificado->created_at->format('d/m/Y') }}</span>
        </div>

        <hr class="divider">
        <p style="font-size:12px; color:#6b7280;">El PDF con el certificado completo se encuentra adjunto a este correo.</p>
    </div>
    <div class="footer">LEMCO &mdash; Laboratorio de Ensayos de Materiales y Control de Obras</div>
</div>
</body>
</html>
