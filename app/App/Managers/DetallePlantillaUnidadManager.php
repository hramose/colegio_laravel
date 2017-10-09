<?php

namespace App\App\Managers;
use App\App\Entities\UnidadCurso;
use App\App\Repositories\SeccionRepo;
use Variable;

class DetallePlantillaUnidadManager extends BaseManager
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
			'plantilla_unidad_id'  => 'required',
			'unidad'  => 'required',
			'nota_ganar'  => 'required',
			'porcentaje' => 'required'
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregar($unidades)
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

			$total = 0;
			foreach($unidades as $unidad)
			{
				if($unidad->id != $this->entity->id)
					$total += $unidad->porcentaje;
			}
			$total += $this->entity->porcentaje;
			if($total > 100){
				throw new \Exception("El porcentaje total de todas las unidades supera los 100 puntos (".$total.").", 1);
				
			}

			$this->entity->save();

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();

			if(str_contains($mensaje, 'detalle_plantilla_unidad_plantilla_unidad_id_unidad_unique')){

				$unidad = $ex->getBindings()[0];
				$unidad = Variable::getUnidad($unidad);

				throw new SaveDataException("Error", new \Exception('La unidad '.$unidad.' ya existe en la plantilla.'));
			}
			throw new SaveDataException("Error", $ex);		
		}
	}
	
}