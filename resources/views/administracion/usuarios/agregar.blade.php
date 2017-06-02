@extends('layouts.admin')
@section('title') Agregar Usuario @endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
	{!! Form::open(['route' => 'agregar_usuario', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}	
		{!! Field::text('username', null, ['data-required'=>'true']) !!}
		{!! Field::password('password', null, ['data-required'=>'true']) !!}
		{!! Field::password('password_confirmation', null, ['data-required'=>'true']) !!}
		{!! Field::select('perfil_id', $perfiles, null, ['data-required'=>'true']) !!}
		{!! Field::select('persona_id', $personas, null, ['data-required'=>'true']) !!}
		<br/>
        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('usuarios') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>
	{!! Form::close() !!}
	</div>
</div>
@stop