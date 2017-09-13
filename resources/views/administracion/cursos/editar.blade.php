@extends('layouts.admin')
@section('title') Editar Curso - {{$curso->seccion->grado->descripcion}} {{$curso->seccion->descripcion_seccion}} @endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($curso, ['route' => array('editar_curso', $curso->id), 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box-body">
			<div class="row">
				<div class="col-lg-3">{!! Field::text('materia_id',$curso->materia->descripcion, ['disabled']) !!}</div>
			</div>
			<div class="row">
				<div class="col-lg-3">
					{!! Field::select('maestro_id',$maestros, null, ['data-required'=> 'true', 'class'=>'buscar-select']) !!}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3">
					{!! Field::number('orden', null, ['data-required'=> 'true']) !!}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3">
					{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
				</div>
			</div>
		</div>
		<div class="box-footer">
		    <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('secciones') }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script>
	$(function(){
		$('.buscar-select').select2();
	});
</script>
@endsection