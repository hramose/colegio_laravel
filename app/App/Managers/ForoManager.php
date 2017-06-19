<?php

namespace App\App\Managers;
use App\App\Entities\MensajeForo;
use App\Notifications\ForoCreado;
use Exception;

class ForoManager extends BaseManager
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
			'curso_id'  => 'required',
			'tema'    => 'required',
            'autor_id'  => 'required',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregar()
	{
		try{
			\DB::beginTransaction();

				$rules = $this->getRules();
                $validation = \Validator::make($this->data, $rules);
                if ($validation->fails())
                {
                    throw new ValidationException('Validation failed', $validation->messages());
                }
                $this->entity->fill($this->prepareData($this->data));	
                $this->entity->visitas = 0;	
		        $this->entity->save();

                $mensaje = new MensajeForo();
                $mensaje->foro_id = $this->entity->id;
                $mensaje->mensaje = $this->data['mensaje'];
                $mensaje->autor_id = $this->entity->autor_id;
                $mensaje->estado = 'A';
                $mensaje->save();

				$estudiantes = $this->entity->curso->seccion->estudiantes;
				foreach($estudiantes as $estudiante)
				{
					$estudiante->estudiante->notify(new ForoCreado($estudiante->estudiante, $this->entity, $mensaje));
				}

			\DB::commit();
		}
		catch(\Exception $ex)
		{
			dd($ex);
			throw new SaveDataException("Error", $ex);
		}
	}

}