@extends('layouts.admin')
@section('title') 
Foro - {{$curso->descripcion}}
@endsection
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
						<th>TEMA</th>
						<th>MENSAJES / VISITAS</th>
						<th>ULTIMO MENSAJE</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($foros as $foro)
					<tr>
						<td>
                            {{$foro->tema}} <br/>
                            Iniciado por {{$foro->autor->nombre_completo}} el {{date('d/m/Y - H:i', strtotime($foro->created_at))}}
                        </td>
						<td>Respuestas: {{$foro->respuestas}} <br/> Visitas: {{$foro->visitas}}</td>
						<td>
							@if($foro->ultima_respuesta)
								De {{$foro->ultima_respuesta->autor->nombre_completo}} el {{date('d/m/Y - H:i', strtotime($foro->ultima_respuesta->created_at))}}
							@endif
						</td>
						<td>
							<a href="{{route('estudiantes.mensajes_foro',$foro->id)}}" class="btn btn-info btn-sm btn-flat fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver"></a>
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