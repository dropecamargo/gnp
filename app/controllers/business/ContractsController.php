<?php

class Business_ContractsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data["contracts"] = $contracts = Contract::paginate();		
		#$data["contracts"] = DB::table('contratos')
		#					->join('clientes','clientes.id','=','contratos.cliente')
		#					->orderBy('contratos.id')
		#					->select('contratos.*',
		#						'clientes.cedula as cliente_cedula',
		#						'clientes.nombre as cliente_nombre' )
		#					->paginate(1);
		if(Request::ajax())
        {
            //Comments pagination
            $data["links"] = $contracts->links();
            $contracts = View::make('business/contracts/contracts', $data)->render();
            return Response::json(array('html' => $contracts));
        }
        return View::make('business/contracts/list')->with($data);	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$contract = new Contract;
		$customer = new Customer;
        return View::make('business/contracts/form')->with($arrayName = array('contract' => $contract, 'customer' => $customer));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$contract = new Contract;
        $data = Input::all();                
        if ($contract->validAndSave($data)){
            return Redirect::route('business.contracts.index');
        }else{
            return Redirect::route('business.contracts.create')->withInput()->withErrors($contract->errors);
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
		$contract = Contract::find($id);
        if (is_null($contract)) {
            App::abort(404);   
        } 
        return View::make('business/contracts/show', array('contract' => $contract));
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
