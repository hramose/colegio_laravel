<?php

namespace App\App\Entities;
use Variable;

class Equipo extends \Eloquent {
	
	protected $fillable = ['nombre','nombre_corto','siglas','logo','estado'];

	protected $table = 'equipo';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

}