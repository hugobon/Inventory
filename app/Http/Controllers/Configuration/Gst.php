<?php

namespace App\Http\Controllers\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\configuration\tax_m;

class Gst extends Controller{
    public function index(){
		return redirect('configuration/gst');
    }
	
    public function view(){
        $taxdata = New tax_m;
		$data =  $taxdata->where('code', 'gst')->first();
		if($data == false){
			#create if gst not found
			$insertdata = array(
				'code' => 'gst',
				'percent' => 6, # GST on 01-03-2018
				'remarks' => 'default : 6%',
				'created_by' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_by' => 1,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$taxdata->insert($insertdata);
			$data =  $taxdata->where('code', 'gst')->first();
		}
		
		return view('Configuration/tax_gst_view',$data);
    }
	
	public function form(){
        $taxdata = New tax_m;
		$data =  $taxdata->where('code', 'gst')->first();
		if($data == false){
			#create if gst not found
			$insertdata = array(
				'code' => 'gst',
				'percent' => 6, # GST on 01-03-2018
				'remarks' => 'default : 6%',
				'created_by' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_by' => 1,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$taxdata->insert($insertdata);
			$data =  $taxdata->where('code', 'gst')->first();
		}
		
		return view('Configuration/tax_gst_form',$data);
    }
	
	public function update(Request $postdata){
		$taxdata = New tax_m;
		$this->validate($postdata,[
			'percent' => 'required',
		]);
		$percent = $postdata->input("percent");
		if($percent > 0)
			$percent = $percent;
		else
			$percent = 0;
		$data =  $taxdata->where('code', 'gst')->first();
		if($data == false){
			#create if gst not found
			$insertdata = array(
				'code' => 'gst',
				'percent' => $percent, # GST on 01-03-2018
				'remarks' => 'set : ' . $percent . '%',
				'created_by' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_by' => 1,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$taxdata->insert($insertdata);
		}
		else{
			$data = array(
				'percent' => $percent,
				'remarks' => $postdata->input("remarks"),
				'updated_by' => 1,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$taxdata = New tax_m;
			$taxdata->where('code','gst')->update($data);
		}
		
		return redirect('configuration/gst')->with("info","Success Save Tax GST");
    }
}
