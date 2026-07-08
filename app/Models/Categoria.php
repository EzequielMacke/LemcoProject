<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['descripcion'])]
class Categoria extends Model
{
    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }
}
