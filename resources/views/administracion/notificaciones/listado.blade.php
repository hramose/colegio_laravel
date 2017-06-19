@extends('layouts.admin')
@section('icon-title') <i class="fa fa-bell"></i> @endsection
@section('title') Notificaciones @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
<style>
	tr.unread{
		background: #cbcfd2 !important;
		font-weight: bold !important;
	}
	.clickable-row{
		cursor: pointer;
	}
</style>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<a href="{{route('notificaciones',0)}}" class="btn btn-primary btn-flat">Todas</a>
		<a href="{{route('notificaciones',1)}}" class="btn btn-info btn-flat">Leídas</a>
		<a href="{{route('notificaciones',2)}}" class="btn btn-warning btn-flat">No Léidas</a>
		<hr>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($notificaciones as $notificacion)
					<tr class="@if($notificacion->unread()) unread @endif clickable-row" data-href='{{route('ver_notificacion',$notificacion->id)}}'>
						<td width="200px">{{$notificacion->data['created_by']}}</td>
						<td> <b>{{$notificacion->data['titulo']}}</b> - <i>{!!strip_tags($notificacion->data['descripcion']) !!}</i> </td>
						<td width="150px" class="text-center" data-toggle="tooltip" data-placement="top" data-original-title="{{date('d-m-Y H:i', strtotime($notificacion->created_at))}}">
							{{\Variable::time_elapsed_string($notificacion->created_at)}}
						</td>
					</tr>
					</a>
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
   			"bSort" : false,
   			"language": {
		        "emptyTable": "No tienes notificaciones."
		    }
   		});
   		$(".clickable-row").click(function() {
       		window.location = $(this).data("href");
    	});
	});
</script>
@endsection