<?php

class Business_ReportsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('business/reports/index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function carteraEdades()
	{	
		$edades_cartera = 'T';
		if(Input::has('edades') && Input::get('edades') != 'T') {
			$edades_cartera = Input::get('edades');	
		}	
	
		DB::beginTransaction();	
        try{
			
			$query_cartera = "SELECT ct.numero as contrato, c.cuota, c.saldo as saldo, 
				cl.id as cliente, DATEDIFF( (DATE_FORMAT(c.fecha, '%Y-%m-%d' ) ) , (current_date) ) AS dias
				FROM cuotas AS c
				INNER JOIN contratos AS ct ON c.contrato = ct.id
				INNER JOIN clientes AS cl ON ct.cliente = cl.id
				WHERE 
				c.saldo != 0
				ORDER BY c.fecha ASC";
			
			$carteras = DB::select($query_cartera);
			foreach ($carteras as $cartera) {
				$cartera = (array) $cartera;
				$report = new Report();
				$report->cin1 = $cartera['cliente'];
				if($cartera['dias'] >= 0) 
					$report->cf1 = $cartera['saldo'];
				else
					$report->cf1 = 0;
				if($cartera['dias'] <0 && $cartera['dias'] >=-30)
					$report->cf2 = $cartera['saldo'];	
				else	
					$report->cf2 = 0;
				if($cartera['dias'] <=-31 && $cartera['dias'] >=-60)
					$report->cf3 = $cartera['saldo'];	
				else
					$report->cf3 = 0;			
				if($cartera['dias'] <=-61 && $cartera['dias'] >=-90)
					$report->cf4 = $cartera['saldo'];	
				else
					$report->cf4 = 0;		
				if($cartera['dias'] <=-91 && $cartera['dias'] >=-180)
					$report->cf5 = $cartera['saldo'];
				else
					$report->cf5 = 0;		
				if($cartera['dias'] <=-181 && $cartera['dias'] >=-360)
					$report->cf6 = $cartera['saldo'];	
				else
					$report->cf6 = 0;			
				if($cartera['dias'] <-360)
					$report->cf7 = $cartera['saldo'];	
				else
					$report->cf7 = 0;	
				$report->cf8 = $cartera['saldo'];
				$report->save();
			}
		}catch(\Exception $exception){
		    DB::rollback();
			return "$exception - Consulte al administrador.";
		}

		$query_reporte = "SELECT cin1 as cliente, cl.nombre as cliente_nombre,
			sum(ar.cf1) as pv, sum(ar.cf2) as m3, sum(ar.cf3) as m6, 
			sum(ar.cf4) as m9, sum(ar.cf5) as m18, sum(ar.cf6) as m36, 
			sum(ar.cf7) as m_36, sum(ar.cf8) as total
			FROM auxiliarreporte AS ar
			INNER JOIN clientes AS cl ON cin1 = cl.id 
			GROUP BY cliente
			ORDER BY cl.nombre ASC";
		$reporte = DB::select($query_reporte);
		DB::rollback();
		$output = '
		<table>
			<tfoot>
	            <tr>
					<td colspan="10">GNP :: Software Cartera vencida por edades a '.date("Y-m-d H:i:s").'</td>
	            </tr>
			</tfoot>
			<thead>
			    <tr>
			        <th>Cliente</th>
			        <th>Nombre</th>
			        <th>Por vencer</th>';
			        if($edades_cartera == 'T' || $edades_cartera == '30'){
			        	$output.= '<th>D 1 A 30</th>';
			        }
			        if($edades_cartera == 'T' || $edades_cartera == '60'){
			        	$output.= '<th>D 31 A 60</th>';
			        }
			        if($edades_cartera == 'T' || $edades_cartera == '90'){
			        	$output.= '<th>D 61 A 90</th>';
			        }
			        if($edades_cartera == 'T' || $edades_cartera == '180'){
			        	$output.= '<th>D 91 A 180</th>';
			        }
			        if($edades_cartera == 'T' || $edades_cartera == '360'){
			        	$output.= '<th>D 181 A 360</th>';
			        }
			        if($edades_cartera == 'T' || $edades_cartera == '370'){
			        	$output.= '<th>MAS DE 360</th>';
			        }
			        if($edades_cartera == 'T'){
			        	$output.= '<th>TOTAL</th>';
			        }
			        			                                                               
		$output.= '</tr>
			</thead>
			<tbody>';
		foreach ($reporte as $cartera) {
			$cartera = (array) $cartera;
			$output.='
		    <tr>
		        <td>'.$cartera['cliente'].'</td>
		        <td>'.utf8_decode($cartera['cliente_nombre']).'</td>
		        <td>'.$cartera['pv'].'</td>';
		        if($edades_cartera == 'T' || $edades_cartera == '30'){
		        	$output.= '<td>'.$cartera['m3'].'</td>';
		        }
		        if($edades_cartera == 'T' || $edades_cartera == '60'){
		        	$output.= '<td>'.$cartera['m6'].'</td>';
		        }
		        if($edades_cartera == 'T' || $edades_cartera == '90'){
		        	$output.= '<td>'.$cartera['m9'].'</td>';
		        }
		        if($edades_cartera == 'T' || $edades_cartera == '180'){
		        	$output.= '<td>'.$cartera['m18'].'</td>';
		        }
		        if($edades_cartera == 'T' || $edades_cartera == '360'){
		        	$output.= '<td>'.$cartera['m36'].'</td>';
		        }
		        if($edades_cartera == 'T' || $edades_cartera == '370'){
		        	$output.= '<td>'.$cartera['m_36'].'</td>';
		        }
		        if($edades_cartera == 'T'){
		        	$output.= '<td>'.$cartera['total'].'</td>';
		        }
			$output.= '</tr>';
		}
	
		$output.='
			</tbody>
		</table>';
	    $headers = array(
	        'Pragma' => 'public',
	        'Expires' => 'public',
	        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
	        'Cache-Control' => 'private',
	        'Content-Type' => 'application/vnd.ms-excel',
	        'Content-Disposition' => 'attachment; filename=gnp_cartera_edades_'.date('Y-m-d').'.xls',
	        'Content-Transfer-Encoding' => ' binary'
	    );
		return Response::make($output, 200, $headers);
	}

	public function estadoCuenta()
	{
		return 'Generando reporte estadoCuenta';
	}

	public function recibosCaja()
	{
		$payment = new Payment();
		$query_recibos = "SELECT rb.*, ct.numero as contrato_numero, 
			cl.cedula as cliente_cedula, cl.nombre as cliente_nombre, 
			em.cedula as cobrador_cedula , em.nombre as cobrador_nombre
		FROM recibos as rb
		INNER JOIN contratos AS ct ON rb.contrato = ct.id
		INNER JOIN clientes AS cl ON ct.cliente = cl.id
		INNER JOIN empleados AS em ON rb.cobrador = em.id";

		$tipo = '';
		if(Input::has('tipo') && Input::get('tipo') != '0') {
			$query_recibos.= " WHERE rb.tipo = '".Input::get('tipo')."'";
			$tipo = ' Tipo '.utf8_decode($payment->types[Input::get('tipo')]);
		}

		$query_recibos.= " ORDER BY rb.fecha DESC";
		$recibos = DB::select($query_recibos);

		$output = '
		<table>
			<tfoot>
	            <tr>
					<td colspan="8">GNP :: Software Recibos de caja a '.date("Y-m-d H:i:s").' '.$tipo.'</td>
	            </tr>
			</tfoot>
			<thead>
			    <tr>
			        <th>Recibo</th>
			        <th>Fecha</th>
			        <th>Cobrador</th>
			        <th>Contrato</th>
			        <th>Cliente</th>
			        <th>Nombre Cliente</th>
			    	<th>Tipo</th>
			    	<th>Valor</th>
			    </tr>
			</thead>
			<tbody>';
		foreach ($recibos as $recibo) {
			$recibo = (array) $recibo;
			$output.='
		    <tr>
		        <td>'.$recibo['numero'].'</td>
		        <td>'.$recibo['fecha'].'</td>
		        <td>'.utf8_decode($recibo['cobrador_nombre']).'</td>
		        <td>'.$recibo['contrato_numero'].'</td>
		        <td>'.$recibo['cliente_cedula'].'</td>
		        <td>'.utf8_decode($recibo['cliente_nombre']).'</td>
		        <td>'.utf8_decode($payment->types[$recibo['tipo']]).'</td>
		        <td>'.$recibo['valor'].'</td>'
		    .'</tr>';
		}

		$output.='
			</tbody>
		</table>';
	    $headers = array(
	        'Pragma' => 'public',
	        'Expires' => 'public',
	        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
	        'Cache-Control' => 'private',
	        'Content-Type' => 'application/vnd.ms-excel',
	        'Content-Disposition' => 'attachment; filename=gnp_recibos_caja_'.date('Y-m-d').'.xls',
	        'Content-Transfer-Encoding' => ' binary'
	    );
		return Response::make($output, 200, $headers);
	}

	public function ventasPeriodo()
	{
		return 'Generando reporte ventasPeriodo';
	}
}
