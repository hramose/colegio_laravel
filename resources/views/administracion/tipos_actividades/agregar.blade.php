@extends('layouts.admin')
@section('title') Agregar Tipo de Actividad @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_tipo_actividad', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       	{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
	       	{!! Field::checkbox('aplica_zona') !!}
	       	{!! Field::checkbox('es_examen') !!}
	       	{!! Field::checkbox('puntos_extras') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('tipos_actividades') }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection