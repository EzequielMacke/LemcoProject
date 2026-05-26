<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['obra_id', 'precio_unitario', 'señores', 'atte', 'verificado', 'enviado'])]
class Certificado extends Model
{
    protected function casts(): array
    {
        return [
            'precio_unitario' => 'decimal:2',
            'verificado'      => 'integer',
            'enviado'         => 'integer',
        ];
    }

    public function obra(): BelongsTo
    {
        return $this->belongsTo(Obra::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(CertificadoDetalle::class);
    }
}
