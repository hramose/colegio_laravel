@extends('layouts.admin')
@section('title') Dashboard @stop
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="row">
			<div class="col-lg-3">
				<div class="info-box bg-yellow">
		            <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>
		            <div class="info-box-content">
		              	<span class="info-box-text">Maestros Activos</span>
		              	<span class="info-box-number">{{$maestrosActivos}}</span>
		            </div>
		      	</div>
			</div>
			<div class="col-lg-3">
				<div class="info-box bg-blue">
		            <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>
		            <div class="info-box-content">
		              	<span class="info-box-text">Estudiantes Activos</span>
		              	<span class="info-box-number">{{$estudiantesActivos}}</span>
		            </div>
		      	</div>
			</div>
		</div>
	</div>
</div>
@stop