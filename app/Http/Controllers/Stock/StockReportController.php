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

class StockReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $reports = $this->getReport();        
        
        return view('Stock.stockReport',compact('reports'));
        // return compact('report');
    }

    private function getBalanceReport(){
        $stockadjustment_m = new stockadjustment_m;
        $stockReport = $stockadjustment_m->all();
        return $stockReport;
    }

    private function getReport($currentMonth = null){
        $product_m = new product_m;
        $stockadjustment_m = new stockadjustment_m;
        $stockIn = new stock_in;

        $productDetail = $product_m->get();
        
              
        if($currentMonth == null){
            $currentMonth = date('m');
        }
        $startdate = date('Y-m-01');
        $enddate = date("Y-m-t");
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        
        $currentdate = $start;
        $stockAdjustmentValue = [];

        foreach($productDetail as $product){
            $productId = $product->id;
            $stockAdjustment = $stockadjustment_m->whereRaw('product_id ='.$product->id)->whereRaw('MONTH(stockadjustment.created_at) = '.$currentMonth)->get();
            $stockInMonth = $product_m->TotalProductCount()->whereRaw('product.id ='.$product->id)->whereRaw('MONTH(stock_in.created_at) = '.$currentMonth)->value('stocksCount');
            $totalAdjustment = 0; 
            

            foreach($stockAdjustment as $adjustment){
                while($currentdate < $end){
                    $cur_date = date('Y-m-d', $currentdate);
                if(Carbon::parse($adjustment->create_at)->format('Y-m-d') == $cur_date){
                    $totalAdjustment+=$adjustment->quantity;
                    $stockAdjustmentValue[] = ['day' => $adjustment->quantity,'date'=>$cur_date,'dbdate'=>$adjustment->create_at];                    
                }else{
                    $stockAdjustmentValue[] = ['day' => 0,'date'=>$cur_date];
                }    
                $currentdate = strtotime('+1 day', $currentdate);   
            }
                
            }
            $product->stockInMonth = $stockInMonth;
            $product->totalAdjustment = $totalAdjustment;
            $product->stockBalance = $stockInMonth - $totalAdjustment;
            $product->stockAdjustmentValue = $stockAdjustmentValue;
            
        }
        return $productDetail;
    }
 
}