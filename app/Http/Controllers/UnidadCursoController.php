<?php

namespace App\Http\Controllers;

use App\App\Repositories\UnidadCursoRepo;
use App\App\Managers\UnidadCursoManager;
use App\App\Entities\UnidadCurso;
use Controller, Redirect, Input, View, Session, Variable, Excel;

use App\App\Entities\Curso;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\ActividadRepo;
use App\App\Repositories\ActividadEstudianteRepo;
use App\App\Repositories\EstudianteSeccionRepo;

class UnidadCursoController extends BaseController {

	protected $unidadCursoRepo;
	protected $cursoRepo;
	protected $actividadRepo;
	protected $actividadEstudianteRepo;
	protected $estudianteSeccionRepo;

	public function __construct(UnidadCursoRepo $unidadCursoRepo, CursoRepo $cursoRepo, ActividadRepo $actividadRepo, ActividadEstudianteRepo $actividadEstudianteRepo, EstudianteSeccionRepo $estudianteSeccionRepo)
	{
		$this->unidadCursoRepo = $unidadCursoRepo;
		$this->cursoRepo = $cursoRepo;
		$this->actividadRepo = $actividadRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Curso $curso)
	{
		$unidades = $this->unidadCursoRepo->getByCurso($curso->id);
		foreach($unidades as $unidad){
			$unidad->actividades = $this->actividadRepo->getByUnidad($unidad->id);
		}

		return view('administracion/unidades_cursos/listado', compact('unidades','curso'));
	}

	public function mostrarEditar(UnidadCurso $unidadCurso)
	{
		return view('administracion/unidades_cursos/editar', compact('unidadCurso'));
	}

	public function editar(UnidadCurso $unidadCurso)
	{
		$data = Input::all();
		$data['curso_id'] = $unidadCurso->curso_id;
		$data['unidad_seccion_id'] = $unidadCurso->unidad_seccion_id;
		$data['estado'] = $unidadCurso->estado;
		$manager = new UnidadCursoManager($unidadCurso, $data);
		$manager->save();
		Session::flash('success', 'Se editó la planificación de unidad del curso con éxito.');
		$url = route('unidades_curso',$unidadCurso->curso_id) . "#" . $unidadCurso->id;
		return redirect()->to($url);
	}

	public function mostrarNotas(UnidadCurso $unidadCurso)
	{
		$actividades = $this->actividadRepo->getByUnidad($unidadCurso->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($unidadCurso->curso->seccion_id);
		$actividadesEstudiantes = $this->actividadEstudianteRepo->getByUnidad($unidadCurso->id);
		$notas = [];
	
		$headers[] = 'ESTUDIANTE';	
		foreach($actividades as $actividad)
		{
			$headers[] = $actividad->id;
		}
		$headers[] = 'TOTAL';

		foreach($estudiantes as $estudiante)
		{
			$notas[$estudiante->estudiante_id]['estudiante'] = $estudiante->estudiante->nombre_completo;
			foreach($actividades as $actividad)
			{
				$notas[$estudiante->estudiante_id][$actividad->id] = $actividad->id;
			}
			$notas[$estudiante->estudiante_id]['total'] = 0;
		}

		foreach($actividadesEstudiantes as $ae)
		{
			$notas[$ae->estudiante_id][$ae->actividad_id] = $ae->nota;
			$notas[$ae->estudiante_id]['total'] += $ae->nota;
		}
		return view('administracion/unidades_cursos/notas', compact('unidadCurso','notas','headers','actividades'));
	}

	public function descargaFormatoNotasActividades(UnidadCurso $unidadCurso)
	{
		$data = Input::all();
		$actividadesDB = $this->actividadRepo->getByUnidad($unidadCurso->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($unidadCurso->curso->seccion_id);
		$actividadesSeleccionadas = [];
		foreach($data['actividades'] as $actividadesEnviadas)
		{
			if(isset($actividadesEnviadas['check'])){
				$id = $actividadesEnviadas['id'];
				foreach($actividadesDB as $adb)
				{
					if($adb->id == $id){
						$actividadesSeleccionadas[] = $adb;
					}
				}
			}
		}
		Excel::create('Carga de Notas', function($excel) use ($estudiantes, $actividadesSeleccionadas, $unidadCurso) {
		    $excel->sheet('Formato', function($sheet) use ($estudiantes, $actividadesSeleccionadas, $unidadCurso) {
		        $sheet->row(1, array(
				    $unidadCurso->id, 'Unidad Curso'
				));
				$sheet->cell('A2', function($cell) { $cell->setValue('IDS'); });
				$sheet->cell('B2', function($cell) { $cell->setValue('Actividades'); });
				foreach($actividadesSeleccionadas as $index => $actividad)
				{
					$sheet->cell($this->getLetterCellByNumber($index+3) . '2', function($cell) use ($actividad) { $cell->setValue($actividad->id); });
				}
				$sheet->cell('A3', function($cell) { $cell->setValue('IDS'); });
				$sheet->cell('B3', function($cell) { $cell->setValue('Estudiante'); });
				foreach($actividadesSeleccionadas as $index => $actividad)
				{
					$sheet->cell($this->getLetterCellByNumber($index+3) . '3', function($cell) use ($actividad) { $cell->setValue($actividad->titulo); });
				}
				foreach($estudiantes as $index => $estudiante)
				{
					$sheet->cell('A' . ($index+4), function($cell) use ($estudiante) { $cell->setValue($estudiante->estudiante_id); });
					$sheet->cell('B' . ($index+4), function($cell) use ($estudiante) { $cell->setValue($estudiante->estudiante->nombre_completo); });
				}
		    });
		})->export('csv');

	}

	private function getLetterCellByNumber($number)
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

		return $cells[$number];
	}


}