<?php

namespace App\App\Managers;
use App\App\Repositories\EstudianteSeccionRepo;
use App\App\Entities\ActividadEstudiante;

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
		$data['entrega_via_web'] = isset($data['entrega_via_web']) ? 1 : 0;
		return $data;
	}

	function save()
	{
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
				$url .= $this->entity->unidad->curso->seccion->ciclo_id . '/';
				$url .= $this->entity->unidad->curso->seccion->grado_id . '/';
				$url .= $this->entity->unidad->curso->seccion_id . '/';
				$url .= $this->entity->unidad->curso->materia_id . '/';
				$url .= $this->entity->unidad_id;

				$this->entity->archivo = $file->storeAs($url,$fileName,'public');
				$this->entity->save();
			}

			$estudiantes = $estudianteSeccionRepo->getBySeccion($this->entity->unidad->curso->seccion_id);
			foreach($estudiantes as $estudiante)
			{
				$te = new ActividadEstudiante();
				$te->actividad_id = $this->entity->id;
				$te->estudiante_id = $estudiante->estudiante_id;
				$te->estado = 'N';
				$te->save();
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