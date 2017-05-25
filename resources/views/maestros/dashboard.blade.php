@extends('layouts.admin')
@section('title') Dashboard @endsection
@section('content')
<div class="row">
	@if(count($secciones) > 0)
	<div class="col-lg-6">
		<div class="box box-primary">
			<h2>Secciones</h2>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>SECCION</th>
						</tr>
					</thead>
					<tbody>
						@foreach($secciones as $s)
						<tr>
							<td>{{$s->grado->descripcion}} {{$s->descripcion_seccion}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@endif
	<div class="col-lg-6">
		<div class="box box-primary">
			<h2>Cursos</h2>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>SECCIONES</th>
							<th>MATERIA</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($cursos as $c)
						<tr>
							<td>
								{{$c->seccion->grado->descripcion}} 
								{{$c->seccion->descripcion_seccion}}
							</td>
							<td>{{$c->materia->descripcion}}</td>
							<td>
								<a href="{{route('unidades',$c->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unidades"></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection