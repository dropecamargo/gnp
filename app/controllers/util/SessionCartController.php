<?php

class SessionCartController extends \BaseController {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(!Input::has('_key')) {
			return Response::json(array('success' => false, 'error' => 'Debe existir [_key] para agregar item.'));	
		}
		if(!Input::has('_template')) {
			return Response::json(array('success' => false, 'error' => 'Debe existir [_template] para agregar item.'));	
		}
		$list = SessionCart::addItem(Input::all());
		return Response::json(array('success' => true, 'list' => $list));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
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
		if(!Input::has('_key')) {
			return Response::json(array('success' => false, 'error' => 'Debe existir [_key] para eliminar item.'));	
		}
		if(!Input::has('_template')) {
			return Response::json(array('success' => false, 'error' => 'Debe existir [_template] para eliminar item.'));	
		}
		$list = SessionCart::delItem($id, Input::get('_key'), Input::get('_template'));
		return Response::json(array('success' => true, 'list' => $list));	
	}
}