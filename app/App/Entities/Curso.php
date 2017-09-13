<?php

namespace App\App\Entities;
use Variable;

class Curso extends \Eloquent {

	use UserStamps;

	protected $fillable = ['seccion_id','materia_id','maestro_id','orden','estado'];

	protected $table = 'curso';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function seccion()
	{
		return $this->belongsTo(Seccion::class);
	}

	public function materia()
	{
		return $this->belongsTo(Materia::class);
	}

	public function maestro()
	{
		return $this->belongsTo(Persona::class,'maestro_id');
	}

	public function unidades()
	{
		return $this->hasMany(UnidadCurso::class)->with('unidad_seccion');
	}

	public function getDescripcionAttribute()
	{
		return $this->seccion->grado->descripcion . ' ' . $this->seccion->descripcion_seccion . ' - ' . $this->materia->descripcion;
	}
	
	public function foros()
	{
		return $this->hasMany(Foro::class);
	}

	public function getCantidadForosAttribute()
	{
		return count($this->foros);
	}


	
}