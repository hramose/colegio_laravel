@extends('layouts.admin')
@section('title') Editar Estudiante @endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($estudiante, ['route' => ['editar_estudiante',$estudiante->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form', 'files'=>'true']) !!}
	    <div class="box-body">
	    	<div class="row">
	    		<div class="col-lg-3">{!! Field::text('primer_nombre', null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::text('segundo_nombre') !!}</div>
	    		<div class="col-lg-3">{!! Field::text('primer_apellido', null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::text('segundo_apellido') !!}</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">
	    			{!! Field::text('fecha_nacimiento', null, ['data-required'=> 'true','class'=>'fecha']) !!}
	    		</div>
	    		<div class="col-lg-3">
	    			{!! Field::number('cui', null, ['data-required'=> 'false']) !!}
	    		</div>
	    		<div class="col-lg-3">
	    			{!! Field::select('genero', $generos, null, ['data-required'=> 'true']) !!}
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">{!! Field::number('telefono', null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::number('celular', null, ['data-required'=> 'false']) !!}</div>
	    		<div class="col-lg-6">{!! Field::text('direccion', null, ['data-required'=> 'true']) !!}</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">
	    		{!! Field::file('fotografia') !!}
	    		</div>
                <div class="col-lg-3">
	    		<img src="{{$estudiante->fotografia}}" height="75px">
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}</div>
	    	</div>			
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('estudiantes') }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
<script>	
$(function()
{
	$('.fecha').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es'
    });    
});
</script>
@endsection