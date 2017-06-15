<?php

namespace App\App\Entities;
use Variable;

class Persona extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['primer_nombre','segundo_nombre','primer_apellido','segundo_apellido','rol','fecha_nacimiento','genero','fotografia','cui','direccion','telefono','celular','estado'];

	protected $table = 'persona';

	public function getDescripcionRolAttribute()
	{
		return Variable::getRol($this->rol);
	}

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getNombreCompletoAttribute()
	{
		$nombre = $this->primer_nombre;
		if(!is_null($this->segundo_nombre))
			$nombre .= ' ' . $this->segundo_nombre;
		$nombre .= ' ' . $this->primer_apellido;
		if(!is_null($this->segundo_nombre))
			$nombre .= ' ' . $this->segundo_apellido;
		return $nombre;
	}

	public function getFotografiaAttribute($fotografia)
    {
    	return \Storage::disk('public')->url($fotografia);
    }

    public function getDescripcionGeneroAttribute()
	{
		return Variable::getGenero($this->genero);
	}

	public function getEdadAttribute()
	{
		return Variable::getAniosMesesBetweenFechas($this->fecha_nacimiento, date('Y-m-d'));
	}

}