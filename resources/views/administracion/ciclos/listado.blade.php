@extends('layouts.admin')

@section('title') Domos @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_domo')}}" class="btn btn-primary">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>NOMBRE</th>
						<th>DIRECCION</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($domos as $domo)
					<tr>
						<td>{{$domo->nombre}}</td>
						<td>{{$domo->direccion}}</td>
						<td>{{$domo->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_domo',$domo->id)}}" class="btn btn-warning btn-xs fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
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