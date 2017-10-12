@extends('layouts.admin')
@section('title') 
Cursos - {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}} 
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_curso',$seccion->id)}}" class="btn btn-primary btn-flat">Agregar</a>
			<a href="{{route('ordenar_cursos',$seccion->id)}}" class="btn btn-info btn-flat">Ordenar</a>
			<a href="{{route('ordenar_cursos_por_nombre',$seccion->id)}}" class="btn btn-info btn-flat">Ordenar por Nombre</a>
			<a href="{{route('secciones')}}" class="btn btn-danger btn-flat">Regresar</a>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>MATERIA</th>
						<th>MAESTRO</th>
						<th>ORDEN</th>
						<th>ESTADO</th>
						<th></th>
					</tr>
				</thead>
				<tfoot class="search">
					<tr>
						<th class="searchField">MATERIA</th>
						<th class="searchField">MAESTRO</th>
						<th class="searchField">ORDEN</th>
						<th class="searchField">ESTADO</th>
						<th></th>
					</tr>
				</tfoot>
				<tbody>
					@foreach($cursos as $curso)
					<tr>
						<td>{{$curso->materia->descripcion}}</td>
						<td>{{$curso->maestro->nombre_completo}}</td>
						<td>{{$curso->orden}}</td>
						<td>{{$curso->descripcion_estado}}</td>
						<td>
							<a href="{{route('editar_curso',$curso->id)}}" class="btn btn-warning btn-sm btn-flat fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></a>
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
	    var table = $('.table').DataTable({'sort':false});	 
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