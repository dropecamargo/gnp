<?php

class Business_CustomersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['customers'] = $customers = Customer::getData();
		if(Request::ajax())
        {
            $data["links"] = $customers->links();
            $customers = View::make('business/customers/customers', $data)->render();
            return Response::json(array('html' => $customers));
        }
        return View::make('business/customers/list')->with($data);
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
		$data = Input::all();
	    $customer = new Customer;
        if ($customer->validAndSave($data)){
        	if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'customer' => $customer));
        	}
        	return Redirect::route('business.customers.index');
        }else{
        	if(Request::ajax()) {
        		$data["errors"] = $customer->errors;
            	$errors = View::make('errors', $data)->render();
        		return Response::json(array('success' => false, 'errors' => $errors));
			} 
          	return Redirect::route('business.customers.create')->withInput()->withErrors($customer->errors);
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
		$customer = Customer::find($id);		
        if (is_null($customer)) {
            App::abort(404);   
        } 
   		return View::make('business/customers/show', array('customer' => $customer));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$customer = Customer::find($id);
        if (is_null ($customer)) {
            App::abort(404);
        }
        return View::make('business/customers/form')->with('customer', $customer);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$customer = Customer::find($id);
        if (is_null ($customer)) {
        	if(Request::ajax()) {
            	return Response::json(array('success' => false, 'errors' => 'Error recuperando cliente - Consulte al administrador'));	
            }
            App::abort(404);
        }        
        $data = Input::all();
        if ($customer->validAndSave($data)){
        	if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'customer' => $customer));
        	}
        	return Redirect::route('business.customers.show');
        }else{
        	if(Request::ajax()) {
        		$data["errors"] = $customer->errors;
            	$errors = View::make('errors', $data)->render();
        		return Response::json(array('success' => false, 'errors' => $errors));
			} 
          	return Redirect::route('business.customers.edit')->withInput()->withErrors($customer->errors);
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

	public function find()
    {
        $cedula = Input::get('cedula');
		$customer = Customer::where('cedula','=', $cedula)->get();
		if(count($customer)>=1){			
			$view_customer = View::make('business/customers/template', array('customer' => $customer[0]))->render();		
			return Response::json(array('success' => true, 'customer' => $customer[0], 'customer_form' => $view_customer));
		}
		$customer = new Customer;
		$view_customer = View::make('business/customers/template', array('customer' => $customer))->render();
		return Response::json(array('success' => false, 'customer_form' => $view_customer));        
    }
}
