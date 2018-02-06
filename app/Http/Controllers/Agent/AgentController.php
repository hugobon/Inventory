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
    	
    }
}
