@extends('layouts.admin')
@section('title') 
{{$curso->materia->descripcion}}  - {{$curso->seccion->grado->descripcion}} {{$curso->seccion->descripcion_seccion}}
@endsection
@section('css')

@endsection
@section('content')
<div class="row">
<div class="col-md-6">
	<a href="{{route('estudiantes.dashboard')}}" class="btn btn-danger btn-flat">Regresar</a>
	<br/><br/>
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    		@foreach($unidades as $index => $unidad)
        	<li class="@if($index == 0) active @endif"><a href="#{{$unidad->id}}" data-toggle="tab">{{$unidad->descripcion}}</a></li>
        	@endforeach
        </ul>
        <div class="tab-content">
        	<h4>Actividades</h4>
        	<hr>
        	@foreach($unidades as $index => $unidad)
        	<div class="tab-pane active" id="{{$unidad->id}}">
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
							 @foreach($unidad->tareas as $tarea)
							<tr>
								<td> {{$tarea->tarea->titulo}} </td>
								<td> {{$tarea->tarea->tipo->descripcion}} </td>
								<td> {{$tarea->tarea->porcentaje}} pts </td>
								<td> {{$tarea->estado}} </td>
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
@endsection
@section('js')
@stop