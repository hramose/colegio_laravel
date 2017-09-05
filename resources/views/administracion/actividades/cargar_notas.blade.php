@extends('layouts.admin')
@section('title') Cargar notas de Actividad - {{$actividad->titulo}} @endsection
@section('css')
<style>
	label { display: none }
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
	{!! Form::open(['route' => ['cargar_notas_actividad',$actividad->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box box-primary">
			<div class="box-body">
				<input type="file" name="xlfile" id="xlf" />
				<div class="table-responsive">
					<table class="table table-responsive" id="tableNotas">
						<thead>
							<tr>
								<th width="100px">ID</th>
								<th width="350px">ESTUDIANTE</th>
								<th width="100px">NOTA</th>
								<th>OBSERVACIONES</th>
								<th></th>
							</tr>
						</thead>
						<tbody>							
						</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer">
	       		<input type="submit" value="Cargar" class="btn btn-primary btn-flat">
	            <a href="{{ route('ver_notas_actividad',$actividad->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
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

      workbook.SheetNames.forEach(function(sheetName) {
        // Here is your object
        var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
        var json = JSON.stringify(XL_row_object);
        row = '';
        $.each(JSON.parse(json),function(key, actividad) 
		{
			if(actividad.ID){
			    row += '<tr>';
			    row += '<td>'+actividad.ID+'</td>';
			    row += '<td><input type="hidden" class="form-control" name="notas['+actividad.ID+'][id]" value="'+actividad.ID+'">' + actividad.ESTUDIANTE + '</td>';
			    row += '<td><input type="text" class="form-control" name="notas['+actividad.ID+'][nota]" value="'+actividad.NOTA+'"></td>';
			    if(actividad.OBSERVACIONES)
			    	row += '<td><input type="text" class="form-control" name="notas['+actividad.ID+'][observaciones]" value="'+actividad.OBSERVACIONES+'"></td>';
			    else
			    	row += '<td><input type="text" class="form-control" name="notas['+actividad.ID+'][observaciones]" value=""></td>';
			    row += '</tr>';
			}
		});

		$('#tableNotas tbody').html(row);

      })

    };

    reader.onerror = function(ex) {
      console.log(ex);
    };

    reader.readAsBinaryString(oFile);
}
</script>

@endsection