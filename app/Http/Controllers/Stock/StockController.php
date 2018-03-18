<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\supplier_stock_assign;
use App\inventory\product_m;
use App\supdetail;
use App\barcode;
use App\inventory\stockadjustment_m;
use App\configuration\config_stockadjustment_m;

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
    	return view('Stock.stockIn',compact('product','supplier'));
    }

    public function submitStockIn(Request $request){
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
         $message = "Successfully Inserted ";   
         return redirect()->back()->with('message', $message);
     }else{
        return 'failed';
     }
     

    }

    public function stockListing(){
        
        $stocks = supplier_stock_assign::leftjoin('product','supplier_stock_assign.stock_product','=','product.id')
                                        ->leftjoin('supdetail','supplier_stock_assign.stock_supplier','=','supdetail.id')
                                        ->leftjoin('barcode','supplier_stock_assign.id','=','barcode.supplier_stock_assign')
                                        ->selectRaw('product.description as product_description,product.code as product_code, count(product.id) as stocksCount ,product.id as product_id')
                                        ->groupBy('product_description','product_code','product_id')
                                        ->get();
                    
            foreach($stocks as $key=>$value){
                $productId = $value->product_id;
                $totalBarcode = $value->stocksCount;
                $adjustment = stockadjustment_m::leftJoin('config_stockadjustment','stockadjustment.adjustment_id','=','config_stockadjustment.id')
                                                ->where('stockadjustment.product_id',$productId)
                                                ->get();
                if($adjustment){
                    foreach($adjustment as $k => $v){
                        $quantity = $v->quantity;
                        $operation = $v->operation;
                        
                        $totalBarcode = $this->calcAdjustment($totalBarcode,$quantity,$operation);
                        
                    }
                    $data[] = [
                        'product_description' => $value->product_description,
                        'product_code' => $value->product_code,
                        'stocksCount' => $totalBarcode
                    ];
                }
                

            }
    
            return view('Stock/stockListing', compact('data'));
            
    }

    private function calcAdjustment($totalBarcode,$quantity,$operation){
        if($operation == '-'){
            return $totalBarcode - $quantity;
        }else{
            return $totalBarcode + $quantity;
        }
    }

    public function stockAdjustment(){
        $configstockadjustmentdata = New config_stockadjustment_m;
		$data = $configstockadjustmentdata->orderBy('adjustment', 'asc')->get();
		$adjustmentArr = array();
		if(count($data) > 0){
			foreach($data->all() as $key => $row)
				$adjustmentArr[$row->id] = $row->adjustment;
		}
		$productdata = New product_m;
		$data = $productdata->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($data) > 0){
			foreach($data->all() as $key => $row)
				$productArr[$row->id] = $row->code . ' (' . $row->description . ')';
		}
		$stockadjustmentdata = New stockadjustment_m;
		$data = array(
			'countstockadjustment' => $stockadjustmentdata->count(),
			'stockadjustmentArr' => $stockadjustmentdata->orderBy('id', 'desc')->paginate(10),
			'adjustmentArr' => $adjustmentArr,
			'productArr' => $productArr,
		);
        return view('Stock/stockAdjustmentForm',$data);
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
