<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;

use App\supdetail;

class SupplierController extends Controller
{
    public function supplierDetail_show_page(){
		
		try{
			
			$supdetail = supdetail::get();
			
			$tbody = "";
			$totalList = count($supdetail);
			foreach($supdetail as $k => $v){
				$tbody.= "<tr>";
				$tbody.= "<td>".$v['comp_code']."</td>";
				$tbody.= "<td>".$v['comp_name']."</td>";
				$tbody.= "<td>".$v['tel']."</td>";
				$tbody.= "<td>".$v['fax']."</td>";
				$tbody.= "<td>".$v['attn_no']."</td>";
				$tbody.= "<td>".$v['email']."</td>";
				/*$tbody.= "<td>
							<a href=".url('supplier/supplierDetail/view/'.$v['comp_code'])." title=' View ".$v['comp_code']." (".$v['comp_name'].") 
							class='btn btn-info btn-rounded'><span class='fa fa-eye'></span></a>
						 </td>";
				$tbody.= "<td>
							<a href=".url('product/edit/'.$row->id)." 
							title=" Edit {{ $row->code.' ('.$row->description.')' }}"
							class="btn btn-primary btn-rounded" ><span class="fa fa-edit"></span></a>
						 </td>
										
										<td>
											<a href="javascript:;" data-base64="{{ $base64data }}" data-code="{{ $row->code }}" data-description="{{ $row->description }}"
											title=" Remove {{ $row->code.' ('.$row->description.')' }}"
											class="btn btn-danger btn-rounded confirm-delete" ><span class="glyphicon glyphicon-trash"></span></a>
										</td>*/
				$tbody.= "</tr>";
			}
			
			$outputData = [
				'totalList' => $totalList,
				'tbody'		=> $tbody
			];
			
		}catch(\Exception $e){
			
		}		
		
    	return view('Supplier.supplierDetail_listing', compact('outputData'));
    }
	
	public function supplierDetail_form_page($comp_code = null){
		
		try{
			
			$outputData = null;
			if(!is_null($comp_code)){
				$outputData = supdetail::where('comp_code',$comp_code)->first();
			}
			
			return view('Supplier.supplierDetail_form',compact('outputData'));
			
			
		}catch(\Exception $e){
			
		}
    }

    public function stockIn_page(){
    	return view('Supplier.stockIn');
    }

    public function supplierDO_page(){
    	return view('Supplier.supplierDO');
    }
	
	public function fn_create_comp(Request $request){
		
		try{
			
			$dataToInsert = [
				'comp_code'		=> $request->get('comp_code'),
				'comp_name'		=> $request->get('comp_name'),
				'add1' 			=> $request->get('add1'),
				'add2'			=> $request->get('add2'),
				'postal_code' 	=> $request->get('poscode'),
				'city'	 		=> $request->get('city'),
				'region' 		=> $request->get('region'),
				'country'	 	=> $request->get('country'),
				'tel'	 		=> $request->get('tel'),
				'fax'	 		=> $request->get('fax'),
				'attn_no' 		=> $request->get('attnNo'),
				'email' 		=> $request->get('email'),
				'created_by'	=> Auth::user()->id,
				'created_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
			];
			
			supdetail::insert($dataToInsert);
			
			return redirect('supplier/supplierDetail');
			
		}catch(\Exception $e){
			
		}
	}
	
	public function fn_update_comp(Request $request){
		
		try{
			
			$comp_code = $request->get('comp_code');
			
			$dataToUpdate = [
				'comp_name'		=> $request->get('comp_name'),
				'add1' 			=> $request->get('add1'),
				'add2'			=> $request->get('add2'),
				'postal_code' 	=> $request->get('poscode'),
				'city'	 		=> $request->get('city'),
				'region' 		=> $request->get('region'),
				'country'	 	=> $request->get('country'),
				'tel'	 		=> $request->get('tel'),
				'fax'	 		=> $request->get('fax'),
				'attn_no' 		=> $request->get('attnNo'),
				'email' 		=> $request->get('email'),
				'updated_by'	=> Auth::user()->id,
				'updated_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
			];
			
			supdetail::where('comp_code',$comp_code)->update($dataToUpdate);
			
		}catch(\Exception $e){
			return 'Error: '.$e;
		}
		
		return $this->fn_get_detail($comp_code);
	}
	
	public function fn_get_detail($comp_code = null){
		
		try{
			
			$outputData = supdetail::where('comp_code',$comp_code)->first();
			
			return view('Supplier.supplierDetail_view',compact('outputData'));
			
			
		}catch(\Exception $e){
			
		}
	}
}
