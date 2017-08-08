@extends('layouts.admin')
@section('title') 
Entregar {{$actividadEstudiante->actividad->unidad_curso->curso->descripcion}}
@endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/summernote/summernote.css') }}" rel="stylesheet">
<style>
    textarea.has-error+.note-editor{
        border: 3px solid red;
    }
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>{{$actividadEstudiante->actividad->titulo}}</h3>
                        {!! $actividadEstudiante->actividad->descripcion !!}
                        @if($actividadEstudiante->actividad->archivo)
                        <ul class="mailbox-attachments clearfix">
                            <li>
                                <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                <div class="mailbox-attachment-info">
                                    <a href="{{$actividadEstudiante->actividad->archivo}}" class="mailbox-attachment-name" download="{{$actividadEstudiante->actividad->titulo}}">
                                        <i class="fa fa-paperclip"></i> {{$actividadEstudiante->actividad->titulo}}
                                    </a>
                                    <span class="mailbox-attachment-size">
                                    <!--1,245 KB-->
                                    <a href="{{$actividadEstudiante->actividad->archivo}}" class="btn btn-default btn-xs pull-right"
                                        download="{{$actividadEstudiante->actividad->titulo}}">
                                        <i class="fa fa-cloud-download"></i>
                                    </a>
                                    </span>
                                </div>
                            </li>
                        </ul>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        {!! Form::open(['route' => ['estudiantes.entregar_actividad',$actividadEstudiante->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
                            {!! Field::textarea('texto',$actividadEstudiante->texto,['data-required'=>'true','id'=>'texto']) !!}
                            {!! Field::file('archivo') !!}
                                 <input type="submit" value="Entregar" class="btn btn-primary btn-flat">
                        {!! Form::close() !!}
                    </div>
                </div>
                
                <a href="{{route('estudiantes.unidades',$actividadEstudiante->actividad->unidad_curso->curso_id)}}" class="btn btn-danger btn-flat fa fa-chevron-circle-left"> Regresar</a>
			</div>
            <br/>
		</div>
	</div>
</div>

@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/summernote/summernote.js')}}"></script>
<script>    
$(function()
{
    $('#texto').summernote({minHeight: 300});    
});
</script>
@endsection