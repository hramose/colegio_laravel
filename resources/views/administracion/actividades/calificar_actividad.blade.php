@extends('layouts.admin')
@section('title') Calificar - {{$actividad->actividad->titulo}} - {{$actividad->estudiante->nombre_completo}} @endsection
@section('css')
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
	{!! Form::model($actividad, ['route' => ['calificar_actividad',$actividad->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box box-primary">
			<div class="box-body">
				<div class="col-lg-6">
					<h3>Respuesta</h3>
					@if($actividad->texto)
					<div style="border: 1px solid black; padding: 10px">
						{!! $actividad->texto !!}
					</div>
					@else
						No se ingresó algún texto en la tarea por parte del estudiante.
					@endif
					<br/>
					@if($actividad->archivo)
						<a href="{{$actividad->archivo}}" class="btn btn-primary btn-flat fa fa-download"> Descargar</a>
					@endif
				</div>
				<div class="col-lg-6">
					<h4>Calificar</h4>
					<hr>
					{!! Field::number('punteo',$actividad->actividad->punteo,['disabled']) !!}
					{!! Field::number('nota',null,['data-required'=>'true','step'=>'any']) !!}
					{!! Field::text('observaciones',null,['data-required'=>'false']) !!}
					<p>
						<input type="submit" value="Calificar" class="btn btn-primary btn-flat">
	            		<a href="{{ route('ver_notas_actividad',$actividad->actividad->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
					</p>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
	</div>
</div>
@endsection