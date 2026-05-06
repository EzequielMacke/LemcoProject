<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nro', 'obra_id', 'contratista', 'estado', 'observacion', 'entregado_por', 'recibio_por'])]
class Remision extends Model
{
    protected $table = 'remisiones';

    protected function casts(): array
    {
        return [
            'estado' => 'integer',
        ];
    }

    public function obra(): BelongsTo
    {
        return $this->belongsTo(Obra::class);
    }

    public function recibidoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'recibio_por');
    }

    public function probetas(): HasMany
    {
        return $this->hasMany(Probeta::class);
    }
}
