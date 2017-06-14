@extends('layouts.admin')
@section('title') 
Unidades - {{$seccion->grado->descripcion}} 
{{$seccion->descripcion_seccion}}
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_unidad_seccion',$seccion->id)}}" class="btn btn-primary btn-flat">Agregar</a>
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
							<a href="{{route('editar_unidad_seccion',$unidad->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
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