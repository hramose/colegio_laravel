<?php

namespace App\App\Managers;
use App\App\Entities\UnidadCurso;
use App\App\Repositories\SeccionRepo;
use Variable;

class UnidadSeccionManager extends BaseManager
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
			'unidad'  => 'required',
			'seccion_id'  => 'required',
			'nota_ganar'  => 'required',
			'porcentaje' => 'required'
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregar($cursos)
	{
		$rules = $this->getRules();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		try{
			\DB::beginTransaction();

			$this->entity->fill($this->prepareData($this->data));
			$this->entity->save();

			foreach($cursos as $curso){
				$unidadCurso = new UnidadCurso();
				$unidadCurso->unidad_seccion_id = $this->entity->id;
				$unidadCurso->curso_id = $curso->id;
				$unidadCurso->estado = 'A';
				$unidadCurso->save();
			}

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();
			$unidad = $ex->getBindings()[0];
			$seccionId = $ex->getBindings()[3];

			$seccionRepo = new SeccionRepo();

			$seccion = $seccionRepo->find($seccionId);
			$unidad = Variable::getUnidad($unidad);

			if(str_contains($mensaje, 'unidad_seccion_seccion_id_unidad_unique')){
				throw new SaveDataException("Error", new \Exception('La unidad '.$unidad.' en '.$seccion->grado->descripcion . ' ' . $seccion->descripcion_seccion . ' ya existe.'));
			}
			throw new SaveDataException("Error", $ex);		
		}
	}

}