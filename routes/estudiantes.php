<?php

Route::group(['middleware' => 'auth'], function(){
Route::group(['middleware' => 'verificarCiclo'], function(){



Route::group(['prefix' => 'estudiantes'], function () {

Route::get('dashboard','EstudianteController@dashboard')->name('estudiantes.dashboard');
Route::get('ver-curso/{curso}','EstudianteController@verCurso')->name('estudiantes.ver_curso');

});

});

});