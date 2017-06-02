@extends('layouts.admin')
@section('title') 
Agregar Tarea -
{{$unidad->curso->seccion->grado->descripcion}} 
{{$unidad->curso->seccion->descripcion_seccion}} 
{{$unidad->descripcion}}  - 
{{$unidad->curso->materia->descripcion}} 
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => ['agregar_tarea',$unidad->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::text('titulo', null, ['data-required'=> 'true']) !!}
	       	{!! Field::select('tipo_tarea_id', $tipos, null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}
	       	{!! Field::textarea('descripcion', null, ['data-required'=> 'true']) !!}
	       	{!! Field::checkbox('aplica_fecha') !!}
	       	{!! Field::text('fecha_inicio', null, ['data-required'=> 'false','class'=>'fecha']) !!}
	       	{!! Field::text('fecha_fin', null, ['data-required'=> 'false','class'=>'fecha']) !!}
	       	{!! Field::file('archivo') !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('tareas',$unidad->id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection