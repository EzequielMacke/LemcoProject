<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'obra_id',
    'recepcion_id',
    'estado',
    'enviado',
    'verificado',
])]
class ProbetaInforme extends Model
{
    protected function casts(): array
    {
        return [
            'estado'     => 'integer',
            'enviado'    => 'integer',
            'verificado' => 'integer',
        ];
    }

    public function obra(): BelongsTo
    {
        return $this->belongsTo(Obra::class);
    }

    public function recepcion(): BelongsTo
    {
        return $this->belongsTo(Remision::class, 'recepcion_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleInforme::class, 'informe_id');
    }
}
