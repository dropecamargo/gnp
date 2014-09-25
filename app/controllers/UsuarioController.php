<?php

class UsuarioController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$usuario = Usuario::paginate();
        return View::make('usuario/list')->with('usuario', $usuario);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	    $usuario = new Usuario;
        return View::make('usuario/form')->with('usuario', $usuario);
			
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	    // Creamos un nuevo objeto para nuestro nuevo usuario
        $usuario = new usuario;
        // Obtenemos la data enviada por el usuario
        $data = Input::all();       
        // Revisamos si la data es válido
        if ($usuario->validAndSave($data))
        {
            // Y Devolvemos una redirección a la acción show para mostrar el usuario
            return Redirect::route('usuario.show', array($usuario->id));
        }
        else
        {
            // En caso de error regresa a la acción create con los datos y los errores encontrados
            return Redirect::route('usuario.edit', $usuario->id)->withInput()->withErrors($usuario->errors);
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
		$usuario = Usuario::find($id);
        
        if (is_null($usuario)) App::abort(404);
        
      return View::make('usuario/show', array('usuario' => $usuario));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$usuario = Usuario::find($id);
        if (is_null ($usuario))
        {
            App::abort(404);
        }
        
        $form_data = array('route' => array('usuario.update', $usuario->id), 'method' => 'PATCH');
        $action    = 'Editar';
        
        return View::make('usuario/form', compact('usuario', 'form_data', 'action'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		/// Creamos un nuevo objeto para nuestro nuevo usuario
        $usuario = Usuario::find($id);
        
        // Si el usuario no existe entonces lanzamos un error 404 :(
        if (is_null ($usuario))
        {
            App::abort(404);
        }
        
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        
        // Revisamos si la data es válido
        if ($usuario->validAndSave($data))
        {
            // Y Devolvemos una redirección a la acción show para mostrar el usuario
            return Redirect::route('usuario.show', array($usuario->id));
        }
        else
        {
            // En caso de error regresa a la acción create con los datos y los errores encontrados
            return Redirect::route('usuario.edit', $usuario->id)->withInput()->withErrors($usuario->errors);
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
		$usuario = Usuario::find($id);
        
        if (is_null ($usuario))
        {
            App::abort(404);
        }
        
        $usuario->delete();

        if (Request::ajax())
        {
            return Response::json(array (
                'success' => true,
                'msg'     => 'Usuario ' . $usuario->usuario_nombre . ' eliminado',
                'id'      => $usuario->id
            ));
        }
        else
        {
            return Redirect::route('usuario.index');
        }
	}


}
