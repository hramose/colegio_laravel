<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection; 
use Auth, URL;

class AdminMenuController extends BaseController{

	protected $cicloNombre;

	public function __construct(){
	}

    public function compose($view)
    {        

        $menu = new Collection();
        $user = Auth::user();
        if($user->perfil_id == 1){
			$menu->push((object)['title' => 'Dashboard', 'url' => route('dashboard'), 'class' => '' ,'icon' => 'fa fa-dashboard']);
			$subMenu = new Collection();
			$subMenu->push((object)['title' => 'Perfiles', 'url' => URL::route('perfiles')]);
			$subMenu->push((object)['title' => 'Usuarios', 'url' => URL::route('usuarios')]);
			$menu->push((object)['title' => 'Administración', 'url' => '#', 'subMenu'=> $subMenu]);
			
			$subMenu = new Collection();
			$subMenu->push((object)['title' => 'Ciclos', 'url' => URL::route('ciclos')]);
			$subMenu->push((object)['title' => 'Estudiantes', 'url' => URL::route('estudiantes')]);
			$subMenu->push((object)['title' => 'Grados', 'url' => URL::route('grados')]);
			$subMenu->push((object)['title' => 'Maestros', 'url' => URL::route('maestros')]);
			$subMenu->push((object)['title' => 'Materias', 'url' => URL::route('materias')]);
			$subMenu->push((object)['title' => 'Tipos Actividades', 'url' => URL::route('tipos_actividades')]);
			$menu->push((object)['title' => 'Catálogos', 'url' => '#', 'subMenu'=> $subMenu]);
			
			$menu->push((object)['title' => 'Secciones', 'url' => URL::route('secciones')]);
		}
		elseif($user->perfil_id == 3){
			$menu->push((object)['title' => 'Dashboard', 'url' => route('maestros.dashboard'), 'class' => '' ,'icon' => 'fa fa-dashboard']);
		}
		elseif($user->perfil_id == 4){
			$menu->push((object)['title' => 'Dashboard', 'url' => route('estudiantes.dashboard'), 'class' => '' ,'icon' => 'fa fa-dashboard']);
			$menu->push((object)['title' => 'Cursos', 'url' => route('estudiantes.cursos'), 'class' => '' ,'icon' => 'fa fa-dashboard']);
		}
				
		$view->menu = $menu;
		/* GET USUARIO */
		$user = Auth::user();
		$view->usuario = $user;

		$view->notificacionesNoLeidas = count($user->persona->unreadNotifications); 
		$view->notificaciones = $user->persona->notifications()->limit(3)->get();

    }

}