@extends('layouts.admin')
@section('title') 
Unidades - {{$curso->descripcion}}
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<a href="{{route('estudiantes.ver_curso',$curso->id)}}" class="btn btn-danger btn-flat">Regresar al Curso</a>
		<br><br>
		<div class="nav-tabs-custom">
	    	<ul class="nav nav-tabs">
	    		@foreach($unidades as $index => $unidad)
	        	<li class="@if($index == 0) active @endif"><a href="#{{$unidad->id}}" data-toggle="tab">{{$unidad->unidad_seccion->descripcion}}</a></li>
	        	@endforeach
	        </ul>
	        <div class="tab-content">
	        	@foreach($unidades as $index => $unidad)
	        	<div class="tab-pane @if($index == 0) active @endif" id="{{$unidad->id}}">
					@if($unidad->archivo_planificacion)
					<a href="{{$unidad->archivo_planificacion}}" class="btn btn-primary btn-flat fa fa-file"> Descargar Planificación</a>
					@endif
					<hr>
					<div class="row">
						<div class="col-md-12">
							<div class="bg-green" style="padding: 10px;"> <i class="fa fa-book"></i> Actividades</div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table responsive">
							<thead>
								<tr>
									<th>DESCRIPCIÓN</th>
									<th>TIPO</th>
									<th>VALOR</th>
									<th>PUNTEO</th>
									<th>FECHA ENTREGA</th>
									<th>ESTADO</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php $totalPorcentaje = 0; $totalNota = 0; ?>
								@foreach($unidad->actividades as $actividad)
								<tr>
									<?php $totalPorcentaje+=$actividad->actividad->punteo; $totalNota+=$actividad->nota; ?>
									<td> {{$actividad->actividad->titulo}} </td>
									<td> {{$actividad->actividad->tipo->descripcion}} </td>
									<td> {{$actividad->actividad->punteo}} pts </td>
									<td>
										@if($actividad->nota)
											{{$actividad->nota}} pts 
										@endif
									</td>
									<td>
										@if($actividad->fecha_entrega)
										{{ date('d-m-Y H:i', strtotime($actividad->fecha_entrega))}} 
										@endif
									</td>
									<td> {{$actividad->descripcion_estado}} </td>
									<td> 
										<a href="{{route('estudiantes.ver_actividad',$actividad->id)}}" class="btn btn-info btn-flat btn-sm fa fa-eye" data-toggle="tooltip" data-placement="top" data-original-title="Ver"></a>
										<a href="{{route('estudiantes.entregar_actividad',$actividad->id)}}" class="btn btn-primary btn-flat btn-sm fa fa-check" data-toggle="tooltip" data-placement="top" data-original-title="Entregar"></a>
									</td>
								</tr>
								 @endforeach 
								 <tr>
								 	<td colspan="2">TOTAL</td>
								 	<td>{{$totalPorcentaje}} pts</td>
								 	<td>{{$totalNota}} pts</td>
								 	<td></td>
								 	<td></td>
								 </tr>
							</tbody>
						</table>
					</div>
	              
	            </div>
	            @endforeach
	      	</div>
	    </div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
		 //var table = $('.table').DataTable();
	} );
</script>
@endsection