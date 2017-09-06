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
				<a href="{{route('reporte_notas_seccion',$seccion->id)}}" class="btn btn-primary btn-flat">Exportar Excel</a>
				<hr>
				<div class="nav-tabs-custom">
	    			<ul class="nav nav-tabs">
	    				@php $index = 0; @endphp
	    				@foreach($notas as $unidad)
	    				@php if($index == 0) $class = "active"; else $class = ''; $index++; @endphp 
	        			<li class="{{$class}}"><a href="#{{$unidad['unidad']->id}}" data-toggle="tab">{{$unidad['unidad']->descripcion}}</a></li>
	        			@endforeach
	        		</ul>
					<div class="tab-content">
						@php $index = 0; @endphp
			        	@foreach($notas as $unidad)
			        	@php if($index == 0) $class = "active"; else $class = ''; $index++; @endphp 
			        	<div class="tab-pane {{$class}}" id="{{$unidad['unidad']->id}}">
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
														<td> {{$nota['estudiante']->nombre_completo}} </td>
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