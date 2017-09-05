@extends('layouts.admin')
@section('title') 
Notas {{$unidadCurso->curso->descripcion}} - {{$unidadCurso->unidad_seccion->descripcion}} 
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
				<div class="table-responsive">
					<a href="{{route('unidades_curso',$unidadCurso->curso_id)}}#{{$unidadCurso->id}}" class="btn btn-danger btn-sm btn-flat" data-toggle="tooltip" data-placement="top" title="" data-original-title="Regresar"><i class="fa fa-chevron-left-o"></i> Regresar</a>
					<hr>
					<div class="row">
						<div class="col-lg-8">
							<table class="table table-responsive" >
								<thead>
									<tr>
										<th class="text-center">ESTUDIANTE</th>
										@foreach($actividades as $index => $actividad)
											<th class="text-center">{{$index+1}}</th>
										@endforeach
										<th class="text-center">TOTAL</th>
									</tr>
								</thead>
								<tbody>
									@foreach($notas as $nota)
										<?php 
											$clase = ''; 
											if($unidadCurso->unidad_seccion->nota_ganar > $nota['total']) 
												$clase = 'bg-red'; 
										?>
										<tr class="{{$clase}}">
											<td> {{$nota['estudiante']}} </td>
											@foreach($actividades as $actividad)
												<td class="text-center">{{$nota[$actividad->id]}}</td>
											@endforeach
											<td class="text-center"> {{$nota['total']}} </td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="col-lg-4">
							<table class="table table-responsive" style="background-color: #3c8dbc; color: white">
								<thead>
									<tr>
										<th width="20px">ACT</th>
										<th>DESCRIPCIÓN</th>
									</tr>
								</thead>
								@foreach($actividades as $index => $actividad)
								<tr>
									<td class="text-center">{{$index+1}}</td>
									<td>{{$actividad->titulo}} ({{$actividad->punteo}} pts)</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
					
				</div>
			</div>
		</div>       
	</div>
</div>
@endsection