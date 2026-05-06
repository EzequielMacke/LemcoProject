<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['area_id', 'modulo_id', 'ver', 'agregar', 'editar', 'eliminar'])]
class Permiso extends Model
{
    protected function casts(): array
    {
        return [
            'ver'      => 'integer',
            'agregar'  => 'integer',
            'editar'   => 'integer',
            'eliminar' => 'integer',
        ];
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function modulo(): BelongsTo
    {
        return $this->belongsTo(Modulo::class);
    }
}
