<?php

class Business_PlanillaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['planillas'] = $planillas = Planilla::getData();
		if(Request::ajax())
        {
            //Comments pagination
            $data["links"] = $planillas->links();
            $planillas = View::make('business/planillas/planillas', $data)->render();
            return Response::json(array('html' => $planillas));
        }
       	$collectors = Employee::whereRaw('cargo = ? and activo = true', array('C'))->lists('nombre', 'id');        
        $data["collectors"] = $collectors;
        return View::make('business/planillas/list')->with($data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$planilla = new Planilla;
		$collectors = Employee::whereRaw('cargo = ? and activo = true', array('C'))->lists('nombre', 'id');        
        // Elimino datos carrito de session
        Session::forget(Planilla::$key_cart_contracts);
        return View::make('business/planillas/form')->with(array(
        	'planilla' => $planilla, 'collectors' => $collectors, 'HtmlContracts' => ''
        ));		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
	    $planilla = new Planilla;
      	
      	if ($planilla->isValid($data)){
      		DB::beginTransaction();	
        	try{
        		$planilla->fill($data);	        			
        		$planilla->save();

        		// Ingresando contratos 
		        $contracts = Session::get(Planilla::$key_cart_contracts);
		        if(count($contracts) > 0){
			        foreach ($contracts as $contract) {
						$contract = (object) $contract;
			        	
			        	// Recupero Contrato
						$objContract = Contract::where('numero', '=', $contract->contrato)->first();
						if(!is_object($objContract)){
							DB::rollback();
							$errors = View::make('exception', array('exception' =>  "Contrato #".$contract->contrato." NO EXISTE.</br>Por favor ingrese un numero valido."))->render();
				    		return Response::json(array('success' => false, 'errors' => $errors));
						}

						// Valido Contrato Planilla
						$objPContrato = PlanillaContrato::where('planilla', '=', $planilla->id)
							->where('contrato', '=', $objContract->id)
							->first();
						if(is_object($objPContrato)){
							DB::rollback();
							$errors = View::make('exception', array('exception' =>  "Contrato #".$contract->contrato." YA EXISTE en la planilla."))->render();
				    		return Response::json(array('success' => false, 'errors' => $errors));
						}

			        	$planilla_contract = new PlanillaContrato();
			        	$planilla_contract->planilla = $planilla->id;
			        	$planilla_contract->contrato = $objContract->id;
			        	$planilla_contract->save();
			        }	
		        } 
        	}catch(\Exception $exception){
			    DB::rollback();
				return Response::json(array('success' => false, 'errors' =>  "$exception - Consulte al administrador."));
			}

			DB::commit();
        	if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'planilla' => $planilla));
        	}
        	return Redirect::route('business.planillas.index'); 
      	}else{
  			$data["errors"] = $planilla->errors;
        	$errors = View::make('errors', $data)->render();
    		return Response::json(array('success' => false, 'errors' => $errors));
      	}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$planilla = Planilla::find($id);		
        if (is_null($planilla)) {
            App::abort(404);   
        }
        $collector = Employee::find($planilla->cobrador);
        if (is_null($collector)) {
            App::abort(404);   
        }

       	$query = Contract::query();      
        $query->select('contratos.numero',DB::raw('SUM(cuotas.saldo) as saldo'));
        $query->join('planillac', 'contratos.id', '=', 'planillac.contrato');
        $query->join('cuotas', 'contratos.id', '=', 'cuotas.contrato');
        $query->where('planillac.planilla','=',$planilla->id);         
        $query->groupBy('contratos.id');         
 		$query->havingRaw('saldo > 0'); 
        $query->orderby('contratos.numero', 'ASC');
        $contracts = $query->get();

        return View::make('business/planillas/show', array('planilla' => $planilla,
			'collector' => $collector, 'contracts' => $contracts
		));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$planilla = Planilla::find($id);
        if (is_null ($planilla)) {
            App::abort(404);
        }
		$collectors = Employee::whereRaw('cargo = ? and activo = true', array('C'))->lists('nombre', 'id');        
       	
		// Elimino datos carrito de session
        Session::forget(Planilla::$key_cart_contracts);
       	// Cargo datos carrito de session
        $query = Contract::query();      
        $query->select('contratos.numero as contrato',DB::raw('SUM(cuotas.saldo) as saldo'));
        $query->join('planillac', 'contratos.id', '=', 'planillac.contrato');
        $query->join('cuotas', 'contratos.id', '=', 'cuotas.contrato');
        $query->where('planillac.planilla','=',$planilla->id);         
        $query->groupBy('contratos.id');         
 		$query->havingRaw('saldo > 0'); 
        $query->orderby('contratos.numero', 'ASC');
        $contracts = $query->get();

        foreach ($contracts as $contract) {
        	$contract->_key = Planilla::$key_cart_contracts;
        	$contract->_template = Planilla::$template_cart_contracts;
        	Session::push(Planilla::$key_cart_contracts, $contract);	
        }
		$HtmlContracts = SessionCart::show(Planilla::$key_cart_contracts,Planilla::$template_cart_contracts);

       	return View::make('business/planillas/form')->with(array(
       		'planilla' => $planilla, 'collectors' => $collectors, 'HtmlContracts' => $HtmlContracts
       	));		
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	    $planilla = Planilla::find($id);
        if (is_null ($planilla)) {
        	if(Request::ajax()) {
            	return Response::json(array('success' => false, 'errors' => 'Error recuperando planilla - Consulte al administrador'));	
            }
            App::abort(404);
        }

        $data = Input::all();
        if ($planilla->isValid($data)){
        	DB::beginTransaction();	
        	try{
	        	$planilla->fill($data);
	        	$planilla->save();
	        	// Elimino contratos planilla para reconstruir
	        	PlanillaContrato::where('planillac.planilla','=',$planilla->id)->delete();
	        	// Ingresando contratos 
		        $contracts = Session::get(Planilla::$key_cart_contracts);
		        if(count($contracts) > 0){
			        foreach ($contracts as $contract) {
						$contract = (object) $contract;
			        	
			        	// Recupero Contrato
						$objContract = Contract::where('numero', '=', $contract->contrato)->first();
						if(!is_object($objContract)){
							DB::rollback();
							$errors = View::make('exception', array('exception' =>  "Contrato #".$contract->contrato." NO EXISTE.</br>Por favor ingrese un numero valido."))->render();
				    		return Response::json(array('success' => false, 'errors' => $errors));
						}

						// Valido Contrato Planilla
						$objPContrato = PlanillaContrato::where('planilla', '=', $planilla->id)
							->where('contrato', '=', $objContract->id)
							->first();
						if(is_object($objPContrato)){
							DB::rollback();
							$errors = View::make('exception', array('exception' =>  "Contrato #".$contract->contrato." YA EXISTE en la planilla."))->render();
				    		return Response::json(array('success' => false, 'errors' => $errors));
						}

			        	$planilla_contract = new PlanillaContrato();
			        	$planilla_contract->planilla = $planilla->id;
			        	$planilla_contract->contrato = $objContract->id;
			        	$planilla_contract->save();
			        }	
		        }
	        }catch(\Exception $exception){
			    DB::rollback();
				$errors = View::make('exception', array('exception' => $exception))->render();
	    		return Response::json(array('success' => false, 'errors' => $errors));
			}
			DB::commit();
			if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'planilla' => $planilla));
        	}
        	return Redirect::route('business.products.index');
        }else{
  			$data["errors"] = $planilla->errors;
        	$errors = View::make('errors', $data)->render();
    		return Response::json(array('success' => false, 'errors' => $errors));
      	}
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

	public function planillaCobroPdf()
	{
		$planilla = Planilla::find(Input::get('planilla'));		
        if (is_null($planilla)) {
            App::abort(404);   
        }
        $collector = Employee::find($planilla->cobrador);
        if (is_null($collector)) {
            App::abort(404);   
        }

       	$query = Contract::query();      
        $query->select('contratos.numero',DB::raw('SUM(cuotas.saldo) as saldo'));
        $query->join('planillac', 'contratos.id', '=', 'planillac.contrato');
        $query->join('cuotas', 'contratos.id', '=', 'cuotas.contrato');
        $query->where('planillac.planilla','=',$planilla->id);         
        $query->groupBy('contratos.id');         
 		$query->havingRaw('saldo > 0'); 
        $query->orderby('contratos.numero', 'ASC');
        $contracts = $query->get();

        $output = '
			<table style="border-collapse: collapse; border: 1px solid black; width: 100%;">
				<thead>
		            <tr><th colspan="2" align="center" style="border: 1px solid black;">GNP :: Software</th></tr>
		            <tr><th colspan="2" align="center" style="border: 1px solid black;">PLANILLA COBRANZA</th></tr>
		            <tr>
						<td align="left" width="20%" style="border: 1px solid black;">ZONA</td>
						<td align="left" width="80%" style="border: 1px solid black;">'.$planilla->zona.'</td>
		            </tr>
		            <tr>
						<td align="left" width="20%" style="border: 1px solid black;">FECHA</td>
						<td align="left" width="80%" style="border: 1px solid black;">'.$planilla->fecha.'</td>
		            </tr>
				</thead>
			</table><br/>

			<table style="width: 100%;">
				<thead>
		            <tr>
						<th colspan="2" align="left" width="100%">'.utf8_decode($collector->nombre).'</th>
		            </tr>
				</thead>
			</table>

			<table style="border-collapse: collapse; border: 1px solid black; width: 100%;">
				<thead>
		            <tr>
						<th align="center" width="5%" style="border: 1px solid black;"></th>
						<th align="center" width="15%" style="border: 1px solid black;">NUMERO</th>
						<th align="center" width="35%" style="border: 1px solid black;">OBSERVACION</th>
						<th align="center" width="15%" style="border: 1px solid black;">SALDO</th>
						<th align="center" width="15%" style="border: 1px solid black;">R.D.P N.</th>
						<th align="center" width="15%" style="border: 1px solid black;">TOTAL</th>
		            </tr>
				</thead>
				<tbody>';
				if(count($contracts) > 0){   
					$item = 1; 	                
		            foreach ($contracts as $contract){
		                $output .='
		                <tr>
		                    <td align="right" style="border: 1px solid black;">'.$item.'</td>
		                    <td align="right" style="border: 1px solid black;">'.$contract->numero.'</td>
		                    <td style="border: 1px solid black;"></td>
		                    <td style="border: 1px solid black; text-align:right;">'.number_format(round($contract->saldo), 2,'.',',' ).'</td>
		                	<td style="border: 1px solid black;"></td>
		                	<td style="border: 1px solid black;"></td>
		                </tr>';
		                $item++;
		            }
			   	}else{   					
			   		$output .='
			   		<tr>
						<td align="center" colspan="6" width="100%">No exiten contratos para la planilla.</td>
					</tr>';	
				}
			$output .='
				</tbody>
			</table>';

		return PDF::load($output, 'A4', 'portrait')->download('gnp_planilla_cobro'.$planilla->id);
	}
}
