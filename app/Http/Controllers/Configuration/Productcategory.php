<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\configuration\config_productcategory_m;

class Productcategory extends Controller
{
	public function index(){
        return redirect('configuration/productcategory');
    }
	
	public function listing(){
		$productcategorydata = New config_productcategory_m;
		$data = array(
			'countcategory' => $productcategorydata->count(),
			'startcount' => 0,
			'categoryArr' => $productcategorydata->orderBy('id', 'desc')->paginate(20),
			'status' => array( '1' => 'Active','0' => 'Inactive'),
		);
		return view('Configuration/productcategory_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('configuration/productcategory');
			
		$datadecode = unserialize(base64_decode($x));
		$search = isset($datadecode['search']) ? $datadecode['search'] : '';
		$search_status = isset($datadecode['search_status']) ? $datadecode['search_status'] : '';
		if($search == '' && $search_status == '')
			return redirect('configuration/productcategory');
		
		$productcategorydata = New config_productcategory_m;
		if($search != ''){
			$productcategorydata = $productcategorydata->where(function ($q) use($search){
											$q->where('category','LIKE','%'. $search .'%')
												->orWhere('remarks','LIKE','%'. $search .'%');
										});
		}
		if($search_status != '')
			$productcategorydata = $productcategorydata->where('status',$search_status);
			
		$countcategory = $productcategorydata->count();
		$categoryArr = $productcategorydata->orderBy('id', 'desc')->paginate(20);
		
		
		$data = array(
			'countcategory' => $countcategory,
			'startcount' => 0,
			'categoryArr' => $categoryArr,
			'status' => array( '1' => 'Active','0' => 'Inactive'),
			'search' => $search,
			'search_status' => $search_status,
		);
        return view('Configuration/productcategory_listing',$data);
    }
	
	public function form_search(Request $postdata){
		$search = trim($postdata->input("search"));
		$search_status = trim($postdata->input("search_status"));
		
		if($search == '' && $search_status == '')
			return redirect('configuration/productcategory');
			
		$rowdata = array(
			'search' => $search,
			'search_status' => $search_status,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('configuration/productcategory/search/' . $base64data);
    }
	
    public function save(Request $postdata){
		$productcategorydata = New config_productcategory_m;
		$data = array(
			'category' => trim($postdata->input("category")),
			'remarks' => $postdata->input("remarks"),
			'status' => $postdata->input("status"),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
			
		$base64 = $postdata->input("base64");
		if($base64 == '' || @unserialize(base64_decode($base64)) == false){
			#insert new Product Category
			$data['created_by'] = 1;
			$data['created_at'] = date('Y-m-d H:i:s');
			$productcategorydata->insert($data);
			
			return redirect('configuration/productcategory')->with("info","Success Submit " . strtoupper(trim($postdata->input("category"))) . "");
		}
		else{
			# update Product Category
			$datadecode = unserialize(base64_decode($base64));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			$productcategorydata->where('id',$selectid)->update($data);
			if($search != '')
				return redirect('configuration/productcategory/search/' . $search)->with("info","Success Save " . strtoupper(trim($postdata->input("category"))) . "");
			else
				return redirect('configuration/productcategory')->with("info","Success Save " . $postdata->input("category") . "");
		}
	}

    public function delete($data = ''){
		if(@unserialize(base64_decode($data)) == true){
			$productcategorydata = New config_productcategory_m;
			$datadecode = unserialize(base64_decode($data));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			
			$checkproductcategory = $productcategorydata->where('id', $selectid)->first();
			if($checkproductcategory == false)
				return redirect('configuration/productcategory')->with("errorid"," Data not found");
			
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			if($checkproductcategory['picture_path'] != ''){
				# remove image after delete
				Storage::delete('public/' . $checkproductcategory['picture_path']);
			}
			
			if($productcategorydata->where('id', $selectid)->delete()){
				if($search != '')
					return redirect('configuration/productcategory/search/' . $search)->with("info","Product Category " . $checkproductcategory['category'] . " Deleted Successfully!!");
				else
					return redirect('configuration/productcategory')->with("info","Product Category " . $checkproductcategory['category'] . "  Deleted Successfully!!");
				
			}
		}
    }
}
