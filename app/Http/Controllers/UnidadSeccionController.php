<?php

namespace App\Http\Controllers;

use App\App\Repositories\UnidadSeccionRepo;
use App\App\Managers\UnidadSeccionManager;
use App\App\Entities\UnidadSeccion;
use Controller, Redirect, Input, View, Session, Variable, Excel;

use App\App\Entities\Seccion;
use App\App\Entities\Curso;
use App\App\Entities\Persona;

use App\App\Repositories\SeccionRepo;
use App\App\Repositories\CursoRepo;
use App\App\Repositories\ActividadEstudianteRepo;
use App\App\Repositories\EstudianteSeccionRepo;

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
		$notas = $this->getNotasSeccion($unidades, $estudiantes, $cursos);
		return view('maestros.ver_seccion', compact('seccion','cursos','notas'));
	}

	public function reporteNotasSeccion(Seccion $seccion)
	{
		$unidades = $this->unidadSeccionRepo->getBySeccion($seccion->id);
		$estudiantes = $this->estudianteSeccionRepo->getBySeccion($seccion->id);
		$cursos = $this->cursoRepo->getBySeccion($seccion->id);
		$notas = $this->getNotasSeccion($unidades, $estudiantes, $cursos);

		Excel::create('Consolidado ' . $seccion->descripcion_con_grado, function($excel) use ($notas, $cursos, $seccion) {
			foreach($notas as $unidad){
			    $excel->sheet($unidad['unidad']->descripcion, function($sheet) use ($cursos, $seccion, $unidad) {
			    	$cantidadCursos = count($cursos);
			    	$row = 1;
			    	$sheet->row($row, array('Centro Educativo Vocacional San José'));
			    	$row++;
			    	$sheet->row($row, array('CATEDRÁTICO GUÍA', '', $seccion->maestro->nombre_completo));
			    	$row++;
			    	$sheet->row($row, array('GRADO', '' , $seccion->descripcion_con_grado));

			    	/*merge cells encabezados*/
			    	$sheet->mergeCells('A1:B1');
			    	$sheet->mergeCells('A2:B2');
			    	/* +2: suma de primeras dos columnas, cantidad de cursos, +1:nota promedio */
			    	$sheet->mergeCells('C2:'.Variable::getCellByNumber(2+$cantidadCursos+1).'2');
			    	$sheet->cell('C2', function($cell) { $cell->setAlignment('center'); });
			    	$sheet->mergeCells('A3:B3');
			    	$sheet->mergeCells('C3:'.Variable::getCellByNumber(2+$cantidadCursos+1).'3');
			    	$sheet->cell('C3', function($cell) { $cell->setAlignment('center'); });

			    	$row++;
			    	/*Fila de Cursos*/
			    	$cellN = 3;
			    	foreach($cursos as $curso)
			    	{
			    		$cell = Variable::getCellByNumber($cellN) . $row;
			    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue($curso->materia->descripcion); $cell->setAlignment('center'); });
			    		$sheet->getStyle($cell)->getAlignment()->setTextRotation(90);
			    		$cellN++;
			    	}
			    	$cell = Variable::getCellByNumber($cellN) . $row;
		    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue('Promedio unidad'); $cell->setAlignment('center'); });
		    		$sheet->getStyle($cell)->getAlignment()->setTextRotation(90);
		    		/*Fila encabezado de notas*/
			    	$row++;
			    	$sheet->cell('A'.$row, function($cell) use ($curso) { $cell->setValue('No.'); });
			    	$sheet->cell('B'.$row, function($cell) use ($curso) { $cell->setValue('NOMBRE DEL ALUMNO'); });
			    	$cellN = 3;
			    	foreach($cursos as $curso)
			    	{
			    		$cell = Variable::getCellByNumber($cellN) . $row;
			    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue(100); });
			    		$cellN++;
			    	}
			    	$cell = Variable::getCellByNumber($cellN) . $row;
		    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue(100); });

		    		/*NOTAS*/
		    		foreach($unidad['estudiantes'] as $nota)
		    		{
		    			$row++;   			
		    			$cellN = 1;		    			
		    			$cell = Variable::getCellByNumber($cellN) . $row;
		    			$sheet->cell($cell, function($cell) use ($nota) { $cell->setValue($nota['codigo']); $cell->setAlignment('center'); });
		    			$cellN++;
		    			$cell = Variable::getCellByNumber($cellN) . $row;
		    			$sheet->cell($cell, function($cell) use ($nota) { $cell->setValue($nota['estudiante']->nombre_completo_apellidos); });

		    			$promedio = 0;
		    			foreach($nota['cursos'] as $curso )
		    			{

		    				$cellN++;
			    			$cell = Variable::getCellByNumber($cellN) . $row;
			    			$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue(round($curso['nota'],2)); $cell->setAlignment('center'); });
			    			$promedio += round($curso['nota'],2);
		    			}
		    			$cellN++;
		    			$cell = Variable::getCellByNumber($cellN) . $row;
		    			$promedio = round( $promedio / count($nota['cursos']) , 2);
		    			$sheet->cell($cell, function($cell) use ($promedio) { $cell->setValue($promedio); $cell->setAlignment('center'); });
		    		}
			    });
		    }
		})->export('xlsx');



	}

	public function mostrarDetalleNotas(UnidadSeccion $unidadSeccion, Curso $curso, Persona $estudiante)
	{
		$actividades = $this->actividadEstudianteRepo->getBySeccionByCursoByEstudiante($unidadSeccion->id, $curso->id, $estudiante->id);
		return view('administracion/unidades_secciones/detalle_notas', compact('unidadSeccion','actividades','estudiante','curso'));
	}

	private function getNotasSeccion($unidades, $estudiantes, $cursos)
	{
		$notas = [];
		foreach($unidades as $unidad)
		{
			$notas[$unidad->id]['unidad'] = $unidad;
			$actividadesEstudiantes = $this->actividadEstudianteRepo->getBySeccion($unidad->id);
			foreach ($estudiantes as $estudiante) {
				$notas[$unidad->id]['estudiantes'][$estudiante->estudiante_id]['codigo'] = $estudiante->codigo;
				$notas[$unidad->id]['estudiantes'][$estudiante->estudiante_id]['estudiante'] = $estudiante->estudiante;
				foreach($cursos as $curso)
				{
					$notas[$unidad->id]['estudiantes'][$estudiante->estudiante_id]['cursos'][$curso->id]['curso'] = $curso;
					$notas[$unidad->id]['estudiantes'][$estudiante->estudiante_id]['cursos'][$curso->id]['nota'] = 0;
				}
			}
			foreach($actividadesEstudiantes as $ac)
			{
				$notas[$unidad->id]['estudiantes'][$ac->estudiante_id]['cursos'][$ac->actividad->unidad_curso->curso_id]['nota'] += $ac->nota;
			}
		}
		return $notas;
	}


}