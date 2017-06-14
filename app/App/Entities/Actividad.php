<?php

namespace App\App\Entities;
use Variable;

class Actividad extends \Eloquent {

	protected $fillable = ['unidad_id','tipo_actividad_id','porcentaje','titulo','descripcion','archivo','aplica_fecha','fecha_inicio','fecha_fin','entrega_via_web','estado'];

	protected $table = 'actividad';

	public function unidad()
	{
		return $this->belongsTo(Unidad::class);
	}

	public function tipo()
	{
		return $this->belongsTo(TipoActividad::class, 'tipo_actividad_id');
	}

	public function getArchivoAttribute($archivo)
    {
    	if(!is_null($archivo))
    		return \Storage::disk('public')->url($archivo);
    	return null;
    }

}