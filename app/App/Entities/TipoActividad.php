<?php

namespace App\App\Entities;
use Variable;

class TipoActividad extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','aplica_zona','es_examen','puntos_extras','estado'];

	protected $table = 'tipo_actividad';
	
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
		if($this->es_examen)
			return '<i class="fa fa-check square text-white bg-green"></i>';
		return '<i class="fa fa-times square text-white bg-red"></i>';
	}

	public function getDescripcionPuntosExtrasAttribute()
	{
		if($this->puntos_extras)
			return '<i class="fa fa-check square text-white bg-green"></i>';
		return '<i class="fa fa-times square text-white bg-red"></i>';
	}
	
}