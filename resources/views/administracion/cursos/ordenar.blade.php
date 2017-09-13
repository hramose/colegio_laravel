@extends('layouts.admin')
@section('title') 
Ordenar Cursos - {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}} 
@endsection
@section('css')
<style>
	.curso:hover {
		cursor: move;
	}
</style>
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			{!! Form::open(['route' => array('ordenar_cursos',$seccion->id), 'method' => 'POST', 'id' => 'form', 'role' => 'form', 'class' => 'validate-form']) !!}
			<table id="sort" class="table table-bordered">
				<thead>
					<tr>
						<th>MATERIA</th>
						<th>MAESTRO</th>
						<th>ORDEN</th>
						<th>ESTADO</th>
					</tr>
				</thead>
				<tbody>
					@foreach($cursos as $curso)
					<tr class="curso" id="{{$curso->id}}">
						<td>{{$curso->materia->descripcion}}</td>
						<td>{{$curso->maestro->nombre_completo}}</td>
						<td>
							<span id="orderSpan{{$curso->id}}">{{$curso->orden}}</span>
							<input type="hidden" name="cursos[{{$curso->id}}][orden]" value="{{$curso->orden}}" id="orderTxt{{$curso->id}}">
							<input type="hidden" name="cursos[{{$curso->id}}][id]" value="{{$curso->id}}">
						</td>
						<td>{{$curso->descripcion_estado}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<hr>
			<input type="submit" value="Ordenar" class="btn btn-primary btn-flat">
        	<a href="{{ route('cursos',$seccion->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('js')
<script
  src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
  integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
  crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
	    var fixHelperModified = function(e, tr) {
			    var $originals = tr.children();
			    var $helper = tr.clone();
			    $helper.children().each(function(index) {
			        $(this).width($originals.eq(index).width())
			    });
			    return $helper;
			},
		    updateIndex = function(e, ui) {
		        $('.curso').each(function($index)
	        	{
	        		var id = $(this).attr('id');
	        		$('#orderSpan'+id).text($index+1);
	        		$('#orderTxt'+id).val($index+1);
	        	});
		    };

		$("#sort tbody").sortable({
		    helper: fixHelperModified,
		    stop: updateIndex
		}).disableSelection();
	});
</script>
@endsection