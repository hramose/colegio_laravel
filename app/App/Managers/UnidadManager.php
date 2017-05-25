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
				$image = \Input::file('archivo_planificacion');
				$imageName = 'planificacion.'.$image->getClientOriginalExtension();
				$url = 'documentos/'.\Auth::user()->ciclo->id . '/' . $this->entity->id;  
				$this->entity->archivo_planificacion = $image->storeAs($url,$imageName,'public');
			}
			$this->entity->save();

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);			
		}
	}

}