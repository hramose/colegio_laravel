@extends('layouts.admin')
@section('title') 
Actividades - {{$unidadCurso->unidad_seccion->descripcion}} - 
{{$unidadCurso->curso->descripcion}} 
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_actividad',$unidadCurso->id)}}" class="btn btn-primary btn-flat">Agregar</a>
			<a href="{{route('unidades_cursos',$unidadCurso->curso_id)}}" class="btn btn-danger btn-flat">Unidades</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ACTIVIDAD</th>
						<th>APLICA FECHA</th>
						<th>FECHA INICIO</th>
						<th>FECHA FIN</th>
						<th>ARCHIVO</th>
						<th>PUNTEO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($actividades as $actividad)
					<tr>
						<td>{{$actividad->titulo}}</td>
						<td> {{$actividad->descripcion_aplica_fecha}}</td>
						<td>
							@if(!is_null($actividad->fecha_inicio)) date('d-m-Y',strtotime($actividad->fecha_inicio)) @endif
						</td>
						<td>
							@if(!is_null($actividad->fecha_fin)) date('d-m-Y',strtotime($actividad->fecha_fin)) @endif
						</td>
						<td>{{$actividad->descripcion_entrega_via_web}}</td>
						<td>
							@if(!is_null($actividad->archivo))
							<a href="{{$actividad->archivo}}" download="{{$actividad->nombre_original_archivo}}" class="btn btn-primary btn-sm btn-flat fa fa-download"></a>
							@endif
						</td>
						<td>{{$actividad->punteo}} pts</td>
						<td>
							<a href="{{route('editar_actividad',$actividad->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
						</td>
					</tr>
					@endforeach
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>TOTAL</td>
						<td>{{$totalPorcentaje}} %</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection