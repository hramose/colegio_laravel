<?php

namespace App\App\Entities;
use Variable;

class DetallePlantillaUnidad extends \Eloquent {

	use UserStamps;

	protected $fillable = ['plantilla_unidad_id','unidad','nota_ganar','porcentaje','estado'];

	protected $table = 'detalle_plantilla_unidad';

	public function plantilla_unidad()
	{
		return $this->belongsTo(PlantillaUnidad::class);
	}

	public function getDescripcionAttribute()
	{
		return Variable::getUnidad($this->unidad);
	}

}