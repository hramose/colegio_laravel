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

	public function entregar()
	{
		try{
			\DB::beginTransaction();

				$this->entity->fill($this->prepareData($this->data));

				if(\Input::hasFile('archivo'))
				{
					$file = \Input::file('archivo');
					$fileOriginalName = $file->getClientOriginalName();
					$fileOrginalExtension = $file->getClientOriginalExtension();
					//$this->entity->nombre_original_archivo = $fileOriginalName;
					$fileName = $this->entity->id.'.'.$fileOrginalExtension;
					$url = 'documentos/';
					$url .= $this->entity->actividad->unidad_curso->curso->seccion->ciclo_id . '/';
					$url .= $this->entity->actividad->unidad_curso->curso->seccion->grado_id . '/';
					$url .= $this->entity->actividad->unidad_curso->curso->seccion_id . '/';
					$url .= $this->entity->actividad->unidad_curso->curso->materia_id . '/';
					$url .= $this->entity->actividad->unidad_curso->id . '/';
					$url .= $this->entity->actividad->actividad_id . '/';

					$this->entity->archivo = $file->storeAs($url,$fileName,'public');
					$this->entity->save();
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