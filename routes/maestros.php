<?php

Route::group(['middleware' => 'auth'], function(){
Route::group(['middleware' => 'verificarCiclo'], function(){



Route::group(['prefix' => 'maestros'], function () {

Route::get('dashboard','MaestroController@dashboard')->name('maestros.dashboard');

/* UNIDADES */
Route::group(['prefix' => 'unidades'], function () {
	Route::get('listado/{curso}','UnidadController@listado')->name('unidades');
	Route::get('agregar/{curso}','UnidadController@mostrarAgregar')->name('agregar_unidad');
	Route::post('agregar/{curso}','UnidadController@agregar')->name('agregar_unidad');
	Route::get('editar/{unidad}','UnidadController@mostrarEditar')->name('editar_unidad');
	Route::put('editar/{unidad}','UnidadController@editar')->name('editar_unidad');
});

/* TAREAS */
Route::group(['prefix' => 'tareas'], function () {
	Route::get('listado/{unidad}','TareaController@listado')->name('tareas');
	Route::get('agregar/{unidad}','TareaController@mostrarAgregar')->name('agregar_tarea');
	Route::post('agregar/{unidad}','TareaController@agregar')->name('agregar_tarea');
	Route::get('editar/{tarea}','TareaController@mostrarEditar')->name('editar_tarea');
	Route::put('editar/{tarea}','TareaController@editar')->name('editar_tarea');
	Route::get('descargar-archivo/{tarea}','TareaController@descargarArchivo')->name('descargar_archivo_tarea');
});

}); //prefix-maestros

}); //middleware verificarCiclo

}); //middleware auth