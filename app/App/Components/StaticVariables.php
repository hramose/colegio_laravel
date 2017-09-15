<?php

namespace App\App\Components;
use DateTime;

class StaticVariables {

	protected $estadosGenerales = [
		'A' => 'Activo',
		'I' => 'Inactivo',
	];

	protected $generos = [
		'M' => 'Masculino',
		'F' => 'Femenino'
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

	protected $unidades = [
		'1' => 'Unidad 1',
		'2' => 'Unidad 2',
		'3' => 'Unidad 3',
		'4' => 'Unidad 4',
		'5' => 'Unidad 5'
	];

	protected $estadosActividades = [
		'N' => 'No Entregada',
		'E' => 'Entregada',
		'C' => 'Calificada',
	];

	protected $parentescos = [
		'M' => 'Madre',
		'P' => 'Padre',
		'TM' => 'Tio',
		'TF' => 'Tia',
		'AM' => 'Abuelo',
		'AF' => 'Abuela',
		'E' => 'Encargado'
	];

	protected $colores = ['bg-yellow','bg-red','bg-green','bg-blue'];

	public function getEstadosGenerales(){ return $this->estadosGenerales; }
	public function getEstadoGeneral($key){ return $this->estadosGenerales[$key]; }

	public function getGeneros(){ return $this->generos; }
	public function getGenero($key){ return $this->generos[$key]; }

	public function getNivelesAcademicos(){ return $this->nivelesAcademicos; }
	public function getNivelAcademico($key){ return $this->nivelesAcademicos[$key]; }

	public function getRoles(){ return $this->roles; }
	public function getRol($key){ return $this->roles[$key]; }

	public function getSecciones(){ return $this->secciones; }
	public function getSeccion($key){ return $this->secciones[$key]; }

	public function getUnidades(){ return $this->unidades; }
	public function getUnidad($key){ return $this->unidades[$key]; }

	public function getEstadosActividades(){ return $this->estadosActividades; }
	public function getEstadoActividad($key){ return $this->estadosActividades[$key]; }

	public function getParentescos(){ return $this->parentescos; }
	public function getParentesco($key){ return $this->parentescos[$key]; }

	public function getColores(){ return $this->colores; }
	public function getColor($key){ return $this->colores[$key]; }

	public function getCiclo()
	{
		return \Auth::user()->ciclo;
	}

	public function quitarTildes($cadena)
	{
		$cadena = str_replace('á', 'a', $cadena);
		$cadena = str_replace('é', 'e', $cadena);
		$cadena = str_replace('í', 'i', $cadena);
		$cadena = str_replace('ó', 'o', $cadena);
		$cadena = str_replace('ú', 'u', $cadena);
		$cadena = str_replace('Á', 'A', $cadena);
		$cadena = str_replace('É', 'E', $cadena);
		$cadena = str_replace('Í', 'I', $cadena);
		$cadena = str_replace('Ó', 'O', $cadena);
		$cadena = str_replace('Ú', 'U', $cadena);
		$cadena = str_replace('ñ', 'n', $cadena);
		$cadena = str_replace('Ñ', 'N', $cadena);
		return $cadena;
	}

	public function getAniosMesesBetweenFechas($fechaInicio, $fechaFin)
	{
		$date1 = new \DateTime($fechaInicio);
		$date2 = new \DateTime($fechaFin);
		$diff = $date1->diff($date2);
		return $diff->y . " años " . $diff->m." meses ";
	}

	function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'año',
	        'm' => 'mes',
	        'w' => 'semana',
	        'd' => 'día',
	        'h' => 'hora',
	        'i' => 'minuto',
	        's' => 'segundo',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? 'hace ' . implode(', ', $string) . '' : 'ahora';
	}

	public function getCellByNumber($number)
	{
		$cells[1] = 'A';
		$cells[2] = 'B';
		$cells[3] = 'C';
		$cells[4] = 'D';
		$cells[5] = 'E';
		$cells[6] = 'F';
		$cells[7] = 'G';
		$cells[8] = 'H';
		$cells[9] = 'I';
		$cells[10] = 'J';
		$cells[11] = 'K';
		$cells[12] = 'L';
		$cells[13] = 'M';
		$cells[14] = 'N';
		$cells[15] = 'O';
		$cells[16] = 'P';
		$cells[17] = 'Q';
		$cells[18] = 'R';
		$cells[19] = 'S';
		$cells[20] = 'T';
		$cells[21] = 'U';
		$cells[22] = 'V';
		$cells[23] = 'W';
		$cells[24] = 'X';
		$cells[25] = 'Y';
		$cells[26] = 'Z';
		$cells[27] = 'AA';
		$cells[28] = 'AB';
		$cells[29] = 'AC';
		$cells[30] = 'AD';
		$cells[31] = 'AE';
		$cells[32] = 'AF';
		$cells[33] = 'AG';
		$cells[34] = 'AH';
		$cells[35] = 'AI';
		$cells[36] = 'AJ';
		$cells[37] = 'AK';
		$cells[38] = 'AL';
		$cells[39] = 'AM';
		$cells[40] = 'AN';
		return $cells[$number];
	}

}