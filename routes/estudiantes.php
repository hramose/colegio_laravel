<?php

Route::group(['middleware' => 'auth'], function(){
Route::group(['middleware' => 'verificarCiclo'], function(){



Route::group(['prefix' => 'estudiantes'], function () {

Route::get('dashboard','EstudianteController@dashboard')->name('estudiantes.dashboard');
Route::get('compañeros','EstudianteController@companeros')->name('estudiantes.companeros');
Route::get('ver-curso/{curso}','EstudianteController@verCurso')->name('estudiantes.ver_curso');
Route::get('ver-actividad/{actividad_estudiante}','EstudianteController@verActividad')->name('estudiantes.ver_actividad');

});

});

});