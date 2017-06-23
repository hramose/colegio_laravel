<?php

Route::group(['middleware' => 'auth'], function(){
Route::group(['middleware' => 'verificarCiclo'], function(){



Route::group(['prefix' => 'maestros'], function () {

Route::get('dashboard','MaestroController@dashboard')->name('maestros.dashboard');
Route::get('cursos','MaestroController@cursos')->name('maestros.cursos');
Route::get('ver-curso/{curso}','MaestroController@verCurso')->name('maestros.ver_curso');
Route::get('foros/{curso}','MaestroController@foros')->name('maestros.foros');
Route::get('estudiantes-seccion/{seccion}','MaestroController@estudiantesSeccion')->name('maestros.estudiantes_seccion');
Route::get('reporte-estudiantes-seccion/{seccion}/{tipo}','MaestroController@reporteEstudiantesSeccion')->name('maestros.reporte_estudiantes_seccion');
Route::get('estudiantes-curso/{curso}','MaestroController@estudiantesCurso')->name('maestros.estudiantes_curso');
Route::get('reporte-estudiantes-curso/{curso}/{tipo}','MaestroController@reporteEstudiantesCurso')->name('maestros.reporte_estudiantes_curso');

/* UNIDADES CURSOS */
Route::group(['prefix' => 'unidades-curso'], function () {
	Route::get('listado/{curso}','UnidadCursoController@listado')->name('unidades_cursos');
	Route::get('editar/{unidad_curso}','UnidadCursoController@mostrarEditar')->name('editar_unidad_curso');
	Route::put('editar/{unidad_curso}','UnidadCursoController@editar')->name('editar_unidad_curso');
});

/* FOROS */
Route::group(['prefix' => 'foros'], function () {
	Route::get('listado/{curso}','ForoController@listado')->name('foros');
	Route::get('agregar/{curso}','ForoController@mostrarAgregar')->name('agregar_foro');
	Route::post('agregar/{curso}','ForoController@agregar')->name('agregar_foro');
	Route::get('editar/{foro}','ForoController@mostrarEditar')->name('editar_foro');
	Route::put('editar/{foro}','ForoController@editar')->name('editar_foro');
});

/* FOROS */
Route::group(['prefix' => 'mensajes-foros'], function () {
	Route::get('listado/{foro}','MensajeForoController@listado')->name('mensajes_foro');
	Route::get('agregar/{foro}','MensajeForoController@mostrarAgregar')->name('agregar_mensaje_foro');
	Route::post('agregar/{foro}','MensajeForoController@agregar')->name('agregar_mensaje_foro');
	Route::get('editar/{mensaje_foro}','MensajeForoController@mostrarEditar')->name('editar_mensaje_foro');
	Route::put('editar/{mensaje_foro}','MensajeForoController@editar')->name('editar_mensaje_foro');
});

/* ACTIVIDADES */
Route::group(['prefix' => 'actividades'], function () {
	Route::get('listado/{unidad_curso}','ActividadController@listado')->name('actividades');
	Route::get('agregar/{unidad_curso}','ActividadController@mostrarAgregar')->name('agregar_actividad');
	Route::post('agregar/{unidad_curso}','ActividadController@agregar')->name('agregar_actividad');
	Route::get('editar/{actividad}','ActividadController@mostrarEditar')->name('editar_actividad');
	Route::put('editar/{actividad}','ActividadController@editar')->name('editar_actividad');
});

}); //prefix-maestros

}); //middleware verificarCiclo

}); //middleware auth