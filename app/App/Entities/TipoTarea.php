<?php

namespace App\App\Entities;
use Variable;

class TipoTarea extends \Eloquent {

	protected $fillable = ['descripcion','aplica_zona','estado'];

	protected $table = 'tipo_tarea';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}
	
}