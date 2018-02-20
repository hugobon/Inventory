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
// Agent :: Amin
//=========================
Route::get('agent', 'Agent\AgentController@fn_get_view');
Route::post('agent/save', 'Agent\AgentController@fn_save_agent_record')->name('agent_view');

//=========================
// Supplier :: Zul
//=========================
Route::get('supplier/supplierDetail', 'Supplier\SupplierController@supplierDetail_page');
Route::get('supplier/stockIn', 'Supplier\SupplierController@stockIn_page');
Route::get('supplier/supplierDO', 'Supplier\SupplierController@supplierDO_page');

//=========================
// Inventory :: Aqi
//=========================
// Product
Route::get('product', function () {  return redirect("product/listing"); });
Route::get('product/listing', 'Inventory\Product@listing');
Route::get('product/search/{x?}', 'Inventory\Product@search');
Route::post('product/form_search', 'Inventory\Product@form_search');
Route::get('product/form', 'Inventory\Product@form');
Route::get('product/edit/{x?}', 'Inventory\Product@edit');
Route::get('product/view/{x?}', 'Inventory\Product@view');
Route::post('product/insert', 'Inventory\Product@insert');
Route::post('product/update/{x?}', 'Inventory\Product@update');
Route::post('product/check_existcode', 'Inventory\Product@check_existcode');
Route::get('product/delete/{x?}', 'Inventory\Product@delete');
// Stock
Route::get('stock', function () {   });

//=========================
// Configuration :: Aqi
//=========================
Route::get('configuration', function () {  return redirect("home"); });
// Tax GST
Route::get('configuration/gst', 'Configuration\Gst@view');
Route::get('configuration/gst/form', 'Configuration\Gst@form');
Route::post('configuration/gst/update', 'Configuration\Gst@update');
// Stock Adjustment stockadjustment
Route::get('configuration/stockadjustment', 'Configuration\Stockadjustment@listing');
Route::get('configuration/stockadjustment/search/{x?}', 'Configuration\Stockadjustment@search');
Route::post('configuration/stockadjustment/form_search', 'Configuration\Stockadjustment@form_search');
Route::get('configuration/stockadjustment/delete/{x?}', 'Configuration\Stockadjustment@delete');
Route::post('configuration/stockadjustment/save', 'Configuration\Stockadjustment@save');

