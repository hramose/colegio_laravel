<?php

namespace App\App\Entities;
use Variable;

class Actividad extends \Eloquent {

	use UserStamps;

	protected $fillable = ['unidad_curso_id','tipo_actividad_id','punteo','titulo','descripcion','archivo','aplica_fecha','fecha_inicio','fecha_entrega','entrega_via_web','estado'];

	protected $table = 'actividad';

	public function unidad_curso()
	{
		return $this->belongsTo(UnidadCurso::class);
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

    public function getDescripcionEstadoAttribute()
    {
    	return $this->estado;
    }

    public function getDescripcionAplicaFechaAttribute()
	{
		if($this->aplica_fecha)
			return '<i class="fa fa-check square text-white bg-green"></i>';
		return '<i class="fa fa-times square text-white bg-red"></i>';
	}

	public function getDescripcionEntregaViaWebAttribute()
	{
		if($this->entrega_via_web)
			return '<i class="fa fa-check square text-white bg-green"></i>';
		return '<i class="fa fa-times square text-white bg-red"></i>';
	}

}