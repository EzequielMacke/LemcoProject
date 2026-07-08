<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['obra_retiro_id', 'funcionario_retiro_id', 'usuario_id', 'fecha_retiro', 'fecha_devolucion'])]
class Retiro extends Model
{
    protected function casts(): array
    {
        return [
            'fecha_retiro'     => 'date',
            'fecha_devolucion' => 'date',
        ];
    }

    public function obraRetiro(): BelongsTo
    {
        return $this->belongsTo(ObraRetiro::class);
    }

    public function funcionarioRetiro(): BelongsTo
    {
        return $this->belongsTo(FuncionarioRetiro::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleRetiro::class);
    }
}
