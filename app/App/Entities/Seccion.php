<?php

namespace App\App\Entities;
use Variable;

class Seccion extends \Eloquent {

	use UserStamps;

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
		return $this->belongsTo(Ciclo::class);
	}

	public function grado()
	{
		return $this->belongsTo(Grado::class);
	}

	public function maestro()
	{
		return $this->belongsTo(Persona::class,'maestro_id');
	}

	public function estudiantes()
	{
		return $this->hasMany(EstudianteSeccion::class)->with('estudiante');
	}

	public function unidades()
	{
		return $this->hasMany(UnidadSeccion::class);
	}
	
}