@extends('layouts.admin')
@section('title') 
Notas {{$estudiante->estudiante->nombre_completo_apellidos}} - {{$seccion->descripcion_con_grado}}
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
				<div class="table-responsive">
					<a href="{{route('reporte_notas_estudiante_seccion',[$seccion->id,$estudiante->id,'PDF'])}}" class="btn btn-primary btn-flat">PDF</a>
					&nbsp;&nbsp;&nbsp;
					<a href="{{route('maestros.ver_seccion',$seccion->id)}}" class="btn btn-danger btn-flat">Regresar</a>
					<hr>
					<div class="row">
						<div class="col-lg-8">
							<table class="table table-responsive" >
								<thead>
									<tr>
										<th class="text-center">CURSO</th>
										@foreach($unidades as $index => $unidad)
											<th class="text-center">{{$unidad->descripcion}}</th>
										@endforeach
										<th class="text-center">FINAL</th>
									</tr>
								</thead>
								<tbody>
									@foreach($notas['cursos'] as $nota)
										<tr>
											<td>{{$nota['curso']->materia->descripcion}}</td>
											@foreach($nota['unidades'] as $unidad)

												@php 
													$clase = ''; 
													if($unidad['unidad']->nota_ganar > $unidad['nota']) 
														$clase = 'bg-red text-white'; 
												@endphp
												<td class="text-center {{$clase}}">
													{{$unidad['nota']}}
												</td>

											@endforeach
										
											<td class="text-center">{{$nota['nota_anual']}}</td>
										</tr>
									@endforeach
									<tr>
										<td>PROMEDIO</td>
										@foreach($notas['promedios']['unidades'] as $p)
										<td class="text-center">{{$p}}</td>
										@endforeach
										<td class="text-center">{{$notas['promedios']['promedio_unidades']}}</td>
									</tr>
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