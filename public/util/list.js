var utilList = { 
	store : function(data){
		console.log('desde list')		
		console.log(data);	

		$.ajax({
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: data,
            url : 'http://localhost/gnp/public/util/cart',
            beforeSend: function() { 
            	$("#contract-list-products").hide().empty(); 
                $('#loading-app').modal('show')                                   
            },
            success: function(data) {
            	$('#loading-app').modal('hide')
                if(data.success == true) {
                    $("#contract-list-products").append(data.list);
                    $("#contract-list-products").show();
                }else{
                	$('#error-app').modal('show');                      
                	$("#error-app-label").empty().html("Ocurrio un error agregando item - Consulte al administrador.");               
                }
            },
            error: function(xhr, textStatus, thrownError) {
                $('#loading-app').modal('hide');
                $('#error-app').modal('show');                      
                $("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");               
            }
        });	
	}
}
