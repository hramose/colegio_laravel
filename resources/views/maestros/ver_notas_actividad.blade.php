@extends('layouts.admin')
@section('title') Ver Notas - {{$actividad->titulo}} @endsection
@section('css')
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
				<div class="table-responsive">
					<a href="{{route('calificar_actividades',$actividad->id)}}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="" data-original-title="Calificar Actividades"><i class="fa fa-edit"></i> Calificar Actividades</a>
					<hr>
					<table class="table table-responsive">
						<thead>
							<tr>
								<th>ESTUDIANTE</th>
								<th>NOTA</th>
								<th>OBSERVACIONES</th>
								<th>ESTADO</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($actividades as $a)
							<tr>
								<td> {{$a->estudiante->nombre_completo}} </td>
								<td> {{$a->nota}} </td>
								<td> {{$a->observaciones}} </td>
								<td> {{$a->descripcion_estado}} </td>
								<td>
									<a href="{{route('calificar_actividad',$a->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>       
	</div>
</div>
@endsection