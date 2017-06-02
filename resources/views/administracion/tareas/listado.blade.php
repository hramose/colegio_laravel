@extends('layouts.admin')
@section('title') 
Tareas - {{$unidad->curso->seccion->grado->descripcion}} 
{{$unidad->curso->seccion->descripcion_seccion}} {{$unidad->descripcion}} - 
{{$unidad->curso->materia->descripcion}} 
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_tarea',$unidad->id)}}" class="btn btn-primary btn-flat">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>TAREA</th>
						<th>APLICA FECHA</th>
						<th>FECHA INICIO</th>
						<th>FECHA FIN</th>
						<th>ARCHIVO</th>
						<th>PORCENTAJE</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($tareas as $tarea)
					<tr>
						<td>{{$tarea->titulo}}</td>
						<td>
							@if($tarea->aplica_fecha) SI @else NO @endif
						</td>
						<td>
							@if(!is_null($tarea->fecha_inicio)) date('d-m-Y',strtotime($tarea->fecha_inicio)) @endif
						</td>
						<td>
							@if(!is_null($tarea->fecha_fin)) date('d-m-Y',strtotime($tarea->fecha_fin)) @endif
						</td>
						<td>
							@if(!is_null($tarea->archivo))
							<a href="{{$tarea->archivo}}">Descargar</a>
							@endif
						</td>
						<td>{{$tarea->porcentaje}} %</td>
						<td>
							<a href="{{route('editar_tarea',$tarea->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
						</td>
					</tr>
					@endforeach
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>TOTAL</td>
						<td>{{$totalPorcentaje}} %</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
		 var table = $('.table').DataTable({'sort': false});
	} );
</script>
@endsection