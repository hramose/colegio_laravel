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
				<a href="{{route('reporte_notas_seccion',$seccion->id)}}" class="btn btn-primary btn-flat">Exportar Excel Notas</a>
				<hr>
				<div class="nav-tabs-custom">
	    			<ul class="nav nav-tabs">
	    				<li class="active"><a href="#estudiantes" data-toggle="tab">Estudiantes</a></li>
	    				@foreach($notas as $unidad)
	        			<li><a href="#{{$unidad['unidad']->id}}" data-toggle="tab">{{$unidad['unidad']->descripcion}}</a></li>
	        			@endforeach
	        		</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="estudiantes">
							<div class="table-responsive">
								<div class="row">
									<ul class="users-list clearfix">
										@foreach($estudiantes as $estudiante)
							            <li>
							          		<img src="{{$estudiante->estudiante->fotografia}}" alt="" style="width: 80px !important; height: 80px !important">
							              	<a class="users-list-name" href="#">{{$estudiante->estudiante->nombre_completo_apellidos}}</a>
							              	<span class="users-list-date">{{$estudiante->estudiante->edad}}</span>
							              	<span class="users-list-date">Codigo: {{$estudiante->codigo}}</span>
							            </li>
							            @endforeach
							      	</ul>
								</div>
							</div>
						</div>
			        	@foreach($notas as $unidad)
			        	<div class="tab-pane" id="{{$unidad['unidad']->id}}">
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
					</div>
				</div>
			</div>
		</div>       
	</div>
</div>
@endsection