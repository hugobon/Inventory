<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\product_m;
use App\inventory\stockadjustment_m;
use App\configuration\config_stockadjustment_m;
use App\stock_in;
use App\product_serial_number;

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
				$productArr[$row->id] = $row->code . ' (' . $row->name . ')';
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

		$product_m = new product_m;
		$adjustmentConfig = config_stockadjustment_m::select('adjustment','remarks','operation')->where('id',$adjustment)->where('status','01')->first();
		
		$stocks = $product_m->TotalProductCount()
				->where('product.id',$product)
				->first();

		$data = array(
			'adjustmentConfig' => $adjustmentConfig,
			'stocks' => $stocks
			
		);

		return $data;
	}

	public function submit(Request $postdata){
		$product_serial_number = new product_serial_number;
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
			'product_name' => $checkproduct["code"]." (".$checkproduct["name"].")",
			'adjustment_id' => $postdata->input("adjustment_id"),
			'quantity' => $postdata->input("quantity"),
			'remarks' => $postdata->input("remarks"),
			'created_by'	=> Auth::user()->id,
			'created_at'	=> Carbon::now()
		);
		$stockadjustmentdata = New stockadjustment_m;
		$stockadjustmentdata->insert($data);

		//random update
		// $updateStock = $stockIn->take($postdata->input("quantity"));

		// foreach($updateStock as $stockQty){
		// 	$stockIn->where('id',$stockQty->id)->update(['status'=>03]);
		// }
		$serialNumberIdBucket = $postdata->input('serial_number_scan_json');   
		$serialNumberIdArray = json_decode($serialNumberIdBucket);
				foreach($serialNumberIdArray as $stockQty){
			$product_serial_number->where('id',$stockQty)->update(['status'=>'03','updated_by'=>Auth::user()->id,'updated_at'	=> Carbon::now()]);
		}
		
		return redirect('stock/adjustment')
		->with("message","Success Submit Product ".$checkproduct["code"]." (".$checkproduct["description"]."),
			 Adjustment ".$checkadjustment['adjustment'].", Quantity ".$postdata->input("quantity")."");
	}
	
	public function checkSerialNumber(Request $request){
		$product_serial_number = new product_serial_number;

		$serialNumber= $request->get('serialNumber');
		$productId = $request->get('product_id');

		$exist = $product_serial_number->where('serial_number',$serialNumber)->where('product_id',$productId)->first();

		$return = [];
		if($exist){
			$return = ["status"=>true,"id"=>$exist->id];
		}else{
			$return = ["status"=>false,"id"=>''];
		}
		return compact('return');
	}
}
