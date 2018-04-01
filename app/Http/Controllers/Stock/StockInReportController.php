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

class StockInReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $stock_in = new stock_in;
        $dataToReturn = $stock_in->all();

        return view('Stock.stockReceivedList',compact('dataToReturn'));

        
    }
}