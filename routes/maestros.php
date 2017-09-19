<?php

Route::group(['middleware' => ['auth','verifyRoutePermission']], function(){
Route::group(['middleware' => 'verificarCiclo','verifyRoutePermission'], function(){



Route::group(['prefix' => 'maestros'], function () {

Route::get('dashboard','MaestroController@dashboard')->name('maestros.dashboard');
Route::get('secciones','MaestroController@secciones')->name('maestros.secciones');
Route::get('ver-seccion/{seccion}','MaestroController@verSeccion')->name('maestros.ver_seccion');
Route::get('cursos','MaestroController@cursos')->name('maestros.cursos');
Route::get('ver-curso/{curso}','MaestroController@verCurso')->name('maestros.ver_curso');
Route::get('foros/{curso}','MaestroController@foros')->name('maestros.foros');
Route::get('estudiantes-seccion/{seccion}','MaestroController@estudiantesSeccion')->name('maestros.estudiantes_seccion');
Route::get('reporte-estudiantes-seccion/{seccion}/{tipo}','MaestroController@reporteEstudiantesSeccion')->name('maestros.reporte_estudiantes_seccion');
Route::get('estudiantes-curso/{curso}','MaestroController@estudiantesCurso')->name('maestros.estudiantes_curso');
Route::get('reporte-estudiantes-curso/{curso}/{tipo}','MaestroController@reporteEstudiantesCurso')->name('maestros.reporte_estudiantes_curso');


/* UNIDADES CURSOS */
Route::group(['prefix' => 'unidades-curso'], function () {
	Route::get('listado/{curso}','UnidadCursoController@listado')->name('unidades_curso');
	Route::get('editar/{unidad_curso}','UnidadCursoController@mostrarEditar')->name('editar_unidad_curso');
	Route::put('editar/{unidad_curso}','UnidadCursoController@editar')->name('editar_unidad_curso');
	Route::get('ver-notas/{unidad_curso}','UnidadCursoController@mostrarNotas')->name('notas_unidad_curso');
	Route::get('ver-notas-actividades/{unidad_curso}','UnidadCursoController@descargarNotasActividades')->name('descargar_notas_unidad_curso');
	Route::post('descargar-formato-notas-actividades/{unidad_curso}','UnidadCursoController@descargaFormatoNotasActividades')->name('descargar_formato_notas_actividades');
	Route::get('cargar-notas-actividades/{unidad_curso}','UnidadCursoController@mostrarCargarNotasActividades')->name('cargar_notas_unidad_curso');
	Route::post('cargar-notas-actividades/{unidad_curso}','UnidadCursoController@cargarNotasActividades')->name('cargar_notas_unidad_curso');
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
	Route::get('ver-notas-actividad/{actividad}','ActividadController@mostrarVerNotas')->name('ver_notas_actividad');
	Route::get('calificar-actividad/{actividad}','ActividadController@mostrarCalificarActividad')->name('calificar_actividad');
	Route::post('calificar-actividad/{actividad}','ActividadController@calificarActividad')->name('calificar_actividad');
	Route::get('calificar-actividades/{actividad}','ActividadController@mostrarCalificarActividades')->name('calificar_actividades');
	Route::post('calificar-actividades/{actividad}','ActividadController@calificarActividades')->name('calificar_actividades');
	Route::get('formato-carga-notas/{actividad}','ActividadController@descargarFormatoCalificarActividad')->name('descargar_formato_calificar_actividad');
	Route::get('cargar-notas/{actividad}','ActividadController@mostrarCargarNotas')->name('cargar_notas_actividad');
	Route::post('cargar-notas/{actividad}','ActividadController@cargarNotas')->name('cargar_notas_actividad');

});

}); //prefix-maestros

}); //middleware verificarCiclo

}); //middleware auth