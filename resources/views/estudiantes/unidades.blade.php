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
	    		<?php
	    			$clase = '';
	    			if($index == 0) $clase = 'active';
	    		?>
	        	<li class="{{$clase}}"><a href="#{{$unidad->id}}" data-toggle="tab">{{$unidad->unidad_seccion->descripcion}}</a></li>
	        	@endforeach
	        </ul>
	        <div class="tab-content">
	        	@foreach($unidades as $index => $unidad)
	        	<?php
	    			$clase = '';
	    			if($index == 0) $clase = 'active';
	    		?>
	        	<div class="tab-pane {{$clase}}" id="{{$unidad->id}}">
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
									<th>PUNTEO</th>
									<th>FECHA INICIO</th>
									<th>ULTIMA FECHA ENTREGA</th>
									<th>FECHA ENTREGA POR ESTUDIANTE</th>
									<th>ENTREGA VIA WEB</th>
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
										@if($actividad->actividad->fecha_inicio)
										{{ date('d-m-Y H:i', strtotime($actividad->actividad->fecha_inicio))}} 
										@endif
									</td>
									<td>
										@if($actividad->actividad->fecha_entrega)
										{{ date('d-m-Y H:i', strtotime($actividad->actividad->fecha_entrega))}} 
										@endif
									</td>
									<td>
										@if($actividad->fecha_entrega)
										{{ date('d-m-Y H:i', strtotime($actividad->fecha_entrega))}} 
										@endif
									</td>
									<td> {!! $actividad->actividad->descripcion_entrega_via_web !!} </td>
									<td> {{$actividad->descripcion_estado}} </td>
									<td> 
										<a href="{{route('estudiantes.ver_actividad',$actividad->id)}}" class="btn btn-info btn-flat btn-sm fa fa-eye" data-toggle="tooltip" data-placement="top" data-original-title="Ver"></a>
										@if(\Gate::allows('entregar_actividad', $actividad->actividad))
										<a href="{{route('estudiantes.entregar_actividad',$actividad->id)}}" class="btn btn-primary btn-flat btn-sm fa fa-check" data-toggle="tooltip" data-placement="top" data-original-title="Entregar"></a>
										@endif
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