@extends('layouts.admin')
@section('title') Cursos {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}} @endsection
@section('css')
<style>
    .ver-curso {
        padding-top: 2px !important; 
        padding-bottom: 2px !important; 
        color: white !important;
    }
    .ver-curso:hover{
        background-color:#57beef !important;
    }
</style>
@endsection
<?php $colors = Variable::getColores(); $columna=0; ?>
@section('content')
<div class="row">
	<div class="col-lg-12">
            <div class="row">
                @foreach($cursos as $index => $curso)
                <div class="col-md-3">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header {{$colors[$columna]}}">
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{$curso->maestro->fotografia}}" alt="User Avatar">
                            </div>
                            <h5 class="widget-user-username" style="font-size: 20px">{{$curso->maestro->nombre_completo}}</h5>
                            <h5 class="widget-user-desc">{{$curso->materia->descripcion}}</h5>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="{{route('unidades_curso',$curso->id)}}"><i class="fa fa-book"></i> Unidades <span class="pull-right badge bg-green">{{count($curso->unidades)}}</span></a></li>
                                <li><a href="{{route('estudiantes.foros',$curso->id)}}"><i class="fa fa-comments-o"></i> Foros <span class="pull-right badge bg-red">{{$curso->cantidad_foros}}</span></a></li>
                                <li class="{{$colors[$columna]}}" style="font-weight: bold;">
                                    <a href="{{route('estudiantes.ver_curso',$curso->id)}}" class="ver-curso">Ver Curso <i class="fa fa-chevron-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php $columna++; if($columna == 4){ $columna=0; } ?>
                </div>
                @endforeach
		</div>
	</div>
</div>
@endsection