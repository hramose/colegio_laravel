@extends('layouts.admin')
@section('title') Maestros {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}} @endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<ul class="users-list clearfix">
				@foreach($cursos as $curso)
                <li>
              		<img src="{{$curso->maestro->fotografia}}" alt="" width="80px" height="80px">
                  	<a class="users-list-name" href="#">{{$curso->maestro->nombre_completo}}</a>
                  	<span class="users-list-date">Maestro</span>
                  	<a href="{{route('estudiantes.ver_curso',$curso->id)}}"><span class="users-list-date">{{$curso->materia->descripcion}}</span></a>
                </li>
                @endforeach
          	</ul>
		</div>
	</div>
</div>
@endsection