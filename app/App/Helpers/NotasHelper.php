<?php

namespace App\App\Helpers;

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

class NotasHelper {

	protected $unidadSeccionRepo;
	protected $seccionRepo;
	protected $cursoRepo;
	protected $actividadEstudianteRepo;
	protected $estudianteSeccionRepo;

	public function __construct()
	{
		$this->unidadSeccionRepo =  new UnidadSeccionRepo();
		$this->seccionRepo = new SeccionRepo();
		$this->cursoRepo = new CursoRepo();
		$this->actividadEstudianteRepo = new ActividadEstudianteRepo();
		$this->estudianteSeccionRepo = new EstudianteSeccionRepo();
	}

	public function getNotasBySeccion($unidades, $estudiantes, $cursos, $seccion)
	{
		$notas = [];
		$promedios = [];
		foreach($unidades as $unidad)
		{
			$notas['unidades'][$unidad->id]['unidad'] = $unidad;
			$actividadesEstudiantes = $this->actividadEstudianteRepo->getBySeccion($unidad->id);
			foreach ($estudiantes as $estudiante) {
				$notas['unidades'][$unidad->id]['estudiantes'][$estudiante->estudiante_id]['codigo'] = $estudiante->codigo;
				$notas['unidades'][$unidad->id]['estudiantes'][$estudiante->estudiante_id]['estudiante'] = $estudiante->estudiante;
				$promedios[$estudiante->estudiante_id]['codigo'] = $estudiante->codigo;
				$promedios[$estudiante->estudiante_id]['estudiante'] = $estudiante->estudiante;
				foreach($cursos as $curso)
				{
					$notas['unidades'][$unidad->id]['estudiantes'][$estudiante->estudiante_id]['cursos'][$curso->id]['curso'] = $curso;
					$notas['unidades'][$unidad->id]['estudiantes'][$estudiante->estudiante_id]['cursos'][$curso->id]['nota'] = 0;
					if(!isset($promedios[$estudiante->estudiante_id]['cursos'][$curso->id])){
						$promedios[$estudiante->estudiante_id]['cursos'][$curso->id]['curso'] = $curso;
						$promedios[$estudiante->estudiante_id]['cursos'][$curso->id]['promedio'] = 0;
					}
				}
			}
			foreach($actividadesEstudiantes as $ac)
			{
				$notas['unidades'][$unidad->id]['estudiantes'][$ac->estudiante_id]['cursos'][$ac->actividad->unidad_curso->curso_id]['nota'] += $ac->nota;
				$promedios[$ac->estudiante_id]['cursos'][$ac->actividad->unidad_curso->curso_id]['promedio'] += $ac->nota*$unidad->porcentaje/100;
			}
		}
		$notas['promedios'] = $promedios;
		return $notas;
	}

