@extends ('admin/layout')

<?php
    if ($product->exists):
        $form_data = array('route' => array('business.products.update', $product->id), 'method' => 'PATCH', 'id' => 'form-add-product');
        $action    = 'Editar';
        $method = 'PATCH';
    else:
        $form_data = array('route' => 'business.products.store', 'method' => 'POST', 'id' => 'form-add-product');
        $action    = 'Crear';
        $method = 'POST';
    endif;
?>


@section ('title') {{ $action }} producto @stop

@section ('content')
	
	<h1 class="page-header">{{ $action }} producto</h1>

	<div class="row">
	    <div class="form-group col-md-4">
	        <a href="{{ route('business.products.index') }}" class="btn btn-info">Lista de productos</a>
	    </div>
  	</div>  

  	<div id="validation-errors-product" style="display: none"></div>

 	{{ Form::model($product, $form_data, array('role' => 'form')) }}
  	<div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('nombre', 'Nombre') }}
            {{ Form::text('nombre', null, array('placeholder' => 'Ingrese nombre', 'class' => 'form-control')) }}        
        </div>        
    </div>

   	{{ Form::button($action .' producto', array('type' => 'submit', 'class' => 'btn btn-success')) }}        
	
	{{ Form::close() }}

    <script type="text/javascript">
        $(function() {
            var root_url = "<?php echo Request::root(); ?>/";
            $('#form-add-product').on('submit', function(event){                             
                var url = $(this).attr('action');
               	var method = "<?php echo $method; ?>";
                event.preventDefault();                
                $.ajax({
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: $('#form-add-product').serialize(),
                    url : url,
                    beforeSend: function() { 
                        $("#validation-errors-product").hide().empty();                                     
                    },
                    success: function(data) {
                        if(data.success == false) {
                            $("#validation-errors-product").append(data.errors);
                            $("#validation-errors-product").show();
                        }else{
                            window.location="{{URL::to('business/products/"+data.product.id+"')}}";
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
        });
    </script>
@stop