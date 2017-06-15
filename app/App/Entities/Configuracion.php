<?php

namespace App\App\Entities;

class Configuracion extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['descripcion','parametro1','parametro2','parametro3'];

	protected $table = 'configuracion';

}