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
        // return compact('reports');
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
        $product_woserialnum = new product_woserialnum;

        $productDetail = $product_m->get();        

        $startdate = date('Y-m-01');
        $enddate = date("Y-m-t");
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        
        foreach($productDetail as $product){
            $currentdate = $start;
            $stockAdjustmentValue = [];
            $productId = $product->id;

            $stockAdjustment = $stockadjustment_m->leftJoin('product','product.id','=','stockadjustment.product_id')
                                ->whereRaw('product.id ='.$productId)
                                ->whereRaw('MONTH(stockadjustment.created_at) = '.$currentMonth)
                                ->select('stockadjustment.created_at','stockadjustment.quantity')
                                ->get();

            $stockWithoutSerialNumber = $product_woserialnum->join('stock_in','stock_in.id','=','product_woserialnum.stock_in_id')
                                        ->leftJoin('product','product.id','=','product_woserialnum.product_id')
                                        ->select('product_woserialnum.quantity','stock_in.in_stock_date')
                                        ->whereRaw('product.id ='.$productId)
                                        ->whereRaw('MONTH(product_woserialnum.created_at) = '.$currentMonth)
                                        ->get();

            $stockInMonth = $product_m->TotalProductCount()
                                    ->whereRaw('product.id ='.$productId)
                                    // ->whereRaw('MONTH(stock_in.created_at) = '.$currentMonth)
                                    ->value('stocksCount');

            $stockDays = $product_serial_number->join('stock_in','stock_in.id','=','product_serial_number.stock_in_id')                                            
                                            ->select('product_serial_number.stock_in_id','stock_in.created_at','stock_in.in_stock_date')
                                            ->whereRaw('product_id ='.$productId)
                                            ->whereRaw('MONTH(stock_in.in_stock_date) = '.$currentMonth)
                                            ->get();

            $totalAdjustmentminus = 0; 
            $totalAdjustmentadd = 0;

            while($currentdate <= $end){
                $adjustmentQty = 0;
                $stockInToday = 0;
                $stockInTodayWS = 0;
                $cur_date = date('Y-m-d', $currentdate);

                foreach($stockAdjustment as $adjustment){
                    if(Carbon::parse($adjustment->create_at)->format('Y-m-d') == $cur_date){
                        $totalAdjustmentminus+=$adjustment->quantity;
                        $adjustmentQty = $totalAdjustmentminus;
                    }
                }

                foreach($stockDays as $stockDay){
                    if(Carbon::parse($stockDay->in_stock_date)->format('Y-m-d') == $cur_date){
                        $stockInToday = count($stockDays); //All of product_serial_number
                    }
                    $totalAdjustmentadd+=$stockInToday;
                }

                foreach($stockWithoutSerialNumber as $withoutSerial){
                    if(Carbon::parse($withoutSerial->in_stock_date)->format('Y-m-d') == $cur_date){
                        $stockInTodayWS+=$withoutSerial->quantity;
                        $totalAdjustmentadd+=$stockInTodayWS;
                    }
                }
                $stockAdjustmentValue[] = ['day_add' => $stockInToday,'day_minus' => $adjustmentQty,'date'=>$cur_date];           
                $currentdate = strtotime('+1 day', $currentdate);   
            } //end loop every day in month

            
            $product->stockInMonth = $stockInMonth?$stockInMonth:$totalAdjustmentadd;
            $product->totalAdjustmentminus = $totalAdjustmentminus;
            $product->totalAdjustmentadd = $totalAdjustmentadd;
            $product->stockBalance = $stockInMonth - $totalAdjustmentminus + $totalAdjustmentadd;
            $product->stockAdjustmentValue = $stockAdjustmentValue;
            $product->asd = $stockAdjustment;
            
        }
        return $productDetail;
    }
 
}