@extends('layouts.admin')
@section('title') Cargar Estudiantes @endsection
@section('css')
<style>
	label { display: none }
	li {display:inline !important;}
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
	{!! Form::open(['route' => 'cargar_estudiantes', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
		<div class="box box-primary">
			<div class="box-body">
				<input type="file" name="xlfile" id="xlf" />
				<hr>
				<div class="row">
					<div class="col-lg-3">
						<a href="{{asset('assets/formatos/carga_estudiantes.xlsx')}}" class="btn btn-primary btn-flat">Descargar Formato</a>
					</div>
					<div class="col-lg-3">
						Parentescos: <br/>
						<ul>
							<li>M => Madre</li>
							<li>P => Padre</li>
							<li>TM => Tio</li>
							<li>TF => Tia</li>
							<li>AM => Abuelo</li>
							<li>AF => Abuela</li>
							<li>E => Encargado</li>
						</ul>
					</div>
					<div class="col-lg-3">
						Generos: <br/>
						<ul>
							<li>M => Masculino</li>
							<li>F => Femenino</li>
						</ul>
					</div>
				</div>
				<hr>
				<div class="table-responsive">
					<table class="table table-responsive" id="tableNotas">
						<thead>
							<tr>
								<th>NO.</th>
								<th>PRIMER NOMBRE</th>
								<th>SEGUNDO NOMBRE</th>
								<th>PRIMER APELLIDO</th>
								<th>SEGUNDO APELLIDO</th>
								<th>FECHA NACIMIENTO</th>
								<th>GENERO</th>
								<th>CUI</th>
								<th>ENCARGADO</th>
								<th>PARENTESCO ENCARGADO</th>
								<th>TELEFONO ENCARGADO</th>
								<th>CELULAR ENCARGADO</th>
								<th>DIRECCION</th>
							</tr>
						</thead>
						<tbody>							
						</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer">
	       		<input type="submit" value="Cargar" class="btn btn-primary btn-flat">
	            <a href="{{ route('estudiantes') }}" class="btn btn-danger btn-flat">Cancelar</a>
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
        index = 1;
        $.each(JSON.parse(json),function(key, estudiante) 
		{
		    row += '<tr>';
		    row += '<td>'+index+'</td>';
		    row += '<td>'+getInputText(index,'PRIMER_NOMBRE',estudiante.PRIMER_NOMBRE,'text','true')+'</td>';
		    row += '<td>'+getInputText(index,'SEGUNDO_NOMBRE',estudiante.SEGUNDO_NOMBRE,'text','false')+'</td>';
		    row += '<td>'+getInputText(index,'PRIMER_APELLIDO',estudiante.PRIMER_APELLIDO,'text','true')+'</td>';
		    row += '<td>'+getInputText(index,'SEGUNDO_APELLIDO',estudiante.SEGUNDO_APELLIDO,'text','true')+'</td>';
		    row += '<td>'+getInputText(index,'FECHA_NACIMIENTO',estudiante.FECHA_NACIMIENTO,'text','true')+'</td>';
		    row += '<td>'+getInputText(index,'GENERO',estudiante.GENERO,'text','true')+'</td>';
		    row += '<td>'+getInputText(index,'CUI',estudiante.CUI,'number','false')+'</td>';
		    row += '<td>'+getInputText(index,'ENCARGADO',estudiante.ENCARGADO,'text','true')+'</td>';
		    row += '<td>'+getInputText(index,'PARENTESCO_ENCARGADO',estudiante.PARENTESCO_ENCARGADO,'text','true')+'</td>';
		    row += '<td>'+getInputText(index,'TELEFONO_ENCARGADO',estudiante.TELEFONO_ENCARGADO,'text','false')+'</td>';
		    row += '<td>'+getInputText(index,'CELULAR_ENCARGADO',estudiante.CELULAR_ENCARGADO,'text','false')+'</td>';
		    row += '<td>'+getInputText(index,'DIRECCION',estudiante.DIRECCION,'text','true')+'</td>';
		    row += '<td></td>';
		    row += '</tr>';
		    index++;
		});

		$('#tableNotas tbody').html(row);

      })

    };

    reader.onerror = function(ex) {
      console.log(ex);
    };

    reader.readAsBinaryString(oFile);
}

function getInputText(index, field, value, type, required)
{
	if(value === undefined) value = '';
	return '<input type="'+type+'" name="estudiantes['+index+']['+field+']"" class="form-control" data-required="'+required+'" value="'+value+'">';
}
</script>

@endsection