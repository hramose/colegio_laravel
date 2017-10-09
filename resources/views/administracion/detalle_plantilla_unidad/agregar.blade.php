@extends('layouts.admin')
@section('title') 
Agregar Unidad - {{$plantillaUnidad->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => ['agregar_detalle_plantilla_unidad',$plantillaUnidad->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	    <div class="box-body">
	       	{!! Field::select('unidad', $unidades, null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('nota_ganar', null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('detalle_plantilla_unidad',$plantillaUnidad->id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection