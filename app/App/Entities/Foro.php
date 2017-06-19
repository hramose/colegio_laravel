<?php

namespace App\App\Entities;
use Variable;

class Foro extends \Eloquent {

	use UserStamps;

	protected $fillable = ['curso_id','tema','autor_id','visitas','estado'];

	protected $table = 'foro';

	public function curso()
	{
		return $this->belongsTo(Curso::class);
	}

	public function autor()
	{
		return $this->belongsTo(Persona::class, 'autor_id');
	}

	public function mensajes()
	{
		return $this->hasMany(MensajeForo::class)->with('autor');
	}

	public function getRespuestasAttribute()
	{
		return count($this->mensajes);
	}

	public function getUltimaRespuestaAttribute()
	{
		$mensajes = $this->mensajes;
		if(!empty($mensajes))
			return $mensajes->last();
		return null;
	}

}