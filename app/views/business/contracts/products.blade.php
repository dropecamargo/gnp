<table id="table-list-products" class="table table-striped">
	<thead>
		<tr>
			<th><span>&nbsp;</span></th>
			<th>Producto</th>
			<th>Cantidad</th>		
		</tr>	
	</thead>     	    	
	<tbody>
		@foreach ($list as $item)
			{{--*/ $item = (object) $item; /*--}}
			<tr>
				<td align="center" width="20%;">
				  	{{ Form::open(array('route' => array('util.cart.destroy', $item->producto), 'method' => 'DELETE')) }}
						<button type="submit" id="btn-contract-add-product" class="btn btn-default btn-md">
							<span class="glyphicon glyphicon-minus-sign"></span>
						</button>
					{{ Form::close() }}	
				</td>
				<td width="60%;">{{ $item->producto }}</td>
				<td align="center" width="20%;">{{ $item->cantidad }}</td>
			</tr>
		@endforeach
	</tbody>
</table> 