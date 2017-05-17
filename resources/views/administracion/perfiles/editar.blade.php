@extends('layouts.admin')
@section('title') Editar Perfil - {{$perfil->descripcion}} @endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($perfil, ['route' => array('editar_perfil', $perfil->id), 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
			{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('perfiles') }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection