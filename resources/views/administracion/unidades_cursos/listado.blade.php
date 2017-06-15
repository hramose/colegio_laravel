@extends('layouts.admin')
@section('title') 
Unidades - {{$curso->descripcion}}
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('maestros.dashboard')}}" class="btn btn-danger btn-flat">Regresar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>UNIDAD</th>
						<th>NOTA PARA GANAR</th>
						<th>PORCENTAJE</th>
						<th>ARCHIVO PLANIFICACION</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($unidades as $unidad)
					<tr>
						<td>{{$unidad->unidad_seccion->descripcion}}</td>
						<td>{{$unidad->unidad_seccion->nota_ganar}}</td>
						<td>{{$unidad->unidad_seccion->porcentaje}}</td>
						<td>
							@if($unidad->archivo_planificacion)
							<a href="{{$unidad->archivo_planificacion}}" class=" btn btn-primary btn-sm fa fa-download" data-toggle="tooltip" data-placement="top" title="" data-original-title="Descargar Archivo"></a>
							@endif
						</td>
						<td>
							<a href="{{route('editar_unidad_curso',$unidad->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
							<a href="{{route('actividades',$unidad->id)}}" class="btn btn-info btn-sm btn-flat fa fa-book" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tareas"></a>
						</td>
					</tr>
					@endforeach
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
		 var table = $('.table').DataTable();
	} );
</script>
@endsection