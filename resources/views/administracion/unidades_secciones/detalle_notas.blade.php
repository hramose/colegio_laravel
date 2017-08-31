@extends('layouts.admin')
@section('title') 
Notas {{$unidadSeccion->descripcion}} - {{$curso->descripcion}}
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
				<div class="table-responsive">
					<h3>
						<img src="{{$estudiante->fotografia}}" style="width: 80px !important; height: 80px !important; border-radius: 50%">
						{{$estudiante->nombre_completo}}
					</h3>
					<hr>
					<div class="row">
						<div class="col-lg-6">
							<table class="table table-responsive" >
								<thead>
									<tr>
										<th class="text-center">ACTIVIDAD</th>
										<th class="text-center">VALOR</th>
										<th class="text-center">NOTA</th>
									</tr>
								</thead>
								<tbody>
									@php $total = 0; @endphp
									@foreach($actividades as $ae)
										@php $total += $ae->nota; @endphp
										<tr>
											<td> {{$ae->actividad->titulo}} </td>
											<td class="text-center"> {{$ae->actividad->punteo}} </td>
											<td class="text-center"> {{$ae->nota}} </td>
										</tr>
									@endforeach
										<tr>
											<th class="text-center" colspan="2"> TOTAL </th>
											<th class="text-center">{{$total}}</th>
										</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>       
	</div>
</div>
@endsection