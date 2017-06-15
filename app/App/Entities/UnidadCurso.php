<?php

namespace App\App\Entities;
use Variable;

class UnidadCurso extends \Eloquent {

	use UserStamps;

	protected $fillable = ['curso_id','unidad_seccion_id','planificacion','archivo_planificacion','estado'];

	protected $table = 'unidad_curso';

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}

	public function unidad_seccion()
	{
		return $this->belongsTo(UnidadSeccion::class);
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