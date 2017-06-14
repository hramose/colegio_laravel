<?php

namespace App\App\Entities;
use Variable;

class ActividadEstudiante extends \Eloquent {

	protected $fillable = ['actividad_id','estudiante_id','nota','texto','archivo','fecha_entrega','estado'];

	protected $table = 'actividad_estudiante';

	public function actividad()
	{
		return $this->belongsTo(Actividad::class);
	}

	public function estudiante()
	{
		return $this->belongsTo(Persona::class,'estudiante_id');
	}

	public function getArchivoAttribute($archivo)
    {
    	if(!is_null($archivo))
    		return \Storage::disk('public')->url($archivo);
    	return null;
    }

}