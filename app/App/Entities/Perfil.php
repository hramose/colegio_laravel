<?php

namespace App\App\Entities;
use Variable;

class Perfil extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['descripcion','estado'];

	protected $table = 'perfil';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}
}