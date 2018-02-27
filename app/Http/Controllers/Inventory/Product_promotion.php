<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\product_m;
use App\inventory\product_promotion_m;
use App\inventory\product_promotion_gift_m;
use App\configuration\config_tax_m;

class Product_promotion extends Controller
{
    public function index(){
        return redirect('product/promotion/listing');
    }

    public function listing(){
		$productdata = New product_m;
		$datap = $productdata->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($datap) > 0){
			foreach($datap->all() as $key => $row)
				$productArr[$row->id] = $row->code . ' (' . $row->description . ')';
		}
		$promotiondata = New product_promotion_m;
		$data = array(
			'countpromotion' => $promotiondata->count(),
			'promotionArr' => $promotiondata->orderBy('id', 'desc')->paginate(10),
			'productArr' => $productArr,
			'statusArr' => array( '1' => 'On','0' => 'Off'),
		);
        return view('Inventory/promotion_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('product/promotion/listing');
			
		$datadecode = unserialize(base64_decode($x));
		$search_product = isset($datadecode['search_product']) ? $datadecode['search_product'] : '';
		$search_status = isset($datadecode['search_status']) ? $datadecode['search_status'] : '';
		if($search_product == '' && $search_status == '')
			return redirect('product/promotion/listing');
		$promotiondata = New product_promotion_m;
		if($search_product != '' && $search_status != ''){
			$countpromotion = $promotiondata->where('product_id',$search_product)
												->where('status',$search_status)->count();
			$promotionArr = $promotiondata->where('product_id',$search_product)
												->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		else if($search_product != ''){
			$countpromotion = $promotiondata->where('product_id',$search_product)->count();
			$promotionArr = $promotiondata->where('product_id',$search_product)->orderBy('id', 'desc')->paginate(10);
		}
		else{
			$countpromotion = $promotiondata->where('status',$search_status)->count();
			$promotionArr = $promotiondata->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		
		$productdata = New product_m;
		$data = $productdata->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($data) > 0){
			foreach($data->all() as $key => $row)
				$productArr[$row->id] = $row->code . ' (' . $row->description . ')';
		}
		$data = array(
			'countpromotion' => $countpromotion,
			'promotionArr' => $promotionArr,
			'productArr' => $productArr,
			'statusArr' => array( '1' => 'On','0' => 'Off'),
			'search_product' => $search_product,
			'search_status' => $search_status,
		);
        return view('Inventory/promotion_listing',$data);
    }
	

    public function form_search(Request $postdata){
		$search_product = trim($postdata->input("search_product"));
		$search_status = trim($postdata->input("search_status"));
		
		if($search_product == '' && $search_status == '')
			return redirect('product/promotion/listing');
			
		$rowdata = array(
			'search_product' => $search_product,
			'search_status' => $search_status,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('product/promotion/search/' . $base64data);
    }

    public function form(){
		# get Tax GST percentage
		$taxgst = config_tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
		
		$productdata = New product_m;
		$datap = $productdata->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($datap) > 0){
			foreach($datap->all() as $key => $row)
				$productArr[$row->id] = $row->code . ' (' . $row->description . ')';
		}
		$data = array();
		$data['gstpercentage'] = $gstpercentage;
		$data['productArr'] = $productArr;
		return view('Inventory/product_promotion_form',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
