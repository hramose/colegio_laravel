<html>
	<header>
		<link href="{{asset('assets/admin/css/custom.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/admin/css/tables.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/admin/css/custom_reports.css') }}" rel="stylesheet" type="text/css" />
		<style>
		    @page { margin: 115px 50px; }
	    	#header { position: fixed; left: 0px; top: -125px; right: 0px; height: 100px; text-align: center; padding-top: 10px;}
	    	#footer { position: fixed; left: 0px; bottom: -100px; right: 0px; height: 75px; text-align: center; display: block; font-size: 12px}
	    	#footer .page:after { content: counter(page); }
	    	.logo { float: left; height: 100px;  }
	    	.table { margin: 0; }
	    	body { background: white; }
	    	.nota{
				width: 50px !important;
			}
			td{
				padding: 0 !important;
			}
			th{
				vertical-align: middle !important;
			}
			th.border-header, .table > thead:first-child > tr:first-child > th.border-header{
				border: 3px solid black;
			}
			.table-bordered thead tr th {
			    text-align: center !important;
			    background-color: white !important;
			    color: black !important;
			}
			.table-bordered tbody tr td {
				border: 1px solid black !important;
				padding: 0px 5px !important;
			}
			.table-responsive tbody tr td {
				border: none !important;
				padding: 0px 5px !important;
			}
			.table{
				border-collapse: collapse !important;
				width: 100%;
			}
			.linea-punteada {
				border-width: 2px; border-style: dashed; border-bottom: none;
			}
		</style>
	</header>
	<body>
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-responsive">
					<tr>
						<td width="125px">
							<img src="{{asset('assets/imagenes/logos/logo.png')}}">
						</td>
						<td>
							<p class="text-center">
								Centro Educativo Vocacional San José<br/>
								Misioneros  de la Divina Redención<br/>
								0 Av. 13-25, Pasaje la visitacion de Maria, Calz. Roosevelt,<br/>
								Zona 3 de Mixco, Colonia El Rosario.<br/>
								Tel: 2432-1902 Fax: 2433-2239<br/>
								centrovocacionalsanjose@gamil.com<br/>
							</p>
						</td>
						<td width="125px">
							<img src="{{asset('assets/imagenes/logos/logo.png')}}">
						</td>
					</tr>
				</table>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-responsive">
					<tr>
						<td width="125px" class="bold">ESTUDIANTE:</td>
						<td>{{$estudiante->estudiante->nombre_completo_apellidos}}</td>
					</tr>
					<tr>
						<td width="125px" class="bold">GRADO:</td>
						<td>{{$seccion->descripcion_con_grado}}</td>
					</tr>
					<tr>
						<td width="125px" class="bold">CODIGO:</td>
						<td>{{$estudiante->codigo}}</td>
					</tr>
				</table>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-bordered" >
					<thead>
						<tr>
							<th class="text-center border-header" width="25px">No.</th>
							<th class="text-center border-header">CURSO</th>
							@foreach($unidades as $index => $unidad)
								<th class="text-center nota border-header">{{$unidad->descripcion}}</th>
							@endforeach
							<th class="text-center nota border-header">FINAL</th>
						</tr>
					</thead>
					<tbody>
						@php $index=0; @endphp
						@foreach($notas as $nota)
							@php $index++; @endphp
							<tr>
								<td class="text-center">{{$index}}</td>
								<td>{{$nota['curso']->materia->descripcion}}</td>
								@foreach($nota['unidades'] as $unidad)

									@php 
										$clase = ''; 
										if($unidad['unidad']->nota_ganar > $unidad['nota']) 
											$clase = 'bg-red text-white'; 
									@endphp
									<td class="text-center nota {{$clase}}">
										{{$unidad['nota']}}
									</td>

								@endforeach
							
								<td class="text-center nota">{{$nota['nota_anual']}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>      
			</div>
		</div>
		<hr class="linea-punteada" style="margin: 25px 0; ">
		<div class="row">
			<div class="col-lg-12">
				Yo _________________________________________, encargado de: __<b><u>{{$estudiante->estudiante->nombre_completo_apellidos}}</u></b>__ del grado: __<b><u>{{$seccion->descripcion_con_grado}}</u></b>__, firmo este codo como constancia del informe de calificaciones. 
				<br/><br/><br/>
				Firma: ____________________________
			</div>
		</div>
	</body>
</html>