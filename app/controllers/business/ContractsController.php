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
        $vendors = Employee::where('vendedor', true)->where('activo', true)->lists('nombre', 'id');
    	$products = Product::lists('nombre', 'id');
    	$groups = Group::lists('nombre', 'id');

        // Elimino datos carrito de session
        Session::forget(Contract::$key_cart_products);
        return View::make('business/contracts/form')->with(array('contract' => $contract, 'vendors' => $vendors, 'groups' => $groups,
        	'products' => $products));
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
        $group = Group::find($contract->grupo);

        $quotas = Quota::where('contrato', '=', $contract->id)->get();

        $products = ContractProduct::select('contratop.*','productos.*')
        	->join('productos', 'productos.id', '=', 'contratop.producto')
        	->where('contrato', '=', $contract->id)->get();

        $bitacoras = Bitacora::select('bitacora.*', 'name')
        	->join('users', 'users.id', '=', 'bitacora.usuario')
        	->where('tabla', '=', 'contratos')
        	->where('llave', '=', $contract->id)->get();

        return View::make('business/contracts/show', array('contract' => $contract, 
        	'customer' => $customer, 'vendor' => $vendor, 'quotas' => $quotas, 'group' => $group,
        	'products' => $products, 'bitacoras' => $bitacoras));
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

        $vendors = Employee::where('vendedor', true)->where('activo', true)->lists('nombre', 'id');
    	$products = Product::lists('nombre', 'id');
    	$groups = Group::lists('nombre', 'id');

        // Elimino datos carrito de session
        Session::forget(Contract::$key_cart_products);
		// Recuperar productos contrato
        $arproducts = ContractProduct::select('contratop.producto','productos.nombre','contratop.cantidad')
        	->join('productos', 'productos.id', '=', 'contratop.producto')
        	->where('contratop.devolucion', '=', '0')
        	->where('contrato', '=', $contract->id)->get();
        foreach ($arproducts as $producto) {
        	$item = array();
        	$item['_key'] = Contract::$key_cart_products;
        	$item['_template'] = Contract::$template_cart_products;
			$item['producto'] = $producto->producto;
        	$item['producto_nombre'] = $producto->nombre;
        	$item['cantidad'] = $producto->cantidad;
        	SessionCart::addItem($item);
        }
        $html_products = SessionCart::show(Contract::$key_cart_products, Contract::$template_cart_products);
        
        // Elimino datos carrito de session
        Session::forget(Contract::$key_cart_quotas);
		$quotas = Quota::where('contrato', '=', $contract->id)->get();
		foreach ($quotas as $quota) {
        	$item = array();
        	$item['_key'] = Contract::$key_cart_quotas;
        	$item['_template'] = Contract::$template_cart_quotas;
			$item['cuota'] = $quota->cuota;
			$item['fecha'] = $quota->fecha;
			$item['valor'] = $quota->valor;
			$item['saldo'] = $quota->saldo;
        	SessionCart::addItem($item);
        }	
		$html_quotas = SessionCart::show(Contract::$key_cart_quotas, Contract::$template_cart_quotas);


      	return View::make('business/contracts/edit', array('contract' => $contract, 'groups' => $groups, 
        	'customer' => $customer, 'vendor' => $vendor, 'vendors' => $vendors, 'products' => $products, 
        	'html_products' => $html_products, 'html_quotas' => $html_quotas));
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
       
        DB::beginTransaction();	
    	try{
	        // Registro bitacora numero	        
	        if($data['numero'] != $contract->numero){
    	        Bitacora::launch('contratos',$contract->id, 'NUMERO', $contract->numero, $data['numero']); 
			}

			// Registro bitacora fecha	        
	        if($data['fecha'] != $contract->fecha){
	        	Bitacora::launch('contratos',$contract->id, 'FECHA', $contract->fecha, $data['fecha']);
			}

			// Registro bitacora grupo	        
	        if($data['grupo'] != $contract->grupo && $data['grupo'] != 0){	        	
	        	$grupo = '';
	        	$old_group = Group::find($contract->grupo);
	        	if (is_null($old_group) && $old_group instanceof Group) { 
                	$grupo = $old_group->nombre;  
            	}
	        	$new_group = Group::find($data['grupo']);
	        	Bitacora::launch('contratos',$contract->id, 'GRUPO', $grupo, $new_group->nombre);
			}

			// Registro bitacora cliente	        
	        if($data['cliente'] != $contract->cliente && $data['cliente'] != ''){
	        	$old_customer = Customer::find($contract->cliente);
	        	$new_customer = Customer::find($data['cliente']);
	        	Bitacora::launch('contratos',$contract->id, 'CLIENTE', $old_customer->nombre, $new_customer->nombre);
			}

			// Registro bitacora vendedor	        
	        if($data['vendedor'] != $contract->vendedor && $data['vendedor'] != 0){
    	        $old_vendor = Employee::find($contract->vendedor);
                $new_vendor = Employee::find($data['vendedor']);
	        	Bitacora::launch('contratos',$contract->id, 'VENDEDOR', $old_vendor->nombre, $new_vendor->nombre);
			}

	        if ($contract->isValid($data)){      		        	
        		// Guardar contrato
        		$contract->fill($data);	        			
        		$contract->save();   
        		
		        // Comparar base de datos vs carrito para evaluar cambios
		        $products = Session::get(Contract::$key_cart_products);    
		        foreach ($products as $product) {				        	
	 		       	$product = (object) $product;

	 		      	$contract_product = ContractProduct::where('producto', '=', $product->producto)
						->where('contrato', '=', $contract->id)
	 		      		->first();
					if($contract_product instanceof ContractProduct){
						if($product->cantidad != $contract_product->cantidad){
		        			Bitacora::launch('contratos',$contract->id, 'CANTIDAD PRODUCTO: '.$product->producto_nombre, $contract_product->cantidad, $product->cantidad);
		 	      			$contract_product->cantidad = $product->cantidad;
		 	      			$contract_product->save();
						}	
					}else{
			        	$contract_product = new ContractProduct();
			        	$contract_product->contrato = $contract->id;
			        	$contract_product->producto = $product->producto;
			        	$contract_product->cantidad = $product->cantidad;
			        	$contract_product->devolucion = 0;
			        	$contract_product->save();
						Bitacora::launch('contratos',$contract->id, 'PRODUCTO: '.$product->producto_nombre, '', 'AGREGADO');
    	    		}
				}
				// Borrar productos eliminados	        	
    	        $arproducts = ContractProduct::select('contratop.producto','productos.nombre','contratop.cantidad')
		        	->join('productos', 'productos.id', '=', 'contratop.producto')
		        	->where('contratop.devolucion', '=', '0')
		        	->where('contrato', '=', $contract->id)->get();
		        foreach ($arproducts as $producto) {
		        	$encontrado = false;
		        	foreach ($products as $product) {
		        		$product = (object) $product;
		        		if($producto->producto == $product->producto){
		        			$encontrado = true;
		        			continue;
		        		}
		        	}
		        	if($encontrado == false) {
		        		DB::table('contratop')->where('producto', '=', $producto->producto)->where('contrato', '=', $contract->id)->delete();
		        		Bitacora::launch('contratos',$contract->id, 'PRODUCTO: '.$producto->nombre, '', 'ELIMINADO');
		        	}		
		        }
		       	
		       	// Actualizar cuotas     
		       	$saldo_contrato = 0;
		       	$valor_cuotas = 0;
		       	$quotas = Session::get(Contract::$key_cart_quotas);   
		        foreach ($quotas as $quota) {				        	
	 		       	$quota = (object) $quota;
	 		   		// Actualizo cuota
	 		   		if(Input::has('valor_cuota_'.$quota->cuota)){
	 		   			$cuota = Input::get('valor_cuota_'.$quota->cuota);
	 		   			$valor_cuotas += $cuota;
		        		
		        		$validator = Validator::make(array('cuota_'.$quota->cuota => $cuota), array('cuota_'.$quota->cuota => 'required|min:1|regex:[^[0-9]*$]'));
						if (!$validator->passes()) {   		  
   			            	$msgerror = View::make('errors', array('errors' => $validator->errors()))->render();
   			            	DB::rollback();
	        				return Response::json(array('success' => false, 'errors' => $msgerror));
				        }
		        		DB::table('cuotas')->where('contrato', '=', $contract->id)
		        		 	->where('cuota', '=', $quota->cuota)->update(array('saldo' => $cuota));
		        		Bitacora::launch('contratos',$contract->id, 'SALDO CUOTA: '.$quota->cuota, $quota->saldo, $cuota);
	 		   		}else{
	 		   			$valor_cuotas += $quota->saldo;
	 		   		}
	 		   		$saldo_contrato += $quota->saldo;

	 		   		// Actualizo fecha
	 		   		if(Input::has('fecha_cuota_'.$quota->cuota)){
	 		   			$fecha = Input::get('fecha_cuota_'.$quota->cuota);
		        		$validator = Validator::make(array('fecha_cuota_'.$quota->cuota => $fecha), array('fecha_cuota_'.$quota->cuota => 'required|date_format:Y-m-d'));
						if (!$validator->passes()) {
							$msgerror = View::make('errors', array('errors' => $validator->errors()))->render();
   			            	DB::rollback();
	        				return Response::json(array('success' => false, 'errors' => $msgerror));
				        }
				        DB::table('cuotas')->where('contrato', '=', $contract->id)
		        		 	->where('cuota', '=', $quota->cuota)->update(array('fecha' => $fecha));
		        		Bitacora::launch('contratos',$contract->id, 'FECHA CUOTA: '.$quota->cuota, $quota->fecha, $fecha);
	 		   		}
	 		   	}

	 		   	// if($saldo_contrato != $valor_cuotas){
		   		// 	DB::rollback();
        		// 	return Response::json(array('success' => false, 'errors' => '<div class="alert alert-danger">Valor CUOTAS ('.$valor_cuotas.') DEBE ser igual a SALDO TOTAL ('.$saldo_contrato.') del contrato.</div>'));
	 		   	// }
	      	}else{
	      		if(Request::ajax()) {
	        		DB::rollback();
	        		$data["errors"] = $contract->errors;
	            	$errors = View::make('errors', $data)->render();
	        		return Response::json(array('success' => false, 'errors' => $errors));
				} 
	            return Redirect::route('business.contracts.create')->withInput()->withErrors($contract->errors);	
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