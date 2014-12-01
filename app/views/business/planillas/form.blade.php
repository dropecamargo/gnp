@extends ('admin/layout')

<?php
	// Data contract
    if ($planilla->exists):
        $form_data = array('route' => array('business.planilla.update', $planilla->id), 'method' => 'PATCH', 'id' => 'form-add-planilla');
        $action    = 'Editar';        
    else:
        $form_data = array('route' => 'business.planilla.store', 'method' => 'POST', 'id' => 'form-add-planilla');
        $action    = 'Crear';        
    endif;
?>

@section ('title') Crear planilla @stop

@section ('content')
	
	<h1 class="page-header">Crear planilla</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.planilla.index') }}" class="btn btn-info">Lista de planillas</a>
	    </div>
  	</div>  

  	<div id="validation-errors-planilla" style="display: none"></div>

  	<div class="row">
        <div class="form-group col-md-12" align="center">
    		{{ Form::button($action . ' planilla', array('type' => 'button','class' => 'btn btn-success', 'id' => 'btn-submit-planilla' )) }}        
	   </div>
    </div>

    {{ Form::model($planilla, $form_data, array('role' => 'form')) }}
    <div class="row">
    	<div class="form-group col-md-3">
            {{ Form::label('fecha', 'Fecha') }}
            <div class="input-append date">	
            	{{ Form::text('fecha', null, array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
        	</div>
        </div>
    	<div class="form-group col-md-5">
            {{ Form::label('cobrador', 'Cobrador') }}
            {{ Form::select('cobrador', array('0' => 'Seleccione cobrador') + $collectors ,null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('zona', 'Zona') }}
            {{ Form::text('zona', null, array('placeholder' => 'Zona', 'class' => 'form-control')) }}        
        </div>
    </div>
    {{ Form::close() }}

    {{ Form::open(array('route' => 'util.cart.store', 'method' => 'POST', 'id' => 'form-cart-contract-planilla')) }}
	<div class="row">
		{{ Form::hidden('_layer', Planilla::$key_cart_contracts) }}
		{{ Form::hidden('_key', Planilla::$key_cart_contracts) }}
		{{ Form::hidden('_template', Planilla::$template_cart_contracts) }}
		<div class="form-group col-md-2">
            {{ Form::label('contrato', 'Contrato') }}
        	{{ Form::text('contrato', null, array('placeholder' => 'Cantidad', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-1">
        	<label><span>&nbsp;</span></label>
        	<button type="submit" id="btn-contract-add-contract" class="btn btn-default btn-md">
				<span class="glyphicon glyphicon-plus-sign"></span>
			</button>
        </div>
        <div class="form-group col-md-2"></div>
    </div>
    {{ Form::close() }}
    <div id="planilla-list-contracts" style="display:none;"></div>

    <script type="text/javascript">
		$(function() {
			var root_url = "<?php echo Request::root(); ?>/";

			$("#fecha").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"              
            })
            
			$("#btn-submit-planilla").click(function() {
				$("#form-add-planilla").submit();
			});

			$('#form-add-planilla').on('submit', function(event){                             
                var url = $(this).attr('action');
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: $('#form-add-planilla').serialize(),
                    url : url,
                    beforeSend: function() { 
                        $("#validation-errors-planilla").hide().empty();                                     
                    },
                    success: function(data) {
                        if(data.success == false) {
                            $("#validation-errors-planilla").append(data.errors);
                            $("#validation-errors-planilla").show();
                        }else{
                        	window.location="{{URL::to('business/planilla/"+data.planilla.id+"')}}";
                        }
                    },
                    error: function(xhr, textStatus, thrownError) {
                        $('#modal-client').modal('hide');
                        $('#error-app').modal('show');                      
                        $("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");               
                    }
                });
                return false;
            });

			$('#form-cart-contract-planilla').on('submit', function(event){                             
	            var url = $(this).attr('action')
	            event.preventDefault();
	            if(!$("#contrato").val()){
	            	alertify.error("Por favor ingrese numero de contrato.");
	            	return
	            }
				utilList.store(url,$('#form-cart-contract-planilla').serialize(),'planilla-list-contracts')
			});
		});
	</script>
@stop