@extends('layouts.admin')
@section('title') Secciones - {{$ciclo->descripcion}} @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_seccion')}}" class="btn btn-primary btn-flat">Agregar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>GRADO</th>
						<th>SECCIÓN</th>
						<th>MAESTRO</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tfoot class="search">
					<tr>
						<th class="searchField">GRADO</th>
						<th class="searchField">SECCION</th>
						<th class="searchField">MAESTRO</th>
						<th class="searchField">ESTADO</th>
						<th></th>
					</tr>
				</tfoot>
				<tbody>
					@foreach($secciones as $seccion)
					<tr>
						<td>{{$seccion->grado->descripcion}}</td>
						<td>{{$seccion->descripcion_seccion}}</td>
						<td>{{$seccion->maestro->nombre_completo}}</td>
						<td>{{$seccion->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_seccion',$seccion->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
							<a href="{{route('ver_seccion',$seccion->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver"></a>
							<a href="{{route('unidades_secciones',$seccion->id)}}" class="btn btn-info btn-sm btn-flat fa fa-th-large" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unidades"></a>
							<a href="{{route('estudiantes_seccion',$seccion->id)}}" class="btn btn-info btn-sm btn-flat fa fa-users" data-toggle="tooltip" data-placement="top" title="" data-original-title="Estudiantes"></a>
							<a href="{{route('cursos',$seccion->id)}}" class="btn btn-primary btn-sm btn-flat fa fa-list" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cursos"></a>
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