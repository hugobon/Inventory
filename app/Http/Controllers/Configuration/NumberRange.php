<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\global_nr;
use Auth;

class NumberRange extends Controller
{
	public function fn_get_nr_list(){

		return view('Configuration/number_range');
	}

}