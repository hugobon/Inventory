<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\product_m;
use App\inventory\stockadjustment_m;
use App\configuration\config_stockadjustment_m;
use App\stock_in;

use Auth;
use Carbon\Carbon;

class StockAdjustmentController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
	
	public function index(){
        $configstockadjustmentdata = New config_stockadjustment_m;
		$data = $configstockadjustmentdata->orderBy('adjustment', 'asc')->get();
		$adjustmentArr = array();
		if(count($data) > 0){
			foreach($data->all() as $key => $row)
				$adjustmentArr[$row->id] = $row->adjustment;
		}
		$productdata = New product_m;
		$data = $productdata->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($data) > 0){
			foreach($data->all() as $key => $row)
				$productArr[$row->id] = $row->code . ' (' . $row->description . ')';
		}
		$stockadjustmentdata = New stockadjustment_m;
		$data = array(
			'countstockadjustment' => $stockadjustmentdata->count(),
			'stockadjustmentArr' => $stockadjustmentdata->orderBy('id', 'desc')->paginate(10),
			'adjustmentArr' => $adjustmentArr,
			'productArr' => $productArr,
		);
        return view('Stock/stockAdjustmentForm',$data);
	}
	
	
	public function loadStockAdjust(Request $request){
		$adjustment = $request->get('adjustment');
		$product = $request->get('product');
		$quantity = $request->get('quantity');
		$remarks = $request->get('remarks');

		$adjustmentConfig = config_stockadjustment_m::select('adjustment','remarks','operation')->where('id',$adjustment)->where('status','1')->first();

		$stocks = stock_in::leftjoin('product','stock_in.stock_product','=','product.id')
				->join('supplier','stock_in.stock_supplier','=','supplier.id')
				->join('product_serial_number','stock_in.id','=','product_serial_number.stock_in_id')
				->selectRaw('product.description as product_description,product.code as product_code, count(product.id) as stocksCount')
				->groupBy('product_description','product_code')
				->where('product.id',$product)
				->first();

		$data = array(
			'adjustmentConfig' => $adjustmentConfig,
			'stocks' => $stocks
			
		);

		return $data;
	}

	public function submit(Request $postdata){
		$this->validate($postdata,[
			'product_id' => 'required',
			'adjustment_id' => 'required',
			'quantity' => 'required',
		]);
		
		$checkproduct = product_m::where('id', $postdata->input("product_id"))->first();
		if($checkproduct == false)
			return redirect('stock/adjustment')->with("errorid"," Product Not Found ");
			
		$checkadjustment = config_stockadjustment_m::where('id', $postdata->input("adjustment_id"))->first();
		if($checkadjustment == false)
			return redirect('stock/adjustment')->with("errorid"," Configuration Stock Adjustment Not Found ");
			
		$data = array(
			'product_id' => $postdata->input("product_id"),
			'product_name' => $checkproduct["code"]." (".$checkproduct["description"].")",
			'adjustment_id' => $postdata->input("adjustment_id"),
			'quantity' => $postdata->input("quantity"),
			'remarks' => $postdata->input("remarks"),
			'created_by'	=> Auth::user()->id,
			'created_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
		);
		$stockadjustmentdata = New stockadjustment_m;
		$stockadjustmentdata->insert($data);
		
		return redirect('stock/adjustment')
		->with("message","Success Submit Product ".$checkproduct["code"]." (".$checkproduct["description"]."),
			 Adjustment ".$checkadjustment['adjustment'].", Quantity ".$postdata->input("quantity")."");
    }
}
