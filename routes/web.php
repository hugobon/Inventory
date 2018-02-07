<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
	if(Auth::check()){
		return redirect('home');
	}
	else{
		return redirect('login');
	}
});

Route::get('/home', 'HomeController@index')->name('home');
//=========================
// Agent
//=========================
Route::get('/home/agent', 'Agent\AgentController@fn_get_view');

//=========================
// Supplier
//=========================
Route::get('supplier', 'Supplier\SupplierController@show_page');

//=========================
// Inventory
//=========================
Route::get('product', function () {
   return redirect("product/listing");
});
Route::get('product/listing', 'Inventory\Product@listing');
Route::get('product/form', 'Inventory\Product@form');

