<table id="table-list-products" class="table table-striped" width="80%">
	<thead>
		<tr>
			{{-- <th><span>&nbsp;</span></th> --}}
            <th>Cuota</th>
            <th>Fecha</th>
            <th>Valor</th>
            <th>Saldo</th>
            <th><span>&nbsp;</span></th>
        </tr> 	
	</thead>     	    	
	<tbody>
		@if(count($list) > 0)
			{{--*/ $total_saldo = 0; /*--}}
			@foreach ($list as $index => $item)
				{{--*/ $item = (object) $item; /*--}}
				{{--*/ $cuota = $item->cuota; /*--}}
				
				<tr>
					{{--
					<td align="center" width="10%;">
						@include('/util/list/remove',array('layer' => 'contract-list-quotas')) 		
					</td>
					--}}
					<td width="10%;">{{ $item->cuota }}</td>
					<td width="15%;">{{ $item->fecha }}</td>
					<td width="15%;"><?php echo number_format(round($item->valor), 2,'.',',' ) ?></td>
                    <td width="15%;"><?php echo number_format(round($item->saldo), 2,'.',',' ) ?></td>
					<td width="15%;" align="center">
            			{{ Form::text('valor_cuota_'.$item->cuota, null, array('placeholder' => 'Valor', 'class' => 'form-control')) }}        
					</td>
					<td width="15%;" align="center">
            			{{ Form::text('fecha_cuota_'.$item->cuota, null, array('id' => 'fecha_cuota_'.$item->cuota, 'placeholder' => 'Fecha', 'class' => 'form-control')) }}        
					</td>
					<script type="text/javascript">
						$(function() {
							$('#fecha_cuota_'+{{ $item->cuota }}).datepicker({
								changeMonth: true,
					          	changeYear: true,
					          	dateFormat: "yy-mm-dd"	          	
					        })
						});
					</script>
				</tr>
				{{--*/ $total_saldo += $item->saldo; /*--}}
			@endforeach
			<tr>
				<th align="center" colspan="3"><span>&nbsp;</span></th>
				<th align="center"><span>SALDO TOTAL</span></th>
				<th><span><?php echo number_format(round($total_saldo), 2,'.',',' ) ?></span></th>
			</tr> 
		@else
			<tr>
				<td align="center" colspan="5">No exiten cuotas.</td>
			</tr>	
		@endif
	</tbody>
</table> 
