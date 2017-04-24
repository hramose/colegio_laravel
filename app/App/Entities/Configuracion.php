<?php

namespace App\App\Entities;

class Configuracion extends \Eloquent {
	
	protected $fillable = ['descripcion','parametro1','parametro2','parametro3'];

	protected $table = 'configuracion';

}