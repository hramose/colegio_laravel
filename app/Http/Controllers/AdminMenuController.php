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

		$menu->push((object)['title' => 'Dashboard', 'url' => route('dashboard'), 'class' => '' ,'icon' => 'fa fa-dashboard']);
		
		$subMenu = new Collection();
		$subMenu->push((object)['title' => 'Ciclos', 'url' => URL::route('ciclos')]);
		$subMenu->push((object)['title' => 'Grados', 'url' => URL::route('grados')]);
		$subMenu->push((object)['title' => 'Maestros', 'url' => URL::route('maestros')]);
		$subMenu->push((object)['title' => 'Materias', 'url' => URL::route('materias')]);
		$subMenu->push((object)['title' => 'Secciones', 'url' => URL::route('secciones')]);
		$menu->push((object)['title' => 'Catálogos', 'url' => '#', 'subMenu'=> $subMenu]);
		
				
		$view->menu = $menu;
		/* GET USUARIO */
		$view->usuario = Auth::user();	

    }

}