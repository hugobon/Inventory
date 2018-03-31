<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\configuration\config_quantitytype_m;

class Quantitytype extends Controller
{
	public function index(){
        return redirect('configuration/quantitytype');
    }
	
	public function listing(){
		$quantitytypedata = New config_quantitytype_m;
		$data = array(
			'counttype' => $quantitytypedata->count(),
			'startcount' => 0,
			'typeArr' => $quantitytypedata->orderBy('id', 'desc')->paginate(10),
			'status' => array( '1' => 'Active','0' => 'Inactive'),
		);
		return view('Configuration/quantitytype_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('configuration/quantitytype');
			
		$datadecode = unserialize(base64_decode($x));
		$search = isset($datadecode['search']) ? $datadecode['search'] : '';
		$search_status = isset($datadecode['search_status']) ? $datadecode['search_status'] : '';
		if($search == '' && $search_status == '')
			return redirect('configuration/quantitytype');
		
		$quantitytypedata = New config_quantitytype_m;
		if($search != '' && $search_status != ''){
			$counttype = $quantitytypedata->where(function ($q) use($search){
											$q->where('type','LIKE','%'. $search .'%')
												->orWhere('remarks','LIKE','%'. $search .'%');
										})
										->where('status',$search_status)
										->count();
			$typeArr = $quantitytypedata->where(function ($q) use($search){
											$q->where('type','LIKE','%'. $search .'%')
												->orWhere('remarks','LIKE','%'. $search .'%');
										})
										->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		else if($search != ''){
			$counttype = $quantitytypedata->where('type','LIKE','%'. $search .'%')
										->orWhere('remarks','LIKE','%'. $search .'%')
										->count();
			$typeArr = $quantitytypedata->where('type','LIKE','%'. $search .'%')
										->orWhere('remarks','LIKE','%'. $search .'%')->orderBy('id', 'desc')->paginate(10);
		}
		else{
			$counttype = $quantitytypedata->where('status',$search_status)
										->count();
			$typeArr = $quantitytypedata->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		
		$data = array(
			'counttype' => $counttype,
			'startcount' => 0,
			'typeArr' => $typeArr,
			'status' => array( '1' => 'Active','0' => 'Inactive'),
			'search' => $search,
			'search_status' => $search_status,
		);
        return view('Configuration/quantitytype_listing',$data);
    }
	
	public function form_search(Request $postdata){
		$search = trim($postdata->input("search"));
		$search_status = trim($postdata->input("search_status"));
		
		if($search == '' && $search_status == '')
			return redirect('configuration/quantitytype');
			
		$rowdata = array(
			'search' => $search,
			'search_status' => $search_status,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('configuration/quantitytype/search/' . $base64data);
    }
	
    public function save(Request $postdata){
		$quantitytypedata = New config_quantitytype_m;
		$data = array(
			'type' => strtoupper(trim($postdata->input("type"))),
			'remarks' => $postdata->input("remarks"),
			'status' => $postdata->input("status"),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
			
		$base64 = $postdata->input("base64");
		if($base64 == '' || @unserialize(base64_decode($base64)) == false){
			#insert new Quantity Type
			$data['created_by'] = 1;
			$data['created_at'] = date('Y-m-d H:i:s');
			$quantitytypedata->insert($data);
			
			return redirect('configuration/quantitytype')->with("info","Success Submit " . strtoupper(trim($postdata->input("type"))) . "");
		}
		else{
			# update Quantity Type
			$datadecode = unserialize(base64_decode($base64));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			$quantitytypedata->where('id',$selectid)->update($data);
			if($search != '')
				return redirect('configuration/quantitytype/search/' . $search)->with("info","Success Save " . strtoupper(trim($postdata->input("type"))) . "");
			else
				return redirect('configuration/quantitytype')->with("info","Success Save " . $postdata->input("type") . "");
		}
	}

    public function delete($data = ''){
		if(@unserialize(base64_decode($data)) == true){
			$quantitytypedata = New config_quantitytype_m;
			$datadecode = unserialize(base64_decode($data));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			
			$checkquantitytype = $quantitytypedata->where('id', $selectid)->first();
			if($checkquantitytype == false)
				return redirect('configuration/quantitytype')->with("errorid"," Data not found");
			
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			if($checkquantitytype['picture_path'] != ''){
				# remove image after delete
				Storage::delete('public/' . $checkquantitytype['picture_path']);
			}
			
			if($quantitytypedata->where('id', $selectid)->delete()){
				if($search != '')
					return redirect('configuration/quantitytype/search/' . $search)->with("info","Quantity Type " . $checkquantitytype['type'] . " Deleted Successfully!!");
				else
					return redirect('configuration/quantitytype')->with("info","Quantity Type " . $checkquantitytype['type'] . "  Deleted Successfully!!");
				
			}
		}
    }
}
