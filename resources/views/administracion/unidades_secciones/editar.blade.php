@extends('layouts.admin')
@section('title') 
Editar {{$unidadSeccion->descripcion}} - 
{{$unidadSeccion->seccion->grado->descripcion}} 
{{$unidadSeccion->seccion->descripcion_seccion}}
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($unidadSeccion, ['route' => ['editar_unidad_seccion',$unidadSeccion->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::text('unidad', $unidadSeccion->descripcion, ['disabled']) !!}
	       	{!! Field::number('nota_ganar', null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('unidades_secciones',$unidadSeccion->seccion_id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection