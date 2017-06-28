@extends('layouts.admin')
@section('title') Foro - {{$foro->curso->descripcion}} @endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/summernote/summernote.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="user-block">
  <img class="img-circle" src="{{$foro->autor->fotografia}}" alt="User Image">
  <span class="username"><a href="#">Tema: {{$foro->tema}}</a></span>
<span class="description">Iniciado por {{$foro->autor->nombre_completo}} el {{date('d/m/Y - H:i', strtotime($foro->created_at))}}</span>
</div>
<br/>
<div class="col-md-12">
    <div class="box box-widget">
        <div class="box-header with-border">
            <div class="box-footer box-comments">
            @foreach($mensajes as $mensaje)
              <div class="box-comment">
                <img class="img-circle img-sm" src="{{$mensaje->autor->fotografia}}" alt="User Image">
                <div class="comment-text">
                  <span class="username">
                    {{$mensaje->autor->nombre_completo}}
                    <span class="text-muted pull-right">{{date('d/m/Y - H:i', strtotime($mensaje->created_at))}}</span>
                  </span>
                  {!! $mensaje->mensaje !!}
                </div>
              </div>
            @endforeach
            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
              {!! Form::open(['route' => ['agregar_mensaje_foro',$foro->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
                <img class="img-responsive img-circle img-sm" src="{{Auth::user()->persona->fotografia}}" alt="Alt Text">
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                  <label for="mensaje">Agrega un nuevo mensaje</label>
                  <br/>
                  <textarea name="mensaje" id="mensaje" cols="30" rows="10" class="form-control"></textarea>
                  <input type="submit" class="btn btn-primary btn-flat" value="Enviar" style="float:left">
                </div>
                
              {!! Form::close() !!}
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/summernote/summernote.js')}}"></script>
<script>	
$(function()
{
    $('#mensaje').summernote({minHeight: 300});    
});
</script>
@endsection