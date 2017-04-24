<?php

Route::group(['middleware' => 'auth'], function(){

	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'AuthController@mostrarDashboard']);

	/* CICLOS */
	Route::get('ciclos', ['as' => 'ciclos', 'uses' => 'CicloController@listado']);
	Route::get('ciclos/agregar', ['as' => 'agregar_ciclo', 'uses' => 'CicloController@mostrarAgregar']);
	Route::post('ciclos/agregar', ['as' => 'agregar_ciclo', 'uses' => 'CicloController@agregar']);
	Route::get('ciclos/editar/{id}', ['as' => 'editar_ciclo', 'uses' => 'CicloController@mostrarEditar']);
	Route::post('ciclos/editar/{id}', ['as' => 'editar_ciclo', 'uses' => 'CicloController@editar']);
	/* GRADOS */
	Route::get('grados', ['as' => 'grados', 'uses' => 'GradoController@listado']);
	Route::get('grados/agregar', ['as' => 'agregar_grado', 'uses' => 'GradoController@mostrarAgregar']);
	Route::post('grados/agregar', ['as' => 'agregar_grado', 'uses' => 'GradoController@agregar']);
	Route::get('grados/editar/{id}', ['as' => 'editar_grado', 'uses' => 'GradoController@mostrarEditar']);
	Route::post('grados/editar/{id}', ['as' => 'editar_grado', 'uses' => 'GradoController@editar']);
	/* MATERIAS */
	Route::get('materias', ['as' => 'materias', 'uses' => 'MateriaController@listado']);
	Route::get('materias/agregar', ['as' => 'agregar_materia', 'uses' => 'MateriaController@mostrarAgregar']);
	Route::post('materias/agregar', ['as' => 'agregar_materia', 'uses' => 'MateriaController@agregar']);
	Route::get('materias/editar/{id}', ['as' => 'editar_materia', 'uses' => 'MateriaController@mostrarEditar']);
	Route::post('materias/editar/{id}', ['as' => 'editar_materia', 'uses' => 'MateriaController@editar']);

	

});

Route::get('/', ['as' => 'inicio', 'uses' => 'AuthController@mostrarLogin']);
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@mostrarLogin']);
Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);

