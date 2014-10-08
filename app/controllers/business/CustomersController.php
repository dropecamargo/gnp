<?php

class Business_CustomersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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

	public function find()
    {
        $cedula = Input::get('cedula');
		$customer = Customer::where('cedula','=', $cedula)->get();
		if(count($customer)>=1){			
			return Response::json(array('success' => true, 'customer' => $customer[0]));
		}
		return Response::json(array('success' => false));        
    }
}
