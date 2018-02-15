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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('logout', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
//=========================
// Agent
//=========================
Route::get('agent', 'Agent\AgentController@fn_get_view');
Route::post('agent/save', 'Agent\AgentController@fn_save_agent_record');

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

