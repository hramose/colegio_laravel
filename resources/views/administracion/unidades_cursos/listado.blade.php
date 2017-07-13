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
	        	<li class="@if($index == 0) active @endif"><a href="#{{$unidad->id}}" data-toggle="tab">{{$unidad->unidad_seccion->descripcion}}</a></li>
	        	@endforeach
	        </ul>
	        <div class="tab-content">
	        	@foreach($unidades as $index => $unidad)
	        	<div class="tab-pane @if($index == 0) active @endif" id="{{$unidad->id}}">
	        		<a href="{{route('editar_unidad_curso',$unidad->id)}}" class="btn btn-warning btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" data-original-title="Editar Planificación"> Editar Planificación</a>&nbsp;&nbsp;&nbsp;
					@if($unidad->archivo_planificacion)
					<a href="{{$unidad->archivo_planificacion}}" class="btn btn-primary btn-flat fa fa-file"> Descargar Planificación</a>
					@endif
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
									<th>DESCRIPCIÓN</th>
									<th>TIPO</th>
									<th>VALOR</th>
									<th>ESTADO</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php $totalPorcentaje = 0; ?>
								@foreach($unidad->actividades as $actividad)
								<tr>
									<?php $totalPorcentaje+=$actividad->porcentaje; ?>
									<td> {{$actividad->titulo}} </td>
									<td> {{$actividad->tipo->descripcion}} </td>
									<td> {{$actividad->porcentaje}} pts </td>
									<td> {{$actividad->descripcion_estado}} </td>
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