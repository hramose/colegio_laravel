<?php

namespace App\App\Entities;

class Vista extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion','ruta','modulo_id','estado'];

	protected $table = 'vista';

	public function modulo()
	{
		return $this->belongsTo(Modulo::class);
	}

}