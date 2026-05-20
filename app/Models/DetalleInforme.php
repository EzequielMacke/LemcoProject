<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'informe_id',
    'probeta_id',
])]
class DetalleInforme extends Model
{
    public function informe(): BelongsTo
    {
        return $this->belongsTo(ProbetaInforme::class, 'informe_id');
    }

    public function probeta(): BelongsTo
    {
        return $this->belongsTo(Probeta::class);
    }
}
