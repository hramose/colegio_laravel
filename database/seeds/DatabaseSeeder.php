<?php

use Illuminate\Database\Seeder;
use App\App\Entities\User;
use App\App\Entities\Perfil;
use App\App\Entities\Ciclo;
use App\App\Entities\Materia;
use App\App\Entities\Grado;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$perfil = Perfil::create([
    		'descripcion' => 'Super Administrador',
    		'estado' => 'A',
    		'created_by' => 'admin',
        	'updated_by' => 'admin'
    	]);

        $user = User::create([
        	'username' => 'admin',
        	'password' => 'admin',
        	'perfil_id' => $perfil->id,
        	'primera_vez' => 1,
        	'estado' => 'A',
        	'created_by' => 'admin',
        	'updated_by' => 'admin'
        ]);

        $anioActual = intval( date('Y') );
        $anio = $anioActual - 1;

        for($i=0;$i<=2;$i++){
        	$ciclo = Ciclo::create([
	        	'descripcion' => $anio,
	        	'fecha_inicio' => $anio.'-01-01',
	        	'fecha_fin' => $anio.'-12-31',
	        	'actual' => $anio == $anioActual ? 1 : 0,
	        	'estado' => 'A',
	        	'created_by' => 'admin',
	        	'updated_by' => 'admin'
	        ]);
        	$anio++;
        }

        $maestros = factory(\App\App\Entities\Persona::class, 10)
        					->states('maestro')->create();

        $materias = ['Matematicas','Idioma Español','Ciencias Naturales','Estudios Sociales'
        ,'Fisica Fundamental','Educación Física','Programación','Computación'];
        foreach($materias as $index => $materia){
        	Materia::create([
        		'descripcion' => $materia,
        		'numero' => $index,
        		'estado' => 'A',
        		'created_by' => 'admin',
	        	'updated_by' => 'admin'
        	]);
        }

        $grados = array(
				        	['Primero Primaria',1,'P'],
				        	['Segundo Primaria',2,'P'],
				        	['Tercero Primaria',3,'P'],
				        	['Cuarto Primaria',4,'P'],
				        	['Quinto Primaria',5,'P'],
				        	['Sexto Primaria',6,'P']
				        );
        foreach($grados as $grado){
        	Grado::create([
        		'descripcion' => $grado[0],
        		'numero' => $grado[1],
        		'nivel_academico' => $grado[2],
        		'estado' => 'A',
        		'created_by' => 'admin',
	        	'updated_by' => 'admin'
        	]);
        }
    }
}
