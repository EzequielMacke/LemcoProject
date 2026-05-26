<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Modulo;
use App\Models\Permiso;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Área
        $area = Area::create([
            'descripcion' => 'Administrador',
        ]);

        // Módulos
        $modulos = [
            ['descripcion' => 'Datos Personas',             'abreviacion' => 'DAT'],
            ['descripcion' => 'Areas',                      'abreviacion' => 'ARE'],
            ['descripcion' => 'Permisos',                   'abreviacion' => 'PER'],
            ['descripcion' => 'Usuarios',                   'abreviacion' => 'USU'],
            ['descripcion' => 'Obras',                      'abreviacion' => 'OBR'],
            ['descripcion' => 'Contactos',                  'abreviacion' => 'CON'],
            ['descripcion' => 'Recepcion de probetas',      'abreviacion' => 'RPB'],
            ['descripcion' => 'Ensayos de Compresion',      'abreviacion' => 'ENS'],
            ['descripcion' => 'Informe de probetas',        'abreviacion' => 'INF'],
            ['descripcion' => 'Certificación',              'abreviacion' => 'CER'],
        ];

        foreach ($modulos as $data) {
            $modulo = Modulo::create($data);

            // Permiso de acceso total para el área administrador
            Permiso::create([
                'area_id'   => $area->id,
                'modulo_id' => $modulo->id,
                'ver'      => 1,
                'agregar'  => 1,
                'editar'   => 1,
                'eliminar' => 1,
            ]);
        }

        // Usuario admin
        Usuario::create([
            'nick'       => 'admin',
            'contrasena' => 'admin',
            'estado'     => 1,
            'envio'      => 0,
            'area_id'    => $area->id,
            'persona_id' => null,
        ]);
    }
}
