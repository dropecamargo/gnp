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
        return View::make('business/planillas/form')->with(array('planilla' => $planilla, 'collectors' => $collectors));		
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
			        	$planilla_contract = new PlanillaContrato();
			        	$planilla_contract->planilla = $planilla->id;
			        	$planilla_contract->contrato = $contract->contrato;
			        	$planilla_contract->save();
			        }	
		        } 
        	}catch(\Exception $exception){
			    DB::rollback();
				return Response::json(array('success' => false, 'errors' =>  "$exception - Consulte al administrador."));
			}
			DB::rollback();
			return Response::json(array('success' => false, 'errors' => '@dropecamargo'));

			//DB::commit();
        	if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'contract' => $contract));
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


}
