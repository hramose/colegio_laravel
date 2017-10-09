@extends('layouts.admin')
@section('title') 
Editar Foro - {{$foro->curso->descripcion}} 
@endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/summernote/summernote.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::model($foro, ['route' => ['editar_foro',$foro->id], 'method' => 'PUT', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	    	<div class="row">
	    		<div class="col-lg-12">{!! Field::text('tema', null, ['data-required'=> 'true']) !!}</div>
	    	</div>
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('foros',$foro->curso_id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
		</div>
	{!! Form::close() !!}
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/summernote/summernote.js')}}"></script>
<script>	
$(function()
{
    $('#summernote').summernote({minHeight: 300,});
    
});
</script>
@endsection