<?php

namespace App\App\Entities;
use Variable;

class UnidadSeccion extends \Eloquent {

	use UserStamps;

	protected $fillable = ['seccion_id','unidad','nota_ganar','porcentaje','estado'];

	protected $table = 'unidad_seccion';

	public function seccion()
	{
		return $this->belongsTo(Seccion::class);
	}

	public function getDescripcionAttribute()
	{
		return Variable::getUnidad($this->unidad);
	}

}