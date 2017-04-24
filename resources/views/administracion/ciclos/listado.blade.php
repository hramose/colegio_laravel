@extends('layouts.admin')
@section('title') Ciclos @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_ciclo')}}" class="btn btn-primary btn-flat">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>FECHA INICIO</th>
						<th>FECHA FIN</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($ciclos as $ciclo)
					<tr>
						<td>{{$ciclo->descripcion}}</td>
						<td>{{date('d-m-Y',strtotime($ciclo->fecha_inicio))}}</td>
						<td>{{date('d-m-Y',strtotime($ciclo->fecha_fin))}}</td>
						<td>{{$ciclo->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_ciclo',$ciclo->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('.table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@stop