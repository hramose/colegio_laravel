@extends('layouts.admin')
@section('title') 
Agregar Planificación -
{{$unidadCurso->unidad_seccion->descripcion}} - 
{{$unidadCurso->curso->descripcion}}
@endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/summernote/summernote.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($unidadCurso, ['route' => ['editar_unidad_curso',$unidadCurso->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	       	{!! Field::text('unidad', $unidadCurso->unidad_seccion->descripcion, ['disabled']) !!}
	       	{!! Field::number('nota_ganar', $unidadCurso->unidad_seccion->nota_ganar, ['disabled']) !!}
	       	{!! Field::number('porcentaje', $unidadCurso->unidad_seccion->porcentaje, ['disabled']) !!}
	       	{!! Field::textarea('planificacion', null, ['data-required'=> 'false','id'=>'summernote']) !!}
	       	{!! Field::file('archivo_planificacion') !!}
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar Planificación" class="btn btn-primary btn-flat">
            <a href="{{ route('unidades_curso',$unidadCurso->curso_id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
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
    $('#summernote').summernote({minHeight: 300,});
    
});
</script>
@endsection