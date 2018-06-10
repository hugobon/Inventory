<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\configuration\config_courier_m;
use Auth;
class Courier extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
	
	public function index(){
        return redirect('configuration/courier');
    }
	
	public function listing(){
		$courierdata = New config_courier_m;
		$data = array(
			'counttype' => $courierdata->count(),
			'startcount' => 0,
			'courierArr' => $courierdata->orderBy('id', 'desc')->paginate(20),
		);
		return view('Configuration/courier_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('configuration/courier');
			
		$datadecode = unserialize(base64_decode($x));
		$search = isset($datadecode['search']) ? $datadecode['search'] : '';
		if($search == '')
			return redirect('configuration/courier');
		
		$courierdata = New config_courier_m;
		if($search != ''){
			$courierdata = $courierdata->where(function ($q) use($search){
											$q->where('courier_code','LIKE','%'. $search .'%')
												->orWhere('courier_name','LIKE','%'. $search .'%')
												->orWhere('tel','LIKE','%'. $search .'%')
												->orWhere('email','LIKE','%'. $search .'%');
										});
		}
			
		$counttype = $courierdata->count();
		$courierArr = $courierdata->orderBy('id', 'desc')->paginate(20);
		
		$data = array(
			'counttype' => $counttype,
			'startcount' => 0,
			'courierArr' => $courierArr,
			'search' => $search,
		);
        return view('Configuration/courier_listing',$data);
    }
	
	public function form_search(Request $postdata){
		$search = trim($postdata->input("search"));
		
		if($search == '')
			return redirect('configuration/courier');
			
		$rowdata = array(
			'search' => $search,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('configuration/courier/search/' . $base64data);
    }
	
    public function save(Request $postdata){
		$courierdata = New config_courier_m;
		$data = array(
			'courier_code' => strtoupper(trim($postdata->input("courier_code"))),
			'courier_name' => strtoupper(trim($postdata->input("courier_name"))),
			'address' => $postdata->input("address") != null ? $postdata->input("address") : '',
			'tel' => $postdata->input("tel") != null ? $postdata->input("tel") : '',
			'fax' => $postdata->input("fax") != null ? $postdata->input("fax") : '',
			'email' => $postdata->input("email") != null ? $postdata->input("email") : '',
			'updated_by' => Auth::user()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
			
		$base64 = $postdata->input("base64");
		if($base64 == '' || @unserialize(base64_decode($base64)) == false){
			#insert new Courier
			$data['created_by'] = Auth::user()->id;
			$data['created_at'] = date('Y-m-d H:i:s');
			$courierdata->insert($data);
			
			return redirect('configuration/courier')->with("info","Success Submit " . $data["courier_name"] . " (" . $data["courier_code"] . ")");
		}
		else{
			# update Courier
			$datadecode = unserialize(base64_decode($base64));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			$courierdata->where('id',$selectid)->update($data);
			if($search != '')
				return redirect('configuration/courier/search/' . $search)->with("info","Success Save " . strtoupper(trim($postdata->input("type"))) . "");
			else
				return redirect('configuration/courier')->with("info","Success Save " . $postdata->input("type") . "");
		}
	}
	
	public function check_existcode(Request $postdata){
		$base64 = $postdata->input("base64");
		if($base64 == '' || @unserialize(base64_decode($base64)) == false)
			$id = 0;
		else{
			$datadecode = unserialize(base64_decode($base64));
			$id = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;	
		}
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$courierdata = New config_courier_m;
		$countcode = $courierdata->where('courier_code','=',$code)->where('id','<>', $id)->count();
		if($countcode > 0)
			return 1;
		else
			return 0;
    }

    public function delete($data = ''){
		if(@unserialize(base64_decode($data)) == true){
			$courierdata = New config_courier_m;
			$datadecode = unserialize(base64_decode($data));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			
			$checkcourier = $courierdata->where('id', $selectid)->first();
			if($checkcourier == false)
				return redirect('configuration/courier')->with("errorid"," Data not found");
			
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			if($courierdata->where('id', $selectid)->delete()){
				if($search != '')
					return redirect('configuration/courier/search/' . $search)->with("info","Courier " . $checkcourier['courier_name'] . " (" . $checkcourier['courier_code'] . ") Deleted Successfully!!");
				else
					return redirect('configuration/courier')->with("info","Courier " . $checkcourier['courier_name'] . " (" . $checkcourier['courier_code'] . ")  Deleted Successfully!!");
				
			}
		}
    }
}
