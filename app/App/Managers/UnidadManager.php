<?php

namespace App\App\Managers;

class UnidadManager extends BaseManager
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
			'curso_id'  => 'required',
			'nota_ganar'  => 'required',
			'porcentaje' => 'required'
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function save()
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
			if(\Input::hasFile('archivo_planificacion'))
			{
				$file = \Input::file('archivo_planificacion');
				$fileOriginalName = $file->getClientOriginalName();
				$fileOrginalExtension = $file->getClientOriginalExtension();
				$this->entity->nombre_original_archivo = $fileOriginalName;
				$fileName = 'planificacion.'.$fileOrginalExtension;
				$url = 'documentos/';
				$url .= $this->entity->curso->seccion->ciclo_id . '/';
				$url .= $this->entity->curso->seccion->grado_id . '/';
				$url .= $this->entity->curso->seccion_id . '/';
				$url .= $this->entity->curso->materia_id . '/';
				$url .= $this->entity->id;

				$this->entity->archivo_planificacion = $file->storeAs($url,$fileName,'public');
				$this->entity->save();
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