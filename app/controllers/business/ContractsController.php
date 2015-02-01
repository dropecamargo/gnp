<?php

class Business_ContractsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$data['contracts'] = $contracts = Contract::getData();
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
        $vendors = Employee::whereRaw('cargo = ? and activo = true', array('V'))->lists('nombre', 'id');
    	$products = Product::lists('nombre', 'id');
        // Elimino datos carrito de session
        Session::forget(Contract::$key_cart_products);
        return View::make('business/contracts/form')->with(array('contract' => $contract, 'vendors' => $vendors, 'products' => $products));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::all();
	    $contract = new Contract;
      	
      	if ($contract->isValid($data)){      		        	
        	DB::beginTransaction();	
        	try{
        		$contract->fill($data);	        			
        		$contract->save();
        		
        		// Generar cuotas
        		$fecha_cuota = $contract->primera;        
		        $valor_cuota = 0;
		        $valor_cuota = $contract->valor/$contract->cuotas;

		        for($i=1; $i <= $contract->cuotas; $i++){
		            if (!$fecha_cuota){                
		                DB::rollback();
						return Response::json(array('success' => false, 'errors' => " Error recuperando fecha cuota - Consulte al administrador."));
		            }
		            DB::table('cuotas')->insert(
		                array(
		                    'contrato' => $contract->id, 
		                    'cuota' => $i,
		                    'fecha' => $fecha_cuota,
		                    'valor' => number_format(round($valor_cuota), 2, '.', ''),
		                    'saldo' => number_format(round($valor_cuota), 2, '.', '')
		                )
		            );
		            $fecha_cuota = $contract->suma_fechas($fecha_cuota, $contract->periodicidad);
		        }

		        // Ingresando productos 
		        $products = Session::get(Contract::$key_cart_products);
		        if(count($products) > 0){
			        foreach ($products as $product) {
			        	$product = (object) $product;
			        	$contract_product = new ContractProduct();
			        	$contract_product->contrato = $contract->id;
			        	$contract_product->producto = $product->producto;
			        	$contract_product->cantidad = $product->cantidad;
			        	$contract_product->devolucion = 0;
			        	$contract_product->save();
			        }	
		        } 
		    }catch(\Exception $exception){
			    DB::rollback();
				return Response::json(array('success' => false, 'errors' =>  "$exception - Consulte al administrador."));
			}
			DB::commit();
        	if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'contract' => $contract));
        	}
        	return Redirect::route('business.contracts.index');        	
      	}else{
      		if(Request::ajax()) {
        		$data["errors"] = $contract->errors;
            	$errors = View::make('errors', $data)->render();
        		return Response::json(array('success' => false, 'errors' => $errors));
			} 
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
        $customer = Customer::find($contract->cliente);
        if (is_null($customer)) {
            App::abort(404);   
        }
        $vendor = Employee::find($contract->vendedor);
        if (is_null($vendor)) {
            App::abort(404);   
        }
        $quotas = Quota::where('contrato', '=', $contract->id)->get();

        $products = ContractProduct::select('contratop.*','productos.*')
        	->join('productos', 'productos.id', '=', 'contratop.producto')
        	->where('contrato', '=', $contract->id)->get();

        return View::make('business/contracts/show', array('contract' => $contract, 
        	'customer' => $customer, 'vendor' => $vendor, 'quotas' => $quotas, 
        	'products' => $products));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$contract = Contract::find($id);		
        if (is_null($contract)) {
            App::abort(404);   
        } 
        $customer = Customer::find($contract->cliente);
        if (is_null($customer)) {
            App::abort(404);   
        }
        $vendor = Employee::find($contract->vendedor);
        if (is_null($vendor)) {
            App::abort(404);   
        }

        $vendors = Employee::whereRaw('cargo = ? and activo = true', array('V'))->lists('nombre', 'id');
    	$products = Product::lists('nombre', 'id');

        // Elimino datos carrito de session
        Session::forget(Contract::$key_cart_products);
		// Recuperar productos contrato
        $arproducts = ContractProduct::select('contratop.id','productos.nombre','contratop.cantidad')
        	->join('productos', 'productos.id', '=', 'contratop.producto')
        	->where('contratop.devolucion', '=', '0')
        	->where('contrato', '=', $contract->id)->get();
        foreach ($arproducts as $producto) {
        	$item = array();
        	$item['_key'] = Contract::$key_cart_products;
        	$item['_template'] = Contract::$template_cart_products;
			$item['producto'] = $producto->id;
        	$item['producto_nombre'] = $producto->nombre;
        	$item['cantidad'] = $producto->cantidad;
        	SessionCart::addItem($item);
        }
        $html_products = SessionCart::show(Contract::$key_cart_products, Contract::$template_cart_products);
        
      	return View::make('business/contracts/edit', array('contract' => $contract, 
        	'customer' => $customer, 'vendor' => $vendor, 'vendors' => $vendors, 'products' => $products, 
        	'html_products' => $html_products));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$contract = Contract::find($id);		
        if (is_null($contract)) {
            App::abort(404);   
        }       
        $data = Input::all();
        if ($contract->isValid($data)){      		        	
        	DB::beginTransaction();	
        	try{
        		$contract->fill($data);	        			
        		$contract->save();   

        	}catch(\Exception $exception){
			    DB::rollback();
				return Response::json(array('success' => false, 'errors' =>  "$exception - Consulte al administrador."));
			}
			DB::commit();
        	if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'contract' => $contract));
        	}
        	return Redirect::route('business.contracts.index');     	
      	}else{
      		if(Request::ajax()) {
        		$data["errors"] = $contract->errors;
            	$errors = View::make('errors', $data)->render();
        		return Response::json(array('success' => false, 'errors' => $errors));
			} 
            return Redirect::route('business.contracts.create')->withInput()->withErrors($contract->errors);	
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
		$contrato = Input::get('contrato');
		$query = "SELECT contratos.id, contratos.numero, 
			clientes.nombre as cliente_nombre, SUM(cuotas.saldo) as contrato_saldo 
			from contratos 
			inner join clientes on contratos.cliente = clientes.id 
			inner join cuotas on cuotas.contrato = contratos.id 
			where numero = $contrato 
			group by id, cliente_nombre";
    	$contract = DB::select($query);       	        				
		if(count($contract)>=1){			
			$contract[0]->contrato_saldo = round($contract[0]->contrato_saldo,-1);
			
			// Recuperar productos contrato
	        $products = ContractProduct::select('contratop.id','productos.nombre','contratop.cantidad',DB::raw('(contratop.cantidad - contratop.devolucion) as disponible'))
	        	->join('productos', 'productos.id', '=', 'contratop.producto')
	        	->where('contrato', '=', $contract[0]->id)->get();
	        $html_products = View::make('business/contracts/products_return', array('products' => $products))->render();
			//$html_products = 'ss';
			return Response::json(array('success' => true, 'contract' => $contract[0], 'products' => $html_products));
		}
		return Response::json(array('success' => false));        
	}
}