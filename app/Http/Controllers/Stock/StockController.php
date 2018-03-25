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
        
        $stocks = stock_in::leftjoin('product','stock_in.stock_product','=','product.id')
                                        ->join('supplier','stock_in.stock_supplier','=','supplier.id')
                                        ->join('product_serial_number','stock_in.id','=','product_serial_number.stock_in_id')
                                        ->selectRaw('product.description as product_description,product.code as product_code, count(product.id) as stocksCount ,product.id as product_id')
                                        ->groupBy('product_description','product_code','product_id')
                                        ->get();
                    
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
                        'product_description' => $value->product_description,
                        'product_code' => $value->product_code,
                        'stocksCount' => $totalserial_number
                    ];
                }             

            }
    
            return view('Stock/stockListing', compact('data'));
            
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
