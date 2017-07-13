<?php

namespace App\App\Managers;
use App\App\Repositories\ActividadEstudianteRepo;

class ActividadEstudianteManager extends BaseManager
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
			'actividad_id'  		=> 'required',
			'estudiante_id'  	=> 'required',
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function getRulesCalificarActividades($notaMaxima)
	{
		$rules = [
			'notas.*.nota' => 'required|numeric|between:0,' . $notaMaxima,
		];
		return $rules;
	}

	function calificarActividades($actividad)
	{
		$actividadEstudianteRepo = new ActividadEstudianteRepo();

		$notas = $this->data['notas'];

		$rules = $this->getRulesCalificarActividades($actividad->punteo);
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
        	//dd($validation->messages());
            throw new ValidationException('Validation failed', $validation->messages());
        }

		try{
			\DB::beginTransaction();
				foreach($notas as $nota)
				{
					$actividad = $actividadEstudianteRepo->find($nota['id']);

					/*if($nota['nota'] > $actividad->actividad->punteo)
						throw new SaveDataException("Error", new \Exception('Existen notas con mayor punteo que el asignado a la actividad.'));				*/		

					$actividad->nota = $nota['nota'];
					$actividad->observaciones = $nota['observaciones'];
					$actividad->estado = 'C';

					$actividad->save();
				}

			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error", $ex);
			
		}
	}

}