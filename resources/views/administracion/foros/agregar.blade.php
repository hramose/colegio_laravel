@extends('layouts.admin')
@section('title') 
Agregar Foro - {{$curso->descripcion}} 
@endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/summernote/summernote.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => ['agregar_foro',$curso->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	    <div class="box-body">
	    	<div class="row">
	    		<div class="col-lg-12">{!! Field::text('tema', null, ['data-required'=> 'true']) !!}</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-lg-12">
	    			{!! Field::textarea('mensaje', null, ['data-required'=> 'true','id'=>'summernote']) !!}
	    		</div>
	    	</div>
	  	</div>
		<div class="box-footer">
       		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('foros',$curso->id) }}" class="btn btn-danger btn-flat">Cancelar</a>     
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