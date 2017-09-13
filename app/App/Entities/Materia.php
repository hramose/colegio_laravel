<?php

namespace App\App\Entities;
use Variable;

class Materia extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','orden','estado'];

	protected $table = 'materia';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}
	
}