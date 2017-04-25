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

	protected $roles = [
		'A' => 'Administrador',
		'M' => 'Maestro',
		'E' => 'Estudiante',
		'P' => 'Padre de Familia'
	];

	protected $secciones = [
		'A' => 'A',
		'B' => 'B',
		'C' => 'C',
		'D' => 'D'
	];

	public function getEstadosGenerales(){ return $this->estadosGenerales; }
	public function getEstadoGeneral($key){ return $this->estadosGenerales[$key]; }

	public function getNivelesAcademicos(){ return $this->nivelesAcademicos; }
	public function getNivelAcademico($key){ return $this->nivelesAcademicos[$key]; }

	public function getRoles(){ return $this->roles; }
	public function getRol($key){ return $this->roles[$key]; }

	public function getSecciones(){ return $this->secciones; }
	public function getSeccion($key){ return $this->secciones[$key]; }

}