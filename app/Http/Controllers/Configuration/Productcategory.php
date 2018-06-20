<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\configuration\config_productcategory_m;
use Auth;
class Productcategory extends Controller
{

	private $statusArr = array( 
		'1' => '<span class="text-success bold"> Active </span>',
		'0' => '<span class="text-danger bold"> Inactive </span>',
	);
	
	public function __construct(){
        $this->middleware('auth');
    }
	
	public function index(){
        return redirect('configuration/productcategory');
    }
	
	public function listing(){
		$productcategorydata = New config_productcategory_m;
		$data = array(
			'countcategory' => $productcategorydata->count(),
			'startcount' => 0,
			'categoryArr' => $productcategorydata->orderBy('id', 'desc')->paginate(20),
			'status' => $this->statusArr,
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
			'status' => $this->statusArr,
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
			'category' => strtoupper(trim($postdata->input("category"))),
			'remarks' => $postdata->input("remarks") != null ? $postdata->input("remarks") : '',
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'updated_by' => Auth::user()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
			
		$base64 = $postdata->input("base64");
		if($base64 == '' || @unserialize(base64_decode($base64)) == false){
			#insert new Product Category
			$data['created_by'] = Auth::user()->id;
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
			if($productcategorydata->where('id', $selectid)->delete()){
				if($search != '')
					return redirect('configuration/productcategory/search/' . $search)->with("info","Product Category " . $checkproductcategory['category'] . " Deleted Successfully!!");
				else
					return redirect('configuration/productcategory')->with("info","Product Category " . $checkproductcategory['category'] . "  Deleted Successfully!!");
				
			}
		}
    }
}
