<?php

namespace App\App\Entities;
use Variable;

class TipoTarea extends \Eloquent {

	protected $fillable = ['descripcion','aplica_zona','es_examen','estado'];

	protected $table = 'tipo_tarea';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getDescripcionAplicaZonaAttribute()
	{
		if($this->aplica_zona)
			return '<i class="fa fa-check square text-white bg-green"></i>';
		return '<i class="fa fa-times square text-white bg-red"></i>';
	}

	public function getDescripcionEsExamenAttribute()
	{
		if($this->aplica_zona)
			return '<i class="fa fa-check square text-white bg-green"></i>';
		return '<i class="fa fa-times square text-white bg-red"></i>';
	}
	
}