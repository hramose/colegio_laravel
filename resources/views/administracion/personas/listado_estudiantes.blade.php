@extends('layouts.admin')
@section('title') Estudiantes @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_estudiante')}}" class="btn btn-primary btn-flat">Agregar</a>
			<a href="{{route('cargar_estudiantes')}}" class="btn btn-primary btn-flat">Cargar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>NOMBRE</th>
						<th>FECHA NACIMIENTO</th>
						<th>TELEFONO</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tfoot class="search">
					<tr>
						<th class="searchField">NOMBRE</th>
						<th class="searchField">FECHA NACIMIENTO</th>
						<th class="searchField">TELEFONO</th>
						<th class="searchField">ESTADO</th>
						<th></th>
					</tr>
				</tfoot>
				<tbody>
					@foreach($estudiantes as $estudiante)
					<tr>
						<td>{{$estudiante->nombre_completo}}</td>
						<td>{{ date('d-m-Y', strtotime($estudiante->fecha_nacimiento)) }}</td>
						<td>{{$estudiante->telefono}}</td>
						<td>{{$estudiante->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_estudiante',$estudiante->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
						</td>
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
	$(document).ready(function() {
	    // Setup - add a text input to each footer cell
	    $('.table tfoot th.searchField').each( function () {
	        var title = $(this).text();
	        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
	    } );	 
	    // DataTable
	    var table = $('.table').DataTable();	 
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
	} );
</script>
@endsection