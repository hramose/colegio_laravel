@extends('layouts.admin')
@section('title') 
{{$actividadEstudiante->actividad->unidad_curso->curso->descripcion}}
@endsection
@section('css')

@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
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
                            <a href="{{$actividadEstudiante->actividad->archivo}}" class="btn btn-default btn-xs pull-right" download="{{$actividadEstudiante->actividad->titulo}}">
                                <i class="fa fa-cloud-download"></i>
                            </a>
                            </span>
                        </div>
                    </li>
                </ul>
                @endif
                @if($actividadEstudiante->estado == 'C')
                {!! Field::text('observaciones',$actividadEstudiante->observaciones,['disabled']) !!}
                @endif
                <a href="{{route('estudiantes.unidades',$actividadEstudiante->actividad->unidad_curso->curso_id)}}" class="btn btn-danger btn-flat fa fa-chevron-circle-left"> Regresar</a>
			</div>
            <br/>
		</div>
	</div>
</div>

@endsection
@section('js')
@stop