@extends('layouts.admin')
@section('title') Usuarios @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_usuario')}}" class="btn btn-primary btn-flat">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>USERNAME</th>
						<th>PERFIL</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($usuarios as $usuario)
					<tr>
						<td>{{$usuario->username}}</td>
						<td>{{$usuario->perfil->descripcion}}</td>
						<td>{{$usuario->descripcion_estado}}</td>
						<td>
							@if(Gate::allows('edit_super_admin', $usuario))
							<a href="{{route('reset_password',$usuario->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reset Contraseña"></a>
							@endif
							@if(Gate::allows('is_super_admin') && $usuario->estado == 'A')
							<a href="{{route('inactivar_usuario',$usuario->id)}}" class="btn btn-danger btn-sm btn-flat fa fa-times" data-toggle="tooltip" data-placement="top" title="" data-original-title="Inactivar"></a>
							@endif
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