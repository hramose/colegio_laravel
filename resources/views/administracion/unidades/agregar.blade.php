@extends('layouts.admin')
@section('title') 
Agregar Unidad -
{{$curso->seccion->grado->descripcion}} 
{{$curso->seccion->descripcion_seccion}} - 
{{$curso->materia->descripcion}} 
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => ['agregar_unidad',$curso->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::select('unidad', $unidades, null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('nota_ganar', null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}
	       	{!! Field::file('archivo_planificacion') !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('unidades',$curso->id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection