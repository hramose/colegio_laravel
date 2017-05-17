<?php

namespace App\App\Entities;
use Variable;

class Seccion extends \Eloquent {

	protected $fillable = ['ciclo_id','grado_id','maestro_id','seccion','estado'];

	protected $table = 'seccion';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getDescripcionSeccionAttribute()
	{
		return Variable::getSeccion($this->seccion);
	}

	public function getDescripcionConGradoAttribute()
	{
		return $this->grado->descripcion . ' ' . Variable::getSeccion($this->seccion);
	}

	public function ciclo()
	{
		return $this->belongsTo('App\App\Entities\Ciclo');
	}

	public function grado()
	{
		return $this->belongsTo('App\App\Entities\Grado');
	}

	public function maestro()
	{
		return $this->belongsTo('App\App\Entities\Persona','maestro_id');
	}
	
}