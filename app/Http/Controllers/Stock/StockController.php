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

class StockController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        $data = [];
        $totalActiveStock = 0;
        $totalLessStock = 0;
        $lastAdjustment = '';
        $totalProduct = 0;
        #Model
        $product_m = new product_m;  
        $stockadjustment_m = new stockadjustment_m;
        $product_serial_number = new product_serial_number;

        //minidashboard
		#1 Total Product in stock
		$totalActiveStock = $product_serial_number->where('status','01')->get()->count();

		#2 Total Less Stock
		$totalLessStock = $product_m->totalProductCount()->havingRaw('stocksCount <= 3')->get()->count();

        #3 Last Adjustment
        $lastAdjustment = $stockadjustment_m->selectRaw('MAX(created_at) as last_adjust')->value('last_adjust');

		#4 Total product
        $totalProduct = $product_m->count();

        $stocks = $product_m->totalProductCount()->get();         
            foreach($stocks as $key=>$value){
                $productId = $value->product_id;
                $totalserial_number = $value->stocksCount;
                $adjustment = stockadjustment_m::join('config_stockadjustment','stockadjustment.adjustment_id','=','config_stockadjustment.id')
                                                ->where('stockadjustment.product_id',$productId)
                                                ->get();
                if($adjustment){
                    foreach($adjustment as $k => $v){
                        $quantity = $v->quantity;
                        $operation = $v->operation;
                        
                        $totalserial_number = $this->calcAdjustment($totalserial_number,$quantity,$operation);
                        
                    }
                    $data[] = [
                        'product_name' => $value->product_name,
                        'product_code' => $value->product_code,
                        'stocksCount' => $totalserial_number,
                    ];
                }             

            }
        $dashboards = [            
            'totalActiveStock' => $totalActiveStock,
            'totalLessStock' => $totalLessStock,
            'lastAdjustment' => Carbon::parse($lastAdjustment)->format('Y-m-d'),
            'totalProduct' => $totalProduct
        ];
    
            return view('Stock/stockListing', compact('data','dashboards'));
           //return compact('dashboards');

            
    }

    private function calcAdjustment($totalserial_number,$quantity,$operation){
        if($operation == '-'){
            return $totalserial_number - $quantity;
        }elseif($operation == '+'){
            return $totalserial_number + $quantity;
        }
        else{
            return;
        }
    }

}
