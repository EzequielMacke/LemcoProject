<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['descripcion', 'abreviacion'])]
class Modulo extends Model
{
    public function permisos(): HasMany
    {
        return $this->hasMany(Permiso::class);
    }
}
