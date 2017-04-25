@extends('layouts.admin')
@section('title') Editar Grado - {{$grado->descripcion}} @stop
@section('content')
<div class="box box-primary">
	{!! Form::model($grado, ['route' => array('editar_grado', $grado->id), 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::number('numero', null, ['data-required'=> 'true']) !!}
			{!! Field::select('nivel_academico', $niveles, null, ['data-required'=> 'true']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('grados') }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@stop