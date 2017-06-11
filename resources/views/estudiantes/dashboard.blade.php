@extends('layouts.admin')
@section('title') Dashboard @endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}">
@endsection
@section('content')
<div class="row">
	<div class="col-lg-9">
		@if(count($cursos) > 0)
		<div class="col-lg-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Cursos</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>SECCIONES</th>
									<th>MATERIA</th>
									<th>MAESTRO</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($cursos as $c)
								<tr>
									<td>
										{{$c->seccion->grado->descripcion}} 
										{{$c->seccion->descripcion_seccion}}
									</td>
									<td>{{$c->materia->descripcion}}</td>
									<td>{{$c->maestro->nombre_completo}}</td>
									<td>
										<a href="{{route('estudiantes.ver_curso',$c->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-list" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver Curso"></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
	<div class="col-lg-3">
		<div class="row">
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
		<div class="row">
			
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