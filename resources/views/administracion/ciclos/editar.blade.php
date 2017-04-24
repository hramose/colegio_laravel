@extends('layouts.admin')

@section('title') Editar Domo @stop

@section('content')
<div class="box box-primary">
	{!! Form::model($domo, ['route' => array('editar_domo', $domo->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
	
			{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
			{!! Field::text('direccion', null, ['data-required'=> 'true']) !!}
			{!! Field::text('imagen', null, ['data-required'=> 'true']) !!}
			{!! Field::text('longitud', null, ['data-required'=> 'false']) !!}
			{!! Field::text('latitud', null, ['data-required'=> 'false']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary">
            <a href="{{ route('domos') }}" class="btn btn-danger">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>

@stop