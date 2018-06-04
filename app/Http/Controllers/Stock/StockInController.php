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
use App\global_nr;
use App\product_woserialnum;
use Session;

use Auth;
use Carbon\Carbon;



class StockInController extends Controller
{
    protected $docNo;
    protected $StockIndate;
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $product_serial_number = new product_serial_number;
        $currentMonth = '04';

 
        $stockDays = $product_serial_number->leftjoin('stock_in','stock_in.id','=','product_serial_number.stock_in_id')
        ->select('product_serial_number.stock_in_id','stock_in.created_at')
        ->whereRaw('MONTH(stock_in.created_at) = '.$currentMonth)
        ->tosql();
       

       return json_encode($stockDays);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'in_stock_date' => 'required|date',
        ]);

        
        $DocNo =  $this->generate_docno();
        $inStockDate = $request->input('in_stock_date');

        $product =  product_m::where('type','<>',['2','3'])->get();
        $supplier = supplier::get();

        $stockInId = stock_in::insertGetId([
            'supplier_id' => 0,
            'in_stock_date' => Carbon::parse($inStockDate)->format('Y-m-d'),
            'stock_received_number' => $DocNo,
            'description' => '',
            'created_by'	=> Auth::user()->id,
            'created_at'	=> Carbon::now()
        ]);     
        
        return view('Stock.stockIn',compact('product','supplier','DocNo','inStockDate','stockInId'));
    }
    
    public function storeStockIn(Request $request){
        $postData = $this->validate($request,[
			'supplier_code' => 'required',
			'product_code' => 'required',
			// 'serial_number_scan_json' => 'required',
			'in_stock_date' => 'required',
            'stock_receive' => 'required',
            'description' => 'required',
            'stock_in_id' => 'required',
            // 'quantity' =>'required',
        ]);

     $supplierCode = $request->input('supplier_code');
     $stockInId = $request->input('stock_in_id');
     $productCode = $request->input('product_code');
     $serialNumberBucket = $request->input('serial_number_scan_json');  
     $link_redirect  = $request->input('link_redirect');
     $quantity  = $request->input('quantity');
     $inStockDate = $request->input('in_stock_date');
     $DocNo = $request->input('stock_receive');
     $description = $request->input('description');     

     $updateStockId = stock_in::where('id',$stockInId)->update([
         'supplier_id' => $supplierCode,
         'description' => $description,
     ]);   

     if($updateStockId){
        $product =  product_m::get();
        $supplier = supplier::get();
        if($serialNumberBucket){
            $insert = $this->insertSerialNumber($serialNumberBucket,$stockInId,$productCode);
            
        }else{
            $insert = $this->productWithoutSerialNum($productCode,$quantity,$stockInId);
        }
        
        if($insert){
            $message = $insert['success']." was successfully saved,".$insert['exist']." was already existed";
        }else{
            $message = "Successfully Inserted ";
        } 
        
         

         
         if($link_redirect){
             return redirect($link_redirect);
         }else{
            Session::flash('message', $message);
            return view('Stock.stockIn',compact('product','supplier','DocNo','inStockDate','stockInId'));
         }   
         
     }else{
        return 'failed';
     }    

    }

    private function insertSerialNumber($serialNumberBucket,$stockInId,$productCode){
        $serialNumberArray = json_decode($serialNumberBucket);

        #makeInsertArray 
        $dataToInsert = [];
        $countSuccess = 0;
        $countExist = 0;
        foreach($serialNumberArray as $productSerialNumber){
            $exist = product_serial_number::where('serial_number',$productSerialNumber)->first();

            if(!$exist){
                $dataToInsert[] = [
                    'serial_number' => $productSerialNumber,
                    'stock_in_id'=>$stockInId,
                    'product_id'=>$productCode,
                    'created_by'	=> Auth::user()->id,
                    'status' => '01',
                    'created_at'	=> Carbon::now()
                ];
                $countSuccess++;
            }else{
                $countExist++;
            }
            
        }

        $message = ['success' => $countSuccess,'exist' => $countExist];
        
        try{
			product_serial_number::insert($dataToInsert);			
			return $message;
			
		}catch(\Exception $e){
			return;
		}
    }
    
    //GEnerate SR
    private function generate_docno(){
        $LatestDocNo = stock_in::selectRaw('MAX(stock_received_number) as latest_sr')->first();    
            $numberOnly = preg_replace("/[^0-9]/", '', $LatestDocNo);
            if(!$numberOnly){
                $numberOnly = "00000";
            }
            $generatedNo =  str_pad($numberOnly+1, 5, '0', STR_PAD_LEFT);
            return "SR".($generatedNo);      
    }

    private function productWithoutSerialNum($product_id,$quantity,$stock_in_id){
        //Init
        $product_woserialnum = new product_woserialnum;
        try{	
                $product_woserialnum->insert([
                                            'product_id'=>$product_id,
                                            'quantity'=>$quantity,
                                            'stock_in_id'=>$stock_in_id,
                                            'created_at'=>Carbon::now(),
                                            'created_by'=>Auth::user()->id
                                            ]);

                $message = ['success' => $quantity,'exist' => 0];
                 return $message;
			
		}catch(\Exception $e){
			return;
		}
    }
}