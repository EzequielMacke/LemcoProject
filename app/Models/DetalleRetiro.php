<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['retiro_id', 'equipo_id', 'fecha_retiro', 'fecha_devolucion', 'cantidad_retirada', 'cantidad_devuelta'])]
class DetalleRetiro extends Model
{
    protected function casts(): array
    {
        return [
            'fecha_retiro'     => 'date',
            'fecha_devolucion' => 'date',
        ];
    }

    public function retiro(): BelongsTo
    {
        return $this->belongsTo(Retiro::class);
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }
}
