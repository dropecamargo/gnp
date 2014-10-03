<?php

class Admin_UsersController extends \BaseController {

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $data["users"] = $users = User::paginate();                
        if(Request::ajax())
        {
            //Comments pagination
            $data["links"] = $users->links();
            $users = View::make('admin/users/users', $data)->render();
            return Response::json(array('html' => $users));
        }
        return View::make('admin/users/list')->with($data);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
         // Creamos un nuevo objeto User para ser usado por el helper Form::model
        $user = new User;
        return View::make('admin/users/form')->with('user', $user);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store()
    {
        // Creamos un nuevo objeto para nuestro nuevo usuario
        $user = new User;
        // Obtenemos la data enviada por el usuario
        $data = Input::all();        
        // Revisamos si la data es válido
        if ($user->isValid($data))
        {
            // Si la data es valida se la asignamos al usuario
            $user->fill($data);
            // Guardamos el usuario
            $user->save();
            // Y Devolvemos una redirección a la acción show para mostrar el usuario
            return Redirect::route('admin.users.index');
        }else{
            return Redirect::route('admin.users.create')->withInput()->withErrors($user->errors);
        }      
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id) { 
        $user = User::find($id);
        if (is_null($user)) {
            App::abort(404);   
        } 
        return View::make('admin/users/show', array('user' => $user));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $user = User::find($id);
        if (is_null ($user)) {
            App::abort(404);
        }
        return View::make('admin/users/form')->with('user', $user);      
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {
        $user = User::find($id);
        if (is_null ($user)) {
            App::abort(404);
        }        
        $data = Input::all();
        if ($user->validAndSave($data)){
            return Redirect::route('admin.users.show', array($user->id));        
        }else{
            return Redirect::route('admin.users.edit', $user->id)->withInput()->withErrors($user->errors);
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
        $user = User::find($id);        
        if (is_null ($user)) {
            App::abort(404);
        }
        $user->delete();
        return Redirect::route('admin.users.index');
    }

    public function search()
    {
        $name = Input::get('name');
        $users = User::where('name','like',"%$name%")->get();
        return Response::json($users);
    }
}