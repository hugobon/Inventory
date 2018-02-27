<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\agentmaster;
use App\users;
use App\agent_order_stock;
use Auth;

class AgentController extends Controller
{
    public function fn_get_view(){
    	return view('Agent.agent_register');
    }

    public function fn_save_agent_record(Request $request){

    	try{

    		$data = [

    			'agent_type' => $request->get('agent_type'),
    			'agent_username' => $request->get('agent_username'),
    			'agent_name' => $request->get('agent_name'),
    			'agent_date_of_birth' => $request->get('agent_dateofbirth'),
    			'agent_gender' => $request->get('agent_gender'),
    			'agrnt_marital_status' => $request->get('agent_marital_status'),
    			'agent_race' => $request->get('agent_race'),
    			'agent_id_type' => $request->get('agent_id_type'),
    			'agent_id' => $request->get('agent_id'),
    			'agent_photo_id' => $request->get('agent_photo_id'),
    			'agent_profile_photo' => $request->get('agent_profile_photo'),
    			'agent_mobile_no' => $request->get('agent_number'),
    			'agent_email' => $request->get('agent_email'),
    			'agent_street' => $request->get('agent_address_street'),
    			'agent_postcode' => $request->get('agent_address_poscode'),
    			'agent_city' => $request->get('agent_address_city'),
    			'agent_country' => $request->get('agent_address_country'),
    			'agent_bank_name' => $request->get('agent_bank_name'),
    			'agent_bank_acc_no' => $request->get('agent_bank_acc_no'),
    			'agent_bank_acc_name' => $request->get('agent_bank_acc_name'),
    			'agent_bank_acc_type' => $request->get('agent_bank_acc_type'),
    			'agent_delivery_type' =>$request->get('agent_delivery_type'),
    			'agent_payment_type' => $request->get('agent_payment_type'),
    			'agent_secqurity_pass' => $request->get('agent_secqurity_pass'),
    			'agent_benefical_name' => $request->get('agent_call_name')

    		];

    		$data['created_by'] = Auth::user()->name;
    		$data['created_at'] = \Carbon\Carbon::now();

    		// echo "<pre>";
    		// echo print_r($data);
    		// echo "</pre>";
    		// die();

    		agentmaster::insert($data);

    		$return['message'] = 'succssfuly';
    		$return['status'] = '01';

    	}
    	catch(\Exception $e){

    		$return['message'] = $e->getMessage();
    		$return['status'] = '02';

    	}
    	return redirect('agent/view');
    }

    function fn_view_agent_record(){

    	try{

    		// $data = agentmaster::
    		$data = [

    			'name' => "amin"
    		];

    		$return['message'] = 'succssfuly';
    		$return['status'] = '01';
    	}
    	catch(\Exception $e){

    		$return['message'] = $e->getMessage();
    		$return['status'] = '02';
    	}

    	return view('Agent.agent_view')->with($data);
    }

    public function fn_get_agent_order_stock($agent_id = null){

        try{

           $data = agent_order_stock::select('agent_id','country','delivery_type','optional','poscode','city','state')
                                ->where('agent_id',$agent_id)
                                ->first();

            $return['message'] = 'succssfuly';
            $return['status'] = '01';
        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = '02';
        }

        
        if(isset($data)){
            // return $data;
            return view('Agent.agent_order_stock',['return' => $return,'data' => $data]);
        }
        else{

            $data = [ 

                'agent_id' => $agent_id,
                'country' => "",
                'delivery_type' => "",
                'optional' => "",
                'poscode' => "",
                'city' => "",
                'state' => ""
             ];
            // return $data;
            return view('Agent.agent_order_stock',['return' => $return,'data' => $data]);
        }
    }

    public function fn_save_agent_order_stock(Request $request){

        try{

            $data = [

                'agent_id' => $request->get('agent_id'),
                'country' => $request->get('country'),
                'delivery_type' => $request->get('delivery_type'),
                'optional' => $request->get('optional'),
                'poscode' => $request->get('poscode'),
                'city' => $request->get('city'),
                'state' => $request->get('state')
            ];

            $data['created_by'] = Auth::user()->name;
            $data['created_at'] = \Carbon\Carbon::now();

            // print_r($data);
            // die();

            agent_order_stock::insert($data);

            $return['message'] = 'succssfuly';
            $return['status'] = '01';
        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = '02';
        }

        // return $return;

        return redirect('agent/order_stock')->with('return');
    }
}
