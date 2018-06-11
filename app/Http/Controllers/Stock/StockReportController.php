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
        $sday = $request->input('sday');
        $eday = $request->input('eday');
        $month = $request->input('month');
        $year = $request->input('month');

        $sdate = $year.'-'.$month.'-'.$sday;
        $edate = $year.'-'.$month.'-'.$eday;

        if($sday == null|| $eday == null){
            $sdate = date('Y-m-01');
            $edate = date('Y-m-t');
            $month = date('m');
            $sday = date('01');
            $eday = date('t');
        }
        $reports = $this->getReport($sdate,$edate);        
        
        return view('Stock.stockReport',compact('reports','month','sdate','edate','sday','eday'));
        // return compact('reports');
    }

    private function getBalanceReport(){
        $stockadjustment_m = new stockadjustment_m;
        $stockReport = $stockadjustment_m->all();
        return $stockReport;
    }

    private function getReport($sdate,$edate){
        $product_m = new product_m;
        $stockadjustment_m = new stockadjustment_m;
        $stockIn = new stock_in;
        $product_serial_number = new product_serial_number;
        $product_woserialnum = new product_woserialnum;

        $products = $product_m->get();        

        $start = strtotime($sdate);
        $end = strtotime($edate);
        
        foreach($products as $product){
            $currentdate = $start;
            $stock_adjustment_value = [];
            $product_id = $product->id;

            //Stock Available overall 
            $stock_in_month = $product_m->TotalProductCount()
                                    ->whereRaw('product.id ='.$product_id)
                                    ->value('stocksCount');

            //Check Adjusted table
            $stockAdjustment = $stockadjustment_m->leftJoin('product','product.id','=','stockadjustment.product_id')
                                ->leftJoin('config_stockadjustment','config_stockadjustment.id','adjustment_id')
                                ->whereRaw('product.id ='.$product_id)
                                ->whereRaw('DATE(stockadjustment.created_at) BETWEEN "'.$sdate.'" AND "'.$edate.'"')
                                ->select('stockadjustment.created_at','stockadjustment.quantity','config_stockadjustment.adjustment')
                                ->get();

            //Check Product without serial number with stock in id
            $stockWithoutSerialNumber = $product_woserialnum->leftJoin('stock_in','stock_in.id','=','product_woserialnum.stock_in_id')
                                        ->leftJoin('product','product.id','=','product_woserialnum.product_id')
                                        ->select('product_woserialnum.quantity','stock_in.in_stock_date')
                                        ->whereRaw('product.id ='.$product_id)
                                        ->whereRaw('DATE(stock_in.in_stock_date) BETWEEN "'.$sdate.'" AND "'.$edate.'"')
                                        ->get();
                                        
            //Check Product with serial number with stock in id         
            $stockDays = $product_serial_number->leftJoin('stock_in','stock_in.id','=','product_serial_number.stock_in_id')                                            
                                            ->select('product_serial_number.stock_in_id','stock_in.created_at','stock_in.in_stock_date')
                                            ->whereRaw('product_id ='.$product_id)
                                            ->whereRaw('DATE(stock_in.in_stock_date) BETWEEN "'.$sdate.'" AND "'.$edate.'"')
                                            ->get();

            $total_adjustment_minus = 0; 
            $total_adjustment_add = 0;

            while($currentdate <= $end){
                $adjustment_today = 0;
                $stockInToday = 0;
                $stockInTodayWS = 0;
                $cur_date = date('Y-m-d', $currentdate);
                $adjustment_tooltip = '';
                
                #1.Adjustment of Minus Quantity
                foreach($stockAdjustment as $adjustment){
                    if(Carbon::parse($adjustment->create_at)->format('Y-m-d') == $cur_date){
                        $total_adjustment_minus+=$adjustment->quantity;
                        $adjustment_today += $adjustment->quantity;
                        $adjustment_tooltip .= $adjustment->adjustment.'('.$adjustment->quantity.' Units)<br />';
                    }
                }

                foreach($stockDays as $stockDay){
                    if(Carbon::parse($stockDay->in_stock_date)->format('Y-m-d') == $cur_date){
                        $stockInToday += $stockDays->count(); //All of product_serial_number
                        $total_adjustment_add+=$stockDays->count();
                    }
                    
                }

                foreach($stockWithoutSerialNumber as $withoutSerial){
                    if(Carbon::parse($withoutSerial->in_stock_date)->format('Y-m-d') == $cur_date){
                        $stockInTodayWS+=$withoutSerial->quantity;
                        $total_adjustment_add+=$withoutSerial->quantity;                        
                    }
                    
                }
                $stock_adjustment_value[] = ['day_add' => $stockInToday+$stockInTodayWS,
                                            'day_minus' => $adjustment_today,
                                            'date'=>$cur_date,
                                            'adjustment_tooltip' => $adjustment_tooltip];           
                $currentdate = strtotime('+1 day', $currentdate);   
            } //end loop every day in month

            
            $product->stock_in_month = $stock_in_month?$stock_in_month:$total_adjustment_add;
            $product->total_adjustment_minus = $total_adjustment_minus;
            $product->total_adjustment_add = $total_adjustment_add;
            $product->stock_balance = $stock_in_month - $total_adjustment_minus + $total_adjustment_add;
            $product->stock_adjustment_value = $stock_adjustment_value;
            $product->asd = $stockWithoutSerialNumber;
            
        }
        return $products;
    }
 
}