<?php

namespace App\App\Managers;
use App\App\Entities\EstudianteSeccion;
use App\App\Repositories\SeccionRepo;
use App\App\Entities\ActividadEstudiante;
use Exception;

class EstudianteSeccionManager extends BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity = $entity;
        $this->data   = $data;
	}

	function getRules()
	{

		$rules = [
			'estudiante_id'  => 'required',
			'seccion_id'  => 'required',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregarEstudiantes($seccion, $actividades)
	{
		try{
			\DB::beginTransaction();

				$estudiantes = $this->data['estudiantes'];
				foreach ($estudiantes as $e) {
					if(isset($e['check'])){
						$es = new EstudianteSeccion();
						$es->seccion_id = $seccion->id;
						$es->estudiante_id = $e['estudiante'];
						$es->codigo = 0;
						$es->estado = 'A';
						$es->save();

						foreach($actividades as $actividad)
						{
							$ae = new ActividadEstudiante();
							$ae->actividad_id = $actividad->id;
							$ae->estudiante_id = $es->estudiante_id;
							$ae->estado = 'N';
							$ae->save();
						}

					}
				}

			\DB::commit();
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();
			if(str_contains($mensaje, 'estudiante_seccion_id_materia_id_unique')){
				$seccionId = $ex->getBindings()[0];
				$materiaId = $ex->getBindings()[1];

				$seccionRepo = new SeccionRepo();
				$materiaRepo = new MateriaRepo();

				$seccion = $seccionRepo->find($seccionId);
				$materia = $materiaRepo->find($materiaId);

				$error = 'La materia ' . $materia->descripcion . ' ya existe en ' . $seccion->grado->descripcion . ' ' . $seccion->descripcion_seccion . '.';


				throw new SaveDataException("Error", new \Exception($error));
			}
			throw new SaveDataException("Error", $ex);
		}
	}

	function corregirCodigos($estudiantes)
	{
		try{
			\DB::beginTransaction();
				$i=1;
				foreach ($estudiantes as $e) {
					$e->codigo = $i;
					$e->save();
					$i++;
				}

			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error", $ex);
		}
	}

}