<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nick', 'contrasena', 'estado', 'envio', 'area_id', 'persona_id'])]
#[Hidden(['contrasena'])]
class Usuario extends Model
{
    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
            'estado' => 'integer',
            'envio'  => 'integer',
        ];
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }
}
