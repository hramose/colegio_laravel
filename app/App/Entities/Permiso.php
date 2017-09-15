<?php

namespace App\App\Entities;

class Permiso extends \Eloquent {

	use UserStamps;
	
	protected $fillable = [];

	protected $table = 'permiso';

	public function vista()
	{
		return $this->belongsTo(Vista::class);
	}

}