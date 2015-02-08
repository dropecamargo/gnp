<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
// Nos mostrará el formulario de login.
Route::get('login', 'AuthController@showLogin');

// Validamos los datos de inicio de sesión.
Route::post('login', 'AuthController@postLogin');

// Nos indica que las rutas que están dentro de él sólo serán mostradas si antes el usuario se ha autenticado.
Route::group(array('before' => 'auth'), function()
{
	// Esta será nuestra ruta de bienvenida.
	Route::get('/', function()
	{
		return View::make('admin/index');
	});
	// Esta ruta nos servirá para cerrar sesión.
	Route::get('logout', 'AuthController@logOut');
	// Rutas modulo usuarios
	Route::resource('admin/users', 'Admin_UsersController');	
	Route::post('admin/users/search', 'Admin_UsersController@search');
	
	// Rutas modulo empleados 
	Route::resource('business/employees', 'Business_EmployeesController');

	// Rutas modulo productos 
	Route::resource('business/products', 'Business_ProductsController');

	// Rutas modulo contratos 
	Route::resource('business/contracts', 'Business_ContractsController');
	Route::post('business/contracts/find', 'Business_ContractsController@find');
	
	// Rutas modulo clientes 
	Route::resource('business/customers', 'Business_CustomersController');
	Route::post('business/customers/find', 'Business_CustomersController@find');

	// Rutas modulo recibos 
	Route::resource('business/payments', 'Business_PaymentsController');

	// Rutas modulo grupos 
	Route::resource('business/groups', 'GroupsController');

	// Rutas modulo reportes 
	Route::resource('business/reports', 'Business_ReportsController');
	Route::post('business/reports/carteraedades', 'Business_ReportsController@carteraEdades');
	Route::post('business/reports/estadocuenta', 'Business_ReportsController@estadoCuenta');
	Route::post('business/reports/estadocuentapdf', 'Business_ReportsController@estadoCuentaPdf');
	Route::post('business/reports/reciboscaja', 'Business_ReportsController@recibosCaja');
	Route::post('business/reports/ventasperiodo', 'Business_ReportsController@ventasPeriodo');

	// Rutas planilla de cobro 
	Route::resource('business/planilla', 'Business_PlanillaController');
	Route::post('business/planilla/planillacobropdf', 'Business_PlanillaController@planillaCobroPdf');

	// Rutas session list UTIL 
	Route::resource('util/cart', 'SessionCartController');	
});