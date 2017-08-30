@extends('layouts.admin')
@section('title') 
Notas {{$unidadSeccion->descripcion}} 
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="box-body">
				<div class="table-responsive">
					
					<hr>
					<div class="row">
						<div class="col-lg-8">
							<table class="table table-responsive" >
								<thead>
									<tr>
										<th class="text-center">ESTUDIANTE</th>
										@foreach($cursos as $index => $curso)
											<th class="text-center">{{$curso->materia->descripcion}}</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									@foreach($notas as $nota)
										<tr>
											<td> {{$nota['estudiante']->nombre_completo}} </td>
											@foreach($nota['cursos'] as $curso)
												<?php 
													$clase = ''; 
													if($unidadSeccion->nota_ganar > $curso['nota']) 
														$clase = 'bg-red'; 
												?>
												<td class="text-center {{$clase}}">{{$curso['nota']}}</td>
											@endforeach
										</tr>
									@endforeach
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