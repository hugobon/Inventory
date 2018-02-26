<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\product_m;
use App\inventory\stockadjustment_m;
use App\configuration\config_stockadjustment_m;

class Stockadjustment extends Controller
{
    public function index(){
        return redirect('stock/adjustment/listing');
    }
	
	public function listing(){
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
        return view('Inventory/stockadjustment_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('stock/adjustment/listing');
			
		$datadecode = unserialize(base64_decode($x));
		$search_product = isset($datadecode['search_product']) ? $datadecode['search_product'] : '';
		$search_adjustment = isset($datadecode['search_adjustment']) ? $datadecode['search_adjustment'] : '';
		if($search_product == '' && $search_adjustment == '')
			return redirect('stock/adjustment/listing');
		$stockadjustmentdata = New stockadjustment_m;
		if($search_product != '' && $search_adjustment != ''){
			$countstockadjustment = $stockadjustmentdata->where('product_id',$search_product)
												->where('adjustment_id',$search_adjustment)->count();
			$stockadjustmentArr = $stockadjustmentdata->where('product_id',$search_product)
												->where('adjustment_id',$search_adjustment)->orderBy('id', 'desc')->paginate(10);
		}
		else if($search_product != ''){
			$countstockadjustment = $stockadjustmentdata->where('product_id',$search_product)->count();
			$stockadjustmentArr = $stockadjustmentdata->where('product_id',$search_product)->orderBy('id', 'desc')->paginate(10);
		}
		else{
			$countstockadjustment = $stockadjustmentdata->where('adjustment_id',$search_adjustment)->count();
			$stockadjustmentArr = $stockadjustmentdata->where('adjustment_id',$search_adjustment)->orderBy('id', 'desc')->paginate(10);
		}
		
		
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
			'countstockadjustment' => $countstockadjustment,
			'stockadjustmentArr' => $stockadjustmentArr,
			'adjustmentArr' => $adjustmentArr,
			'productArr' => $productArr,
			'search_product' => $search_product,
			'search_adjustment' => $search_adjustment,
		);
        return view('Inventory/stockadjustment_listing',$data);
    }
	
	public function form_search(Request $postdata){
		$search_product = trim($postdata->input("search_product"));
		$search_adjustment = trim($postdata->input("search_adjustment"));
		
		if($search_product == '' && $search_adjustment == '')
			return redirect('stock/adjustment/listing');
			
		$rowdata = array(
			'search_product' => $search_product,
			'search_adjustment' => $search_adjustment,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('stock/adjustment/search/' . $base64data);
    }
	
	public function submit(Request $postdata){
		$this->validate($postdata,[
			'product_id' => 'required',
			'adjustment_id' => 'required',
			'quantity' => 'required',
		]);
		
		$checkproduct = product_m::where('id', $postdata->input("product_id"))->first();
		if($checkproduct == false)
			return redirect('stock/adjustment/listing')->with("errorid"," Product Not Found ");
			
		$checkadjustment = config_stockadjustment_m::where('id', $postdata->input("adjustment_id"))->first();
		if($checkadjustment == false)
			return redirect('stock/adjustment/listing')->with("errorid"," Configuration Stock Adjustment Not Found ");
			
		$data = array(
			'product_id' => $postdata->input("product_id"),
			'product_name' => $checkproduct["code"]." (".$checkproduct["description"].")",
			'adjustment_id' => $postdata->input("adjustment_id"),
			'quantity' => $postdata->input("quantity"),
			'remarks' => $postdata->input("remarks"),
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$stockadjustmentdata = New stockadjustment_m;
		$stockadjustmentdata->insert($data);
		
		return redirect('stock/adjustment/listing')
		->with("info","Success Submit Product ".$checkproduct["code"]." (".$checkproduct["description"]."),
			 Adjustment ".$checkadjustment['adjustment'].", Quantity ".$postdata->input("quantity")."");
    }
	
    public function delete($data = ''){
		if(@unserialize(base64_decode($data)) == true){
			$datadecode = unserialize(base64_decode($data));
			$delete = isset($datadecode['delete']) ? $datadecode['delete'] : '';
			$fullrow = isset($datadecode['fullrow']) ? $datadecode['fullrow'] : '';
			$deleteid = isset($datadecode['deleteid']) ? $datadecode['deleteid'] : 0;
			if($delete == 'stockadjustment' && $deleteid > 0){
				$checkproduct = stockadjustment_m::where('id', $deleteid)->first();
				if($checkproduct == false)
					return redirect('stock/adjustment/listing')->with("errorid"," Data not found");
				
				$search = isset($datadecode['search']) ? $datadecode['search'] : '';
				if(stockadjustment_m::where('id', $deleteid)->delete()){
					if($search != '')
						return redirect('stock/adjustment/search/' . $search)->with("info","Stock Adjustment " . $fullrow . " Deleted Successfully!!");
					else
						return redirect('stock/adjustment/listing')->with("info","Stock Adjustment " . $fullrow . " Deleted Successfully!!");
					
				}
			}
		}
		return redirect('stock/adjustment/listing');
    }
}
