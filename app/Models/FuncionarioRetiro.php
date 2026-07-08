<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['descripcion'])]
class FuncionarioRetiro extends Model
{
    public function retiros(): HasMany
    {
        return $this->hasMany(Retiro::class);
    }
}
