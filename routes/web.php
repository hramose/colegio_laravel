<?php
//
Route::group(['middleware' => 'auth'], function(){

	Route::get('ciclos/elegir', ['as' => 'elegir_ciclo', 'uses' => 'CicloController@mostrarElegir']);
	Route::post('ciclos/elegir', ['as' => 'elegir_ciclo', 'uses' => 'CicloController@elegir']);

Route::group(['middleware' => 'verificarCiclo'], function(){
	
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'AuthController@mostrarDashboard']);
	
	/* CICLOS */
	Route::get('ciclos', ['as' => 'ciclos', 'uses' => 'CicloController@listado']);
	Route::get('ciclos/agregar', ['as' => 'agregar_ciclo', 'uses' => 'CicloController@mostrarAgregar']);
	Route::post('ciclos/agregar', ['as' => 'agregar_ciclo', 'uses' => 'CicloController@agregar']);
	Route::get('ciclos/editar/{id}', ['as' => 'editar_ciclo', 'uses' => 'CicloController@mostrarEditar']);
	Route::put('ciclos/editar/{id}', ['as' => 'editar_ciclo', 'uses' => 'CicloController@editar']);
	
	/* GRADOS */
	Route::get('grados', ['as' => 'grados', 'uses' => 'GradoController@listado']);
	Route::get('grados/agregar', ['as' => 'agregar_grado', 'uses' => 'GradoController@mostrarAgregar']);
	Route::post('grados/agregar', ['as' => 'agregar_grado', 'uses' => 'GradoController@agregar']);
	Route::get('grados/editar/{id}', ['as' => 'editar_grado', 'uses' => 'GradoController@mostrarEditar']);
	Route::put('grados/editar/{id}', ['as' => 'editar_grado', 'uses' => 'GradoController@editar']);
	/* MAESTROS */
	Route::get('maestros', ['as' => 'maestros', 'uses' => 'PersonaController@maestros']);
	Route::get('maestros/agregar', ['as' => 'agregar_maestro', 'uses' => 'PersonaController@mostrarAgregarMaestro']);
	Route::post('maestros/agregar', ['as' => 'agregar_maestro', 'uses' => 'PersonaController@agregarMaestro']);
	Route::get('maestros/editar/{id}', ['as' => 'editar_maestro', 'uses' => 'PersonaController@mostrarEditarMaestro']);
	Route::put('maestros/editar/{id}', ['as' => 'editar_maestro', 'uses' => 'PersonaController@editarMaestro']);
	/* MATERIAS */
	Route::get('materias', ['as' => 'materias', 'uses' => 'MateriaController@listado']);
	Route::get('materias/agregar', ['as' => 'agregar_materia', 'uses' => 'MateriaController@mostrarAgregar']);
	Route::post('materias/agregar', ['as' => 'agregar_materia', 'uses' => 'MateriaController@agregar']);
	Route::get('materias/editar/{id}', ['as' => 'editar_materia', 'uses' => 'MateriaController@mostrarEditar']);
	Route::put('materias/editar/{id}', ['as' => 'editar_materia', 'uses' => 'MateriaController@editar']);
	/* SECCIONS */
	Route::get('secciones', ['as' => 'secciones', 'uses' => 'SeccionController@listado']);
	Route::get('secciones/agregar', ['as' => 'agregar_seccion', 'uses' => 'SeccionController@mostrarAgregar']);
	Route::post('secciones/agregar', ['as' => 'agregar_seccion', 'uses' => 'SeccionController@agregar']);
	Route::get('secciones/editar/{id}', ['as' => 'editar_seccion', 'uses' => 'SeccionController@mostrarEditar']);
	Route::put('secciones/editar/{id}', ['as' => 'editar_seccion', 'uses' => 'SeccionController@editar']);

});

});

Route::get('/', ['as' => 'inicio', 'uses' => 'AuthController@mostrarLogin']);
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@mostrarLogin']);
Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);

