<?php

use Illuminate\Database\Seeder;
use App\App\Entities\Modulo;

class ModuloTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modulo::create([
            'descripcion' => 'Administración',
            'estado' => 'A',
            'created_by' => 'admin',
            'updated_by' => 'admin'
        ]);
        Modulo::create([
            'descripcion' => 'Maestros',
            'estado' => 'A',
            'created_by' => 'admin',
            'updated_by' => 'admin'
        ]);
        Modulo::create([
            'descripcion' => 'Estudiantes',
            'estado' => 'A',
            'created_by' => 'admin',
            'updated_by' => 'admin'
        ]);
    }
}
