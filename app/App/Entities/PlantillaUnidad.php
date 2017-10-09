<?php

namespace App\App\Entities;
use Variable;

class PlantillaUnidad extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','estado'];

	protected $table = 'plantilla_unidad';

	public function unidades()
	{
		return $this->hasMany(DetallePlantillaUnidad::class);
	}
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	
}