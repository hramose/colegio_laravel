@extends('layouts.admin')

@section('title') Agregar Domo @stop

@section('content')

<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_domo', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       {!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
			{!! Field::text('direccion', null, ['data-required'=> 'true']) !!}
			{!! Field::text('imagen', null, ['data-required'=> 'true']) !!}
			{!! Field::text('longitud', null, ['data-required'=> 'false']) !!}
			{!! Field::text('latitud', null, ['data-required'=> 'false']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}         
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary">
            <a href="{{ route('domos') }}" class="btn btn-danger">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@stop