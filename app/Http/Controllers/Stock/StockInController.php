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

        // $product =  product_m::get();
        // $supplier = supplier::get();
        // $docNo = $this->docNo;
        // $StockIndate = $this->StockIndate;

       // return view('Stock.stockIn',compact('product','supplier','generateDocNo'));
       $LatestDocNo = stock_in::selectRaw('MAX(stock_received_number) as latest_sr')->first();
       if($LatestDocNo){
        $DocNo =  $this->generate_docno($LatestDocNo->latest_sr);
       }else{
        $DocNo = "SR00001";
       }
       

       return compact('DocNo');
    }

    public function create(){
        // $validatedData = $request->validate([
        //     'in_stock_date' => 'required|date',
        // ]);

        
        $DocNo =  $this->generate_docno();

        $product =  product_m::get();
        $supplier = supplier::get();

        $today = date('Y-m-d');

        $stockInId = stock_in::insertGetId([
            'supplier_id' => 0,
            'in_stock_date' =>$today,
            'stock_received_number' => $DocNo,
            'description' => '',
            'created_by'	=> Auth::user()->id,
            'created_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
        ]);     
        
        return view('Stock.stockIn',compact('product','supplier','DocNo','today','stockInId'));
    }
    
    public function storeStockIn(Request $request){
        $postData = $this->validate($request,[
			'supplier_code' => 'required',
			'product_code' => 'required',
			'serial_number_scan_json' => 'required',
			'in_stock_date' => 'required',
            'stock_receive' => 'required',
            'description' => 'required',
            'stock_in_id' => 'required'
        ]);

     $supplierCode = $request->input('supplier_code');
     $stockInId = $request->input('stock_in_id');
     $productCode = $request->input('product_code');
     $serialNumberBucket = $request->input('serial_number_scan_json');    

     $instockDate = $request->input('in_stock_date');
     $stockReceive = $request->input('stock_receive');
     $description = $request->input('description');     

     $updateStockId = stock_in::where('id',$stockInId)->update([
         'supplier_id' => $supplierCode,
         'description' => $description,
     ]);   

     if($updateStockId){
        $this->insertSerialNumber($serialNumberBucket,$stockInId,$productCode);
         $message = "Successfully Inserted ";   
        // return $message;
         return back()->withInput();
     }else{
        return 'failed';
     }    

    }

    private function insertSerialNumber($serialNumberBucket,$stockInId,$productCode){
        $serialNumberArray = json_decode($serialNumberBucket);

        #makeInsertArray 
        $dataToInsert = [];
        foreach($serialNumberArray as $productSerialNumber){
            $dataToInsert[] = [
                'serial_number' => $productSerialNumber,
                'stock_in_id'=>$stockInId,
                'product_id'=>$productCode,
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
    
    //GEnerate SR
    private function generate_docno(){
        $LatestDocNo = stock_in::selectRaw('MAX(stock_received_number) as latest_sr')->first();

        if($LatestDocNo){
            $numberOnly = preg_replace("/[^0-9]/", '', $LatestDocNo);
            $generatedNo =  str_pad($numberOnly+1, 5, '0', STR_PAD_LEFT);
            return "SR".($generatedNo);
        }else{
            return  "SR00001";
        }
        
      
    }
}