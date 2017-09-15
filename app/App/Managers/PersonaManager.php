<?php

namespace App\App\Managers;
use App\App\Entities\User;
use App\App\Entities\Persona;
use App\App\Repositories\UsuarioRepo;
use Variable;

class PersonaManager extends BaseManager
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
			'primer_nombre'  => 'required',
			'primer_apellido'  => 'required',
			'rol'  => 'required',
			'fecha_nacimiento' => 'required|date'
		];
		return $rules;
	}

	function prepareData($data)
	{
		return $data;
	}

	/* Maestros */

	function getRulesMaestros()
	{
		$rules = [
			'primer_nombre'  => 'required',
			'primer_apellido'  => 'required',
			'fecha_nacimiento' => 'required|date',
			'cui' => 'required',
			'direccion' => 'required',
			'genero' => 'required',
			'estado' => 'required'
		];
		return $rules;
	}

	/* Estudiantes */

	function getRulesEstudiantes()
	{
		$rules = [
			'primer_nombre'  => 'required',
			'primer_apellido'  => 'required',
			'fecha_nacimiento' => 'required|date',
			'direccion' => 'required',
			'genero' => 'required',
			'estado' => 'required'
		];
		return $rules;
	}

	function prepareDataMaestros($data)
	{
		$data['rol'] = 'M';
		return $data;
	}

	function prepareDataEstudiantes($data)
	{
		$data['rol'] = 'E';
		return $data;
	}

	function saveMaestro()
	{
		$rules = $this->getRulesMaestros();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		try{
			\DB::beginTransaction();

			$this->entity->fill($this->prepareDataMaestros($this->data));
			$crearUsuario = false;
			if(is_null($this->entity->id))
			{
				$this->entity->fotografia = $this->entity->genero=='M'?'personas/male.png':'personas/female.png';
				$crearUsuario = true;
			}
			$this->entity->save();
			if($crearUsuario){
				$user = new User();
				$user->username = $this->data['username'];
				$user->password = $this->data['username'];
				$user->estado = 'A';
				$user->primera_vez = 1;
				$user->persona_id = $this->entity->id;
				$user->perfil_id = 3;
				$user->save();
			}
			if(\Input::hasFile('fotografia'))
			{
				$image = \Input::file('fotografia');
				$imageName = $this->entity->id.'.'.$image->getClientOriginalExtension();
				$this->entity->fotografia = $image->storeAs('personas',$imageName,'public');
			}
			$this->entity->save();

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();
			if(str_contains($mensaje, 'users_username_unique')){			

				$error = 'El usuario ya existe. Por favor ingrese otro.';


				throw new SaveDataException("Error", new \Exception($error));
			}
			throw new SaveDataException("Error!", $ex);			
		}
	}

	function saveEstudiante()
	{
		$rules = $this->getRulesEstudiantes();
		$validation = \Validator::make($this->data, $rules);
		if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
		try{
			\DB::beginTransaction();

			$this->entity->fill($this->prepareDataEstudiantes($this->data));
			$crearUsuario = false;
			if(is_null($this->entity->id))
			{
				$crearUsuario = true;
				$this->entity->fotografia = $this->entity->genero=='M'?'personas/boy.png':'personas/girl.png';
			}
			$this->entity->save();

			if($crearUsuario){
				$this->crearUsuarioEstudiante($this->entity);
			}

			if(\Input::hasFile('fotografia'))
			{
				$image = \Input::file('fotografia');
				$imageName = $this->entity->id.'.'.$image->getClientOriginalExtension();
				$this->entity->fotografia = $image->storeAs('personas',$imageName,'public');
			}
			$this->entity->save();

			\DB::commit();
			return $this->entity;
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();
			if(str_contains($mensaje, 'users_username_unique')){
				$error = 'No se pudo crear usuario para el estudiante. Contacte al administrador.';
				throw new SaveDataException("Error", new \Exception($error));
			}
			throw new SaveDataException("Error!", $ex);			
		}
	}

	function cargarEstudiantes()
	{
		try{
			\DB::beginTransaction();
			$estudiantes = $this->data['estudiantes'];
			$index = 1;
			$errores = false;
			$mensajeErrores = '<ul>';
			foreach($estudiantes as $estudiante)
			{
				$e = new Persona();
				$e->primer_nombre = $estudiante['PRIMER_NOMBRE'];	
				$e->segundo_nombre = $estudiante['SEGUNDO_NOMBRE'];
				$e->primer_apellido = $estudiante['PRIMER_APELLIDO'];	
				$e->segundo_apellido = $estudiante['SEGUNDO_APELLIDO'];
				$e->fecha_nacimiento = $estudiante['FECHA_NACIMIENTO'];
				$e->cui = $estudiante['CUI'];
				/*Validar cui*/
				try{ 
					intval($this->cui);
				}
				catch(\Exception $ex){
					$mensajeErrores .= '<li>Linea: '.$index.': Error en cui, no es numero.</li>';
					$errores = true;
				}

				$e->genero = $estudiante['GENERO'];
				/*Validar Genero*/
				try{ 
					Variable::getGenero($e->genero);
				}
				catch(\Exception $ex){
					$mensajeErrores .= '<li>Linea: '.$index.': Error en genero.</li>';
					$errores = true;
				}

				$e->encargado_1 = $estudiante['ENCARGADO'];
				$e->parentesco_encargado_1 = $estudiante['PARENTESCO_ENCARGADO'];
				/*validar parentesco*/
				try{ 
					Variable::getParentesco($e->parentesco_encargado_1);
				}
				catch(\Exception $ex){
					$mensajeErrores .= '<li>Linea: '.$index.': Error en parentesco.</li>';
					$errores = true;
				}
				$e->telefono_encargado_1 = $estudiante['TELEFONO_ENCARGADO'];
				$e->celular_encargado_1 = $estudiante['CELULAR_ENCARGADO'];
				$e->direccion = $estudiante['DIRECCION'];
				$e->rol = 'E';
				$e->estado = 'A';
				$e->fotografia = $e->genero=='M'?'personas/boy.png':'personas/girl.png';
				$e->save();
				$this->crearUsuarioEstudiante($e);
				$index++;
			}
			$mensajeErrores .= '</ul>';
			if($errores){
				throw new \Exception($mensajeErrores);
			}
			\DB::commit();
			return true;
		}
		catch(\Exception $ex)
		{
			$mensaje = $ex->getMessage();
			if(str_contains($mensaje, 'users_username_unique')){
				$error = 'No se pudo crear usuario para el estudiante. Contacte al administrador.';
				throw new SaveDataException("Error", new \Exception($error));
			}
			throw new SaveDataException("Error!", $ex);			
		}
	}

	private function crearUsuarioEstudiante($persona, $numeroASumar = 1)
	{
		$user = new User();
		$year = date('Y');
		$userRepo = new UsuarioRepo();
		$cantidadUsuarios = count($userRepo->getUsuariosByAnio($year));
		$username = '';
		if($cantidadUsuarios == 0)
		{
			$username = intval(str_pad($year, 9, "0", STR_PAD_RIGHT)) + $numeroASumar ;
		}
		else{
			$username = intval(str_pad($year, 9, "0", STR_PAD_RIGHT)) + $numeroASumar + $cantidadUsuarios;
		}
		$user->username = $username;
		$user->password = $username;
		$user->estado = 'A';
		$user->primera_vez = 1;
		$user->persona_id = $persona->id;
		$user->perfil_id = 4;
		$user->save();
	}

}
