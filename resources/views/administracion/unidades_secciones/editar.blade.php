@extends('layouts.admin')
@section('title') 
Editar {{$unidad->descripcion}} - 
{{$unidad->seccion->grado->descripcion}} 
{{$unidad->seccion->descripcion_seccion}}
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($unidad, ['route' => ['editar_unidad_seccion',$unidad->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::text('unidad', $unidad->descripcion, ['disabled']) !!}
	       	{!! Field::number('nota_ganar', null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('unidades_secciones',$unidad->seccion_id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection