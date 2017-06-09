<?php

Route::get('/','AuthController@mostrarLogin')->name('inicio');
Route::get('login','AuthController@mostrarLogin')->name('login');
Route::post('login','AuthController@login')->name('login');
Route::get('logout','AuthController@logout')->name('logout');

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
});

/* TIPOS TAREAS */
Route::group(['prefix' => 'tipos-tareas'], function () {
	Route::get('listado','TipoTareaController@listado')->name('tipos_tareas');
	Route::get('agregar','TipoTareaController@mostrarAgregar')->name('agregar_tipo_tarea');
	Route::post('agregar','TipoTareaController@agregar')->name('agregar_tipo_tarea');
	Route::get('editar/{id}','TipoTareaController@mostrarEditar')->name('editar_tipo_tarea');
	Route::put('editar/{id}','TipoTareaController@editar')->name('editar_tipo_tarea');
});

});

});




include('maestros.php');