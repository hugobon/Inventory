<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\configuration\config_deliverytype_m;
use Auth;
class Deliverytype extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
	
	public function index(){
        return redirect('configuration/deliverytype');
    }
	
	public function listing(){
		$deliverytype_data = New config_deliverytype_m;
		$data = array(
			'counttype' => $deliverytype_data->count(),
			'startcount' => 0,
			'deliverytypeArr' => $deliverytype_data->orderBy('id', 'desc')->paginate(20),
		);
		return view('Configuration/deliverytype_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('configuration/deliverytype');
			
		$datadecode = unserialize(base64_decode($x));
		$search = isset($datadecode['search']) ? $datadecode['search'] : '';
		if($search == '')
			return redirect('configuration/deliverytype');
		
		$deliverytype_data = New config_deliverytype_m;
		if($search != ''){
			$deliverytype_data = $deliverytype_data->where(function ($q) use($search){
											$q->where('delivery_code','LIKE','%'. $search .'%')
												->orWhere('type_description','LIKE','%'. $search .'%');
										});
		}
			
		$counttype = $deliverytype_data->count();
		$deliverytypeArr = $deliverytype_data->orderBy('id', 'desc')->paginate(20);
		
		$data = array(
			'counttype' => $counttype,
			'startcount' => 0,
			'deliverytypeArr' => $deliverytypeArr,
			'search' => $search,
		);
        return view('Configuration/deliverytype_listing',$data);
    }
	
	public function form_search(Request $postdata){
		$search = trim($postdata->input("search"));
		
		if($search == '')
			return redirect('configuration/deliverytype');
			
		$rowdata = array(
			'search' => $search,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('configuration/deliverytype/search/' . $base64data);
    }
	
    public function save(Request $postdata){
		$deliverytype_data = New config_deliverytype_m;
		$data = array(
			'delivery_code' => strtoupper(trim($postdata->input("delivery_code"))),
			'type_description' => $postdata->input("type_description") != null ? trim($postdata->input("type_description")) : '',
			'updated_by' => Auth::user()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
			
		$base64 = $postdata->input("base64");
		if($base64 == '' || @unserialize(base64_decode($base64)) == false){
			#insert new Delivery Type
			$data['created_by'] = Auth::user()->id;
			$data['created_at'] = date('Y-m-d H:i:s');
			$deliverytype_data->insert($data);
			
			return redirect('configuration/deliverytype')->with("info","Success Submit " . $data["type_description"] . " (" . $data["delivery_code"] . ")");
		}
		else{
			# update Delivery Type
			$datadecode = unserialize(base64_decode($base64));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			$deliverytype_data->where('id',$selectid)->update($data);
			if($search != '')
				return redirect('configuration/deliverytype/search/' . $search)->with("info","Success Save " . strtoupper(trim($postdata->input("type"))) . "");
			else
				return redirect('configuration/deliverytype')->with("info","Success Save " . $postdata->input("type") . "");
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
		$deliverytype_data = New config_deliverytype_m;
		$countcode = $deliverytype_data->where('delivery_code','=',$code)->where('id','<>', $id)->count();
		if($countcode > 0)
			return 1;
		else
			return 0;
    }

    public function delete($data = ''){
		if(@unserialize(base64_decode($data)) == true){
			$deliverytype_data = New config_deliverytype_m;
			$datadecode = unserialize(base64_decode($data));
			$selectid = isset($datadecode['selectid']) ? $datadecode['selectid'] : 0;
			
			$checkdeliverytype = $deliverytype_data->where('id', $selectid)->first();
			if($checkdeliverytype == false)
				return redirect('configuration/deliverytype')->with("errorid"," Data not found");
			
			$search = isset($datadecode['search']) ? $datadecode['search'] : '';
			
			if($deliverytype_data->where('id', $selectid)->delete()){
				if($search != '')
					return redirect('configuration/deliverytype/search/' . $search)->with("info","Delivery Type " . $checkdeliverytype['type_description'] . " (" . $checkdeliverytype['delivery_code'] . ") Deleted Successfully!!");
				else
					return redirect('configuration/deliverytype')->with("info","Delivery Type " . $checkdeliverytype['type_description'] . " (" . $checkdeliverytype['delivery_code'] . ")  Deleted Successfully!!");
				
			}
		}
    }
}
