@extends('layouts.admin')
@section('title') Compañeros {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}} @endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<ul class="users-list clearfix">
				@foreach($estudiantes as $estudiante)
                <li>
              		<img src="{{$estudiante->estudiante->fotografia}}" alt="" width="80px" height="80px">
                  	<a class="users-list-name" href="#">{{$estudiante->estudiante->nombre_completo}}</a>
                  	<span class="users-list-date">Estudiante</span>
                  	<span class="users-list-date">{{$estudiante->estudiante->edad}}</span>
                </li>
                @endforeach
          	</ul>
		</div>
	</div>
</div>
@endsection