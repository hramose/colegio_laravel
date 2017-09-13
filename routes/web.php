<?php

date_default_timezone_set('America/Guatemala');
setlocale(LC_TIME, 'es_ES.UTF-8');

Route::get('/','AuthController@mostrarLogin')->name('inicio');
Route::get('login','AuthController@mostrarLogin')->name('login');
Route::post('login','AuthController@login')->name('login');
Route::get('logout','AuthController@logout')->name('logout');

include('maestros.php');
include('estudiantes.php');

Route::group(['middleware' => 'auth'], function(){

Route::get('dashboard','AuthController@mostrarDashboard')->name('dashboard');

/* CICLOS */
Route::group(['prefix' => 'ciclos'], function () {
	Route::get('listado','CicloController@listado')->name('ciclos');
	Route::get('agregar','CicloController@mostrarAgregar')->name('agregar_ciclo');
	Route::post('agregar','CicloController@agregar')->name('agregar_ciclo');
	Route::get('editar/{id}','CicloController@mostrarEditar')->name('editar_ciclo');
	Route::put('editar/{id}','CicloController@editar')->name('editar_ciclo');
	Route::get('elegir','CicloController@mostrarElegir')->name('elegir_ciclo');
	Route::post('elegir','CicloController@elegir')->name('elegir_ciclo');
});
	
/* GRADOS */
Route::group(['prefix' => 'grados'], function () {
	Route::get('listado','GradoController@listado')->name('grados');
	Route::get('agregar','GradoController@mostrarAgregar')->name('agregar_grado');
	Route::post('agregar','GradoController@agregar')->name('agregar_grado');
	Route::get('editar/{id}','GradoController@mostrarEditar')->name('editar_grado');
	Route::put('editar/{id}','GradoController@editar')->name('editar_grado');
});
	
/* MAESTROS */
Route::group(['prefix' => 'maestros'], function () {
	Route::get('listado','PersonaController@maestros')->name('maestros');
	Route::get('agregar','PersonaController@mostrarAgregarMaestro')->name('agregar_maestro');
	Route::post('agregar','PersonaController@agregarMaestro')->name('agregar_maestro');
	Route::get('editar/{id}','PersonaController@mostrarEditarMaestro')->name('editar_maestro');
	Route::put('editar/{id}','PersonaController@editarMaestro')->name('editar_maestro');
});

/* ESTUDIANTES */
Route::group(['prefix' => 'estudiantes'], function () {
	Route::get('listado','PersonaController@estudiantes')->name('estudiantes');
	Route::get('agregar','PersonaController@mostrarAgregarEstudiante')->name('agregar_estudiante');
	Route::post('agregar','PersonaController@agregarEstudiante')->name('agregar_estudiante');
	Route::get('editar/{id}','PersonaController@mostrarEditarEstudiante')->name('editar_estudiante');
	Route::put('editar/{id}','PersonaController@editarEstudiante')->name('editar_estudiante');
});

/* MATERIAS */
Route::group(['prefix' => 'materias'], function () {
	Route::get('listado','MateriaController@listado')->name('materias');
	Route::get('agregar','MateriaController@mostrarAgregar')->name('agregar_materia');
	Route::post('agregar','MateriaController@agregar')->name('agregar_materia');
	Route::get('editar/{id}','MateriaController@mostrarEditar')->name('editar_materia');
	Route::put('editar/{id}','MateriaController@editar')->name('editar_materia');
});

Route::group(['middleware' => 'verificarCiclo'], function(){

/* SECCIONES */
Route::group(['prefix' => 'secciones'], function () {
	Route::get('listado','SeccionController@listado')->name('secciones');
	Route::get('agregar','SeccionController@mostrarAgregar')->name('agregar_seccion');
	Route::post('agregar','SeccionController@agregar')->name('agregar_seccion');
	Route::get('editar/{id}','SeccionController@mostrarEditar')->name('editar_seccion');
	Route::put('editar/{id}','SeccionController@editar')->name('editar_seccion');
});

/* CURSOS */
Route::group(['prefix' => 'cursos'], function () {
	Route::get('listado/{seccionId}','CursoController@listado')->name('cursos');
	Route::get('agregar/{seccionId}','CursoController@mostrarAgregar')->name('agregar_curso');
	Route::post('agregar/{seccionId}','CursoController@agregar')->name('agregar_curso');
	Route::get('editar/{id}','CursoController@mostrarEditar')->name('editar_curso');
	Route::put('editar/{id}','CursoController@editar')->name('editar_curso');
	Route::get('trasladar/{seccionId}/{seccion2Id}','CursoController@mostrarTrasladar')->name('trasladar_cursos');
	Route::post('trasladar/{seccionId}/{seccion2Id}','CursoController@trasladar')->name('trasladar_cursos');
	Route::get('ordenar/{seccion}','CursoController@mostrarOrdenar')->name('ordenar_cursos');
	Route::post('ordenar/{seccion}','CursoController@ordenar')->name('ordenar_cursos');
	Route::get('ordenar-por-nombre/{seccion}','CursoController@ordenarPorNombre')->name('ordenar_cursos_por_nombre');
});

/* PERFILES */
Route::group(['prefix' => 'perfiles'], function () {
	Route::get('listado','PerfilController@listado')->name('perfiles');
	Route::get('agregar','PerfilController@mostrarAgregar')->name('agregar_perfil');
	Route::post('agregar','PerfilController@agregar')->name('agregar_perfil');
	Route::get('editar/{id}','PerfilController@mostrarEditar')->name('editar_perfil');
	Route::put('editar/{id}','PerfilController@editar')->name('editar_perfil');
});

/* USUARIOS */
Route::group(['prefix' => 'usuarios'], function () {
	Route::get('listado','UsuarioController@listado')->name('usuarios');
	Route::get('agregar','UsuarioController@mostrarAgregar')->name('agregar_usuario');
	Route::post('agregar','UsuarioController@agregar')->name('agregar_usuario');
	Route::get('editar/{id}','UsuarioController@mostrarEditar')->name('editar_usuario');
	Route::put('editar/{id}','UsuarioController@editar')->name('editar_usuario');
	Route::get('reset-password/{id}','UsuarioController@resetPassword')->name('reset_password');
	Route::get('inactivar/{id}','UsuarioController@inactivarUsuario')->name('inactivar_usuario');
	Route::get('activar/{id}','UsuarioController@activarUsuario')->name('activar_usuario');
});

/* TIPOS ACTIVIDADES */
Route::group(['prefix' => 'tipos-actividades'], function () {
	Route::get('listado','TipoActividadController@listado')->name('tipos_actividades');
	Route::get('agregar','TipoActividadController@mostrarAgregar')->name('agregar_tipo_actividad');
	Route::post('agregar','TipoActividadController@agregar')->name('agregar_tipo_actividad');
	Route::get('editar/{id}','TipoActividadController@mostrarEditar')->name('editar_tipo_actividad');
	Route::put('editar/{id}','TipoActividadController@editar')->name('editar_tipo_actividad');
});

/* ESTUDIANTES EN SECCIONES */
Route::group(['prefix' => 'estudiantes-seccion'], function () {
	Route::get('listado/{seccion}','EstudianteSeccionController@listado')->name('estudiantes_seccion');
	Route::get('agregar/{seccion}','EstudianteSeccionController@mostrarAgregar')->name('agregar_estudiante_seccion');
	Route::post('agregar/{seccion}','EstudianteSeccionController@agregar')->name('agregar_estudiante_seccion');
	Route::get('editar/{id}','EstudianteSeccionController@mostrarEditar')->name('editar_estudiante_seccion');
	Route::put('editar/{id}','EstudianteSeccionController@editar')->name('editar_estudiante_seccion');
	Route::get('corregir-codigos/{seccion}','EstudianteSeccionController@corregirCodigos')->name('corregir_codigos_estudiante_seccion');
});

/* UNIDADES SECCIONES */
Route::group(['prefix' => 'unidades-secciones'], function () {
	Route::get('listado/{seccion}','UnidadSeccionController@listado')->name('unidades_secciones');
	Route::get('agregar/{seccion}','UnidadSeccionController@mostrarAgregar')->name('agregar_unidad_seccion');
	Route::post('agregar/{seccion}','UnidadSeccionController@agregar')->name('agregar_unidad_seccion');
	Route::get('editar/{unidad_seccion}','UnidadSeccionController@mostrarEditar')->name('editar_unidad_seccion');
	Route::put('editar/{unidad_seccion}','UnidadSeccionController@editar')->name('editar_unidad_seccion');
	Route::get('notas-unidad/{unidad_seccion}','UnidadSeccionController@mostrarNotas')->name('notas_unidad_seccion');
	Route::get('detalle-notas/{unidad_seccion}/{curso}/{estudiante}','UnidadSeccionController@mostrarDetalleNotas')->name('detalle_notas_unidad_seccion');
	Route::get('notas-seccion/{seccion}','UnidadSeccionController@mostrarNotasSeccion')->name('notas_seccion');
	Route::get('reporte-notas-seccion/{seccion}','UnidadSeccionController@reporteNotasSeccion')->name('reporte_notas_seccion');
	Route::get('notas-estudiante/{seccion}/{estudiante}','UnidadSeccionController@mostrarNotasEstudiante')->name('notas_estudiante_seccion');
	Route::get('reporte-notas-estudiante/{seccion}/{estudiante}/{tipo}','UnidadSeccionController@reporteNotasEstudiante')->name('reporte_notas_estudiante_seccion');
	Route::get('reporte-notas-estudiantes/{seccion}/{tipo}','UnidadSeccionController@reporteNotasEstudiantes')->name('reporte_notas_estudiantes_seccion');
});

/* PERFILES */
Route::group(['prefix' => 'notificaciones'], function () {
	Route::get('listado/{tipo}','NotificacionController@listado')->name('notificaciones');
	Route::get('ver/{id}','NotificacionController@ver')->name('ver_notificacion');
});

});

});




