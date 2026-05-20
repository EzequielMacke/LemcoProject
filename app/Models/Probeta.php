<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'remision_id',
    'concretera', 'fck', 'fecha_moldeo', 'hora_moldeo', 'mixer',
    'edad_ensayo', 'elemento', 'nombre', 'estado',
    'fecha_ensayo', 'defecto', 'carga_rotura', 'tipo_rotura',
    'diametro_superior_1', 'diametro_superior_2',
    'diametro_inferior_1', 'diametro_inferior_2',
    'altura_1', 'altura_2', 'altura_3',
    'ensayo_por',
])]
class Probeta extends Model
{
    protected function casts(): array
    {
        return [
            'fck'                 => 'integer',
            'edad_ensayo'         => 'integer',
            'estado'              => 'integer',
            'tipo_rotura'         => 'integer',
            'fecha_moldeo'        => 'date',
            'fecha_ensayo'        => 'date',
            'carga_rotura'        => 'decimal:2',
            'diametro_superior_1' => 'decimal:2',
            'diametro_superior_2' => 'decimal:2',
            'diametro_inferior_1' => 'decimal:2',
            'diametro_inferior_2' => 'decimal:2',
            'altura_1'            => 'decimal:2',
            'altura_2'            => 'decimal:2',
            'altura_3'            => 'decimal:2',
        ];
    }

    public function remision(): BelongsTo
    {
        return $this->belongsTo(Remision::class);
    }

    public function ensayadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'ensayo_por');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleInforme::class, 'probeta_id');
    }
}
