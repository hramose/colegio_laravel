<?php

use Illuminate\Database\Seeder;
use App\App\Entities\Perfil;

class PerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfilSuperAdmin = Perfil::create([
    		'descripcion' => 'Super Administrador',
    		'estado' => 'A',
    		'created_by' => 'admin',
        	'updated_by' => 'admin'
    	]);

        $perfilAdmin = Perfil::create([
            'descripcion' => 'Administrador',
            'estado' => 'A',
            'created_by' => 'admin',
            'updated_by' => 'admin'
        ]);

        $perfilMaestro = Perfil::create([
            'descripcion' => 'Maestro',
            'estado' => 'A',
            'created_by' => 'admin',
            'updated_by' => 'admin'
        ]);

        $perfilEstudiante = Perfil::create([
            'descripcion' => 'Estudiante',
            'estado' => 'A',
            'created_by' => 'admin',
            'updated_by' => 'admin'
        ]);
    }
}
