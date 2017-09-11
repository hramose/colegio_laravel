@extends('layouts.admin')
@section('title') Secciones - {{$maestro->nombre_completo}} @endsection
@section('css')
<style>
    .ver-seccion {
        padding-top: 2px !important; 
        padding-bottom: 2px !important; 
        color: black !important;
    }
    .ver-seccion:hover{
        background-color:#57beef !important;
        color: white !important;;
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
                            <li>
                                <a href="{{route('maestros.ver_seccion',$seccion->id)}}" class="ver-seccion">Ver Seccion <i class="fa fa-chevron-right"></i></a>
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