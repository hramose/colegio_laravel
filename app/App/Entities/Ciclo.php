<?php

namespace App\App\Entities;
use Variable;

class Ciclo extends \Eloquent {
	
	protected $fillable = ['descripcion','fecha_inicio','fecha_fin','estado'];

	protected $table = 'ciclo';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

}