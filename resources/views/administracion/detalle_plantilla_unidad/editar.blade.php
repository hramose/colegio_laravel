@extends('layouts.admin')
@section('title') 
Editar Unidad - {{$unidad->plantilla_unidad->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($unidad, ['route' => ['editar_detalle_plantilla_unidad',$unidad->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       	{!! Field::text('unidad', $unidad->unidad, ['disabled']) !!}
	       	{!! Field::number('nota_ganar', null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('detalle_plantilla_unidad',$unidad->plantilla_unidad->id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection