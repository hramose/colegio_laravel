<?php

namespace App\App\Entities;
use Variable;

class TareaEstudiante extends \Eloquent {

	protected $fillable = ['tarea_id','estudiante_id','nota','texto','archivo','fecha_entrega','estado'];

	protected $table = 'tarea_estudiante';

	public function tarea()
	{
		return $this->belongsTo(Tarea::class);
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