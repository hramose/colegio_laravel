@extends('layouts.admin')
@section('title') 
Agregar Estudiantes - {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}}
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
	{!! Form::open(['route' => array('agregar_estudiante_seccion',$seccion->id), 'method' => 'POST', 'id' => 'form', 'role' => 'form', 'class' => 'validate-form']) !!}				
	    <div class="table-responsive">
				<table class="table table-responsive" id="tableEstudiantes">
					<thead>
						<tr>
							<th></th>
							<th>ESTUDIANTE</th>
							<th>EDAD</th>
							<th>GENERO</th>
						</tr>
					</thead>
					<tbody>
						@foreach($estudiantes as $estudiante)
						<tr>
							<td class="text-center" width="50px">
								<input type="checkbox" value="{{$estudiante->id}}" name="estudiantes[{{$estudiante->id}}][check]">
								<input type="hidden" value="{{$estudiante->id}}" name="estudiantes[{{$estudiante->id}}][estudiante]">
							</td>
							<td>{{$estudiante->nombre_completo}}</td>
							<td>{{$estudiante->edad}}</td>
							<td>{{$estudiante->descripcion_genero}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="box-footer">
	        <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
	        <a href="{{ route('estudiantes_seccion',$seccion->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
		</div>
	{!! Form::close() !!}
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		var estudiantes = $('#tableEstudiantes').dataTable({
   			"bSort" : true,
   			"aaSorting" : [[1, 'asc']]
   		});

   		$('#form').on('submit', function(e){
   			//alert('submit');
			var form = this;
	      	// Iterate over all checkboxes in the table
	      	estudiantes.$('input[type="checkbox"]').each(function(){
         	// If checkbox doesn't exist in DOM
     			if(!$.contains(document, this)){
	            	// If checkbox is checked
	            	if(this.checked){
	            		//alert(this.name);
	            		//alert(this.value);
	               	// Create a hidden element 
	               		$(form).append(
	                  	$('<input>')
	                     	.attr('type', 'hidden')
	                     	.attr('name', this.name)
	                     	.val('on')
	               		);
	               		$(form).append(
	                  	$('<input>')
	                     	.attr('type', 'hidden')
	                     	.attr('name', 'estudiantes['+this.value+'][estudiante]')
	                     	.val(this.value)
	               		);

	            	}
	         	} 
	      	});
	   	});
	});
</script>
@endsection