<?php

class Business_PaymentsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['payments'] = $payments = Payment::getData();
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
 
        		// Devolucion productos
        		if($payment->tipo == 'DV'){
        			$products = ContractProduct::select('contratop.id','contratop.cantidad',DB::raw('(contratop.cantidad - contratop.devolucion) as disponible'))
						->where('contrato', '=', $payment->contrato)->get();
					foreach ($products as $product) {
						unset($unidades_devolucion);
						if($product->disponible > 0 && Input::has('devolucion_'.$product->id)) {
							$unidades_devolucion = intval(Input::get('devolucion_'.$product->id));
							if($unidades_devolucion > 0){
								if($unidades_devolucion > $product->disponible) {
									DB::rollback();
									return Response::json(array('success' => false, 'errors' =>  "Error unidades {$product->disponible} $unidades_devolucion - Consulte al administrador."));		
								}else{
									$product_contract = ContractProduct::find($product->id);
							        if (is_null($product_contract)) {
							       		DB::rollback();
										return Response::json(array('success' => false, 'errors' =>  "Error recuperando item producto contrato"));
							        }
							        $product_contract->devolucion = ($product_contract->devolucion + $unidades_devolucion); 
									$product_contract->save();

									$product_payment = new PaymentProduct();
									$product_payment->recibo = $payment->id;
						        	$product_payment->producto = $product_contract->producto;
						        	$product_payment->devolucion = $unidades_devolucion;
						        	$product_payment->save();
								}		
							}
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

      	$products = PaymentProduct::select('recibop.*','productos.*')
        	->join('productos', 'productos.id', '=', 'recibop.producto')
        	->where('recibo', '=', $payment->id)->get();
        
        return View::make('business/payments/show', array('payment' => $payment,
        	'contract' => $contract, 'customer' => $customer, 'collector' => $collector,
        	'products' => $products
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
