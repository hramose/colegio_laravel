@extends('layouts.admin')
@section('title') Secciones - {{$maestro->nombre_completo}} @endsection
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
            @foreach($secciones as $index => $seccion)
            <div class="col-md-3">
                <div class="box box-widget widget-user-2">
                    <div class="widget-user-header {{$colors[$columna]}}">
                        <div class="widget-user-image">
                            <img class="img-circle" src="{{$seccion->maestro->fotografia}}" alt="User Avatar">
                        </div>
                        <h5 class="widget-user-username" style="font-size: 20px">
                            {{$seccion->grado->descripcion}}
                        </h5>
                        <h5 class="widget-user-desc">Sección {{$seccion->descripcion_seccion}} </h5>
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="{{route('maestros.estudiantes_seccion',$seccion->id)}}"><i class="fa fa-users"></i> Estudiantes <span class="pull-right badge bg-blue">{{count($seccion->estudiantes)}}</span></a></li>
                            <li><a href="{{route('notas_seccion',$seccion->id)}}"><i class="fa fa-users"></i> Notas <span class="pull-right badge bg-blue">{{count($seccion->estudiantes)}}</span></a></li>
                            @foreach($seccion->unidades as $unidad)
                            <li><a href="{{route('notas_unidad_seccion',$unidad->id)}}"><i class="fa fa-book"></i> Ver Notas {{$unidad->descripcion}} <span class="pull-right badge bg-green"><i class="fa fa-chevron-right"></i></span> </a></li>
                            @endforeach
                            
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