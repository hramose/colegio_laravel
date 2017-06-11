@extends('layouts.admin')
@section('title') Editar Tipo de Tarea - {{$tipoTarea->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($tipoTarea, ['route' => 'editar_tipo_tarea', 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       	{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
	       	{!! Field::checkbox('aplica_zona') !!}
	       	{!! Field::checkbox('es_examen') !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('tipos_tareas') }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection