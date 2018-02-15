<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentController extends Controller
{
    public function fn_get_view(){
    	return view('Agent/agent_register');
    }

    public function fn_save_agent_record(Request $request){

    	try{

    		$data = Array(

    			'agent_type' => $request->get('agent_type'),
    			'agent_username' => $request->get('agent_username'),
    			'agent_name' => $request->get('agent_name'),
    		);

    		echo "<pre>";
    		echo print_r($data);
    		echo "</pre>";
    		die();

    	}
    	catch(\Exception $e){

    	}
    	
    }
}
