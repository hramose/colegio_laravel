<?php

namespace App\Http\Controllers;

use App\App\Repositories\UnidadSeccionRepo;
use App\App\Managers\UnidadSeccionManager;
use App\App\Entities\UnidadSeccion;
use Controller, Redirect, Input, View, Session, Variable, Excel,PDF;

use App\App\Entities\Seccion;
use App\App\Entities\Curso;
use App\App\Entities\Persona;
use App\App\Entities\EstudianteSeccion;

use App\App\Repositories\SeccionRepo;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\ActividadEstudianteRepo;
use App\App\Repositories\EstudianteSeccionRepo;

use App\App\Helpers\NotasHelper;

class UnidadSeccionController extends BaseController {

	protected $unidadSeccionRepo;
	protected $seccionRepo;
	protected $cursoRepo;
	protected $actividadEstudianteRepo;
	protected $estudianteSeccionRepo;

	public function __construct(UnidadSeccionRepo $unidadSeccionRepo, SeccionRepo $seccionRepo, CursoRepo $cursoRepo, ActividadEstudianteRepo $actividadEstudianteRepo, EstudianteSeccionRepo $estudianteSeccionRepo)
	{
		$this->unidadSeccionRepo = $unidadSeccionRepo;
		$this->seccionRepo = $seccionRepo;
		$this->cursoRepo = $cursoRepo;
		$this->actividadEstudianteRepo = $actividadEstudianteRepo;
		$this->estudianteSeccionRepo = $estudianteSeccionRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Seccion $seccion)
	{
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$totalPorcentaje = 0;
		foreach($unidades as $unidad)
			$totalPorcentaje += $unidad->porcentaje;
		return view('administracion/unidades_secciones/listado', compact('unidades','seccion','totalPorcentaje'));
	}

	public function mostrarAgregar(Seccion $seccion)
	{
		$unidades = Variable::getUnidades();
		return view('administracion/unidades_secciones/agregar',compact('seccion','unidades'));
	}

	public function agregar(Seccion $seccion)
	{
		$data = Input::all();
		$data['seccion_id'] = $seccion->id;
		$data['estado'] = 'A';
		$manager = new UnidadSeccionManager(new UnidadSeccion(), $data);
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$manager->agregar($cursos, $unidades);
		Session::flash('success', 'Se agregó la unidad '.Variable::getUnidad($data['unidad']).' a '.$seccion->grado->descripcion . ' ' . $seccion->descripcion_seccion .' con éxito.');
		return redirect()->route('unidades_secciones',$seccion->id);
	}

	public function mostrarEditar(UnidadSeccion $unidadSeccion)
	{
		return view('administracion/unidades_secciones/editar', compact('unidadSeccion'));
	}

	public function editar(UnidadSeccion $unidadSeccion)
	{
		$data = Input::all();
		$data['seccion_id'] = $unidadSeccion->seccion_id;
		$data['estado'] = $unidadSeccion->estado;
		$data['unidad'] = $unidadSeccion->unidad;
		$manager = new UnidadSeccionManager($unidadSeccion, $data);
		$manager->save();
		Session::flash('success', 'Se editó la unidad con éxito.');
		return redirect()->route('unidades_secciones',$unidadSeccion->seccion_id);
	}

	public function mostrarNotas(UnidadSeccion $unidadSeccion)
	{
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($unidadSeccion->seccion_id);
		$actividadesEstudiantes = $this->actividadEstudianteRepo->getBySeccion($unidadSeccion->id);
		$cursos = $this->cursoRepo->getBySeccion($unidadSeccion->seccion_id);

		$notas = [];
		foreach ($estudiantes as $estudiante) {
			$notas[$estudiante->estudiante_id]['estudiante'] = $estudiante->estudiante;
			foreach($cursos as $curso)
			{
				$notas[$estudiante->estudiante_id]['cursos'][$curso->id]['curso'] = $curso;
				$notas[$estudiante->estudiante_id]['cursos'][$curso->id]['nota'] = 0;
			}
		}
		foreach($actividadesEstudiantes as $ac)
		{
			$notas[$ac->estudiante_id]['cursos'][$ac->actividad->unidad_curso->curso_id]['nota'] += $ac->nota;
		}
		return view('administracion/unidades_secciones/notas', compact('unidadSeccion','cursos','notas'));
	}

