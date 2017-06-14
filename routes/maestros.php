<?php

Route::group(['middleware' => 'auth'], function(){
Route::group(['middleware' => 'verificarCiclo'], function(){



Route::group(['prefix' => 'maestros'], function () {

Route::get('dashboard','MaestroController@dashboard')->name('maestros.dashboard');
Route::get('estudiantes-seccion/{seccion}','MaestroController@estudiantesSeccion')->name('maestros.estudiantes_seccion');
Route::get('reporte-estudiantes-seccion/{seccion}/{tipo}','MaestroController@reporteEstudiantesSeccion')->name('maestros.reporte_estudiantes_seccion');
Route::get('estudiantes-curso/{curso}','MaestroController@estudiantesCurso')->name('maestros.estudiantes_curso');
Route::get('reporte-estudiantes-curso/{curso}/{tipo}','MaestroController@reporteEstudiantesCurso')->name('maestros.reporte_estudiantes_curso');

/* UNIDADES */
Route::group(['prefix' => 'unidades'], function () {
	Route::get('listado/{curso}','UnidadController@listado')->name('unidades');
	Route::get('agregar/{curso}','UnidadController@mostrarAgregar')->name('agregar_unidad');
	Route::post('agregar/{curso}','UnidadController@agregar')->name('agregar_unidad');
	Route::get('editar/{unidad}','UnidadController@mostrarEditar')->name('editar_unidad');
	Route::put('editar/{unidad}','UnidadController@editar')->name('editar_unidad');
});

/* ACTIVIDADES */
Route::group(['prefix' => 'actividades'], function () {
	Route::get('listado/{unidad}','ActividadController@listado')->name('actividades');
	Route::get('agregar/{unidad}','ActividadController@mostrarAgregar')->name('agregar_actividad');
	Route::post('agregar/{unidad}','ActividadController@agregar')->name('agregar_actividad');
	Route::get('editar/{actividad}','ActividadController@mostrarEditar')->name('editar_actividad');
	Route::put('editar/{actividad}','ActividadController@editar')->name('editar_actividad');
});

}); //prefix-maestros

}); //middleware verificarCiclo

}); //middleware auth