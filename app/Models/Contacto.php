<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nombre', 'apellido', 'correo', 'estado', 'usuario_id', 'obra_id'])]
class Contacto extends Model
{
    protected function casts(): array
    {
        return [
            'estado' => 'integer',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function obra(): BelongsTo
    {
        return $this->belongsTo(Obra::class);
    }
}
