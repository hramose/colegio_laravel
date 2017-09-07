@extends('layouts.admin')
@section('title') Calificar Actividad - {{$actividad->titulo}} @endsection
@section('css')
<style>
	label { display: none }
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
	{!! Form::open(['route' => ['calificar_actividades',$actividad->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box box-primary">
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-responsive">
						<thead>
							<tr>
								<th width="350px">ESTUDIANTE</th>
								<th width="100px">NOTA</th>
								<th>OBSERVACIONES</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($actividades as $a)
							<tr>
								<td>
									{{$a->estudiante->nombre_completo_apellidos}}
									<input type="hidden" class="form-control" name="notas[{{$a->estudiante->id}}][id]" value="{{$a->id}}">
								</td>
								<td>
									{!! Field::number('notas['.$a->estudiante->id.'][nota]',$a->nota,['data-required'=>'true']) !!}
								</td>
								<td>
									<input type="text" class="form-control" name="notas[{{$a->estudiante->id}}][observaciones]" value="">
								</td>
								<td>
									
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer">
	       		<input type="submit" value="Calificar" class="btn btn-primary btn-flat">
	            <a href="{{ route('ver_notas_actividad',$actividad->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
			</div>
		</div>
	{!! Form::close() !!}
	</div>
</div>
@endsection