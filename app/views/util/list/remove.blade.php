{{ Form::open(array('route' => array('util.cart.destroy', $index), 'method' => 'DELETE', 'id' => 'form-cart-delete-products-contract_'.$index)) }}
	{{ Form::hidden('_key',$item->_key) }}
	{{ Form::hidden('_template',$item->_template) }}
	<button type="button" id="btn-contract-remove-product_{{ $index }}" class="btn btn-default btn-md">
		<span class="glyphicon glyphicon-minus-sign"></span>
	</button>
{{ Form::close() }}
<script type="text/javascript">
	$(function() {
		$("#btn-contract-remove-product_"+{{ $index }}).click(function() {
			$("#form-cart-delete-products-contract_"+{{ $index }}).submit();
		});	

		$('#form-cart-delete-products-contract_'+{{ $index }}).on('submit', function(event){                             
            var url = $(this).attr('action');
            event.preventDefault();
			utilList.remove(url,$('#form-cart-delete-products-contract_'+{{ $index }}).serialize(), '{{ $layer }}')
		});
	});
</script>