	public function getExcelForNotasBySeccion($unidades, $estudiantes, $cursos, $seccion)
	{
		$notas = $this->getNotasBySeccion($unidades, $estudiantes, $cursos, $seccion);
		return Excel::create('Consolidado ' . $seccion->descripcion_con_grado, function($excel) use ($notas, $cursos, $seccion, $unidades) {
			foreach($notas['unidades'] as $unidad){
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
			    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue(100); $cell->setAlignment('center'); });
			    		$cellN++;
			    	}
			    	$cell = Variable::getCellByNumber($cellN) . $row;
		    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue(100); $cell->setAlignment('center'); });

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

		    /*Consolidado*/
		    $excel->sheet('Consolidado', function($sheet) use ($notas, $cursos, $seccion, $unidades) {
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
	    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue('Promedio Anual'); $cell->setAlignment('center'); });
	    		$sheet->getStyle($cell)->getAlignment()->setTextRotation(90);
	    		/*Fila encabezado de notas*/
		    	$row++;
		    	$sheet->cell('A'.$row, function($cell) use ($curso) { $cell->setValue('No.'); });
		    	$sheet->cell('B'.$row, function($cell) use ($curso) { $cell->setValue('NOMBRE DEL ALUMNO'); });
		    	$cellN = 3;
		    	foreach($cursos as $curso)
		    	{
		    		$cell = Variable::getCellByNumber($cellN) . $row;
		    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue(100); $cell->setAlignment('center'); });
		    		$cellN++;
		    	}
		    	$cell = Variable::getCellByNumber($cellN) . $row;
	    		$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue(100); $cell->setAlignment('center'); });

	    		/*NOTAS*/
	    		foreach($notas['promedios'] as $notaPromedio)
	    		{
	    			$row++;   			
	    			$cellN = 1;		    			
	    			$cell = Variable::getCellByNumber($cellN) . $row;
	    			$sheet->cell($cell, function($cell) use ($notaPromedio) { $cell->setValue($notaPromedio['codigo']); $cell->setAlignment('center'); });
	    			$cellN++;
	    			$cell = Variable::getCellByNumber($cellN) . $row;
	    			$sheet->cell($cell, function($cell) use ($notaPromedio) { $cell->setValue($notaPromedio['estudiante']->nombre_completo_apellidos); });

	    			$promedio = 0;
	    			foreach($notaPromedio['cursos'] as $curso )
	    			{

	    				$cellN++;
		    			$cell = Variable::getCellByNumber($cellN) . $row;
		    			$sheet->cell($cell, function($cell) use ($curso) { $cell->setValue(round($curso['promedio'],2)); $cell->setAlignment('center'); });
		    			$promedio += round($curso['promedio'],2);
	    			}
	    			$cellN++;
	    			$cell = Variable::getCellByNumber($cellN) . $row;
	    			$promedio = round( $promedio / count($notaPromedio['cursos']) , 2);
	    			$sheet->cell($cell, function($cell) use ($promedio) { $cell->setValue($promedio); $cell->setAlignment('center'); });
	    		}
		    });
		});
	}

	public function getNotasByCurso($unidadCurso, $estudiantes, $actividades, $actividadesEstudiantes)
	{
		$notas = [];
		foreach($estudiantes as $estudiante)
		{
			$notas[$estudiante->estudiante_id]['codigo'] = $estudiante->codigo;
			$notas[$estudiante->estudiante_id]['estudiante'] = $estudiante->estudiante;
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
		return $notas;
	}

	public function getExcelForNotasByCurso($unidadCurso, $estudiantes, $actividades, $actividadesEstudiantes)
	{
		$curso = $unidadCurso->curso;
		$notas = $this->getNotasByCurso($unidadCurso, $estudiantes, $actividades, $actividadesEstudiantes);

		return Excel::create('Consolidado ' . $curso->descripcion, function($excel) use ($notas, $actividades, $curso) {

		    $excel->sheet('Notas', function($sheet) use ($notas, $actividades, $curso) {
		    	$cantidadActividades = count($actividades);
		    	$row = 1;
		    	$sheet->row($row, array('Centro Educativo Vocacional San José'));
		    	$row++;
		    	$sheet->row($row, array('CATEDRÁTICO', '', $curso->maestro->nombre_completo));
		    	$row++;
		    	$sheet->row($row, array('GRADO', '' , $curso->descripcion));

		    	/*merge cells encabezados*/
		    	$sheet->mergeCells('A1:B1');
		    	$sheet->mergeCells('A2:B2');
		    	/* +2: suma de primeras dos columnas, cantidad de actividades, +1:nota promedio */
		    	$sheet->mergeCells('C2:'.Variable::getCellByNumber(2+$cantidadActividades+1).'2');
		    	$sheet->cell('C2', function($cell) { $cell->setAlignment('center'); });
		    	$sheet->mergeCells('A3:B3');
		    	$sheet->mergeCells('C3:'.Variable::getCellByNumber(2+$cantidadActividades+1).'3');
		    	$sheet->cell('C3', function($cell) { $cell->setAlignment('center'); });

		    	$row++;
		    	/*Fila de Actividades*/
		    	$cellN = 3;
		    	foreach($actividades as $actividad)
		    	{
		    		$cell = Variable::getCellByNumber($cellN) . $row;
		    		$sheet->cell($cell, function($cell) use ($actividad) { $cell->setValue($actividad->titulo); $cell->setAlignment('center'); });
		    		$sheet->getStyle($cell)->getAlignment()->setTextRotation(90);
		    		$cellN++;
		    	}
		    	$cell = Variable::getCellByNumber($cellN) . $row;
	    		$sheet->cell($cell, function($cell) { $cell->setValue('Total'); $cell->setAlignment('center'); });
	    		$sheet->getStyle($cell)->getAlignment()->setTextRotation(90);
	    		/*Fila encabezado de notas*/
		    	$row++;
		    	$sheet->cell('A'.$row, function($cell) { $cell->setValue('No.'); });
		    	$sheet->cell('B'.$row, function($cell) { $cell->setValue('NOMBRE DEL ALUMNO'); });
		    	$cellN = 3;
		    	foreach($actividades as $actividad)
		    	{
		    		$cell = Variable::getCellByNumber($cellN) . $row;
		    		$sheet->cell($cell, function($cell) use ($actividad) { $cell->setValue($actividad->punteo); });
		    		$cellN++;
		    	}
		    	$cell = Variable::getCellByNumber($cellN) . $row;
	    		$sheet->cell($cell, function($cell) use ($actividad) { $cell->setValue(100); });

	    		/*NOTAS*/
	    		foreach($notas as $nota)
	    		{
	    			$row++;   			
	    			$cellN = 1;		    			
	    			$cell = Variable::getCellByNumber($cellN) . $row;
	    			$sheet->cell($cell, function($cell) use ($nota) { $cell->setValue($nota['codigo']); $cell->setAlignment('center'); });
	    			$cellN++;
	    			$cell = Variable::getCellByNumber($cellN) . $row;
	    			$sheet->cell($cell, function($cell) use ($nota) { $cell->setValue($nota['estudiante']->nombre_completo_apellidos); });

	    			$total = 0;
	    			foreach($actividades as $actividad)
	    			{

	    				$cellN++;
		    			$cell = Variable::getCellByNumber($cellN) . $row;
		    			$sheet->cell($cell, function($cell) use ($actividad, $nota) { $cell->setValue(round($nota[$actividad->id],2)); $cell->setAlignment('center'); });
		    			$total += round($nota[$actividad->id],2);
	    			}
	    			$cellN++;
	    			$cell = Variable::getCellByNumber($cellN) . $row;
	    			$sheet->cell($cell, function($cell) use ($total) { $cell->setValue($total); $cell->setAlignment('center'); });
	    		}
		    });
		});
	}

	public function getNotasBySeccionByEstudiante($unidades, $estudiante, $cursos, $seccion)
	{
		$notas = [];

		$promedio = [];

		foreach($unidades as $unidad)
		{
			$actividades = $this->actividadEstudianteRepo->getBySeccionByEstudiante($unidad->id,$estudiante->id);
			foreach($cursos as $curso)
			{
				if(!isset($notas['cursos'][$curso->id])){
					$notas['cursos'][$curso->id]['curso'] = $curso;
					$notas['cursos'][$curso->id]['nota_anual'] = 0;
					$notas['cursos'][$curso->id]['promedio_anual'] = 0;
				}
				$total = 0;
				foreach($actividades as $actividad)
				{
					if($actividad->actividad->unidad_curso->curso_id == $curso->id)
						$total += $actividad->nota;
				}
				$notas['cursos'][$curso->id]['unidades'][$unidad->id]['unidad'] = $unidad;
				$notas['cursos'][$curso->id]['unidades'][$unidad->id]['nota'] = $total;
				$notas['cursos'][$curso->id]['nota_anual'] += $unidad->porcentaje/100*$total;

				if(!isset($promedio['unidades'][$unidad->id]))
					$promedio['unidades'][$unidad->id] = 0;
				$promedio['unidades'][$unidad->id] += $total;
			}
		}
		
		/*Calcular Promedio*/
		$cantidadCursos = count($cursos);
		$promedioUnidades = 0;
		foreach($unidades as $unidad)
		{
			$promedio['unidades'][$unidad->id] = round($promedio['unidades'][$unidad->id] / $cantidadCursos,2);
			$promedioUnidades += $promedio['unidades'][$unidad->id];
		}
		$promedio['promedio_unidades'] = round($promedioUnidades/count($unidades),2);
		$notas['promedios'] = $promedio;
		return $notas;
	}

}