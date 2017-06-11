@extends('layouts.admin')
@section('title') 
Estudiantes - {{$curso->materia->descripcion}} - {{$curso->seccion->grado->descripcion}} {{$curso->seccion->descripcion_seccion}} 
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('maestros.reporte_estudiantes_curso',[$curso->id, 'excel'])}}">
				<img src="{{asset('assets/imagenes/excel.png')}}" height="50px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Generar Listado">
			</a>
			<a href="{{route('maestros.dashboard')}}" class="btn btn-danger btn-flat">Regresar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>CODIGO</th>
						<th>ESTUDIANTE</th>
					</tr>
				</thead>
				<tfoot class="search">
					<tr>
						<th class="searchField">CODIGO</th>
						<th class="searchField">ESTUDIANTE</th>
						<th></th>
					</tr>
				</tfoot>
				<tbody>
					@foreach($estudiantes as $estudiante)
					<tr>
						<td>{{$estudiante->codigo}}</td>
						<td>{{$estudiante->estudiante->nombre_completo}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	/*$(document).ready(function() {
	    // Setup - add a text input to each footer cell
	    $('.table tfoot th.searchField').each( function () {
	        var title = $(this).text();
	        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
	    } );	 
	    // DataTable
	    var table = $('.table').DataTable({sort:false});	 
	    // Apply the search
	    table.columns().every( function () {
	        var that = this;	 
	        $( 'input', this.footer() ).on( 'keyup change', function () {
	            if ( that.search() !== this.value ) {
	                that
	                    .search( this.value )
	                    .draw();
	            }
	        } );
	    } );
	} );*/
</script>
@endsection