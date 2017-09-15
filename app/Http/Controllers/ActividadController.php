<?php

namespace App\Http\Controllers;

use App\App\Repositories\ActividadRepo;
use App\App\Managers\ActividadManager;
use App\App\Entities\Actividad;
use Controller, Redirect, Input, View, Session, Variable, Excel, Gate;

use App\App\Entities\UnidadCurso;
use App\App\Repositories\UnidadCursoRepo;
use App\App\Repositories\TipoActividadRepo;

use App\App\Repositories\ActividadEstudianteRepo;
use App\App\Entities\ActividadEstudiante;
use App\App\Managers\ActividadEstudianteManager;
use App\App\Managers\SaveDataException;

class ActividadController extends BaseController {

	protected $actividadRepo;
	protected $tipoActividadRepo;
	protected $unidadCursoRepo;
	protected $actividadEstudianteRepo;

	public function __construct(ActividadRepo $actividadRepo, UnidadCursoRepo $unidadCursoRepo, TipoActividadRepo $tipoActividadRepo,ActividadEstudianteRepo $actividadEstudianteRepo)
	{
		$this->actividadRepo = $actividadRepo;
		$this->tipoActividadRepo = $tipoActividadRepo;
		$this->unidadCursoRepo = $unidadCursoRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAgregar(UnidadCurso $unidadCurso)
	{
		$tipos = $this->tipoActividadRepo->lists('descripcion','id');
		return view('administracion/actividades/agregar',compact('tipos','unidadCurso'));
	}

	public function agregar(UnidadCurso $unidadCurso)
	{
		$data = Input::all();
		$data['unidad_curso_id'] = $unidadCurso->id;
		$data['estado'] = 'A';

		$actividades = $unidadCurso->actividades;

		$tipoActividad = $this->tipoActividadRepo->find($data['tipo_actividad_id']);
		if($tipoActividad->puntos_extras == 0){
			$total = 0;
			foreach($actividades as $actividad)
			{
				if($actividad->tipo->puntos_extras == 0)
					$total += $actividad->punteo;
			}
			$total += $data['punteo'];
			if($total > 100)
				throw new SaveDataException("Error", new \Exception("El total del punteo de las tareas en la unidad supera los 100 puntos (".$total.")."));
		}

		$manager = new ActividadManager(new Actividad(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la actividad '.$data['titulo'].' con éxito.');
		$url = route('unidades_curso',$unidadCurso->curso_id) . "#" . $unidadCurso->id;
		return redirect()->to($url);
	}

	public function mostrarEditar(Actividad $actividad)
	{
		$tipos = $this->tipoActividadRepo->lists('descripcion','id');
		return view('administracion/actividades/editar', compact('actividad','tipos'));
	}

	public function editar(Actividad $actividad)
	{
		$data = Input::all();
		$data['unidad_curso_id'] = $actividad->unidad_curso_id;
		$data['estado'] = $actividad->estado;
		$data['actividad'] = $actividad->actividad;

		$actividades = $actividad->unidad_curso->actividades;
		$total = 0;
		foreach($actividades as $a)
		{
			if($a->id != $actividad->id && $a->tipo->puntos_extras == 0)
				$total += $a->punteo;
		}
		$total += $data['punteo'];
		if($total > 100)
			throw new SaveDataException("Error", new \Exception("El total del punteo de las tareas en la unidad supera los 100 puntos (".$total.")."));

		$manager = new ActividadManager($actividad, $data);
		$manager->save();
		Session::flash('success', 'Se editó la actividad '.$actividad->titulo.' con éxito.');
		$url = route('unidades_curso',$actividad->unidad_curso->curso_id) . "#" . $actividad->unidad_curso->id;
		return redirect()->to($url);
	}

	public function mostrarVerNotas(Actividad $actividad)
	{
		$actividades = $this->actividadEstudianteRepo->getByActividad($actividad->id);	
		return view('maestros/ver_notas_actividad', compact('actividad','actividades'));
	}

	public function mostrarCalificarActividades(Actividad $actividad)
	{
		if(Gate::denies('calificar_actividad',$actividad))
		{
			Session::flash('error', 'La actividad ya no se puede calificar debido a que la unidad ya fue cerrada.');
			return redirect()->back();
		}
		$actividades = $this->actividadEstudianteRepo->getByActividad($actividad->id);	
		return view('administracion/actividades/calificar_actividades', compact('actividad','actividades'));
	}

	public function calificarActividades(Actividad $actividad)
	{
		if(Gate::denies('calificar_actividad',$actividad))
		{
			Session::flash('error', 'La actividad ya no se puede calificar debido a que la unidad ya fue cerrada.');
			return redirect()->back();
		}
		$data = Input::all();
		$manager = new ActividadEstudianteManager(null, $data);
		$manager->calificarActividades($actividad);
		Session::flash('success', 'Se calificaron las actividades de '.$actividad->titulo.' con éxito.');
		return redirect()->route('ver_notas_actividad',$actividad->id);
	}

	public function mostrarCalificarActividad(ActividadEstudiante $actividad)
	{
		if(Gate::denies('calificar_actividad',$actividad->actividad))
		{
			Session::flash('error', 'La actividad ya no se puede calificar debido a que la unidad ya fue cerrada.');
			return redirect()->back();
		}
		return view('administracion/actividades/calificar_actividad', compact('actividad'));
	}

	public function calificarActividad(ActividadEstudiante $actividad)
	{
		if(Gate::denies('calificar_actividad',$actividad->actividad))
		{
			Session::flash('error', 'La actividad ya no se puede calificar debido a que la unidad ya fue cerrada.');
			return redirect()->back();
		}
		$data = Input::all();

		if($actividad->actividad->punteo <= $data['nota']){
			Session::flash('error', 'La nota ('.$data['nota'].') es mayor al punteo maximo ('.$actividad->actividad->punteo.').');
			return redirect()->back();
		}
		$data['actividad_id'] = $actividad->actividad_id;
		$data['estudiante_id'] = $actividad->estudiante_id;
		$data['estado'] = 'C';
		$manager = new ActividadEstudianteManager($actividad, $data);
		$manager->save();
		Session::flash('success', 'Se calificó la actividad de '.$actividad->actividad->titulo.' de '.$actividad->estudiante->nombre_completo.' con éxito.');
		return redirect()->route('ver_notas_actividad',$actividad->actividad_id);
	}

	public function descargarFormatoCalificarActividad(Actividad $actividad)
	{
		$data = Input::all();
		$actividadesDB = $this->actividadEstudianteRepo->getByActividad($actividad->id);
		$actividades = [];
		foreach($actividadesDB as $act)
		{
			$a['ID'] = $act->id;
			$a['ESTUDIANTE'] = $act->estudiante->nombre_completo_apellidos;
			$a['NOTA'] = $act->nota;
			$a['OBSERVACIONES'] = $act->observaciones;
			$actividades[] = $a;
		}
		Excel::create('Carga - ' . $actividad->titulo, function($excel) use ($actividad, $actividades) {
		    $excel->sheet('Formato', function($sheet) use ($actividades) {
				$sheet->fromArray($actividades);
		    });
		})->export('xlsx');

	}

	public function mostrarCargarNotas(Actividad $actividad)
	{
		if(Gate::denies('calificar_actividad',$actividad))
		{
			Session::flash('error', 'La actividad ya no se puede calificar debido a que la unidad ya fue cerrada.');
			return redirect()->back();
		}
		return view('administracion/actividades/cargar_notas', compact('actividad'));
	}

	public function cargarNotas(Actividad $actividad)
	{
		$data = Input::all();
		$manager = new ActividadEstudianteManager(null, $data);
		$manager->calificarActividadesCargadas($actividad);
		Session::flash('success', 'Se calificaron las actividades de '.$actividad->titulo.' con éxito.');
		return redirect()->route('ver_notas_actividad',$actividad->id);
	}

}