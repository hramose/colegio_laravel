@extends('layouts.admin')
@section('title') 
Eliminar Actividad - {{$actividad->titulo}} - 
{{$actividad->unidad_curso->unidad_seccion->descripcion}}  - 
{{$actividad->unidad_curso->curso->descripcion}} 
@endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datetimepicker/datetimepicker.css')}}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/summernote/summernote.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($actividad, ['route' => ['eliminar_actividad',$actividad->id], 'method' => 'DELETE', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	    	<div class="alert alert-danger alert-dismissable">
		      	@if(!is_null($mensaje))
				{{$mensaje}}
		      	@endif
				<br><br>
				¿Está seguro que desea eliminar la siguiente actividad? No se podrán recuperar los datos asociados.
				
		    </div>
	       	<div class="row">
	    		<div class="col-lg-6">{!! Field::text('titulo', null, ['disabled']) !!}</div>
	    		<div class="col-lg-3">{!! Field::text('tipo_actividad_id', $actividad->tipo->descripcion, ['disabled']) !!}</div>
	    		<div class="col-lg-3">{!! Field::number('punteo', null, ['disabled']) !!}</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-12">
	    			{!! Field::textarea('descripcion', null, ['disabled','id'=>'summernote']) !!}
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-3">{!! Field::checkbox('entrega_via_web') !!}</div>
	    		<div class="col-lg-3">{!! Field::text('fecha_inicio', null, ['disabled']) !!}</div>
	    		<div class="col-lg-3">{!! Field::text('fecha_entrega', null, ['disabled']) !!}</div>
	    	</div>
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Eliminar" class="btn btn-primary btn-flat">
            <a href="{{ route('unidades_curso',$actividad->unidad_curso->curso_id) }}#{{$actividad->unidad_curso->id}}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/moment/locale/es.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/datetimepicker/datetimepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/summernote/summernote.js')}}"></script>
<script>	
$(function()
{
	$('.fecha').datetimepicker({
		locale: 'es',
		format: 'YYYY-MM-DD HH:mm'
	});

    $('#summernote').summernote({minHeight: 300,});
    $('#summernote').summernote('disable');

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