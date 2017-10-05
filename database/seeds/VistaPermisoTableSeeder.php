<?php

use Illuminate\Database\Seeder;
use App\App\Entities\Vista;
use App\App\Entities\Permiso;

class VistaPermisoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vistas = array(
            [1,"Inicio","inicio",1,[]],
            [2,"Login","login",1,[]],
            [3,"Logout","logout",1,[1,2,3,4]],
            [4,"Dashboard","dashboard",1,[1,2]],
            [5,"Ciclos","ciclos",1,[1,2]],
            [6,"Agregar Ciclo","agregar_ciclo",1,[1,2]],
            [7,"Editar Ciclo","editar_ciclo",1,[1,2]],
            [8,"Elegir Ciclo","elegir_ciclo",1,[1,2,3,4]],
            [9,"Grados","grados",1,[1,2]],
            [10,"Agregar Grado","agregar_grado",1,[1,2]],
            [11,"Editar Grado","editar_grado",1,[1,2]],
            [12,"Maestros","maestros",1,[1,2]],
            [13,"Agregar Maestro","agregar_maestro",1,[1,2]],
            [14,"Editar Maestro","editar_maestro",1,[1,2]],
            [15,"Estudiantes","estudiantes",1,[1,2]],
            [16,"Agregar Estudiante","agregar_estudiante",1,[1,2]],
            [17,"Editar Estudiante","editar_estudiante",1,[1,2]],
            [18,"Materias","materias",1,[1,2]],
            [19,"Agregar Materia","agregar_materia",1,[1,2]],
            [20,"Editar Materia","editar_materia",1,[1,2]],
            [21,"Secciones","secciones",1,[1,2]],
            [22,"Agregar Seccion","agregar_seccion",1,[1,2]],
            [23,"Editar Seccion","editar_seccion",1,[1,2]],
            [24,"Cursos","cursos",1,[1,2]],
            [25,"Agregar Curso","agregar_curso",1,[1,2]],
            [26,"Editar Curso","editar_curso",1,[1,2]],
            [27,"Trasladar Cursos","trasladar_cursos",1,[1,2]],
            [28,"Ordenar Cursos","ordenar_cursos",1,[1,2]],
            [29,"Ordenar Cursos Por Nombre","ordenar_cursos_por_nombre",1,[1,2]],
            [30,"Perfiles","perfiles",1,[1]],
            [31,"Agregar Perfil","agregar_perfil",1,[1]],
            [32,"Editar Perfil","editar_perfil",1,[1]],
            [33,"Usuarios","usuarios",1,[1,2]],
            [34,"Agregar Usuario","agregar_usuario",1,[1,2]],
            [35,"Editar Usuario","editar_usuario",1,[1,2]],
            [36,"Reset Password","reset_password",1,[1,2]],
            [37,"Inactivar Usuario","inactivar_usuario",1,[1]],
            [38,"Activar Usuario","activar_usuario",1,[1]],
            [39,"Tipos Actividades","tipos_actividades",1,[1,2]],
            [40,"Agregar Tipo Actividad","agregar_tipo_actividad",1,[1,2]],
            [41,"Editar Tipo Actividad","editar_tipo_actividad",1,[1,2]],
            [42,"Estudiantes Seccion","estudiantes_seccion",1,[1,2]],
            [43,"Agregar Estudiante Seccion","agregar_estudiante_seccion",1,[1,2]],
            [44,"Editar Estudiante Seccion","editar_estudiante_seccion",1,[1,2]],
            [45,"Corregir Codigos Estudiante Seccion","corregir_codigos_estudiante_seccion",1,[1,2]],
            [46,"Unidades Secciones","unidades_secciones",1,[1,2]],
            [47,"Agregar Unidad Seccion","agregar_unidad_seccion",1,[1,2]],
            [48,"Editar Unidad Seccion","editar_unidad_seccion",1,[1,2]],
            [49,"Notas Unidad Seccion","notas_unidad_seccion",2,[3]],
            [50,"Detalle Notas Unidad Seccion","detalle_notas_unidad_seccion",2,[1,2,3]],
            [51,"Notas Seccion","notas_seccion",2,[3]],
            [52,"Reporte Notas Seccion","reporte_notas_seccion",2,[3]],
            [53,"Notas Estudiante Seccion","notas_estudiante_seccion",2,[3]],
            [54,"Reporte Notas Estudiante Seccion","reporte_notas_estudiante_seccion",2,[3]],
            [55,"Reporte Notas Estudiantes Seccion","reporte_notas_estudiantes_seccion",2,[3]],
            [56,"Notificaciones","notificaciones",1,[1,2,3,4]],
            [57,"Ver Notificacion","ver_notificacion",1,[1,2,3,4]],
            [58,"Dashboard","maestros.dashboard",2,[3]],
            [59,"Secciones","maestros.secciones",2,[3]],
            [60,"Ver Seccion","maestros.ver_seccion",2,[3]],
            [61,"Cursos","maestros.cursos",2,[3]],
            [62,"Ver Curso","maestros.ver_curso",2,[3]],
            [63,"Foros","maestros.foros",2,[3]],
            [64,"Estudiantes Seccion","maestros.estudiantes_seccion",2,[3]],
            [65,"Reporte Estudiantes Seccion","maestros.reporte_estudiantes_seccion",2,[3]],
            [66,"Estudiantes Curso","maestros.estudiantes_curso",2,[3]],
            [67,"Reporte Estudiantes Curso","maestros.reporte_estudiantes_curso",2,[3]],
            [68,"Unidades Curso","unidades_curso",2,[3]],
            [69,"Editar Unidad Curso","editar_unidad_curso",2,[3]],
            [70,"Notas Unidad Curso","notas_unidad_curso",2,[3]],
            [71,"Descargar Notas Unidad Curso","descargar_notas_unidad_curso",2,[3]],
            [72,"Descargar Formato Notas Actividades","descargar_formato_notas_actividades",2,[3]],
            [73,"Foros","foros",2,[3]],
            [74,"Agregar Foro","agregar_foro",2,[3]],
            [75,"Editar Foro","editar_foro",2,[3]],
            [76,"Mensajes Foro","mensajes_foro",2,[3]],
            [77,"Agregar Mensaje Foro","agregar_mensaje_foro",2,[3]],
            [78,"Editar Mensaje Foro","editar_mensaje_foro",2,[3]],
            [79,"Actividades","actividades",2,[3]],
            [80,"Agregar Actividad","agregar_actividad",2,[3]],
            [81,"Editar Actividad","editar_actividad",2,[3]],
            [82,"Ver Notas Actividad","ver_notas_actividad",2,[3]],
            [83,"Calificar Actividad","calificar_actividad",2,[3]],
            [84,"Calificar Actividades","calificar_actividades",2,[3]],
            [85,"Descargar Formato Calificar Actividad","descargar_formato_calificar_actividad",2,[3]],
            [86,"Cargar Notas Actividad","cargar_notas_actividad",2,[3]],
            [87,"Dashboard","estudiantes.dashboard",3,[4]],
            [88,"Companeros","estudiantes.companeros",3,[4]],
            [89,"Maestros","estudiantes.maestros",3,[4]],
            [90,"Cursos","estudiantes.cursos",3,[4]],
            [91,"Ver Curso","estudiantes.ver_curso",3,[4]],
            [92,"Ver Actividad","estudiantes.ver_actividad",3,[4]],
            [93,"Entregar Actividad","estudiantes.entregar_actividad",3,[4]],
            [94,"Foros","estudiantes.foros",3,[4]],
            [95,"Unidades","estudiantes.unidades",3,[4]],
            [96,"Mensajes Foro","estudiantes.mensajes_foro",3,[4]],
            [97,"Cerrar Unidad Seccion ","cerrar_unidad_seccion",2,[3]],
            [98,"Activar Unidad Seccion","activar_unidad_seccion",2,[3]],
            [99,"Cargar Notas Unidad Curso","cargar_notas_unidad_curso",2,[3]],
            [100,"Cargar Estudiantes","cargar_estudiantes",1,[1,2]],
            [101,"Ver Seccion","ver_seccion",1,[1,2]],
            [102,"Eliminar Actividad","eliminar_actividad",2,[3]],
            [103,"Agregar Mensaje a Foro","estudiantes.agregar_mensaje_foro",3,[4]],
            
        );            

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

            foreach($vista[4] as $perfil)
            {
            	Permiso::create([
                    'vista_id' => $vista[0],
                    'perfil_id' => $perfil,
                    'estado' => 'A',
                    'created_by' => 'admin',
                    'updated_by' => 'admin'
                ]);
            }
        }
    }
}
