<?php

namespace App\App\Managers;
use App\App\Repositories\EstudianteSeccionRepo;
use App\App\Entities\ActividadEstudiante;
use App\Notifications\ActividadCreada;

class ActividadManager extends BaseManager
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
			'titulo'  			=> 'required',
			'unidad_curso_id'  	=> 'required',
			'descripcion'  		=> 'required',
			'porcentaje' 		=> 'required'
		];
		
		if(isset($this->data['aplica_fecha'])){
			$rules['fecha_inicio'] = 'required';
			$rules['fecha_entrega'] = 'required';
		}
		return $rules;
	}

	function prepareData($data)
	{
		$data['aplica_fecha'] = isset($data['aplica_fecha']) ? 1 : 0;
		$data['entrega_via_web'] = isset($data['entrega_via_web']) ? 1 : 0;
		return $data;
	}

	function save()
	{
		$action = 'save';
		if(!is_null($this->entity->id)){
			$action = 'update';
		}
		$estudianteSeccionRepo = new EstudianteSeccionRepo();
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
				$file = \Input::file('archivo');
				$fileOriginalName = $file->getClientOriginalName();
				$fileOrginalExtension = $file->getClientOriginalExtension();
				$this->entity->nombre_original_archivo = $fileOriginalName;
				$fileName = 'Actividad'.$this->entity->id.'.'.$fileOrginalExtension;
				$url = 'documentos/';
				$url .= $this->entity->unidad_curso->curso->seccion->ciclo_id . '/';
				$url .= $this->entity->unidad_curso->curso->seccion->grado_id . '/';
				$url .= $this->entity->unidad_curso->curso->seccion_id . '/';
				$url .= $this->entity->unidad_curso->curso->materia_id . '/';
				$url .= $this->entity->unidad_curso_id;

				$this->entity->archivo = $file->storeAs($url,$fileName,'public');
				$this->entity->save();
			}

			if($action == 'save'){
				$estudiantes = $estudianteSeccionRepo->getBySeccion($this->entity->unidad_curso->curso->seccion_id);
				foreach($estudiantes as $estudiante)
				{
					$te = new ActividadEstudiante();
					$te->actividad_id = $this->entity->id;
					$te->estudiante_id = $estudiante->estudiante_id;
					$te->estado = 'N';
					$te->save();

					$estudiante->estudiante->notify(new ActividadCreada($estudiante->estudiante, $this->entity));

				}
			}

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			dd($ex);
			throw new SaveDataException("Error!", $ex);			
		}
	}

}