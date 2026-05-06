<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['nombre', 'apellido', 'fecha_nacimiento', 'correo', 'ci', 'cargo', 'titulo'])]
class Persona extends Model
{
    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class);
    }
}
