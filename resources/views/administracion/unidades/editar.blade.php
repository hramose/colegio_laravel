@extends('layouts.admin')
@section('title') 
Editar {{$unidad->descripcion}} - 
{{$unidad->curso->seccion->grado->descripcion}} 
{{$unidad->curso->seccion->descripcion_seccion}} - 
{{$unidad->curso->materia->descripcion}} 
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($unidad, ['route' => ['editar_unidad',$unidad->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::text('unidad', $unidad->descripcion, ['disabled']) !!}
	       	{!! Field::number('nota_ganar', null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}
	       	{!! Field::file('archivo_planificacion') !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('unidades',$unidad->curso_id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection