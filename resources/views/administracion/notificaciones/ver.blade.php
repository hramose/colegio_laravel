@extends('layouts.admin')
@section('title') {{$notificacion->data['titulo']}} @endsection
@section('content')
<div class="box box-primary">
    	<div class="box-body">
		{!! $notificacion->data['descripcion'] !!}
	</div>
	<div class="box-footer">
            <a href="{{ route('notificaciones',0) }}" class="btn btn-danger btn-flat fa fa-bell"> Regresar a Notificaciones</a>     
	</div>
	{!! Form::close() !!}
</div>
@endsection