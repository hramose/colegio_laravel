@extends('layouts.admin')
@section('title') Agregar Tipo de Tarea @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_tipo_tarea', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       	{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
	       	{!! Field::checkbox('aplica_zona') !!}
	       	{!! Field::checkbox('es_examen') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('tipos_tareas') }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection