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
		<a href="{{route('maestros.ver_curso',$curso->id)}}" class="btn btn-danger btn-flat">Regresar al Curso</a>
		<br><br>
		<div class="nav-tabs-custom">
	    	<ul class="nav nav-tabs">
	    		@foreach($unidades as $index => $unidad)
	    		<?php if($index == 0) $class = "active"; else $class = ''; ?> 
	        	<li class="{{$class}}"><a href="#{{$unidad->id}}" data-toggle="tab">{{$unidad->unidad_seccion->descripcion}}</a></li>
	        	@endforeach
	        </ul>
	        <div class="tab-content">
	        	@foreach($unidades as $index => $unidad)
	        	<?php if($index == 0) $class = "active"; else $class = ''; ?> 
	        	<div class="tab-pane {{$class}}" id="{{$unidad->id}}">
	        		<a href="{{route('editar_unidad_curso',$unidad->id)}}" class="btn btn-warning btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" data-original-title="Editar Planificación"> Editar Planificación</a>&nbsp;&nbsp;&nbsp;
					@if($unidad->archivo_planificacion)
					<a href="{{$unidad->archivo_planificacion}}" class="btn btn-primary btn-flat fa fa-file"> Descargar Planificación</a>
					@endif
					<a href="{{route('notas_unidad_curso', $unidad->id)}}" class="btn btn-primary btn-flat fa fa-file"> Ver Notas</a>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<div class="info-box bg-red">
	           					<span class="info-box-icon"><i class="fa fa-book"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">ACTIVIDADES</span>
									<span class="info-box-number">{{count($unidad->actividades)}}</span>
										<div class="progress">
											<div class="progress-bar" style="width: 100%"></div>
										</div>
										<span class="progress-description">
										<a href="{{route('agregar_actividad',$unidad->id)}}" class="btn btn-default btn-flat fa fa-plus" data-toggle="tooltip" data-placement="top" data-original-title="Agregar Actividad"></a>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table responsive">
							<thead>
								<tr>
									<th class="text-center">DESCRIPCIÓN</th>
									<th class="text-center">TIPO</th>
									<th class="text-center">VALOR</th>
									<th class="text-center">ENTREGA VIA WEB</th>
									<th class="text-center">FECHA INICIO</th>
									<th class="text-center">FECHA ENTREGA</th>
									<th class="text-center">ESTADO</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php $totalPorcentaje = 0; ?>
								@foreach($unidad->actividades as $actividad)
								<tr>
									<?php $totalPorcentaje+=$actividad->punteo; ?>
									<td> {{$actividad->titulo}} </td>
									<td class="text-center"> {{$actividad->tipo->descripcion}} </td>
									<td class="text-center"> {{$actividad->punteo}} pts </td>
									<td class="text-center"> {!! $actividad->descripcion_entrega_via_web !!} </td>
									<td>
										@if($actividad->fecha_inicio)
										{{ date('d-m-Y H:i', strtotime($actividad->fecha_inicio))}} 
										@endif
									</td>
									<td class="text-center">
										@if($actividad->fecha_entrega)
										{{ date('d-m-Y H:i', strtotime($actividad->fecha_entrega))}} 
										@endif
									</td>
									<td class="text-center"> {{$actividad->descripcion_estado}} </td>
									<td> 
										<a href="@{{route('maestros.ver_actividad',$actividad->id)}}" class="btn btn-info btn-flat btn-sm fa fa-eye" data-toggle="tooltip" data-placement="top" data-original-title="Ver"></a> 
										<a href="{{route('editar_actividad',$actividad->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" data-original-title="Editar"></a>
										<a href="{{route('ver_notas_actividad',$actividad->id)}}" class="btn btn-primary btn-sm btn-flat fa fa-check" data-toggle="tooltip" data-placement="top" data-original-title="Ver Notas"></a>
									</td>
								</tr>
								 @endforeach 
								 <tr>
								 	<td colspan="2">TOTAL</td>
								 	<td>{{$totalPorcentaje}} pts</td>
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