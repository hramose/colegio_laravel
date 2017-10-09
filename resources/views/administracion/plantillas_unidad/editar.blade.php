@extends('layouts.admin')
@section('title') Editar Plantilla de Unidad - {{$plantilla->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($plantilla, ['route' => array('editar_plantilla_unidad', $plantilla->id), 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('plantillas_unidad') }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection