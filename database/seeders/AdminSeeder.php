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
        $area = Area::firstOrCreate([
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
            ['descripcion' => 'Pendientes',                 'abreviacion' => 'PEN'],
        ];

        foreach ($modulos as $data) {
            $modulo = Modulo::firstOrCreate([
                'abreviacion' => $data['abreviacion'],
            ], $data);

            // Permiso de acceso total para el área administrador
            Permiso::firstOrCreate([
                'area_id'   => $area->id,
                'modulo_id' => $modulo->id,
            ], [
                'ver'      => 1,
                'agregar'  => 1,
                'editar'   => 1,
                'eliminar' => 1,
            ]);
        }

        // Usuario admin
        Usuario::firstOrCreate([
            'nick' => 'admin',
        ], [
            'contrasena' => '#Paraguari1_',
            'estado'     => 1,
            'envio'      => 0,
            'area_id'    => $area->id,
            'persona_id' => null,
        ]);
    }
}