	public function reporteNotas(UnidadSeccion $unidadSeccion)
	{
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($unidadSeccion->seccion_id);
		$actividadesEstudiantes = $this->actividadEstudianteRepo->getBySeccion($unidadSeccion->id);
		$cursos = $this->cursoRepo->getBySeccion($unidadSeccion->seccion_id);
		$notas = [];
		foreach ($estudiantes as $estudiante) {
			$notas[$estudiante->estudiante_id]['estudiante'] = $estudiante->estudiante;
			foreach($cursos as $curso)
			{
				$notas[$estudiante->estudiante_id]['cursos'][$curso->id]['curso'] = $curso;
				$notas[$estudiante->estudiante_id]['cursos'][$curso->id]['nota'] = 0;
			}
		}
		foreach($actividadesEstudiantes as $ac)
		{
			$notas[$ac->estudiante_id]['cursos'][$ac->actividad->unidad_curso->curso_id]['nota'] += $ac->nota;
		}
		Excel::create('Consolidado ' . $unidadSeccion->descripcion . ' - ' . $unidadSeccion->seccion->descripcion_con_grado, function($excel) use ($estudiantes, $actividadesEstudiantes, $cursos) {
		    $excel->sheet('Formato', function($sheet) use ($estudiantes, $actividadesEstudiantes, $cursos) {

				


		    });
		})->export('xlsx');
	}

	public function mostrarNotasSeccion(Seccion $seccion)
	{
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);

		$notasHelper = new NotasHelper();
		$notas = $notasHelper->getNotasBySeccion($unidades, $estudiantes, $cursos, $seccion);
		return view('maestros.ver_seccion', compact('seccion','cursos','notas','estudiantes'));
	}

	public function reporteNotasSeccion(Seccion $seccion)
	{
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);
		$notasHelper = new NotasHelper();
		$excel = $notasHelper->getExcelForNotasBySeccion($unidades, $estudiantes, $cursos, $seccion);
		$excel->export('xlsx');
	}

	public function mostrarDetalleNotas(UnidadSeccion $unidadSeccion, Curso $curso, Persona $estudiante)
	{
		$actividades = $this->actividadEstudianteRepo->getBySeccionByCursoByEstudiante($unidadSeccion->id, $curso->id, $estudiante->id);
		return view('administracion/unidades_secciones/detalle_notas', compact('unidadSeccion','actividades','estudiante','curso'));
	}

	public function mostrarNotasEstudiante(Seccion $seccion, EstudianteSeccion $estudiante)
	{
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);
		$notasHelper = new NotasHelper();
		$notas = $notasHelper->getNotasBySeccionByEstudiante($unidades, $estudiante->estudiante, $cursos, $seccion);
		return view('administracion.unidades_secciones.notas_estudiante', compact('seccion','cursos','notas','estudiante','unidades'));
	}

	public function reporteNotasEstudiante(Seccion $seccion, EstudianteSeccion $estudiante, $tipo)
	{
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);
		$notasHelper = new NotasHelper();
		if($tipo == 'EXCEL'){
			$excel = $notasHelper->getExcelForNotasBySeccionByEstudiante($unidades, $estudiante->estudiante, $cursos, $seccion);
			$excel->export('xlsx');
		}
		if($tipo == 'PDF')
		{
			$notas = $notasHelper->getNotasBySeccionByEstudiante($unidades, $estudiante->estudiante, $cursos, $seccion);
			//return view('reportes.notas_estudiante_seccion', compact('seccion','cursos','notas','estudiante','unidades'));
			$pdf = PDF::loadView('reportes.notas_estudiante_seccion', compact('seccion','cursos','notas','estudiante','unidades'));
			return $pdf->download('Notas '.$estudiante->estudiante->nombre_completo_apellidos.'.pdf');
		}
	}

	


}