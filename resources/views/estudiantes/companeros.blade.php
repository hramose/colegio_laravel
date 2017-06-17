@extends('layouts.admin')
@section('title') Compañeros {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}} @endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}">
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<ul class="users-list clearfix">
				@foreach($estudiantes as $estudiante)
                <li>
              		<img src="{{$estudiante->estudiante->fotografia}}" alt="" width="80px" height="80px">
                  	<a class="users-list-name" href="#">{{$estudiante->estudiante->nombre_completo}}</a>
                  	<span class="users-list-date">Estudiante</span>
                  	<span class="users-list-date">{{$estudiante->estudiante->edad}}</span>
                </li>
                @endforeach
          	</ul>
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/admin/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
<script type="text/javascript">
	  $(function(){
	  		$("#calendar").datepicker({
	  			language: 'es'
	  		});
	  	});

</script>
@stop