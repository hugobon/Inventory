<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\supplier_stock_assign;
use App\inventory\product_m;

class StockController extends Controller
{
    public function showPage(){
        //get Data from product,supplier and return to view
       $product =  product_m::get();

       $data['product'] = $product;
       $data['tabform'] = 'active';
       var_dump($product);
    	return view('Stock.stock_body',compact('data'));
    }

    public function stockIn_page(){
        $product =  product_m::get();
    	return view('Supplier.stockIn',compact('product'));
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
     $barcode = $request->input('barcode')?$request->input('barcode')!='':1;
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
        $stocks = supplier_stock_assign::leftjoin('product','supplier_stock_assign.stock_product','=','product.id')
                                        ->select('supplier_stock_assign.stock_supplier',
                                                'supplier_stock_assign.barcode',
                                                'supplier_stock_assign.in_stock_date',
                                                'supplier_stock_assign.stock_received_number',
                                                'product.description as product_description',
                                                'supplier_stock_assign.description')
                                        ->get();
        return view('Stock/stockSupplierListing', compact('stocks'));
    }
}
