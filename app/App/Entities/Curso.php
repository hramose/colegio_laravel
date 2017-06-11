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
		return $this->hasMany(Unidad::class);
	}
	
}