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
Route::get('agent/get_address/display', 'Agent\AgentController@fn_get_address_listing');
Route::post('agent/save_address', 'Agent\AgentController@fn_save_address');
Route::get('agent/delete_address/{id?}', 'Agent\AgentController@fn_delete_address');
Route::get('agent/get_place_order_items/{agent_id?}/{deliveryType?}', 'Agent\AgentController@fn_get_place_order_items');
Route::post('agent/procced_to_payment', 'Agent\AgentController@fn_proceed_to_payment');
Route::get('agent/get_delivery_status/{order_no?}', 'Agent\AgentController@fn_get_delivery_status');
Route::get('agent/get_address','Agent\AgentController@fn_get_address');
Route::get('agent/get_order_list/{agent_id?}', 'Agent\AgentController@fn_get_order_list');

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
Route::get('delivery_order/listing', 'DeliveryOrder\DeliveryOrderController@deliveryOrder_show_page');
Route::post('delivery_order/form', 'DeliveryOrder\DeliveryOrderController@deliveryOrder_form');
Route::post('delivery_order/create', 'DeliveryOrder\DeliveryOrderController@deliveryOrder_create');
Route::get('delivery_order/view/{do_no}', 'DeliveryOrder\DeliveryOrderController@deliveryOrder_view');
Route::post('delivery_order/get_itemDetail', 'DeliveryOrder\DeliveryOrderController@get_itemDetail');
Route::post('delivery_order/verify_serialno', 'DeliveryOrder\DeliveryOrderController@verify_serialno');
Route::get('delivery_order/get_product/{id}', 'DeliveryOrder\DeliveryOrderController@get_product');
Route::post('delivery_order/search_so', 'DeliveryOrder\DeliveryOrderController@search_so');

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
// Quantity Type
Route::get('configuration/quantitytype', 'Configuration\Quantitytype@listing');
Route::get('configuration/quantitytype/search/{x?}', 'Configuration\Quantitytype@search');
Route::post('configuration/quantitytype/form_search', 'Configuration\Quantitytype@form_search');
Route::get('configuration/quantitytype/delete/{x?}', 'Configuration\Quantitytype@delete');
Route::post('configuration/quantitytype/save', 'Configuration\Quantitytype@save');
// Product Category
Route::get('configuration/productcategory', 'Configuration\Productcategory@listing');
Route::get('configuration/productcategory/search/{x?}', 'Configuration\Productcategory@search');
Route::post('configuration/productcategory/form_search', 'Configuration\Productcategory@form_search');
Route::get('configuration/productcategory/delete/{x?}', 'Configuration\Productcategory@delete');
Route::post('configuration/productcategory/save', 'Configuration\Productcategory@save');

//=========================
// Stock In
//=========================
 Route::post('stock/in/store_stock_in','Stock\StockInController@storeStockIn');
 Route::get('stock/in/store_stock_in', function(){
	return view('Stock.stockInNew');
 });
 Route::get('stock/in', 'Stock\StockInController@index');
 Route::get('stock/in/new', function(){
	return view('Stock.stockInNew');
 });
 Route::post('stock/in/create', 'Stock\StockInController@create');
 Route::get('stock/in/create', function(){
	return view('Stock.stockInNew');
 });


 
//=========================
// Stock adjustment
//=========================
Route::get('stock/adjustment', 'Stock\StockAdjustmentController@index');
Route::post('stock/submit_adjustment', 'Stock\StockAdjustmentController@submit');
Route::get('stock/load_stock_adjust', 'Stock\StockAdjustmentController@loadStockAdjust');
Route::get('stock/adjustment/check_serial_number', 'Stock\StockAdjustmentController@checkSerialNumber');

// Route::get('stock/adjustment/listing', 'Inventory\Stockadjustment@listing');
// Route::get('stock/adjustment/search/{x?}', 'Inventory\Stockadjustment@search');
// Route::post('stock/adjustment/form_search', 'Inventory\Stockadjustment@form_search');
// Route::get('stock/adjustment/delete/{x?}', 'Inventory\Stockadjustment@delete');

//=========================
// Current Stock
//=========================
Route::get('stock/listing', 'Stock\StockController@index');
//=========================
// Stock Report
//=========================
Route::get('stock/report/balance', 'Stock\StockReportController@index');
Route::post('stock/report/balance', 'Stock\StockReportController@index');
Route::get('stock/report/receive', 'Stock\StockInReportController@index');


