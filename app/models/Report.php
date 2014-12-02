<?php

class Report extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'auxiliarreporte';

	public $timestamps = false;

	public static function getContratosEstadoCuenta($cliente_codigo) {
		$query_contratos = " SELECT ct.*, em.nombre as vendedor_nombre,
			(
				SELECT SUM(cu.saldo) FROM cuotas as cu
				WHERE cu.contrato = ct.id
			) as saldo
			FROM contratos AS ct
			INNER JOIN empleados AS em ON ct.vendedor = em.id 
			WHERE ct.cliente = $cliente_codigo ";
		$query_contratos.= " ORDER BY ct.fecha DESC";
		$contratos = DB::select($query_contratos);
		return $contratos;
	}

	public static function getRecibosEstadoCuenta($contrato_codigo) {
		$query_recibos = " SELECT rb.*, em.nombre as cobrador_nombre
			FROM recibos AS rb
			INNER JOIN empleados AS em ON rb.cobrador = em.id 
			WHERE rb.contrato = ".$contrato_codigo;
		$query_recibos.= " ORDER BY rb.tipo DESC";
		$recibos = DB::select($query_recibos);
		return $recibos;
	}
	
	public static function getEstadoCuenta($cliente_codigo) {
		$customer = Customer::find($cliente_codigo);		
        if (is_null($customer)) {
            App::abort(404);   
        }

		$payment = new Payment();
		$contratos = Report::getContratosEstadoCuenta($cliente_codigo);

		$output = '
			<table class="table table-striped">
				<thead>
		            <tr>
						<td>GNP :: Software Estado de cuenta a '.date("Y-m-d").' Cliente '.utf8_decode($customer->nombre).'</td>
		            </tr>
				</thead>
			</table>';
		foreach ($contratos as $contrato) {
			$output .= '
			<table class="table table-bordered">
				<tbody>';
			$contrato = (array) $contrato;
			$output.='
				<tr>
			        <th>Contrato</th>
			        <th>Fecha</th>
			        <th>Vendedor</th>
			        <th>Valor</th>
			        <th>Saldo</th>
			    </tr>
			    <tr>
			        <td>'.$contrato['numero'].'</td>
			        <td>'.$contrato['fecha'].'</td>
			        <td>'.utf8_decode($contrato['vendedor_nombre']).'</td>
			        <td align="right">'.number_format(round($contrato['valor']), 2,'.',',').'</td>
			        <td align="right">'.number_format(round($contrato['saldo']), 2,'.',',').'</td>
				</tr>';

			$recibos = Report::getRecibosEstadoCuenta($contrato['id']);
			if(count($recibos)){
				$output.='
				<tr><td colspan="5"><table class="table table-striped">
					<tr>
				        <th colspan="5">Recibos</th>
				    </tr>';
				foreach ($recibos as $recibo) {
					$recibo = (array) $recibo;
					$output.='
				    <tr>
						<td>'.$recibo['numero'].'</td>
				        <td>'.$recibo['fecha'].'</td>
				        <td>'.utf8_decode($recibo['cobrador_nombre']).'</td>
				        <td>'.$payment->types[$recibo['tipo']].'</td>
				        <td align="right">'.number_format(round($recibo['valor']), 2,'.',',').'</td>
					</tr>';
				}
				$output.='
				</table></td></tr>';
			}else{
				// contrato sin recibos
				$output.='
				<tr>
					<td colspan="5" align="center">
						Contrato no registra recibos.
					</td>
				</tr>';
			}
			$output.='
				</tbody>
			</table>';
		}
		return $output;
	}

	public static function getEstadoCuentaPDF($cliente_codigo) {
		$customer = Customer::find($cliente_codigo);		
        if (is_null($customer)) {
            App::abort(404);   
        }

		$payment = new Payment();
		$contratos = Report::getContratosEstadoCuenta($cliente_codigo);

		$output = '
			<table style="border: 1px solid black; width: 100%;">
				<thead>
		            <tr>
						<th align="center">GNP :: Software</th>
		            </tr>
		            <tr>
						<td align="center">
							Estado de cuenta a '.date("Y-m-d").' '.utf8_decode($customer->nombre).'
						</td>
		            </tr>
				</thead>
			</table><br/>';
		foreach ($contratos as $contrato) {
			$output .= '
			<table style="border: 1px solid black; width: 100%;">
				<tbody>';
			$contrato = (array) $contrato;
			$output.='
				<tr>
			        <th>Contrato</th>
			        <th>Fecha</th>
			        <th>Vendedor</th>
			        <th>Valor</th>
			        <th>Saldo</th>
			    </tr>
			    <tr>
			        <td>'.$contrato['numero'].'</td>
			        <td>'.$contrato['fecha'].'</td>
			        <td>'.utf8_decode($contrato['vendedor_nombre']).'</td>
			        <td align="right">'.number_format(round($contrato['valor']), 2,'.',',').'</td>
			        <td align="right">'.number_format(round($contrato['saldo']), 2,'.',',').'</td>
				</tr>';

			$recibos = Report::getRecibosEstadoCuenta($contrato['id']);
			if(count($recibos)){
				$output.='
				<tr><td colspan="5"><table class="table table-striped" style="border: 1px solid black; width: 100%;">
					<tr>
				        <th colspan="5">Recibos</th>
				    </tr>';
				foreach ($recibos as $recibo) {
					$recibo = (array) $recibo;
					$output.='
				    <tr>
						<td>'.$recibo['numero'].'</td>
				        <td>'.$recibo['fecha'].'</td>
				        <td>'.utf8_decode($recibo['cobrador_nombre']).'</td>
				        <td>'.utf8_decode($payment->types[$recibo['tipo']]).'</td>
				        <td align="right">'.number_format(round($recibo['valor']), 2,'.',',').'</td>
					</tr>';
				}
				$output.='
				</table></td></tr>';
			}else{
				// contrato sin recibos
				$output.='
				<tr>
					<td colspan="5" align="center">
						Contrato no registra recibos.
					</td>
				</tr>';
			}
			$output.='
				</tbody>
			</table><br/>';
		}
		return $output;
	}
}