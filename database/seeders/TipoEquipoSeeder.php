<?php

namespace Database\Seeders;

use App\Models\TipoEquipo;
use Illuminate\Database\Seeder;

class TipoEquipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Identificable',
            'No identificable',
        ];

        foreach ($tipos as $descripcion) {
            TipoEquipo::firstOrCreate([
                'descripcion' => $descripcion,
            ]);
        }
    }
}
