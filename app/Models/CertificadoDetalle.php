<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Detalle de un certificado.
 *
 * Según el tipo de certificación de la obra:
 *   - tipo 1 (por remisión): remision_id  tiene valor, informe_id es null.
 *   - tipo 2 (por informe):  informe_id   tiene valor, remision_id es null.
 */
#[Fillable(['certificado_id', 'remision_id', 'informe_id'])]
class CertificadoDetalle extends Model
{
    protected $table = 'certificado_detalles';

    protected function casts(): array
    {
        return [
            'certificado_id' => 'integer',
            'remision_id'    => 'integer',
            'informe_id'     => 'integer',
        ];
    }

    public function certificado(): BelongsTo
    {
        return $this->belongsTo(Certificado::class);
    }

    /** Disponible cuando tipo_certificacion === 1 */
    public function remision(): BelongsTo
    {
        return $this->belongsTo(Remision::class);
    }

    /** Disponible cuando tipo_certificacion === 2 */
    public function informe(): BelongsTo
    {
        return $this->belongsTo(ProbetaInforme::class, 'informe_id');
    }
}
