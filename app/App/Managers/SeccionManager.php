<?php

namespace App\App\Managers;
use App\App\Entities\Seccion;
use App\App\Entities\UnidadSeccion;
use App\App\Repositories\DetallePlantillaUnidadRepo;
use Exception;

class SeccionManager extends BaseManager
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
			'grado_id'  => 'required',
			'maestro_id'  => 'required',
			'estado' => 'required'
		];

		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	function agregarSecciones($cicloId)
	{
		$detallePlantillaUnidadRepo = new DetallePlantillaUnidadRepo();
		try{
			\DB::beginTransaction();

				$secciones = $this->data['secciones'];
				foreach ($secciones as $s) {
					$seccion = new Seccion();
					$seccion->ciclo_id = $cicloId;
					$seccion->grado_id = $s['grado'];
					$seccion->seccion = $s['seccion'];
					$seccion->maestro_id = $s['maestro'];
					$seccion->estado = 'A';
					$seccion->save();

					if($s['plantilla'] != ''){
						$unidades = $detallePlantillaUnidadRepo->getByPlantilla($s['plantilla']);
						foreach($unidades as $unidad)
						{
							$us = new UnidadSeccion();
							$us->seccion_id = $seccion->id;
							$us->unidad = $unidad->unidad;
							$us->nota_ganar = $unidad->nota_ganar;
							$us->porcentaje = $unidad->porcentaje;
							$us->estado = 'A';
							$us->save();
						}

					}

				}

			\DB::commit();
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();
			if(str_contains($mensaje, 'uq_seccion_cgs')){
				throw new SaveDataException("Error", new \Exception('Intentó agregar una sección que ya existe. ERROR DB: ' . $ex->errorInfo[2], 1));
			}
			throw new SaveDataException("Error", $ex);
		}
	}

}