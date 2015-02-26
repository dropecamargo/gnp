<?php

class GroupsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data["groups"] = $groups = Group::paginate();
		if(Request::ajax())
        {
            //Comments pagination
            $data["links"] = $groups->links();
            $groups = View::make('business/groups/groups', $data)->render();
            return Response::json(array('html' => $groups));
        }
        return View::make('business/groups/list')->with($data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$group = new Group;
        return View::make('business/groups/form')->with('group', $group);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$group = new Group;
        $data = Input::all();        
        if ($group->validAndSave($data)){
            return Redirect::route('business.groups.index');
        }else{
            return Redirect::route('business.groups.create')->withInput()->withErrors($group->errors);
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
		$group = Group::find($id);
        if (is_null($group)) {
            App::abort(404);   
        } 
        return View::make('business/groups/show', array('group' => $group));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$group = Group::find($id);
        if (is_null ($group)) {
            App::abort(404);
        }
        return View::make('business/groups/form')->with('group', $group);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$group = Group::find($id);
        if (is_null ($group)) {
            App::abort(404);
        }        
        $data = Input::all();
        if ($group->validAndSave($data)){
            return Redirect::route('business.groups.show', array($group->id));        
        }else{
            return Redirect::route('business.groups.edit', $group->id)->withInput()->withErrors($group->errors);
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
		$group = Group::find($id);        
        if (is_null ($group)) {
            App::abort(404);
        }
        $group->delete();
        return Redirect::route('business.groups.index');
	}


}
