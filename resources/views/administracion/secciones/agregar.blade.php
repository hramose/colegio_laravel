@extends('layouts.admin')
@section('title') Agregar Secciones @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" />
@stop
@section('content')
<div class="box box-primary">
    {!! Form::open(['route' => array('agregar_seccion'), 'method' => 'POST', 'id' => 'form', 'role' => 'form', 'class' => 'validate-form']) !!}				
    <div class="box-body">
		<a onclick="agregarFila();" class="btn btn-primary btn-flat btn-sm fa fa-plus"></a>
		<br/><br/>
		<div class="alert alert-danger alert-dismissable" id="errorSecciones" style="display: none" >
			<span id="txtErrorSecciones"></span>
        </div>
		<div class="table-responsive">
			<table class="table table-responsive" id="tableDetalleSeccion">
				<thead>
					<tr>
						<th width="200px">GRADO</th>
						<th width="200px">SECCION</th>
						<th>MAESTRO</th>
					</tr>
				</thead>
				<tbody>							
				</tbody>
			</table>
		</div>
	</div>
	<div class="box-footer">
        <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
        <a href="{{ route('secciones') }}" class="btn btn-danger btn-flat">Cancelar</a>
	</div>
    {!! Form::close() !!}
</div>
@stop

@section('js')
<script src="{{asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script>

	var maestros = '';
	var secciones = '';
	var grados = '';
	var filasActuales = 0;

    $(function(){
    	$('.fecha').datepicker({
    		format: 'yyyy-mm-dd',
		    autoclose: true,
		    todayHighlight: true
		});

		$('#errorSecciones').hide();

    	maestros += '<option value="">Seleccione</option>';
    	@foreach($maestros as $maestro)
    		maestros += '<option value="{{$maestro->id}}">{{$maestro->nombre_completo}}</option>';
    	@endforeach

    	secciones += '<option value="">Seleccione</option>';
    	@foreach($secciones  as $key => $seccion)
    		secciones += '<option value="{{$key}}">{{$seccion}}</option>';
    	@endforeach

    	grados += '<option value="">Seleccione</option>';
    	@foreach($grados as $grado)
    		grados += '<option value="{{$grado->id}}">{{$grado->descripcion}}</option>';
    	@endforeach

    	$('#form').on('submit', submit);

    });

    function agregarFila()
    {
    	filasActuales++;
    	var html = '<tr class="seccion">';
    	html += '<td><select name=secciones['+filasActuales+'][grado] class="form-control" data-required="true" >' + grados + '</select></td>';
    	html += '<td><select name=secciones['+filasActuales+'][seccion] class="form-control" data-required="true" >' + secciones + '</select></td>';
    	html += '<td><select name=secciones['+filasActuales+'][maestro] class="form-control buscar-select" data-required="true" >' + maestros + '</select></td>';
    	html += '</tr>';
    	$('#tableDetalleSeccion tr:last').after(html);
    	$("select.buscar-select").select2();
    }

    function submit()
    {
    	$('#errorSecciones').hide();
    	if($('.seccion').length <= 0){
    		$('#txtErrorSecciones').text('Ingrese alguna sección.');
    		$('#errorSecciones').show();
    		return false;
    	}
    }
</script>
@stop