@extends('layouts.admin')
@section('title') Grados @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_grado')}}" class="btn btn-primary btn-flat">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>NUMERO</th>
						<th>NIVEL ACADEMICO</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($grados as $grado)
					<tr>
						<td>{{$grado->descripcion}}</td>
						<td>{{$grado->numero}}</td>
						<td>{{$grado->descripcion_nivel_academico}}</td>
						<td>{{$grado->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_grado',$grado->id)}}" class="btn btn-warning btn-sm  btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
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