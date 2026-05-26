<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nombre', 'clave', 'estado', 'tipo_certificacion', 'residente', 'usuario_id'])]
class Obra extends Model
{
    protected function casts(): array
    {
        return [
            'estado'             => 'integer',
            'tipo_certificacion' => 'integer',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}
