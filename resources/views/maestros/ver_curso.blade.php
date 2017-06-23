@extends('layouts.admin')
@section('title') 
{{$curso->descripcion}}
@endsection
@section('css')

@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
			        	<div class="box box-widget widget-user-2">
			            	<div class="widget-user-header bg-yellow">
			              		<div class="widget-user-image">
			                		<img class="img-circle" src="{{$curso->maestro->fotografia}}" alt="User Avatar">
			              		</div>
			              		<h3 class="widget-user-username">{{$curso->maestro->nombre_completo}}</h3>
			              		<h5 class="widget-user-desc">Maestro</h5>
			            	</div>
			          	</div>
			        </div>
				</div>
				<div class="row">
					<div class="col-md-6">
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
									<hr>
									<h4>Actividades</h4>
					        		<hr>
									@endif
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
												 @foreach($unidad->actividades as $actividad)
												<tr>
													<td> {{$actividad->titulo}} </td>
													<td> {{$actividad->tipo->descripcion}} </td>
													<td> {{$actividad->porcentaje}} pts </td>
													<td> {{$actividad->descripcion_estado}} </td>
													<td> 
														<a href="@{{route('maestros.ver_actividad',$actividad->id)}}" class="btn btn-info btn-flat btn-sm fa fa-eye" data-toggle="tooltip" data-placement="top" data-original-title="Ver"></a> 
														<a href="{{route('editar_actividad',$actividad->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" data-original-title="Editar"></a>
													</td>
												</tr>
												 @endforeach 
											</tbody>
										</table>
									</div>
					              
					            </div>
					            @endforeach
					      	</div>
					    </div>
					</div>
					<div class="col-md-6">
						<h4>FORO</h4>
						<div class="info-box bg-red">
           					<span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Temas</span>
								<span class="info-box-number">{{$curso->cantidadForos}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 100%"></div>
									</div>
									<span class="progress-description">
									¡Participa!
								</span>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>TEMA</th>
										<th>MENSAJES / VISITAS</th>
										<th>ULTIMO MENSAJE</th>
									</tr>
								</thead>
								<tbody>
									@foreach($foros as $foro)
									<tr>
										<td>
											<a href="{{route('mensajes_foro',$foro->id)}}">{{$foro->tema}}</a> <br/>
											Iniciado por {{$foro->autor->nombre_completo}} el {{date('d/m/Y - H:i', strtotime($foro->created_at))}}
										</td>
										<td>Respuestas: {{$foro->respuestas}} <br/> Visitas: {{$foro->visitas}}</td>
										<td>
											@if($foro->ultima_respuesta)
												De {{$foro->ultima_respuesta->autor->nombre_completo}} el {{date('d/m/Y - H:i', strtotime($foro->ultima_respuesta->created_at))}}
											@endif
										</td>
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

@endsection
@section('js')
@stop