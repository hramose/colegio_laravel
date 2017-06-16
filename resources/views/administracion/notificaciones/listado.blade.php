@extends('layouts.admin')
@section('title') Notificaciones @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>DE</th>
						<th>ASUNTO</th>
						<th>ENTREGADO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($notificaciones as $notificacion)
					<tr>
						<td>{{$notificacion->data['created_by']}}</td>
						<td>{{$notificacion->data['titulo']}}</td>
						<td>{{$notificacion->created_at}}</td>
						<td>
							<a href="{{route('ver_notificacion',$notificacion->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver"></a>
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