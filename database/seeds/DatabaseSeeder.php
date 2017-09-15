<?php

use Illuminate\Database\Seeder;
use App\App\Entities\User;
use App\App\Entities\Persona;
use App\App\Entities\Perfil;
use App\App\Entities\Ciclo;
use App\App\Entities\Materia;
use App\App\Entities\Grado;
use App\App\Entities\TipoActividad;
use App\App\Entities\Vista;
use App\App\Entities\Permiso;
use App\App\Entities\Modulo;

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
            		'orden' => $index,
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

            $vistas = array(
                [1,"Inicio","inicio",1],
                [2,"Login","login",1],
                [3,"Logout","logout",1],
                [4,"Dashboard","dashboard",1],
                [5,"Ciclos","ciclos",1],
                [6,"Agregar Ciclo","agregar_ciclo",1],
                [7,"Editar Ciclo","editar_ciclo",1],
                [8,"Elegir Ciclo","elegir_ciclo",1],
                [9,"Grados","grados",1],
                [10,"Agregar Grado","agregar_grado",1],
                [11,"Editar Grado","editar_grado",1],
                [12,"Maestros","maestros",1],
                [13,"Agregar Maestro","agregar_maestro",1],
                [14,"Editar Maestro","editar_maestro",1],
                [15,"Estudiantes","estudiantes",1],
                [16,"Agregar Estudiante","agregar_estudiante",1],
                [17,"Editar Estudiante","editar_estudiante",1],
                [18,"Materias","materias",1],
                [19,"Agregar Materia","agregar_materia",1],
                [20,"Editar Materia","editar_materia",1],
                [21,"Secciones","secciones",1],
                [22,"Agregar Seccion","agregar_seccion",1],
                [23,"Editar Seccion","editar_seccion",1],
                [24,"Cursos","cursos",1],
                [25,"Agregar Curso","agregar_curso",1],
                [26,"Editar Curso","editar_curso",1],
                [27,"Trasladar Cursos","trasladar_cursos",1],
                [28,"Ordenar Cursos","ordenar_cursos",1],
                [29,"Ordenar Cursos Por Nombre","ordenar_cursos_por_nombre",1],
                [30,"Perfiles","perfiles",1],
                [31,"Agregar Perfil","agregar_perfil",1],
                [32,"Editar Perfil","editar_perfil",1],
                [33,"Usuarios","usuarios",1],
                [34,"Agregar Usuario","agregar_usuario",1],
                [35,"Editar Usuario","editar_usuario",1],
                [36,"Reset Password","reset_password",1],
                [37,"Inactivar Usuario","inactivar_usuario",1],
                [38,"Activar Usuario","activar_usuario",1],
                [39,"Tipos Actividades","tipos_actividades",1],
                [40,"Agregar Tipo Actividad","agregar_tipo_actividad",1],
                [41,"Editar Tipo Actividad","editar_tipo_actividad",1],
                [42,"Estudiantes Seccion","estudiantes_seccion",1],
                [43,"Agregar Estudiante Seccion","agregar_estudiante_seccion",1],
                [44,"Editar Estudiante Seccion","editar_estudiante_seccion",1],
                [45,"Corregir Codigos Estudiante Seccion","corregir_codigos_estudiante_seccion",1],
                [46,"Unidades Secciones","unidades_secciones",2],
                [47,"Agregar Unidad Seccion","agregar_unidad_seccion",2],
                [48,"Editar Unidad Seccion","editar_unidad_seccion",2],
                [49,"Notas Unidad Seccion","notas_unidad_seccion",2],
                [50,"Detalle Notas Unidad Seccion","detalle_notas_unidad_seccion",2],
                [51,"Notas Seccion","notas_seccion",2],
                [52,"Reporte Notas Seccion","reporte_notas_seccion",2],
                [53,"Notas Estudiante Seccion","notas_estudiante_seccion",2],
                [54,"Reporte Notas Estudiante Seccion","reporte_notas_estudiante_seccion",2],
                [55,"Reporte Notas Estudiantes Seccion","reporte_notas_estudiantes_seccion",2],
                [56,"Notificaciones","notificaciones",1],
                [57,"Ver Notificacion","ver_notificacion",1],
                [58,"Dashboard","maestros.dashboard",2],
                [59,"Secciones","maestros.secciones",2],
                [60,"Ver Seccion","maestros.ver_seccion",2],
                [61,"Cursos","maestros.cursos",2],
                [62,"Ver Curso","maestros.ver_curso",2],
                [63,"Foros","maestros.foros",2],
                [64,"Estudiantes Seccion","maestros.estudiantes_seccion",2],
                [65,"Reporte Estudiantes Seccion","maestros.reporte_estudiantes_seccion",2],
                [66,"Estudiantes Curso","maestros.estudiantes_curso",2],
                [67,"Reporte Estudiantes Curso","maestros.reporte_estudiantes_curso",2],
                [68,"Unidades Curso","unidades_curso",2],
                [69,"Editar Unidad Curso","editar_unidad_curso",2],
                [70,"Notas Unidad Curso","notas_unidad_curso",2],
                [71,"Descargar Notas Unidad Curso","descargar_notas_unidad_curso",2],
                [72,"Descargar Formato Notas Actividades","descargar_formato_notas_actividades",2],
                [73,"Foros","foros",2],
                [74,"Agregar Foro","agregar_foro",2],
                [75,"Editar Foro","editar_foro",2],
                [76,"Mensajes Foro","mensajes_foro",2],
                [77,"Agregar Mensaje Foro","agregar_mensaje_foro",2],
                [78,"Editar Mensaje Foro","editar_mensaje_foro",2],
                [79,"Actividades","actividades",2],
                [80,"Agregar Actividad","agregar_actividad",2],
                [81,"Editar Actividad","editar_actividad",2],
                [82,"Ver Notas Actividad","ver_notas_actividad",2],
                [83,"Calificar Actividad","calificar_actividad",2],
                [84,"Calificar Actividades","calificar_actividades",2],
                [85,"Descargar Formato Calificar Actividad","descargar_formato_calificar_actividad",2],
                [86,"Cargar Notas Actividad","cargar_notas_actividad",2],
                [87,"Dashboard","estudiantes.dashboard",3],
                [88,"Companeros","estudiantes.companeros",3],
                [89,"Maestros","estudiantes.maestros",3],
                [90,"Cursos","estudiantes.cursos",3],
                [91,"Ver Curso","estudiantes.ver_curso",3],
                [92,"Ver Actividad","estudiantes.ver_actividad",3],
                [93,"Entregar Actividad","estudiantes.entregar_actividad",3],
                [94,"Foros","estudiantes.foros",3],
                [95,"Unidades","estudiantes.unidades",3],
                [96,"Mensajes Foro","estudiantes.mensajes_foro",3],
                [97,"Cerrar Unidad Seccion ","cerrar_unidad_seccion",2],
                [98,"Activar Unidad Seccion","activar_unidad_seccion",2]
            );

            Modulo::create([
                'descripcion' => 'Administracion',
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

            foreach($vistas as $vista)
            {
                $v = Vista::create([
                    'id' => $vista[0],
                    'descripcion' => $vista[1],
                    'ruta' => $vista[2],
                    'modulo_id' => $vista[3],
                    'estado' => 'A',
                    'created_by' => 'admin',
                    'updated_by' => 'admin'
                ]);
                
                if($vista[3] == 1)
                {
                    Permiso::create([
                        'vista_id' => $vista[0],
                        'perfil_id' => 1,
                        'estado' => 'A',
                        'created_by' => 'admin',
                        'updated_by' => 'admin'
                    ]);
                }
                if($vista[3] == 2)
                {
                    Permiso::create([
                        'vista_id' => $vista[0],
                        'perfil_id' => 3,
                        'estado' => 'A',
                        'created_by' => 'admin',
                        'updated_by' => 'admin'
                    ]);
                }
                if($vista[3] == 3)
                {
                    Permiso::create([
                        'vista_id' => $vista[0],
                        'perfil_id' => 4,
                        'estado' => 'A',
                        'created_by' => 'admin',
                        'updated_by' => 'admin'
                    ]);
                }
            }
            /*Elegir Ciclo*/
            Permiso::create([
                'vista_id' => 8,
                'perfil_id' => 3,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);
            Permiso::create([
                'vista_id' => 8,
                'perfil_id' => 4,
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
