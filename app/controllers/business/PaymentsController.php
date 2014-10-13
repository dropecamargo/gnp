<?php

class Business_PaymentsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$query = Payment::join('contratos', 'contrato', '=', 'contratos.id')
			->join('clientes', 'contratos.cliente', '=', 'clientes.id');
		$data["payments"] = $payments = $query->paginate(6, array('recibos.*','clientes.nombre as cliente_nombre'));
		if(Request::ajax())
        {
            //Comments pagination
            $data["links"] = $payments->links();
            $payments = View::make('business/payments/payments', $data)->render();
            return Response::json(array('html' => $payments));
        }
        return View::make('business/payments/list')->with($data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$payment = new Payment;
		$collectors = Employee::whereRaw('cargo = ? and activo = true', array('C'))->lists('nombre', 'id');        
        return View::make('business/payments/form')->with($arrayName = array('payment' => $payment, 'collectors' => $collectors));		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
	    $payment = new Payment;
      	
      	if ($payment->isValid($data)){
      		DB::beginTransaction();	
        	try{
        		$payment->fill($data);	        			
        		$payment->save();

        		$quotas = Quota::where('contrato', '=', $payment->contrato)
        			->where('saldo', '>', '0')
        			->orderBy('fecha', 'ASC')
        			->get();
        		$saldo_abono = $payment->valor; 
        		foreach ($quotas as $quota) {
        			if($saldo_abono > 0){
	        			if($saldo_abono >= $quota->saldo){	        				
	        				$saldo_abono = $saldo_abono - $quota->saldo;

							$quota->saldo = 0;
							$quota->save();														 	        					        				
	        			}else{
	        				$quota->saldo = $quota->saldo - $saldo_abono;
							$quota->save();

	        				$saldo_abono = 0;
	        			}        		
	        		}	
        		}

        	}catch(\Exception $exception){
			    DB::rollback();
				return Response::json(array('success' => false, 'errors' =>  "$exception - Consulte al administrador."));
			}
			DB::commit();
			if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'payment' => $payment));
        	}
        	return Redirect::route('business.payments.index'); 
      	}else{
      		if(Request::ajax()) {
        		$data["errors"] = $payment->errors;
            	$errors = View::make('errors', $data)->render();
        		return Response::json(array('success' => false, 'errors' => $errors));
			} 
            return Redirect::route('business.payments.create')->withInput()->withErrors($payment->errors);	
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
		$payment = Payment::find($id);		
        if (is_null($payment)) {
            App::abort(404);   
        } 
        $contract = Contract::find($payment->contrato);
        if (is_null($contract)) {
            App::abort(404);   
        }
        $customer = Customer::find($contract->cliente);
        if (is_null($customer)) {
            App::abort(404);   
        }
        $collector = Employee::find($payment->cobrador);
        if (is_null($collector)) {
            App::abort(404);   
        }
        return View::make('business/payments/show', array('payment' => $payment,
        	'contract' => $contract, 'customer' => $customer, 'collector' => $collector
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
