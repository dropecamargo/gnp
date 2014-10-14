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

	public function carteraedades()
	{
		$query_cartera = "SELECT ct.numero as contrato, cl.cedula as cliente, 
			cl.nombre as cliente_nombre, c.cuota, c.saldo as saldo,  
			DATE_FORMAT(c.fecha, '%Y-%m-%d' ) as vencimiento, 
			DATEDIFF( (DATE_FORMAT(c.fecha, '%Y-%m-%d' ) ) , (current_date) ) AS dias
			FROM cuotas AS c
			INNER JOIN contratos AS ct ON c.contrato = ct.id
			INNER JOIN clientes AS cl ON ct.cliente = cl.id
			WHERE 
			c.saldo != 0
			AND
			c.fecha <= '".date("Y-m-d")."' ORDER BY c.fecha ASC";
		$carteras = DB::select($query_cartera);

		$output = '
		<table>
			<tfoot>
	            <tr>
					<td colspan="10">GNP :: Software Cartera vencida por edades a '.date("Y-m-d H:i:s").'</td>
	            </tr>
			</tfoot>
			<thead>
			    <tr>
			        <th>Contrato</th>
			        <th>Cliente</th>
			        <th>Nombre</th>
			        <th>Vencimiento</th>
			        <th>D 1 A 30</th>
			        <th>D 31 A 60</th>
			        <th>D 61 A 90</th>
			        <th>D 91 A 180</th>
			        <th>D 181 A 360</th>
			        <th>MAS DE 360</th>			                                                               
			    </tr>
			</thead>
			<tbody>';
		foreach ($carteras as $cartera) {
			$cartera = ( array ) $cartera;
			$output.='
		    <tr>
		        <td>'.$cartera['contrato'].'</td>
		        <td>'.$cartera['cliente'].'</td>
		        <td>'.$cartera['cliente_nombre'].'</td>
		        <td>'.$cartera['vencimiento'].'</td>';
			//if($f['dias']>=0)
			//	$q->addInsert("cdb2", $f['valor']);
			//else
			//	$q->addInsert("cdb2", 0);
			if($cartera['dias']<0 && $cartera['dias']>=-30)
				$output.='<td>'.$cartera['saldo'].'</td>';		
			else	
				$output.='<td>0</td>';	
			if($cartera['dias']<=-31 && $cartera['dias']>=-60)
				$output.='<td>'.$cartera['saldo'].'</td>';	
			else
				$output.='<td>0</td>';			
			if($cartera['dias']<=-61 && $cartera['dias']>=-90)
				$output.='<td>'.$cartera['saldo'].'</td>';	
			else
				$output.='<td>0</td>';			
			if($cartera['dias']<=-91 && $cartera['dias']>=-180)
				$output.='<td>'.$cartera['saldo'].'</td>';
			else
				$output.='<td>0</td>';		
			if($cartera['dias']<=-181 && $cartera['dias']>=-360)
				$output.='<td>'.$cartera['saldo'].'</td>';	
			else
				$output.='<td>0</td>';			
			if($cartera['dias']<-360)
				$output.='<td>'.$cartera['saldo'].'</td>';	
			else
				$output.='<td>0</td>';  
		    $output.='</tr>';
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
}
