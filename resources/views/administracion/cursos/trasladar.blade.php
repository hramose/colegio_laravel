@extends('layouts.admin')
@section('title') 
Trasladar Cursos - 
@if(!is_null($seccion) && !is_null($seccion2))
De {{$seccion2->grado->descripcion}} {{$seccion2->descripcion_seccion}}
a {{$seccion->grado->descripcion}} {{$seccion->descripcion_seccion}} 
@endif
@endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="box box-primary">
    {!! Form::open(['route' => array('trasladar_cursos',$seccionId,$seccion2Id), 'method' => 'POST', 'id' => 'form', 'role' => 'form', 'class' => 'validate-form']) !!}				
    <div class="box-body">
		<div class="alert alert-danger alert-dismissable" id="errorCursos" style="display: none" >
			<span id="txtErrorCursos"></span>
        </div>
        <div class="row">
        	<div class="col-lg-4">
        		{!! Field::select('seccion_id',$secciones,$seccion2Id,['data-required'=>'true','id'=>'seccion']) !!}
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-4">
				<div class="table-responsive">
					<table class="table table-responsive" id="tableDetalleCursos">
						<thead>
							<tr>
								<th width="200px">MATERIA</th>
								<th>MAESTRO</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@forelse($cursos as $curso)
							<tr>
								<td class="curso">
									<input type="hidden" name="cursos[{{$curso->id}}][materia]" value="{{$curso->materia_id}}">
									{{$curso->materia->descripcion}}
								</td>
								<td>
									<input type="hidden" name="cursos[{{$curso->id}}][maestro]" value="{{$curso->maestro_id}}">
									{{$curso->maestro->nombre_completo}}
								</td>
								<td>
									<a class="btn btn-danger btn-sm btn-flat fa fa-times delete"></a>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="3">
									No existen cursos que trasladar.
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="box-footer">
        <input type="submit" value="Trasladar" class="btn btn-primary btn-flat">
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

		$('#seccion').on('change',function(){
			var seccion = $(this).val();
			if(seccion=='') seccion = 0;
			window.location.href = "{{route('inicio')}}/cursos/trasladar/{{$seccionId}}/" + seccion;
		})

		$(".delete").on('click', function(e) {
		    var whichtr = $(this).closest("tr");
		    whichtr.remove();      
		});

    	$('#form').on('submit', submit);

    });

    function submit()
    {
    	$('#errorCursos').hide();
    	if($('.curso').length <= 0){
    		$('#txtErrorCursos').text('Ingrese alguna materia para la sección.');
    		$('#errorCursos').show();
    		return false;
    	}
    }
</script>
@endsection