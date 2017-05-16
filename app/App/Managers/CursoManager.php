<?php

namespace App\App\Managers;
use App\App\Entities\Curso;
use App\App\Repositories\SeccionRepo;
use App\App\Repositories\MateriaRepo;
use Exception;

class CursoManager extends BaseManager
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
			'materia_id'  => 'required',
			'maestro_id'  => 'required',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregarCursos($seccionId)
	{
		try{
			\DB::beginTransaction();

				$cursos = $this->data['cursos'];
				foreach ($cursos as $c) {
					$curso = new Curso();
					$curso->seccion_id = $seccionId;
					$curso->materia_id = $c['materia'];
					$curso->maestro_id = $c['maestro'];
					$curso->estado = 'A';
					$curso->save();
				}

			\DB::commit();
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();
			if(str_contains($mensaje, 'curso_seccion_id_materia_id_unique')){
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

}