<?php

namespace App\App\Managers;
use App\App\Repositories\CicloRepo;

class CicloManager extends BaseManager
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
			'descripcion'  => 'required',
			'fecha_inicio' => 'required|date',
			'fecha_fin' => 'required|date',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		$data['actual'] = isset($data['actual']) ? 1 : 0;
		return $data;
	}

	public function save()
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
				if($this->entity->actual == 1){
					$cicloRepo = new CicloRepo();
					$cicloActual = $cicloRepo->getActual();
					$cicloActual->actual = 0;
					$cicloActual->save();
				}
				$this->entity->save();
			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error", $ex);
			
		}
	}

}