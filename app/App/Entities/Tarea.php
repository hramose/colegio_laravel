<?php

namespace App\App\Entities;
use Variable;

class Tarea extends \Eloquent {

	protected $fillable = ['unidad_id','tipo_tarea_id','porcentaje','titulo','descripcion','archivo','aplica_fecha','fecha_inicio','fecha_fin','entrega_via_web','estado'];

	protected $table = 'tarea';

	public function unidad()
	{
		return $this->belongsTo(Unidad::class);
	}

	public function tipo()
	{
		return $this->belongsTo(TipoTarea::class, 'tipo_tarea_id');
	}

	public function getArchivoAttribute($archivo)
    {
    	if(!is_null($archivo))
    		return \Storage::disk('public')->url($archivo);
    	return null;
    }

}