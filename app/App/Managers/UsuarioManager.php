<?php

namespace App\App\Managers;

class UsuarioManager extends BaseManager
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
			'username' 			 	=> 'required|unique:users,username',
			'password' 			 	=> 'required|confirmed',
			'password_confirmation' => 'required',
		];

		return $rules;
	}

	function prepareData($data)
	{
		$data['primera_vez'] = 1;
		$data['estado'] = 'A';
		return $data;
	}

	public function resetPassword()
	{
		try{
			\DB::beginTransaction();

				$this->entity->password = $this->entity->username;
				$this->entity->primera_vez = 1;
				$this->entity->save();

			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);
			
		}
	}

	public function inactivarUsuario()
	{
		try{
			\DB::beginTransaction();

				$this->entity->estado = 'I';
				$this->entity->save();

			\DB::commit();
		}
		catch(\Exception $ex)
		{
			throw new SaveDataException("Error!", $ex);
			
		}
	}

}