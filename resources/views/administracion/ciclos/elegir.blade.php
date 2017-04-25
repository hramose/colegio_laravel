@extends('layouts.admin')
@section('title') Elegir Ciclo @stop
@section('content')
<div class="row">
	@foreach($ciclos as $ciclo)
		<div class="col-md-3 col-sm-6 col-xs-12">
      		<div class="info-box">
            	<span class="info-box-icon bg-aqua"><i class="fa fa-clock-o"></i></span>

            	<div class="info-box-content">
            		<span class="info-box-number">{{$ciclo->descripcion}}</span>
              		<span class="info-box-text" style="padding-bottom: 10px;">Del {{$ciclo->fecha_inicio}} al {{$ciclo->fecha_fin}}</span>
              		{!! Form::model($ciclo, ['route' => array('elegir_ciclo', $ciclo->id), 'method' => 'POST', 'id' => 'form{{$ciclo->id}}']) !!}
                    	<input type="hidden" value="{{$ciclo->id}}" name="ciclo_id">
                    	<button type="submit" class="btn btn-info btn-sm fa fa-check" style="float: right; margin: 0 10px"> Elegir Ciclo</button>
                    {!! Form::close() !!}
            	</div>
          	</div>
        </div>
	@endforeach
</div>
@stop