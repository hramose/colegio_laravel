<?php

namespace App\App\Entities;
use Variable;

class Materia extends \Eloquent {

	protected $fillable = ['descripcion','estado'];

	protected $table = 'materia';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}
	
}