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
Route::get('agent/register', 'Agent\AgentController@fn_get_view');
Route::post('agent/save', 'Agent\AgentController@fn_save_agent_record');
Route::get('agent/view','Agent\AgentController@fn_view_agent_record');
Route::get('agent/get_order_stock/{mode?}/{agent_id?}', 'Agent\AgentController@fn_get_agent_order_stock');
Route::post('agent/save_agent_order_stock', 'Agent\AgentController@fn_save_agent_order_stock');
Route::get('agent/get_product_list/{mode?}', 'Agent\AgentController@fn_get_product_list');
Route::get('agent/get_checkout_items/{agent_id?}', 'Agent\AgentController@fn_get_checkout_items');
Route::post('agent/save_selected_items', 'Agent\AgentController@fn_save_selected_items');
Route::get('agent/get_cart_items', 'Agent\AgentController@fn_get_cart_items');
Route::post('agent/delete_cart_item', 'Agent\AgentController@fn_delete_cart_item');
Route::post('agent/update_quantity_item', 'Agent\AgentController@fn_update_quantity_item');
Route::get('agent/get_product_details/{product_id?}', 'Agent\AgentController@fn_get_product_details');

//=========================
// Supplier :: Zul
//=========================
Route::get('supplier/supplierDetail', 'Supplier\SupplierController@supplierDetail_show_page');
Route::get('supplier/supplierDetail/form/{comp_code?}', 'Supplier\SupplierController@supplierDetail_form_page');
Route::post('supplier/supplierDetail/create_comp', 'Supplier\SupplierController@fn_create_comp');
Route::post('supplier/supplierDetail/update_comp', 'Supplier\SupplierController@fn_update_comp');
Route::get('supplier/supplierDetail/view/{comp_code}', 'Supplier\SupplierController@fn_get_detail');
// Route::get('supplier/stockIn', 'Supplier\SupplierController@stockIn_page');
// Route::get('supplier/supplierDO', 'Supplier\SupplierController@supplierDO_page');

//=========================
// Delivery Order :: Zul
//=========================
Route::get('delivery_order/listing', 'Supplier\SupplierController@supplierDO_page');
Route::post('delivery_order/form', 'Supplier\SupplierController@do_show_page');

//=========================
// Inventory :: Aqi
//=========================
// Product
Route::get('product', function () {  return redirect("product/listing"); });
Route::get('product/listing', 'Inventory\Product@listing');
Route::get('product/search/{x?}', 'Inventory\Product@search');
Route::post('product/form_search', 'Inventory\Product@form_search');
Route::get('product/form', 'Inventory\Product@form');
Route::get('product/edit/{x?}/{y?}', 'Inventory\Product@edit');
Route::get('product/view/{x?}', 'Inventory\Product@view');
Route::post('product/insert', 'Inventory\Product@insert');
Route::post('product/update/{x?}', 'Inventory\Product@update');
Route::get('product/package_form', 'Inventory\Product@package_form');
Route::get('product/package_edit/{x?}/{y?}', 'Inventory\Product@package_edit');
Route::get('product/package_view/{x?}', 'Inventory\Product@package_view');
Route::post('product/package_insert', 'Inventory\Product@package_insert');
Route::post('product/package_update/{x?}', 'Inventory\Product@package_update');
Route::get('product/reload_image/{x?}', 'Inventory\Product@reload_image');
Route::post('product/upload_image/{x?}', 'Inventory\Product@upload_image');
Route::post('product/set_mainimage', 'Inventory\Product@set_mainimage');
Route::post('product/check_existcode', 'Inventory\Product@check_existcode');
Route::get('product/delete/{x?}', 'Inventory\Product@delete');
Route::get('product/delete_image/{x?}', 'Inventory\Product@delete_image');
Route::get('product/all_data_product', 'Inventory\Product@all_data_product');
Route::get('product/single_data_product/{x?}', 'Inventory\Product@single_data_product');
// Product promotion
Route::get('product/promotion', function () {  return redirect("promotion/listing"); });
Route::get('product/promotion/listing', 'Inventory\Product_promotion@listing');
Route::get('product/promotion/search/{x?}', 'Inventory\Product_promotion@search');
Route::post('product/promotion/form_search', 'Inventory\Product_promotion@form_search');
Route::get('product/promotion/form', 'Inventory\Product_promotion@form');
Route::get('product/promotion/view/{x?}', 'Inventory\Product_promotion@view');
Route::post('product/promotion/insert', 'Inventory\Product_promotion@insert');
Route::get('product/promotion/edit/{x?}', 'Inventory\Product_promotion@edit');
Route::post('product/promotion/update/{x?}', 'Inventory\Product_promotion@update');
Route::get('product/promotion/delete/{x?}', 'Inventory\Product_promotion@delete');
// Stock Adjustment
// Route::get('stock/adjustment', function () {  return redirect("stock/adjustment/listing"); });

Route::get('stock/adjustment/listing', 'Inventory\Stockadjustment@listing');
Route::get('stock/adjustment/search/{x?}', 'Inventory\Stockadjustment@search');
Route::post('stock/adjustment/form_search', 'Inventory\Stockadjustment@form_search');

Route::get('stock/adjustment/delete/{x?}', 'Inventory\Stockadjustment@delete');

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

//=========================
// Stock
//=========================
 Route::get('stock', 'Stock\StockController@showPage');
 Route::post('stock/submit_stock-in','Stock\StockController@submitStockIn');
 Route::get('stock/listing', 'Stock\StockController@stockListing');
 Route::get('stock/in', 'Stock\StockController@stockIn_page');
 Route::get('stock/adjustment', 'Stock\StockController@stockAdjustment');
 Route::post('stock/submit_adjustment', 'Stock\StockAdjustmentController@submit');
 Route::post('stock/load_stock_adjust', 'Stock\StockAdjustmentController@loadStockAdjust');
 
 