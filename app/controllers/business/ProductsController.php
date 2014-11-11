<?php

class Business_ProductsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$data['products'] = $products = Product::getData();
		if(Request::ajax())
        {
            $data["links"] = $products->links();
            $products = View::make('business/products/products', $data)->render();
            return Response::json(array('html' => $products));
        }
        return View::make('business/products/list')->with($data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$product = new Product;      
        return View::make('business/products/form')->with($arrayName = array('product' => $product));		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
	    $product = new Product;
      	
      	if ($product->isValid($data)){
      		DB::beginTransaction();	
        	try{
        		$product->fill($data);	        			
        		$product->save();
        	}catch(\Exception $exception){
			    DB::rollback();
				return Response::json(array('success' => false, 'errors' =>  "$exception - Consulte al administrador."));
			}
			DB::commit();
			if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'product' => $product));
        	}
        	return Redirect::route('business.products.index');
        }else{
      		if(Request::ajax()) {
        		$data["errors"] = $product->errors;
            	$errors = View::make('errors', $data)->render();
        		return Response::json(array('success' => false, 'errors' => $errors));
			} 
            return Redirect::route('business.products.create')->withInput()->withErrors($products->errors);	
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
		$product = Product::find($id);		
        if (is_null($product)) {
            App::abort(404);   
        } 
		return View::make('business/products/show', array('product' => $product));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::find($id);
        if (is_null ($product)) {
            App::abort(404);
        }
        return View::make('business/products/form')->with('product', $product);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$product = Product::find($id);
        if (is_null ($product)) {
        	if(Request::ajax()) {
            	return Response::json(array('success' => false, 'errors' => 'Error recuperando producto - Consulte al administrador'));	
            }
            App::abort(404);
        }        
        $data = Input::all();
        if ($product->isValid($data)){
        	DB::beginTransaction();	
        	try{
	        	$product->fill($data);
	        	$product->save();
	        }catch(\Exception $exception){
			    DB::rollback();
				return Response::json(array('success' => false, 'errors' =>  "$exception - Consulte al administrador."));
			}
			DB::commit();
			if(Request::ajax()) {        	    
        	    return Response::json(array('success' => true, 'product' => $product));
        	}
        	return Redirect::route('business.products.index');
        }else{
        	if(Request::ajax()) {
        		$data["errors"] = $product->errors;
            	$errors = View::make('errors', $data)->render();
        		return Response::json(array('success' => false, 'errors' => $errors));
			} 
          	return Redirect::route('business.product.edit')->withInput()->withErrors($product->errors);
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


}
