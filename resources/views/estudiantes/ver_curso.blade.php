@extends('layouts.admin')
@section('title') 
{{$curso->descripcion}}
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
			        	<div class="box box-widget widget-user-2">
			            	<div class="widget-user-header bg-yellow">
			              		<div class="widget-user-image">
			                		<img class="img-circle" src="{{$curso->maestro->fotografia}}" alt="User Avatar">
			              		</div>
			              		<h3 class="widget-user-username">{{$curso->maestro->nombre_completo}}</h3>
			              		<h5 class="widget-user-desc">Maestro</h5>
			            	</div>
			          	</div>
			        </div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="info-box bg-green">
           					<span class="info-box-icon"><i class="fa fa-dashboard"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">UNIDADES</span>
								<span class="info-box-number">{{count($curso->unidades)}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 100%"></div>
									</div>
									<span class="progress-description">
									<a href="{{route('estudiantes.unidades',$curso->id)}}" style="color: white">Ver Unidades <i class="fa fa-chevron-right"></i></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="info-box bg-blue">
           					<span class="info-box-icon"><i class="fa fa-users"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">ESTUDIANTES</span>
								<span class="info-box-number">{{count($curso->seccion->estudiantes)}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 100%"></div>
									</div>
									<span class="progress-description">
									<a href="{{route('maestros.estudiantes_curso',$curso->id)}}" style="color: white">Ver Estudiantes <i class="fa fa-chevron-right"></i></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="info-box bg-red">
           					<span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">FORO</span>
								<span class="info-box-number">{{count($curso->foros)}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 100%"></div>
									</div>
									<span class="progress-description">
									<a href="{{route('estudiantes.foros',$curso->id)}}" style="color: white">Ver Foro <i class="fa fa-chevron-right"></i></a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('#foros').dataTable({
   			"bSort" : false
   		});
	});
</script>
@stop