@extends('layouts.admin')
@section('title') 
Unidades - {{$curso->seccion->grado->descripcion}} 
{{$curso->seccion->descripcion_seccion}} - 
{{$curso->materia->descripcion}} 
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_unidad',$curso->id)}}" class="btn btn-primary btn-flat">Agregar</a>
			<hr>
			@if($totalPorcentaje != 100)
				<div class="alert alert-danger alert-dismissable">
               	La suma del porcentaje de todas las unidades no es igual a 100.
               	</div>
            </div>
				
			@endif
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
						<td>{{$unidad->descripcion}}</td>
						<td>{{$unidad->nota_ganar}}</td>
						<td>{{$unidad->porcentaje}}</td>
						<td>
							@if(!is_null($unidad->archivo_planificacion))
							<a href="{{$unidad->archivo_planificacion}}" download="{{$unidad->nombre_original_archivo}}" class="btn btn-primary btn-sm btn-flat fa fa-download"></a>
							@endif
						</td>
						<td>
							<a href="{{route('editar_unidad',$unidad->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
							<a href="{{route('tareas',$unidad->id)}}" class="btn btn-primary btn-sm btn-flat fa fa-book" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tareas"></a>
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