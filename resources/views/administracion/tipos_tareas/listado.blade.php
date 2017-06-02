@extends('layouts.admin')
@section('title') Tipos de Tarea @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_tipo_tarea')}}" class="btn btn-primary btn-flat">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>APLICA ZONA</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($tipos as $tipo)
					<tr>
						<td>{{$tipo->descripcion}}</td>
						<td>
							@if($tipo->aplica_zona)
								SI
							@else
								NO
							@endif
						</td>
						<td>{{$tipo->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_tipo_tarea',$tipo->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
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
   		$('.table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@endsection