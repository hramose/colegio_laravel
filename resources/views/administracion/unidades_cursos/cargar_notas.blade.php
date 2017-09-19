@extends('layouts.admin')
@section('title') Cargar notas @endsection
@section('css')
<style>
	label { display: none }
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		{!! Form::open(['route' => ['cargar_notas_unidad_curso',$unidadCurso->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box box-primary">
			<div class="box-body">
				<input type="file" name="xlfile" id="xlf" />
				<hr>				
				<div id="tabs"></div>				
			</div>
			<div class="box-footer">
	       		<input type="submit" value="Cargar" class="btn btn-primary btn-flat">
	       		<a href="{{route('unidades_curso',$unidadCurso->curso_id)}}" class="btn btn-danger btn-flat">Regresar</a>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/admin/js/excel/xlsx.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script>

var oFileIn;

$(function() {
    oFileIn = document.getElementById('xlf');
    if(oFileIn.addEventListener) {
        oFileIn.addEventListener('change', filePicked, false);
    }
});


function filePicked(oEvent) {
    // Get The File From The Input
    var oFile = oEvent.target.files[0];
    var sFilename = oFile.name;
    // Create A File Reader HTML5
    var reader = new FileReader();

    reader.onload = function(e) {
      var data = e.target.result;
      var workbook = XLSX.read(data, {
        type: 'binary'
      });

      var html = '<div class="nav-tabs-custom">';
      var tabsHeaders = '<ul class="nav nav-tabs">';
      var tabsBodies = '<div class="tab-content">';
      var clase = 'active';

      workbook.SheetNames.forEach(function(sheetName) {
      	
      	tabsHeaders += '<li class="'+clase+'"><a href="#'+sheetName+'" data-toggle="tab">'+sheetName+'</a></li>';

        tabsBodies += '<div class="tab-pane '+clase+'" id="'+sheetName+'">';
        tabsBodies += '<div class="table-responsive">';
        tabsBodies += '<input type="hidden" name="notas['+sheetName+'][actividad]" value="'+sheetName+'" >';
        tabsBodies += '<table class="table table-responsive">';
        tabsBodies += '<thead>';
        tabsBodies += '<tr>';
        tabsBodies += '<th>TAREA_ID</th>';
        tabsBodies += '<th>TAREA</th>';
        tabsBodies += '<th>ESTUDIANTE_ID</th>';
        tabsBodies += '<th>ESTUDIANTE</th>';
        tabsBodies += '<th>NOTA</th>';
        tabsBodies += '<th>OBSERVACIONES</th>';
        tabsBodies += '</tr>';
        tabsBodies += '</thead>';
        tabsBodies += '<tbody>';

        var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
        var json = JSON.stringify(XL_row_object);
        console.log(json);
        row = '';
        $.each(JSON.parse(json),function(key, actividad) 
		{
			if(actividad.NOTA == undefined) actividad.NOTA = 0;
			if(actividad.OBSERVACIONES == undefined) actividad.OBSERVACIONES = '';

			tabsBodies += '<tr>';
	        tabsBodies += '<td><input type="hidden" name="notas['+sheetName+'][actividades_estudiantes]['+actividad.TAREA_ID+'][id]" value="'+actividad.TAREA_ID+'"">'+actividad.TAREA_ID+'</td>';
	        tabsBodies += '<td>'+actividad.TAREA+'</td>';
	        tabsBodies += '<td><input type="hidden" name="notas['+sheetName+'][actividades_estudiantes]['+actividad.TAREA_ID+'][estudiante_id]" value="'+actividad.ESTUDIANTE_ID+'"">'+actividad.ESTUDIANTE_ID+'</td>';
	        tabsBodies += '<td>'+actividad.ESTUDIANTE+'</td>';
	        tabsBodies += '<td><input type="hidden" name="notas['+sheetName+'][actividades_estudiantes]['+actividad.TAREA_ID+'][nota]" value="'+actividad.NOTA+'"">'+actividad.NOTA+'</td>';
	        tabsBodies += '<td><input type="hidden" name="notas['+sheetName+'][actividades_estudiantes]['+actividad.TAREA_ID+'][observaciones]" value="'+actividad.OBSERVACIONES+'"">'+actividad.OBSERVACIONES+'</td>';
	        tabsBodies += '</tr>';
		});

        tabsBodies += '</tbody>';
		tabsBodies += '</table>';
		tabsBodies +='</div>';
		tabsBodies +='</div>';

		clase = '';

      });

      
      tabsHeaders += '</ul>';
      tabsBodies += '</div>';
      

      html += tabsHeaders + tabsBodies;
      html += '</div>';
      $('#tabs').html(html);

    };

    reader.onerror = function(ex) {
      console.log(ex);
    };

    reader.readAsBinaryString(oFile);
}
</script>

@endsection