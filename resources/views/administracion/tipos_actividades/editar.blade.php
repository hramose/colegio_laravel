@extends('layouts.admin')
@section('title') Editar Tipo de Actividad - {{$tipoActividad->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($tipoActividad, ['route' => ['editar_tipo_actividad', $tipoActividad->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       	{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
	       	{!! Field::checkbox('aplica_zona') !!}
	       	{!! Field::checkbox('es_examen') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('tipos_actividades') }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection