<?php

namespace App\App\Entities;
use Variable;

class Grado extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','numero','nivel_academico','estado'];

	protected $table = 'grado';

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getDescripcionNivelAcademicoAttribute()
	{
		return Variable::getNivelAcademico($this->nivel_academico);
	}

}