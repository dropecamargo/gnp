<div align="center">
	{{ $products->links() }}
</div>
<table id="table-search-products" class="table table-striped">
	<thead>
		<tr>
			<th>Nombre</th>		
			<th>&nbsp;</th>
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($products as $product)
			<tr>
				<td>{{ $product->nombre }}</td>
				<td nowrap="nowrap">					
					<a href="{{ route('business.products.show', $product->id) }}" class="btn btn-info">Ver</a>
					<a href="{{ route('business.products.edit', $product->id) }}" class="btn btn-primary">Editar</a>
				</td>
			</tr>
		@endforeach	
	</tbody>
</table> 
<script type="text/javascript">
	$(document).ready(function(){	
		$(".pagination a").click(function()
		{
			var url = $(this).attr('href');						
			$.ajax({
				url: url,
				type: "GET",
				data: $('#form-search-produts').serialize(),
				datatype: "html",
				beforeSend: function() {
					$('#loading-app').modal('show');
				}
			})
			.done(function(data) {				
				$('#loading-app').modal('hide');
				$("#products").empty().html(data.html);
			})
			.fail(function(jqXHR, ajaxOptions, thrownError)
			{
				$('#loading-app').modal('hide');
				$('#error-app').modal('show');
				$("#error-app-label").empty().html("No hay respuesta del servidor - Consulte al administrador.");				
			});
			return false;
		});
	});
</script>