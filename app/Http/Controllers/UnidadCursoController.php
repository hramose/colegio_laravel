<?php

namespace App\Http\Controllers;

use App\App\Repositories\UnidadCursoRepo;
use App\App\Managers\UnidadCursoManager;
use App\App\Entities\UnidadCurso;
use Controller, Redirect, Input, View, Session, Variable, Excel;

use App\App\Entities\Curso;

use App\App\Helpers\NotasHelper;

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
		if(Gate::denies('permiso_curso', $unidadCurso->curso)){
			Session::flash('error','No tiene permiso para ver el curso.');
			return redirect()->back();
		}
		$actividades = $this->actividadRepo->getByUnidad($unidadCurso->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($unidadCurso->curso->seccion_id);
		$actividadesEstudiantes = $this->actividadEstudianteRepo->getByUnidad($unidadCurso->id);
		$notasHelper = new NotasHelper();
		$notas = $notasHelper->getNotasByCurso($unidadCurso, $estudiantes, $actividades, $actividadesEstudiantes);
		return view('administracion/unidades_cursos/notas', compact('unidadCurso','notas','actividades'));
	}

	public function descargarNotasActividades(UnidadCurso $unidadCurso)
	{
		$actividades = $this->actividadRepo->getByUnidad($unidadCurso->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($unidadCurso->curso->seccion_id);
		$actividadesEstudiantes = $this->actividadEstudianteRepo->getByUnidad($unidadCurso->id);
		$notasHelper = new NotasHelper();
		$excel = $notasHelper->getExcelForNotasByCurso($unidadCurso, $estudiantes, $actividades, $actividadesEstudiantes);
		$excel->export('xlsx');
	}

	public function descargaFormatoNotasActividades(UnidadCurso $unidadCurso)
	{
		$data = Input::all();
		
		$cantidadActividadesEnviadas = 0;

		$actividadesDB = $this->actividadRepo->getByUnidad($unidadCurso->id);
		$actividadesSeleccionadas = [];
		foreach($data['actividades'] as $actividadesEnviadas)
		{
			if(isset($actividadesEnviadas['check'])){
				$cantidadActividadesEnviadas++;
				$id = $actividadesEnviadas['id'];
				foreach($actividadesDB as $adb)
				{
					if($adb->id == $id){
						$actividadesSeleccionadas[$id]['actividad'] = $adb;
						$actividadesEstudiantes = $this->actividadEstudianteRepo->getByActividad($adb->id);
						$actividadesSeleccionadas[$id]['actividades_estudiantes'] = $actividadesEstudiantes;
					}
				}
			}
		}

		if($cantidadActividadesEnviadas == 0){
			Session::flash('error','Seleccione al menos una actividad.');
			return redirect()->back();
		}

		$nombre = 'Formato Carga de Notas - ' . $unidadCurso->curso->descripcion;
		Excel::create($nombre, function($excel) use ($actividadesSeleccionadas, $unidadCurso) {
			foreach($actividadesSeleccionadas as $actividad){
				$estudiantesArray = [];

				foreach($actividad['actividades_estudiantes'] as $ae)
				{
					$estudiante['TAREA_ID'] = $ae->id;
					$estudiante['TAREA'] = $actividad['actividad']->titulo;
					$estudiante['ESTUDIANTE_ID'] = $ae->estudiante->id;
					$estudiante['ESTUDIANTE'] = $ae->estudiante->nombre_completo_apellidos;
					$estudiante['NOTA'] = $ae->nota;
					$estudiante['OBSERVACIONES'] = $ae->observaciones;
					$estudiantesArray[] = $estudiante;
				}

			    $excel->sheet($actividad['actividad']->id."", function($sheet) use ($estudiantesArray,$actividad,$unidadCurso) 
			    {
			    	$sheet->fromArray($estudiantesArray);
			    });
			}
		})->export('xlsx');
	}

	public function mostrarCargarNotasActividades(UnidadCurso $unidadCurso)
	{
		return view('administracion/unidades_cursos/cargar_notas', compact('unidadCurso','actividad'));
	}

	public function cargarNotasActividades(UnidadCurso $unidadCurso)
	{
		$data = Input::all();
		$errores = [];
		/*validar actividades*/
		$actividadesEstudiantesDB = [];
		foreach($data['notas'] as $a)
		{
			$actividad = $this->actividadRepo->find($a['actividad']);
			if(is_null($actividad)){
				Session::flash('error','Actividad ' . $a['actividad'] . ' no existe. Favor verifique el nombre de las pestañas del archivo.');
				return redirect()->back();
			}
			if($actividad->unidad_curso_id != $unidadCurso->id)
			{
				$errores[] = 'La actividad no pertenece al curso en el cual esta subiendo las notas. Verfique la pestaña ' . $a['actividad'];
			}
			$actividadesEstudiantes = $this->actividadEstudianteRepo->getByActividad($actividad->id);
			foreach($a['actividades_estudiantes'] as $ae)
			{
				$existe = false;
				foreach($actividadesEstudiantes as $aedb)
				{
					if($ae['id'] == $aedb->id)
					{
						$existe = true;
						if($aedb->actividad->unidad_curso_id != $unidadCurso->id)
						{
							$errores[] = 'La actividad del estudiante no pertenece al curso en el cual esta subiendo las notas. Verfique la pestaña ' . $a['actividad'];
						}
						if($aedb->estudiante_id != $ae['estudiante_id']){
							$errores[] = 'ID de estudiante no corresponde. Verifique la pestaña ' . $actividad->id . '. ESTUDIANTE_ID Cargado: ' . $ae['estudiante_id'] . ' - ESTUDIANTE_ID Base de Datos: ' . $aedb->estudiante_id;
						}
						if($ae['nota'] < 0 || $ae['nota'] > $actividad->punteo)
						{
							$errores[] = 'La nota del estudiante ' . $ae['estudiante_id'] . ' es menor a 0 o mayor a '.$actividad->punteo.'. Verifique la pestaña ' . $actividad->id . '. Nota cargada: ' . $ae['nota'] . '.';
						}
						$aedb->nota = $ae['nota'];
						$aedb->observaciones = $ae['observaciones'];
						$actividadesEstudiantesDB[] = $aedb;
					}
				}
				if(!$existe)
				{
					$errores[] = 'Actividad no asignada a estudiante. Verifique la pestaña ' . $actividad->id . '. TAREA_ID Cargado: ' . $ae['id'] . '.';
				}
			}
		}
		if(count($errores) > 0 )
		{
			$html = '<ul>';
			foreach($errores as $error)
			{
				$html .= '<li>' . $error . '</li>';
			}
			$html .= '</ul>';	
			Session::flash('error',$html);
			return redirect()->back();		
		}
		/*NO EXISTE ERRORES*/
		$manager = new UnidadCursoManager($unidadCurso, $data);
		$manager->cargarNotas($actividadesEstudiantesDB);
		Session::flash('success','Se cargaron las notas de las actividades con exito.');
		return redirect()->route('unidades_curso',$unidadCurso->curso_id);
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