<?php

namespace App\App\Components;

class StaticVariables {

	protected $estadosGenerales = [
		'A' => 'Activo',
		'I' => 'Inactivo',
	];

	protected $nivelesAcademicos = [
		'P' => 'Primaria',
		'B' => 'Basicos',
		'D' => 'Diversificado',
	];

	public function getEstadosGenerales(){ return $this->estadosGenerales; }
	public function getEstadoGeneral($key){ return $this->estadosGenerales[$key]; }

	public function getNivelesAcademicos(){ return $this->nivelesAcademicos; }
	public function getNivelAcademico($key){ return $this->nivelesAcademicos[$key]; }

}