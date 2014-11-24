@extends ('admin/layout')

@section ('title') Crear recibo @stop

@section ('content')
	
	<h1 class="page-header">Crear recibo</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.payments.index') }}" class="btn btn-info">Lista de recibos</a>
	    </div>
  	</div>  

  	<div id="validation-errors-payment" style="display: none"></div>

  	{{ Form::model($payment, array('route' => 'business.payments.store', 'method' => 'POST', 'id' => 'form-add-payment'), array('role' => 'form')) }}
    
	<div class="row">
        <div class="form-group col-md-3">
            {{ Form::label('numero', 'Número') }}
            {{ Form::text('numero', null, array('placeholder' => 'Número recibo', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('fecha', 'Fecha') }}
            <div class="input-append date">	
            	{{ Form::text('fecha', null, array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
        	</div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
        	{{ Form::label('contrato_numero', 'Contrato') }}
            {{ Form::text('contrato_numero', null, array('placeholder' => 'Ingrese contrato', 'class' => 'form-control')) }}        
        	{{ Form::hidden('contrato', null, array('id' => 'contrato')) }}
        </div>
        <div class="form-group col-md-6">        	
            {{ Form::label('cliente_nombre', 'Cliente') }}
            {{ Form::text('cliente_nombre', null, array('class' => 'form-control', 'disabled' => 'disabled')) }}        
        </div>
        <div class="form-group col-md-2">
            {{ Form::label('contrato_saldo', 'Saldo') }}
            {{ Form::text('contrato_saldo', null, array('class' => 'form-control','disabled' => 'disabled')) }}        
        </div>        
    </div>
    <div class="row">
    	<div class="form-group col-md-6">
            {{ Form::label('cobrador', 'Cobrador') }}
            {{ Form::select('cobrador', array('0' => 'Seleccione cobrador') + $collectors ,null, array('class' => 'form-control')) }}
        </div>
    </div>
	<div class="row">
        <div class="form-group col-md-3">
            {{ Form::label('tipo', 'Tipo') }}
           	{{ Form::select('tipo', $payment->types ,null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('valor', 'Valor') }}
            {{ Form::text('valor', null, array('placeholder' => 'Valor', 'class' => 'form-control')) }}        
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('proxima', 'Proximo pago') }}
            <div class="input-append date"> 
                {{ Form::text('proxima', null, array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control')) }}        
            </div>
        </div>        
	</div>
    {{ Form::button('Crear recibo', array('type' => 'submit', 'class' => 'btn btn-success')) }}        
    
    <div class="row">
        <div id="return-products-payment"></div>
   	</div>

	{{ Form::close() }}

    <script type="text/javascript">
        $(function() {
            var root_url = "<?php echo Request::root(); ?>/";

            $("#fecha").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"              
            })

            $("#proxima").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"              
            })

            $("#valor").change(function() {
                var inputValor = $("#valor").val()
                var inputSaldo = $("#contrato_saldo").val()

                var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
                if(!numericReg.test(inputValor) || $("#contrato_numero").val() == '') {
                    $("#valor").val('')
                }else{
                    if(parseFloat(inputValor) > parseFloat(inputSaldo)){
                        $("#valor").val('')
                        $('#error-app').modal('show');
                        $("#error-app-label").empty().html("El valor del recibo no puede ser mayor al saldo del contrato.");               
                    }
                }
            })

            $("#tipo").change(function() {
                if($('#tipo').val() == 'DV'){
                    $("#return-products-payment").show() 
                }else{
                    $("#return-products-payment").hide()    
                }
            })
              
            $("#contrato_numero").change(function() {
                var inputVal = $("#contrato_numero").val();
                var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
                
                $("#valor").val('')
                $('#contrato').val('')
                $('#cliente_nombre').val('')
                $('#contrato_saldo').val('')

                if(!numericReg.test(inputVal)) {
                    $("#contrato_numero").val('')
                }else{
                    var url = root_url + 'business/contracts/find';                    
                    $.ajax({
                        type: 'post',
                        cache: false,
                        dataType: 'json',
                        data: { contrato : inputVal },
                        url : url,
                        beforeSend: function() {
                            $('#loading-app').modal('show');
                            $("#return-products-payment").hide().empty();
                        },
                        success: function(data) {
                            console.log(data)
                            $('#loading-app').modal('hide')
                            if(data.success == true) {                                                   
                                $('#contrato').val(data.contract.id)
                                $('#cliente_nombre').val(data.contract.cliente_nombre)
                                $('#contrato_saldo').val(data.contract.contrato_saldo) 

                                // Productos devolucion 
                                $("#return-products-payment").append(data.products);                                    
                                if($('#tipo').val() == 'DV'){
                                    $("#return-products-payment").show(); 
                                }
                            }else{
                                $("#contrato_numero").val('')
                            }                            
                        },
                        error: function(xhr, textStatus, thrownError) {
                            $('#loading-app').modal('hide');
                            $('#error-app').modal('show');
                            $("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");               
                        }
                    });
                }
            });

            $('#form-add-payment').on('submit', function(event){                             
                var url = $(this).attr('action');

                if(!$.isNumeric($("#contrato_saldo").val())){
                    alertify.error("Por favor ingrese contrato.");
                    return false
                }
                if(!$.isNumeric($("#valor").val())){
                    alertify.error("Por favor valor recibo.");
                    return false
                }
                var saldo_contrato = $('#contrato_saldo').val() - $('#valor').val();
                event.preventDefault();  
                bootbox.confirm('Nuevo saldo para el contrato: <h3><span class="label label-danger">'+saldo_contrato+'</span></h3>¿Desea continuar?', function(result) {
                    if(result === true){
                        $.ajax({
                            type: 'POST',
                            cache: false,
                            dataType: 'json',
                            data: $('#form-add-payment').serialize(),
                            url : url,
                            beforeSend: function() { 
                                $("#validation-errors-payment").hide().empty();                                     
                            },
                            success: function(data) {
                                if(data.success == false) {
                                    $("#validation-errors-payment").append(data.errors);
                                    $("#validation-errors-payment").show();
                                }else{
                                    window.location="{{URL::to('business/payments/"+data.payment.id+"')}}";
                                }
                            },
                            error: function(xhr, textStatus, thrownError) {
                                $('#modal-client').modal('hide');
                                $('#error-app').modal('show');                      
                                $("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");               
                            }
                        });
                    }
                }); 
                return false;
            });
        });
    </script>
@stop