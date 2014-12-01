<table id="table-list-products" class="table table-striped">
	<thead>
		<tr>
			<th><span>&nbsp;</span></th>
			<th>Contrato</th>		
		</tr>	
	</thead>     	    	
	<tbody>
		@if(count($list) > 0)
			@foreach ($list as $index => $item)
				{{--*/ $item = (object) $item; /*--}}
				<tr>
					<td align="center" width="20%;">
						@include('/util/list/remove',array('layer' => 'planilla-list-contracts')) 		
					</td>
					<td width="60%;">{{ $item->contrato }}</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td align="center" colspan="3">No exiten contratos en el carrito.</td>
			</tr>	
		@endif
	</tbody>
</table> 
