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
			</div>
		</div>
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
      	alert(sheetName);
        // Here is your object
        var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
        var json = JSON.stringify(XL_row_object);
        console.log(json);
        row = '';
        $.each(JSON.parse(json),function(key, actividad) 
		{
			
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