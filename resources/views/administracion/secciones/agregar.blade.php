@extends('layouts.admin')
@section('title') Agregar Secciones @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="box box-primary">
    {!! Form::open(['route' => array('agregar_seccion'), 'method' => 'POST', 'id' => 'form', 'role' => 'form', 'class' => 'validate-form']) !!}				
    <div class="box-body">
		<a onclick="agregarFila();" class="btn btn-primary btn-flat btn-sm fa fa-plus"></a>
		<br/><br/>
		<div class="alert alert-danger alert-dismissable" id="errorSecciones" style="display: none" >
			<div id="errores"></div>
        </div>
		<div class="table-responsive">
			<table class="table table-responsive" id="tableDetalleSeccion">
				<thead>
					<tr>
						<th width="200px">GRADO</th>
						<th width="200px">SECCION</th>
						<th width="300px">MAESTRO</th>
                        <th>PLANTILLA</th>
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
@endsection

@section('js')
<script src="{{asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script>

	var maestros = '';
	var secciones = '';
	var grados = '';
    var plantillas = '';
	var filasActuales = 0;

    $(function(){
    	$('.fecha').datepicker({
    		format: 'yyyy-mm-dd',
		    autoclose: true,
		    todayHighlight: true
		});

		$('#errorSecciones').hide();
        $('select').removeClass('has-error');

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

        plantillas += '<option value="">Seleccione</option>';
        @foreach($plantillas  as $key => $plantilla)
            plantillas += '<option value="{{$key}}">{{$plantilla}}</option>';
        @endforeach

    	$('#form').on('submit', submit);

    });

    function agregarFila()
    {
    	filasActuales++;
    	var html = '<tr class="seccion" id="'+filasActuales+'">';
    	html += '<td><select name=secciones['+filasActuales+'][grado] class="form-control" data-required="true" id="grado'+filasActuales+'">' + grados + '</select></td>';
    	html += '<td><select name=secciones['+filasActuales+'][seccion] class="form-control" data-required="true" id="seccion'+filasActuales+'">' + secciones + '</select></td>';
    	html += '<td><select name=secciones['+filasActuales+'][maestro] class="form-control buscar-select" data-required="true" >' + maestros + '</select></td>';
        html += '<td><select name=secciones['+filasActuales+'][plantilla] class="form-control buscar-select" data-required="false" >' + plantillas + '</select></td>';
    	html += '</tr>';
    	$('#tableDetalleSeccion tr:last').after(html);
    	$("select.buscar-select").select2();
    }

    function submit()
    {
        existenErrores = false;
        errores = [];
    	$('#errorSecciones').hide();
    	if($('.seccion').length <= 0){
            existenErrores = true;
    		//$('#txtErrorSecciones').text('Ingrese alguna sección.');
            errores.push('Ingrese alguna sección');
    		
    	}

        /*validando secciones iguales*/
        filas = $('.seccion');
        $.each(filas, function(index, value){
            $.each(filas, function(index2, value2){
                if(index != index2){
                    id1 = $(value).attr('id');
                    id2 = $(value2).attr('id');

                    grado1Id = $('#grado'+id1).val();
                    seccion1Id = $('#seccion'+id1).val();
                    grado2Id = $('#grado'+id2).val();
                    seccion2Id = $('#seccion'+id2).val();

                    if(grado1Id == grado2Id && seccion1Id == seccion2Id){
                        existenErrores = true;
                        grado = $('#grado'+id1+' option:selected' ).text();
                        seccion = $('#seccion'+id1+' option:selected' ).text();

                        textoError = 'Ingreso de sección duplicada: ' + grado + ' ' + seccion;

                        existeTextoError = false;
                        $.each(errores, function(index,error){
                            if(error == textoError){
                                existeTextoError = true;
                            }
                        });
                        if(!existeTextoError)
                            errores.push(textoError);

                        $('#grado'+id1).addClass('has-error');
                        $('#seccion'+id1).addClass('has-error');
                        $('#grado'+id2).addClass('has-error');
                        $('#seccion'+id2).addClass('has-error');


                    }
                }
            });    
        });


        if(existenErrores){
            lista = '<ul style="margin:0;">';
            $.each(errores, function(index, value){
                lista += '<li>' + value + '</li>';
            });
            lista += '</ul>';
            $('#errores').html(lista);
            $('#errorSecciones').show();
            return false;
        }
    }
</script>
@endsection