<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\supplier_stock_assign;

class StockController extends Controller
{
    public function showPage(){
        //get Data from product,supplier and return to view
    	return view('Stock.stock_body');
    }

    public function insertStockIn(Request $request){
        // $postData = $this->validate($request,[
		// 	'code' => 'required',
		// 	'type' => 'required',
		// 	'description' => 'required',
		// 	'price_wm' => 'required',
		// 	'price_em' => 'required',
		// 	'price_staff' => 'required',
        // ]);
     $postData = $request->all();

     $supplierCode = $request->input('supplier_code');
     $productCode = $request->input('product_code');
     $quantity = $request->input('quantity');
     $barcode = $request->input('barcode');
     $instockDate = $request->input('instock_date');
     $stockReceive = $request->input('stock_receive');
     $description = $request->input('description');
     $insert = supplier_stock_assign::insert([
         'stock_supplier' => $supplierCode,
         'stock_product' => $productCode,
         'barcode' => $barcode,
         'in_stock_date' => $instockDate,
         'stock_received_number' => $stockReceive,
         'description' => $description
     ]);
     
     if($insert){      
         $message = "Successfully Insert";   
         return redirect()->back()->with('message', $message);
     }else{
        return 'failed';
     }
     

    }

    public function stockSupplierListing(){
        $stocks = supplier_stock_assign::get();
        return view('Stock/stockSupplierListing', compact('stocks'));
    }
}
