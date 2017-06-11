<?php

namespace App\App\Entities;
use Variable;

class EstudianteSeccion extends \Eloquent {

	protected $fillable = ['estudiante_id','seccion_id','codigo','estado'];

	protected $table = 'estudiante_seccion';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function estudiante()
	{
		return $this->belongsTo(Persona::class,'estudiante_id');
	}

	public function seccion()
	{
		return $this->belongsTo(Seccion::class);
	}
	
}