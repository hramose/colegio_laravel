<?php

namespace App\App\Entities;
use Variable;

class Persona extends \Eloquent {
	protected $fillable = ['primer_nombre','segundo_nombre','primer_apellido','segundo_apellido','rol','pais_id','fecha_nacimiento','posicion','estado'];

	protected $table = 'persona';

	public function getDescripcionRolAttribute()
	{
		return Variable::getRol($this->rol);
	}

	public function getDescripcionPosicionAttribute()
	{
		return Variable::getPosicion($this->posicion);
	}

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function pais()
	{
		return $this->belongsTo('App\App\Entities\Pais');
	}

	public function getNombreCompletoAttribute()
	{
		$portero = $this->posicion == 'PO' ? ' (P)' : '';
		$nombre = $this->primer_nombre;
		if(!is_null($this->segundo_nombre))
			$nombre .= ' ' . $this->segundo_nombre;
		$nombre .= ' ' . $this->primer_apellido;
		if(!is_null($this->segundo_nombre))
			$nombre .= ' ' . $this->segundo_apellido;
		$nombre .= ' ' . $portero;
		return $nombre;
	}

	public function getNombreCompletoApellidosAttribute()
	{
		$portero = $this->posicion == 'PO' ? ' (P)' : '';
		$nombre .= ' ' . $this->primer_apellido;
		if(!is_null($this->segundo_nombre))
			$nombre .= ' ' . $this->segundo_apellido;
		$nombre = $this->primer_nombre;
		if(!is_null($this->segundo_nombre))
			$nombre .= ' ' . $this->segundo_nombre;
		$nombre .= ' ' . $portero;
		return $nombre;
	}

}