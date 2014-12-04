<table id="table-list-products" class="table table-striped" style="width:40%" align="center">
	<thead>
		<tr>
			<th><span>&nbsp;</span></th>
			<th>Contrato</th>
			<th>Saldo</th>		
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
					<td width="50%;">{{ $item->contrato }}</td>
					<td width="30%;" style="text-align:right;"><?php echo number_format(round($item->saldo), 2,'.',',' ) ?></td>
				</tr>
			@endforeach
		@else
			<tr>
				<td align="center" colspan="3">No exiten contratos en el carrito.</td>
			</tr>	
		@endif
	</tbody>
</table> 
