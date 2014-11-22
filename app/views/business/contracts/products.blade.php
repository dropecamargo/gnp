<table id="table-list-products" class="table table-striped">
	<thead>
		<tr>
			<th><span>&nbsp;</span></th>
			<th>Producto</th>
			<th>Cantidad</th>		
		</tr>	
	</thead>     	    	
	<tbody>
		@if(count($list) > 0)
			@foreach ($list as $index => $item)
				{{--*/ $item = (object) $item; /*--}}
				<tr>
					<td align="center" width="20%;">
						@include('/util/list/remove') 		
					</td>
					<td width="60%;">{{ $item->producto_nombre }}</td>
					<td align="center" width="20%;">{{ $item->cantidad }}</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td align="center" colspan="3">No exiten productos en el carrito.</td>
			</tr>	
		@endif
	</tbody>
</table> 
