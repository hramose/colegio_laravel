@extends('layouts.admin')
@section('title') 
Editar Actividad - {{$actividad->titulo}} - 
{{$actividad->unidad_curso->unidad_seccion->descripcion}}  - 
{{$actividad->unidad_curso->curso->descripcion}} 
@endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/summernote/summernote.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($actividad, ['route' => ['editar_actividad',$actividad->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	<div class="row">
	    		<div class="col-lg-6">{!! Field::text('titulo', null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::select('tipo_actividad_id', $tipos, null, ['data-required'=> 'true']) !!}</div>
	    		<div class="col-lg-3">{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-12">
	    			{!! Field::textarea('descripcion', null, ['data-required'=> 'true','id'=>'summernote']) !!}
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">{!! Field::checkbox('aplica_fecha') !!}</div>
	    		<div class="col-lg-3">{!! Field::text('fecha_inicio', null, ['data-required'=> 'false','class'=>'fecha']) !!}</div>
	    		<div class="col-lg-3">{!! Field::text('fecha_fin', null, ['data-required'=> 'false','class'=>'fecha']) !!}</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">{!! Field::file('archivo') !!}</div>
	    	</div>
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('unidades_curso',$actividad->unidad_curso->curso_id) }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/summernote/summernote.js')}}"></script>
<script>	
$(function()
{
	$('.fecha').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es'
    });

    $('#summernote').summernote({minHeight: 300,});

	$('input[name="aplica_fecha"]').on('change',function()
	{
		if($(this).is(':checked')){
			$('.fecha').attr('data-required',true);
		}
		else{
			$('.fecha').attr('data-required',false);	
		}
	});
    
});
</script>
@endsection