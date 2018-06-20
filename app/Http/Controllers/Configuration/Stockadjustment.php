<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\configuration\config_stockadjustment_m;
use Auth;
class Stockadjustment extends Controller
{
	private $statusArr = array( 
		'1' => '<span class="text-success bold"> Active </span>',
		'0' => '<span class="text-danger bold"> Inactive </span>',
	);
	
	private $OperatorArr = array( 
		'0' => '', 
		'-' => '<span class="font-orange bold" title="Adjustment - " > Minus </span>',
		'+' => '<span class="font-darkblue bold" title="Adjustment + " > Add </span>',
	);
	
	public function __construct(){
        $this->middleware('auth');
    }
	
	public function index(){
        return redirect('configuration/stockadjustment');
    }
	
	public function listing(){
		$stockadjustmentdata = New config_stockadjustment_m;
		$data = array(
			'countadjustment' => $stockadjustmentdata->count(),
			'startcount' => 0,
			'adjustmentArr' => $stockadjustmentdata->orderBy('id', 'desc')->paginate(10),
			'status' => $this->statusArr,
			'OperatorArr' => $this->OperatorArr,
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
		
		$stockadjustmentdata = New config_stockadjustment_m;
		if($search != '' && $search_status != ''){
			$countadjustment = $stockadjustmentdata->where(function ($q) use($search){
											$q->where('adjustment','LIKE','%'. $search .'%')
												->orWhere('remarks','LIKE','%'. $search .'%');
										})
										->where('status',$search_status)
										->count();
			$adjustmentArr = $stockadjustmentdata->where(function ($q) use($search){
											$q->where('adjustment','LIKE','%'. $search .'%')
												->orWhere('remarks','LIKE','%'. $search .'%');
										})
										->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		else if($search != ''){
			$countadjustment = $stockadjustmentdata->where('adjustment','LIKE','%'. $search .'%')
										->orWhere('remarks','LIKE','%'. $search .'%')
										->count();
			$adjustmentArr = $stockadjustmentdata->where('adjustment','LIKE','%'. $search .'%')
										->orWhere('remarks','LIKE','%'. $search .'%')->orderBy('id', 'desc')->paginate(10);
		}
		else{
			$countadjustment = $stockadjustmentdata->where('status',$search_status)
										->count();
			$adjustmentArr = $stockadjustmentdata->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		
		$data = array(
			'countadjustment' => $countadjustment,
			'startcount' => 0,
			'adjustmentArr' => $adjustmentArr,
			'status' => $this->statusArr,
			'search' => $search,
			'OperatorArr' => $this->OperatorArr,
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
		$stockadjustmentdata = New config_stockadjustment_m;
		$data = array(
			'adjustment' => $postdata->input("adjustment"),
			'remarks' => $postdata->input("remarks") != null ? $postdata->input("remarks") : '',
			'operation' => $postdata->input("operator") != null ? $postdata->input("operator") : '',
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'updated_by' => Auth::user()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
			
		$base64 = $postdata->input("base64");
		if($base64 == '' || @unserialize(base64_decode($base64)) == false){
			#insert new stock stockadjustment
			$data['created_by'] = Auth::user()->id;
			$data['created_at'] = date('Y-m-d H:i:s');
			$stockadjustmentdata->insert($data);
			
			return redirect('configuration/stockadjustment')->with("info","Success Submit " . $postdata->input("adjustment") . "");
		}
		else{
			# update stock stockadjustment
			$datadecode = unserialize(base64_decode($base64));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			$stockadjustmentdata->where('id',$selectid)->update($data);
			if($search != '')
				return redirect('configuration/stockadjustment/search/' . $search)->with("info","Success Save " . $postdata->input("adjustment") . "");
			else
				return redirect('configuration/stockadjustment')->with("info","Success Save " . $postdata->input("adjustment") . "");
		}
	}

    public function delete($data = ''){
		if(@unserialize(base64_decode($data)) == true){
			$stockadjustmentdata = New config_stockadjustment_m;
			$datadecode = unserialize(base64_decode($data));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			
			$checkstockadjustment = $stockadjustmentdata->where('id', $selectid)->first();
			if($checkstockadjustment == false)
				return redirect('configuration/stockadjustment')->with("errorid"," Data not found");
			
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			if($checkstockadjustment['picture_path'] != ''){
				# remove image after delete
				Storage::delete('public/' . $checkstockadjustment['picture_path']);
			}
			
			if($stockadjustmentdata->where('id', $selectid)->delete()){
				if($search != '')
					return redirect('configuration/stockadjustment/search/' . $search)->with("info","Stock Adjustment " . $checkstockadjustment['adjustment'] . " Deleted Successfully!!");
				else
					return redirect('configuration/stockadjustment')->with("info","Stock stockadjustment " . $checkstockadjustment['adjustment'] . "  Deleted Successfully!!");
				
			}
		}
    }
}
