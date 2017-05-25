<?php

Route::group(['middleware' => 'auth'], function(){
Route::group(['middleware' => 'verificarCiclo'], function(){



Route::group(['prefix' => 'maestros'], function () {

Route::get('dashboard','MaestroController@dashboard')->name('maestros.dashboard');

/* PERFILES */
Route::group(['prefix' => 'unidades'], function () {
	Route::get('listado/{curso}','UnidadController@listado')->name('unidades');
	Route::get('agregar/{curso}','UnidadController@mostrarAgregar')->name('agregar_unidad');
	Route::post('agregar/{curso}','UnidadController@agregar')->name('agregar_unidad');
	Route::get('editar/{unidad}','UnidadController@mostrarEditar')->name('editar_unidad');
	Route::put('editar/{unidad}','UnidadController@editar')->name('editar_unidad');
});

}); //prefix-maestros

}); //middleware verificarCiclo

}); //middleware auth