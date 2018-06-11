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
use App\product_woserialnum;
use DB;

use Auth;
use Carbon\Carbon;

class StockBarcodeListingController  extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($product_id){
        
        if($product_id === 'all' && type == 'barcode'){
            $data = product_serial_number::leftjoin('product','product.id','=','product_serial_number.product_id')
                                        ->leftjoin('stock_in','stock_in.id','product_serial_number.stock_in_id')
                                        ->select('product_serial_number.serial_number','stock_in.in_stock_date','stock_in.stock_received_number')
                                        ->get();
                                        
            $product_name['name'] = "All products";

        }else{
            $data = product_serial_number::leftjoin('product','product.id','=','product_serial_number.product_id')
                                        ->leftjoin('stock_in','stock_in.id','product_serial_number.stock_in_id')
                                        ->select('product_serial_number.serial_number','stock_in.in_stock_date','stock_in.stock_received_number')
                                        ->where('product_id',$product_id)
                                        ->get();
            $product_name = product_m::where('id',$product_id)->select('name')->first();
        }

        
        

        return view('Stock.stockBarcode',compact('data','product_name'));
        // return compact('data','product_name','product_id');
    }

}