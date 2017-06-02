<?php

namespace App\App\Managers;

class TareaManager extends BaseManager
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
			'titulo'  		=> 'required',
			'unidad_id'  	=> 'required',
			'descripcion'  	=> 'required',
			'porcentaje' 	=> 'required'
		];
		
		if(isset($this->data['aplica_fecha'])){
			$rules['fecha_inicio'] = 'required';
			$rules['fecha_fin'] = 'required';
		}
		return $rules;
	}

	function prepareData($data)
	{
		$data['aplica_fecha'] = isset($data['aplica_fecha']) ? 1 : 0;
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
			if(\Input::hasFile('archivo'))
			{
				$image = \Input::file('archivo');
				$imageName = 'planificacion.'.$image->getClientOriginalExtension();
				$url = 'documentos/'.\Auth::user()->ciclo->id . '/' . $this->entity->id;  
				$this->entity->archivo = $image->storeAs($url,$imageName,'public');
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