<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\configuration\stockadjustment_m;

class Stockadjustment extends Controller
{
	public function index(){
        return redirect('configuration/stockadjustment');
    }
	
	public function listing(){
		$adjustmentdata = New stockadjustment_m;
		$data = array(
			'countadjustment' => $adjustmentdata->count(),
			'startcount' => 0,
			'adjustmentArr' => $adjustmentdata->orderBy('id', 'desc')->paginate(10),
			'status' => array( '1' => 'Active','0' => 'Inactive'),
		);
		return view('Configuration/stockadjustment_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('configuration/stockadjustment');
			
		$datadecode = unserialize(base64_decode($x));
		$search = isset($datadecode['search']) ? $datadecode['search'] : '';
		$search_status = isset($datadecode['search_status']) ? $datadecode['search_status'] : '';
		if($search == '' && $search_status == '')
			return redirect('configuration/stockadjustment');
		
		$adjustmentdata = New stockadjustment_m;
		if($search != '' && $search_status != ''){
			$countadjustment = $adjustmentdata->where(function ($q) use($search){
											$q->where('adjustment','LIKE','%'. $search .'%')
												->orWhere('remarks','LIKE','%'. $search .'%');
										})
										->where('status',$search_status)
										->count();
			$adjustmentArr = $adjustmentdata->where(function ($q) use($search){
											$q->where('adjustment','LIKE','%'. $search .'%')
												->orWhere('remarks','LIKE','%'. $search .'%');
										})
										->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		else if($search != ''){
			$countadjustment = $adjustmentdata->where('adjustment','LIKE','%'. $search .'%')
										->orWhere('remarks','LIKE','%'. $search .'%')
										->count();
			$adjustmentArr = $adjustmentdata->where('adjustment','LIKE','%'. $search .'%')
										->orWhere('remarks','LIKE','%'. $search .'%')->orderBy('id', 'desc')->paginate(10);
		}
		else{
			$countadjustment = $adjustmentdata->where('status',$search_status)
										->count();
			$adjustmentArr = $adjustmentdata->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		
		$data = array(
			'countadjustment' => $countadjustment,
			'startcount' => 0,
			'adjustmentArr' => $adjustmentArr,
			'status' => array( '1' => 'Active','0' => 'Inactive'),
			'search' => $search,
			'search_status' => $search_status,
		);
        return view('Configuration/stockadjustment_listing',$data);
    }
	
	public function form_search(Request $postdata){
		$search = trim($postdata->input("search"));
		$search_status = trim($postdata->input("search_status"));
		
		if($search == '' && $search_status == '')
			return redirect('configuration/stockadjustment');
			
		$rowdata = array(
			'search' => $search,
			'search_status' => $search_status,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('configuration/stockadjustment/search/' . $base64data);
    }
	
    public function save(Request $postdata){
		$adjustmentdata = New stockadjustment_m;
		$data = array(
			'adjustment' => $postdata->input("adjustment"),
			'remarks' => $postdata->input("remarks"),
			'status' => $postdata->input("status"),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
			
		$base64 = $postdata->input("base64");
		if($base64 == '' || @unserialize(base64_decode($base64)) == false){
			#insert new stock Adjustment
			$data['created_by'] = 1;
			$data['created_at'] = date('Y-m-d H:i:s');
			$adjustmentdata->insert($data);
			
			return redirect('configuration/stockadjustment')->with("info","Success Submit " . $postdata->input("adjustment") . "");
		}
		else{
			# update stock Adjustment
			$datadecode = unserialize(base64_decode($base64));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			$adjustmentdata->where('id',$selectid)->update($data);
			if($search != '')
				return redirect('configuration/stockadjustment/search/' . $search)->with("info","Success Save " . $postdata->input("adjustment") . "");
			else
				return redirect('configuration/stockadjustment')->with("info","Success Save " . $postdata->input("adjustment") . "");
		}
	}

    public function delete($data = ''){
		$adjustmentdata = New stockadjustment_m;
        $datadecode = unserialize(base64_decode($data));
		$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
		
		$checkadjustment = $adjustmentdata->where('id', $selectid)->first();
		if($checkadjustment == false)
			return redirect('configuration/stockadjustment')->with("errorid"," Data not found");
		
		$search = isset($datadecode['search']) ? $datadecode['search'] : '';
		
		if($checkadjustment['picture_path'] != ''){
			# remove image after delete
			Storage::delete('public/' . $checkadjustment['picture_path']);
		}
		
		if($adjustmentdata->where('id', $selectid)->delete()){
			if($search != '')
				return redirect('configuration/stockadjustment/search/' . $search)->with("info","Stock Adjustment " . $checkadjustment['adjustment'] . " Deleted Successfully!!");
			else
				return redirect('configuration/stockadjustment')->with("info","Stock Adjustment " . $checkadjustment['adjustment'] . "  Deleted Successfully!!");
			
		}
    }
}
