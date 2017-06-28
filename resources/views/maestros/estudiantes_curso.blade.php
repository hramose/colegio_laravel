@extends('layouts.admin')
@section('title') Estudiantes {{$curso->descripcion}}@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<a href="{{route('maestros.reporte_estudiantes_curso',[$curso->id, 'excel'])}}">
			<img src="{{asset('assets/imagenes/excel.png')}}" height="50px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Generar Listado">
		</a>
		<a href="{{route('maestros.ver_curso',$curso->id)}}" class="btn btn-danger btn-flat">Regresar al Curso</a>
		<hr style="border-top: 2px solid #3c8dbc">
		<ul class="users-list clearfix">
			@foreach($estudiantes as $estudiante)
            <li>
          		<img src="{{$estudiante->estudiante->fotografia}}" alt="" style="width: 80px !important; height: 80px !important">
              	<a class="users-list-name" href="#">{{$estudiante->estudiante->nombre_completo}}</a>
              	<span class="users-list-date">Estudiante</span>
              	<span class="users-list-date">{{$estudiante->estudiante->edad}}</span>
            </li>
            @endforeach
      	</ul>
	</div>
</div>
@endsection
