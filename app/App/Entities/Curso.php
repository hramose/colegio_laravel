<?php

namespace App\App\Entities;
use Variable;

class Curso extends \Eloquent {

	protected $fillable = ['seccion_id','materia_id','maestro_id','estado'];

	protected $table = 'curso';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function seccion()
	{
		return $this->belongsTo('App\App\Entities\Seccion');
	}

	public function materia()
	{
		return $this->belongsTo('App\App\Entities\Materia');
	}

	public function maestro()
	{
		return $this->belongsTo('App\App\Entities\Persona','maestro_id');
	}
	
}