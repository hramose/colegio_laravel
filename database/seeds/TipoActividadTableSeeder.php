<?php

use Illuminate\Database\Seeder;
use App\App\Entities\TipoActividad;

class TipoActividadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoActividad::create([
                'descripcion' => 'Actividad',
                'aplica_zona' => 1,
                'es_examen' => 0,
                'puntos_extras' => 0,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

        TipoActividad::create([
                'descripcion' => 'Laboratorio',
                'aplica_zona' => 1,
                'es_examen' => 0,
                'puntos_extras' => 0,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

        TipoActividad::create([
                'descripcion' => 'Examen Corto',
                'aplica_zona' => 1,
                'es_examen' => 1,
                'puntos_extras' => 0,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

        TipoActividad::create([
                'descripcion' => 'Examen Parcial',
                'aplica_zona' => 1,
                'es_examen' => 1,
                'puntos_extras' => 0,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

        TipoActividad::create([
                'descripcion' => 'Examen Final',
                'aplica_zona' => 0,
                'es_examen' => 1,
                'puntos_extras' => 0,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);
    }
}
