@extends('layouts.admin')
@section('title') 
Agregar Cursos - {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}}
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="box box-primary">
    {!! Form::open(['route' => array('agregar_curso',$seccion->id), 'method' => 'POST', 'id' => 'form', 'role' => 'form', 'class' => 'validate-form']) !!}				
    <div class="box-body">
		<a onclick="agregarFila();" class="btn btn-primary btn-flat btn-sm fa fa-plus"></a>
		<br/><br/>
		<div class="alert alert-danger alert-dismissable" id="errorCursos" style="display: none" >
			<span id="txtErrorCursos"></span>
        </div>
		<div class="table-responsive">
			<table class="table table-responsive" id="tableDetalleCursos">
				<thead>
					<tr>
						<th width="200px">MATERIA</th>
						<th>MAESTRO</th>
                        <th width="50px"></th>
					</tr>
				</thead>
				<tbody>							
				</tbody>
			</table>
		</div>
	</div>
	<div class="box-footer">
        <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
        <a href="{{ route('cursos',$seccion->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
	</div>
    {!! Form::close() !!}
</div>
@endsection

@section('js')
<script src="{{asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script>

	var maestros = '';
	var materias = '';
	var filasActuales = 0;

    $(function(){
    	$('.fecha').datepicker({
    		format: 'yyyy-mm-dd',
		    autoclose: true,
		    todayHighlight: true
		});

		$('#errorCursos').hide();

    	maestros += '<option value="">Seleccione</option>';
    	@foreach($maestros as $maestro)
    		maestros += '<option value="{{$maestro->id}}">{{$maestro->nombre_completo}}</option>';
    	@endforeach

    	materias += '<option value="">Seleccione</option>';
    	@foreach($materias as $materia)
    		materias += '<option value="{{$materia->id}}">{{$materia->descripcion}}</option>';
    	@endforeach

    	$('#form').on('submit', submit);

    });

    function agregarFila()
    {
    	filasActuales++;
    	var html = '<tr class="curso">';
    	html += '<td><select name=cursos['+filasActuales+'][materia] class="form-control materia" data-required="true" id="materia'+filasActuales+'">' + materias + '</select></td>';
    	html += '<td><select name=cursos['+filasActuales+'][maestro] class="form-control buscar-select" data-required="true" >' + maestros + '</select></td>';
        html += '<td><a class="btn btn-danger btn-sm btn-flat fa fa-times delete"></a></td>'
    	html += '</tr>';
    	$('#tableDetalleCursos tr:last').after(html);
    	$("select.buscar-select").select2();
        $(".delete").on('click', function(e) {
            var whichtr = $(this).closest("tr");
            whichtr.remove();      
        });
    }

    function submit()
    {
    	$('#errorCursos').hide();
    	if($('.curso').length <= 0){
    		$('#txtErrorCursos').text('Ingrese algun curso.');
    		$('#errorCursos').show();
    		return false;
    	}
    	var materias = $('.materia');
    	materias.each(function(index, materia){
    		materias.each(function(index2, materia2){
    			if($(materia).val() == $(materia2).val() && index2!=index){
    				var id = $(materia).attr('id');
    				var desc = $('#'+id+' option:selected').text();
    				$('#txtErrorCursos').text('Existen materias duplicadas. ' + desc);
    				$('#errorCursos').show();
    				return false;
    			}
    		})
    	});
    }
</script>
@endsection