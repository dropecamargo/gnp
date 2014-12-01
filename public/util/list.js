var utilList = { 
	store : function(url, data, layer){
		$.ajax({
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: data,
            url : url,
            beforeSend: function() { 
            	$('#loading-app').modal('show')                                   
            },
            success: function(data) {
                $('#loading-app').modal('hide')
                if(data.success == true) {
                    $("#"+layer).empty().append(data.list);
                    $("#"+layer).show();
                }else{
                	$('#error-app').modal('show');                      
                	$("#error-app-label").empty().html(data.error+" - Consulte al administrador.");               
                }
            },
            error: function(xhr, textStatus, thrownError) {
                $('#loading-app').modal('hide');
                $('#error-app').modal('show');                      
                $("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");               
            }
        });	
	},
    remove : function(url, data, layer){
        $.ajax({
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: data,
            url : url,
            beforeSend: function() { 
                $('#loading-app').modal('show')                                   
            },
            success: function(data) {
                $('#loading-app').modal('hide')
                if(data.success == true) {
                    $("#"+layer).empty().append(data.list);
                    $("#"+layer).show();
                }else{
                    $('#error-app').modal('show');                      
                    $("#error-app-label").empty().html(data.error+" - Consulte al administrador.");               
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
