@extends('layouts.admin')
@section('title') Dashboard - {{Auth::user()->persona->nombre_completo}} @endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}">
@endsection
@section('content')
<div class="row">
	@if(count($secciones) > 0)
	<div class="col-lg-4">
		<div class="info-box bg-green">
			<span class="info-box-icon"><i class="fa fa-users"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Secciones</span>
				<span class="info-box-number">{{count($secciones)}}</span>
				<div class="progress">
        			<div class="progress-bar" style="width: 100%"></div>
      			</div>
          		<span class="progress-description">
        			<a href="#" style="color: white !important">
      					Ver secciones <i class="fa fa-arrow-circle-right"></i>
    				</a>
          		</span>
          	</div>
    	</div>
	</div>
	@endif
	@if(count($cursos) > 0)
	<div class="col-lg-4">
		<div class="info-box bg-red">
			<span class="info-box-icon"><i class="fa fa-book"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Cursos</span>
				<span class="info-box-number">{{count($cursos)}}</span>
				<div class="progress">
        			<div class="progress-bar" style="width: 100%"></div>
      			</div>
          		<span class="progress-description">
        			<a href="{{route('maestros.cursos')}}" style="color: white !important">
      					Ver cursos <i class="fa fa-arrow-circle-right"></i>
    				</a>
          		</span>
          	</div>
    	</div>
	</div>
	@endif
	<div class="col-lg-4">
		<div class="info-box bg-yellow">
			<span class="info-box-icon"><i class="fa fa-bell"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Notificaciones sin Leer</span>
				<span class="info-box-number">{{count(Auth::user()->persona->unreadNotifications)}}</span>
				<div class="progress">
        			<div class="progress-bar" style="width: 100%"></div>
      			</div>
          		<span class="progress-description">
        			<a href="{{route('notificaciones',0)}}" style="color: white !important">
      					Ver notificaciones <i class="fa fa-arrow-circle-right"></i>
    				</a>
          		</span>
          	</div>
    	</div>
		<div class="box box-solid bg-blue">
			<div class="box-header">
				<i class="fa fa-calendar"></i>
				<h3 class="box-title">Calendario</h3>
				<div class="pull-right box-tools">
					<button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body no-padding">
				<div id="calendar" style="width: 100%"></div>
			</div>
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