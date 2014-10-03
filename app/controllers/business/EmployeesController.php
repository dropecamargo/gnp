<?php

class Business_EmployeesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{		
		$data["employees"] = $employees = Employee::paginate();
		if(Request::ajax())
        {
            //Comments pagination
            $data["links"] = $employees->links();
            $employees = View::make('business/employees/employees', $data)->render();
            return Response::json(array('html' => $employees));
        }
        return View::make('business/employees/list')->with($data);  
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$employee = new Employee;
        return View::make('business/employees/form')->with('employee', $employee);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$employee = new Employee;
        $data = Input::all();        
        if ($employee->validAndSave($data)){
            return Redirect::route('business.employees.index');
        }else{
            return Redirect::route('business.employees.create')->withInput()->withErrors($employee->errors);
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
		$employee = Employee::find($id);
        if (is_null($employee)) {
            App::abort(404);   
        } 
        return View::make('business/employees/show', array('employee' => $employee));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$employee = Employee::find($id);
        if (is_null ($employee)) {
            App::abort(404);
        }
        return View::make('business/employees/form')->with('employee', $employee);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$employee = Employee::find($id);
        if (is_null ($employee)) {
            App::abort(404);
        }        
        $data = Input::all();
        if ($employee->validAndSave($data)){
            return Redirect::route('business.employees.show', array($employee->id));        
        }else{
            return Redirect::route('business.employees.edit', $employee->id)->withInput()->withErrors($employee->errors);
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
		$employee = Employee::find($id);        
        if (is_null ($employee)) {
            App::abort(404);
        }
        $employee->delete();
        return Redirect::route('business.employees.index');
	}
}
