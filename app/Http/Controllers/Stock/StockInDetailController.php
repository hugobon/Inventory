<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\stock_in;
use App\inventory\product_m;
use App\supplier;
use App\product_serial_number;
use App\inventory\stockadjustment_m;
use App\product_woserialnum;
use App\configuration\config_stockadjustment_m;

use Auth;
use Carbon\Carbon;

class StockInDetailController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($id=""){
        $stock_in_detail = stock_in::where('stock_in.stock_received_number',$id)->first();
        $stocks = stock_in::leftjoin('supplier','supplier.id','=','stock_in.supplier_id')
        ->leftjoin('product_serial_number','product_serial_number.stock_in_id','=','stock_in.id')
        ->leftjoin('product','product.id','=','product_serial_number.product_id')        
        ->where('stock_in.stock_received_number',$id)
        ->get();

        return view('Stock.stock_in_detail',compact('stocks','stock_in_detail'));

        
    }
}