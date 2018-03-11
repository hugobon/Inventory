<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\supplier_stock_assign;
use App\inventory\product_m;
use App\supdetail;
use App\barcode;

use Auth;
use Carbon\Carbon;

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
        $supplier = supdetail::get();
    	return view('Supplier.stockIn',compact('product','supplier'));
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
     //get barcode id
     //$barcode = $request->input('barcode')?$request->input('barcode')!='':1;
     $barcodeBucket = $request->input('barcode_scan_json');    

     $instockDate = $request->input('instock_date');
     $stockReceive = $request->input('stock_receive');
     $description = $request->input('description');     

     $insert = supplier_stock_assign::insertGetId([
         'stock_supplier' => $supplierCode,
         'stock_product' => $productCode,
         //'barcode' => $barcode,
         'in_stock_date' => Carbon::parse($instockDate)->format('Y-m-d'),
         'stock_received_number' => $stockReceive,
         'description' => $description,
         'created_by'	=> Auth::user()->id,
		 'created_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
     ]);   

     if($insert){
        $this->insertBarcode($barcodeBucket,$insert);
         $message = "Successfully Insert";   
         return redirect()->back()->with('message', $message);
     }else{
        return 'failed';
     }
     

    }

    public function stockSupplierListing(){
        $stocks = supplier_stock_assign::leftjoin('product','supplier_stock_assign.stock_product','=','product.id')
                                        ->leftjoin('supdetail','supplier_stock_assign.stock_supplier','=','supdetail.id')
                                        ->leftjoin('barcode','supplier_stock_assign.id','=','barcode.supplier_stock_assign')
                                        ->selectRaw('product.description as product_description, count(product.id) as stocksCount')
                                        ->groupBy('product_description')
                                        ->get();
    
        return view('Stock/stockSupplierListing', compact('stocks'));
    }

    private function insertBarcode($barcodeBucket,$supplierStockAssignId){
        $barcodeArray = json_decode($barcodeBucket);

        #makeInsertArray 
        $dataToInsert = [];
        foreach($barcodeArray as $barcode){
            $dataToInsert[] = [
                'barcode_value' => $barcode,
                'supplier_stock_assign'=>$supplierStockAssignId,
                'created_by'	=> Auth::user()->id,
		        'created_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
            ];
        }
        
        try{			
			barcode::insert($dataToInsert);			
			return true;
			
		}catch(\Exception $e){
			
		}
	}
}
