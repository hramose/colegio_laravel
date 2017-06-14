<?php

namespace App\App\Managers;
use App\App\Entities\UnidadCurso;

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
			}

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}