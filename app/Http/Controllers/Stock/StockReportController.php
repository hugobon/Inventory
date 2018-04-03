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

    public function index(Request $request){
        $date = $request->input('month');
        if($date==null){
            $date = date('m');
        }
        $reports = $this->getReport($date);        
        
        return view('Stock.stockReport',compact('reports','date'));
        // return compact('report');
    }

    private function getBalanceReport(){
        $stockadjustment_m = new stockadjustment_m;
        $stockReport = $stockadjustment_m->all();
        return $stockReport;
    }

    private function getReport($currentMonth){
        $product_m = new product_m;
        $stockadjustment_m = new stockadjustment_m;
        $stockIn = new stock_in;
        $product_serial_number = new product_serial_number;

        $productDetail = $product_m->get();        

        $startdate = date('Y-m-01');
        $enddate = date("Y-m-t");
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        
        $currentdate = $start;
        $stockAdjustmentValue = [];

        foreach($productDetail as $product){
            $productId = $product->id;
            $stockAdjustment = $stockadjustment_m->whereRaw('product_id ='.$product->id)
                                ->whereRaw('MONTH(stockadjustment.created_at) = '.$currentMonth)
                                ->get();

            $stockInMonth = $product_m->TotalProductCount()
                                    ->whereRaw('product.id ='.$product->id)
                                    ->whereRaw('MONTH(stock_in.created_at) = '.$currentMonth)
                                    ->value('stocksCount');

            $stockDays = $product_serial_number->leftjoin('stock_in','stock_in.id','=','product_serial_number.stock_in_id')
                                            ->whereRaw('product_id ='.$product->id)
                                            ->select('product_serial_number.stock_in_id','stock_in.created_at')
                                            ->whereRaw('MONTH(stock_in.created_at) = '.$currentMonth)
                                            ->get();

            $totalAdjustmentminus = 0; 
            $totalAdjustmentadd = 0;

            while($currentdate <= $end){
                $adjustmentQty = 0;
                $stockInToday = 0;
                $cur_date = date('Y-m-d', $currentdate);
                foreach($stockAdjustment as $adjustment){
                    if(Carbon::parse($adjustment->create_at)->format('Y-m-d') == $cur_date){
                        $totalAdjustmentminus+=$adjustment->quantity;
                        $adjustmentQty = $adjustment->quantity;
                    }
                }
                foreach($stockDays as $stockDay){
                    if(Carbon::parse($stockDay->created_at)->format('Y-m-d') == $cur_date){
                        $stockInToday++;
                    }
                    $totalAdjustmentadd+=$stockInToday;
                }
                $stockAdjustmentValue[] = ['day_add' => $stockInToday,'day_minus' => $adjustmentQty,'date'=>$cur_date];           
                $currentdate = strtotime('+1 day', $currentdate);   
            }

            
            $product->stockInMonth = $stockInMonth?$stockInMonth:0;
            $product->totalAdjustmentminus = $totalAdjustmentminus;
            $product->totalAdjustmentadd = $totalAdjustmentadd;
            $product->stockBalance = $stockInMonth - $totalAdjustmentminus + $totalAdjustmentadd;
            $product->stockAdjustmentValue = $stockAdjustmentValue;
            
        }
        return $productDetail;
    }
 
}