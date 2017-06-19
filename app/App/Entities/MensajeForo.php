<?php

namespace App\App\Entities;
use Variable;

class MensajeForo extends \Eloquent {

	use UserStamps;

	protected $fillable = ['foro_id','mensaje','autor_id','estado'];

	protected $table = 'mensaje_foro';

	public function foro()
	{
		return $this->belongsTo(Foro::class);
	}

	public function autor()
	{
		return $this->belongsTo(Persona::class, 'autor_id');
	}

}