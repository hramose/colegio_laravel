<?php

namespace App\App\Entities;
use Variable;

class Unidad extends \Eloquent {

	protected $fillable = ['curso_id','unidad','nota_ganar','porcentaje','planificacion','archivo_planificacion','estado'];

	protected $table = 'unidad';

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}

	public function getDescripcionAttribute()
	{
		return Variable::getUnidad($this->unidad);
	}

	public function getArchivoPlanificacionAttribute($archivo_planificacion)
    {
    	if(!is_null($archivo_planificacion))
    		return \Storage::disk('public')->url($archivo_planificacion);
    	return null;
    }

    public function actividades()
    {
    	return $this->hasMany(Actividad::class);
    }

}