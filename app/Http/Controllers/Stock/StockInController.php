<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\stock_in;
use App\inventory\product_m;
use App\supplier;
use App\product_serial_number;
use App\inventory\stockadjustment_m;
use App\configuration\config_stockadjustment_m;

use Auth;
use Carbon\Carbon;

class StockInController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $product =  product_m::get();
        $supplier = supplier::get();
    	return view('Stock.stockIn',compact('product','supplier'));
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
     $serialNumberBucket = $request->input('serial_number_scan_json');    

     $instockDate = $request->input('instock_date');
     $stockReceive = $request->input('stock_receive');
     $description = $request->input('description');     

     $stockInId = stock_in::insertGetId([
         'stock_supplier' => $supplierCode,
         'stock_product' => $productCode,
         'in_stock_date' => Carbon::parse($instockDate)->format('Y-m-d'),
         'stock_received_number' => $stockReceive,
         'description' => $description,
         'created_by'	=> Auth::user()->id,
		 'created_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
     ]);   

     if($stockInId){
        $this->insertSerialNumber($serialNumberBucket,$stockInId);
         $message = "Successfully Inserted ";   
         return redirect()->back()->with('message', $message);
     }else{
        return 'failed';
     }    

    }

    private function insertSerialNumber($serialNumberBucket,$stockInId){
        $serialNumberArray = json_decode($serialNumberBucket);

        #makeInsertArray 
        $dataToInsert = [];
        foreach($serialNumberArray as $productSerialNumber){
            $dataToInsert[] = [
                'serial_number' => $productSerialNumber,
                'stock_in_id'=>$stockInId,
                'created_by'	=> Auth::user()->id,
                'status' => '01',
		        'created_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
            ];
        }
        
        try{			
			product_serial_number::insert($dataToInsert);			
			return true;
			
		}catch(\Exception $e){
			return;
		}
	}
}