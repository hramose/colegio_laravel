@extends('layouts.admin')
@section('title') Cursos - {{$maestro->nombre_completo}} @endsection
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
                            <h5 class="widget-user-username" style="font-size: 20px">{{$curso->materia->descripcion}}</h5>
                            <h5 class="widget-user-desc">{{$curso->seccion->grado->descripcion}} {{$curso->seccion->descripcion_seccion}}</h5>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="{{route('maestros.foros',$curso->id)}}">Foros <span class="pull-right badge bg-blue">{{$curso->cantidad_foros}}</span></a></li>
                                <li><a href="#">Tareas <span class="pull-right badge bg-green">{{rand(0,10)}}</span></a></li>
                                <!--<li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>-->
                                <li class="{{$colors[$columna]}}" style="font-weight: bold;">
                                    <a href="{{route('maestros.ver_curso',$curso->id)}}" class="ver-curso">Ver Curso <i class="fa fa-chevron-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php $columna++; if($columna == 4) $columna==0; ?>
                </div>
                @endforeach
		</div>
	</div>
</div>
@endsection