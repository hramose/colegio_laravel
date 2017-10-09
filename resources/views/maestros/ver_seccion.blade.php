@extends('layouts.admin')
@section('title') 
{{$seccion->descripcion_con_grado}}
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
				<a href="{{route('reporte_notas_seccion',$seccion->id)}}">
					<img src="{{asset('assets/imagenes/excel.png')}}" height="50px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exportar Notas">
				</a>
				<a href="{{route('reporte_notas_estudiantes_seccion',[$seccion->id,'PDF'])}}">
					<img src="{{asset('assets/imagenes/pdf.png')}}" height="50px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exportar Boletas">
				</a>
				<hr>
				<div class="nav-tabs-custom">
	    			<ul class="nav nav-tabs">
	    				<li class="active"><a href="#estudiantes" data-toggle="tab">Estudiantes</a></li>
	    				@foreach($notas['unidades'] as $unidad)
	        			<li><a href="#{{$unidad['unidad']->id}}" data-toggle="tab">{{$unidad['unidad']->descripcion}}</a></li>
	        			@endforeach
	        			<li><a href="#promedios" data-toggle="tab">Promedio</a></li>
	        		</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="estudiantes">
							<div class="table-responsive">
								<div class="row">
									<ul class="users-list clearfix">
										@foreach($estudiantes as $estudiante)
							            <li>
							          		<img src="{{$estudiante->estudiante->fotografia}}" alt="" style="width: 80px !important; height: 80px !important">
							              	<a class="users-list-name" href="{{route('notas_estudiante_seccion',[$seccion->id, $estudiante->id])}}">{{$estudiante->estudiante->nombre_completo_apellidos}}</a>
							              	<span class="users-list-date">{{$estudiante->estudiante->edad}}</span>
							              	<span class="users-list-date">Codigo: {{$estudiante->codigo}}</span>
							            </li>
							            @endforeach
							      	</ul>
								</div>
							</div>
						</div>
			        	@foreach($notas['unidades'] as $unidad)
			        	<div class="tab-pane" id="{{$unidad['unidad']->id}}">
			        		@if($unidad['unidad']->estado == 'A')
			        			<a onclick="cerrarUnidad('{{route('cerrar_unidad_seccion',$unidad['unidad']->id)}}', '{{$unidad['unidad']->descripcion}}'); return false;" class="btn btn-primary btn-flat">Cerrar Unidad</a>
			        		@endif
			        		@if($unidad['unidad']->estado != 'A')
								<a onclick="activarUnidad('{{route('activar_unidad_seccion',$unidad['unidad']->id)}}', '{{$unidad['unidad']->descripcion}}'); return false;" class="btn btn-primary btn-flat">Activar Unidad</a>
							@endif
			        		<hr>
							<div class="table-responsive">
								<div class="row">
									<div class="col-lg-8">
										<table class="table table-responsive" >
											<thead>
												<tr>
													<th class="text-center">ESTUDIANTE</th>
													@foreach($cursos as $index => $curso)
														<th class="text-center">{{$curso->materia->descripcion}}</th>
													@endforeach
												</tr>
											</thead>
											<tbody>
												@foreach($unidad['estudiantes'] as $nota)
													<tr>
														<td> {{$nota['estudiante']->nombre_completo_apellidos}} </td>
														@foreach($nota['cursos'] as $curso)
															<?php 
																$clase = ''; 
																if($unidad['unidad']->nota_ganar > $curso['nota']) 
																	$clase = 'bg-red text-white'; 
															?>
															<td class="text-center {{$clase}}">
																<a href="{{route('detalle_notas_unidad_seccion',[$unidad['unidad']->id, $curso['curso']->id,$nota['estudiante']->id])}}" style="text-decoration: none; " class="{{$clase}}">
																	{{$curso['nota']}}
																</a>
															</td>
														@endforeach
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						@endforeach
						<div class="tab-pane" id="promedios">
							<div class="table-responsive">
								<div class="row">
									<div class="col-lg-8">
										<table class="table table-responsive" >
											<thead>
												<tr>
													<th class="text-center">CODIGO</th>
													<th class="text-center">ESTUDIANTE</th>
													@foreach($cursos as $index => $curso)
														<th class="text-center">{{$curso->materia->descripcion}}</th>
													@endforeach
												</tr>
											</thead>
											<tbody>
												@foreach($notas['promedios'] as $nota)
													<tr>
														<td> {{$nota['codigo']}} </td>
														<td> {{$nota['estudiante']->nombre_completo_apellidos}} </td>
														@foreach($nota['cursos'] as $curso)
															<td class="text-center">
																{{number_format($curso['promedio'],2)}}
															</td>
														@endforeach
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>       
	</div>
</div>
<div class="modal modal-flex fade" id="modalCerrarUnidad" tabindex="-1" role="dialog" aria-labelledby="flexModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal-title">Cerrar Unidad</h4>
            </div>
            <div class="modal-body">
            	<span id="txtCerrarUnidad"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <a href="#" id="cerrarUnidadLink" class="btn btn-primary">Cerrar Unidad</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal modal-flex fade" id="modalActivarUnidad" tabindex="-1" role="dialog" aria-labelledby="flexModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal-title">Activar Unidad</h4>
            </div>
            <div class="modal-body">
            	<span id="txtActivarUnidad"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <a href="#" id="activarUnidadLink" class="btn btn-primary">Activar Unidad</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section('js')
<script>
	function cerrarUnidad(ruta,unidad)
	{
		$('#cerrarUnidadLink').attr('href',ruta);
		$('#txtCerrarUnidad').text('¿Esta seguro de cerrar la ' + unidad + '?');
		$('#modalCerrarUnidad').modal('show');
	}
	function activarUnidad(ruta,unidad)
	{
		$('#activarUnidadLink').attr('href',ruta);
		$('#txtActivarUnidad').text('¿Esta seguro de activar la ' + unidad + '?');
		$('#modalActivarUnidad').modal('show');
	}
</script>
@endsection