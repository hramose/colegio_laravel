@extends('layouts.admin')
@section('title') 
Editar Tarea - {{$tarea->titulo}} - 
{{$tarea->unidad->curso->seccion->grado->descripcion}} 
{{$tarea->unidad->curso->seccion->descripcion_seccion}} 
{{$tarea->unidad->descripcion}}  - 
{{$tarea->unidad->curso->materia->descripcion}} 
@endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($tarea, ['route' => ['editar_tarea',$tarea->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::text('titulo', null, ['data-required'=> 'true']) !!}
	       	{!! Field::select('tipo_tarea_id', $tipos, null, ['data-required'=> 'true']) !!}
	       	{!! Field::number('porcentaje', null, ['data-required'=> 'true']) !!}
	       	{!! Field::textarea('descripcion', null, ['data-required'=> 'true']) !!}
	       	{!! Field::checkbox('aplica_fecha') !!}
	       	{!! Field::text('fecha_inicio', null, ['data-required'=> 'false','class'=>'fecha']) !!}
	       	{!! Field::text('fecha_fin', null, ['data-required'=> 'false','class'=>'fecha']) !!}
	       	{!! Field::file('archivo') !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('tareas',$tarea->unidad_id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
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