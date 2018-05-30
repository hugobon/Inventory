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

class StockSalesReportController  extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $date = $request->input('month');
        if($date==null){
            $date = date('m');
        }
        
        return view('Stock.stockSalesReport',compact('date'));
        // return compact('reports');
    }

}