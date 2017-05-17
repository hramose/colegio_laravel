<?php

Route::group(['middleware' => 'auth'], function(){
Route::group(['middleware' => 'verificarCiclo'], function(){

Route::get('dashboard-maestros','AuthController@mostrarDashboardMaestros')->name('dashboard_maestros');

});
});