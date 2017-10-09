<?php

Route::group(['middleware' => ['auth','verifyRoutePermission']], function(){
Route::group(['middleware' => 'verificarCiclo'], function(){



Route::group(['prefix' => 'estudiantes'], function () {

Route::get('dashboard','EstudianteController@dashboard')->name('estudiantes.dashboard');
Route::get('compañeros','EstudianteController@companeros')->name('estudiantes.companeros');
Route::get('maestros','EstudianteController@maestros')->name('estudiantes.maestros');
Route::get('cursos','EstudianteController@cursos')->name('estudiantes.cursos');
Route::get('ver-curso/{curso}','EstudianteController@verCurso')->name('estudiantes.ver_curso');
Route::get('ver-actividad/{actividad_estudiante}','EstudianteController@verActividad')->name('estudiantes.ver_actividad');
Route::get('entregar-actividad/{actividad_estudiante}','EstudianteController@mostrarEntregarActividad')->name('estudiantes.entregar_actividad');
Route::post('entregar-actividad/{actividad_estudiante}','EstudianteController@entregarActividad')->name('estudiantes.entregar_actividad');
Route::get('foros/{curso}','EstudianteController@foros')->name('estudiantes.foros');
Route::get('unidades/{curso}','EstudianteController@unidades')->name('estudiantes.unidades');
Route::get('mensajes-foro/{foro}','EstudianteController@mensajesForo')->name('estudiantes.mensajes_foro');
Route::post('agregar-mensaje-foro/{foro}','EstudianteController@agregarMensajeForo')->name('estudiantes.agregar_mensaje_foro');

});

});

});