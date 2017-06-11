<?php

use Illuminate\Database\Seeder;
use App\App\Entities\User;
use App\App\Entities\Persona;
use App\App\Entities\Perfil;
use App\App\Entities\Ciclo;
use App\App\Entities\Materia;
use App\App\Entities\Grado;
use App\App\Entities\TipoTarea;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
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

            $administrador = Persona::create([
                'primer_nombre' => 'Administrador',
                'primer_apellido' => 'Administrador',
                'fecha_nacimiento' => '2000-01-01',
                'genero' => 'M',
                'rol' => 'A',
                'cui' => '0000000000000',
                'direccion' => 'Guatemala',
                'telefono' => '00000000',
                'celular' => '00000000',
                'fotografia' => 'personas/male.png',
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

            $maestro = Persona::create([
                'primer_nombre' => 'Profesor',
                'primer_apellido' => 'Jirafales',
                'fecha_nacimiento' => '2000-01-01',
                'genero' => 'M',
                'rol' => 'M',
                'cui' => '0000000000000',
                'direccion' => 'Guatemala',
                'telefono' => '00000000',
                'celular' => '00000000',
                'fotografia' => 'personas/male.png',
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

            $estudiante = Persona::create([
                'primer_nombre' => 'Chavo',
                'primer_apellido' => 'Del 8',
                'fecha_nacimiento' => '2000-01-01',
                'genero' => 'M',
                'rol' => 'E',
                'cui' => '0000000000000',
                'direccion' => 'Guatemala',
                'telefono' => '00000000',
                'celular' => '00000000',
                'fotografia' => 'personas/male.png',
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

            $user = User::create([
            	'username' => 'admin',
            	'password' => 'admin',
            	'perfil_id' => $perfilSuperAdmin->id,
                'persona_id' => $administrador->id,
            	'primera_vez' => 1,
            	'estado' => 'A',
            	'created_by' => 'admin',
            	'updated_by' => 'admin'
            ]);

            $userMaestro = User::create([
                'username' => 'jirafales',
                'password' => 'jirafales',
                'perfil_id' => $perfilMaestro->id,
                'persona_id' => $maestro->id,
                'primera_vez' => 1,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

            $userEstudiante = User::create([
                'username' => 'chavo8',
                'password' => 'chavo8',
                'perfil_id' => $perfilEstudiante->id,
                'persona_id' => $estudiante->id,
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

            $estudiantes = factory(\App\App\Entities\Persona::class, 100)
                                ->states('estudiante')->create();

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

            TipoTarea::create([
                    'descripcion' => 'Tarea',
                    'aplica_zona' => 1,
                    'es_examen' => 0,
                    'estado' => 'A',
                    'created_by' => 'admin',
                    'updated_by' => 'admin'
                ]);

            TipoTarea::create([
                    'descripcion' => 'Laboratorio',
                    'aplica_zona' => 1,
                    'es_examen' => 0,
                    'estado' => 'A',
                    'created_by' => 'admin',
                    'updated_by' => 'admin'
                ]);

            TipoTarea::create([
                    'descripcion' => 'Examen Corto',
                    'aplica_zona' => 1,
                    'es_examen' => 1,
                    'estado' => 'A',
                    'created_by' => 'admin',
                    'updated_by' => 'admin'
                ]);

            TipoTarea::create([
                    'descripcion' => 'Examen Parcial',
                    'aplica_zona' => 1,
                    'es_examen' => 1,
                    'estado' => 'A',
                    'created_by' => 'admin',
                    'updated_by' => 'admin'
                ]);

            TipoTarea::create([
                    'descripcion' => 'Examen Final',
                    'aplica_zona' => 0,
                    'es_examen' => 1,
                    'estado' => 'A',
                    'created_by' => 'admin',
                    'updated_by' => 'admin'
                ]);
        }
        catch(\Exception $ex)
        {
            dd($ex);
        }
    }
}
