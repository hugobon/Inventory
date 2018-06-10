<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;

use App\supplier;


class SupplierController extends Controller
{
    public function supplierDetail_show_page(){
		
		try{
			
			$supplier = supplier::get();
			$totalList = count($supplier);
			
			
			$outputData = [
				'totalList' => $totalList,
				'supplier' => $supplier
			];
			
		}catch(\Exception $e){
			return 'Error: '.$e->getMessage();
		}		
		
		return view('Supplier.supplierDetail_listing', compact('outputData'));
    }
	
	public function supplierDetail_form_page($id = null){
		
		try{
			
			$outputData = null;
			if(!is_null($id)){
				$outputData = supplier::where('id',$id)->first();
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
			
			$supplier = new supplier([
				'supplier_code'	=> $request->get('supplier_code'),
				'company_name'	=> $request->get('company_name'),
				'street1' 		=> $request->get('street1'),
				'street2'		=> $request->get('street2'),
				'poscode' 		=> $request->get('poscode'),
				'city'	 		=> $request->get('city'),
				'state' 		=> $request->get('state'),
				'country'	 	=> $request->get('country'),
				'tel'	 		=> $request->get('tel'),
				'fax'	 		=> $request->get('fax'),
				'attn_no' 		=> $request->get('attn_no'),
				'email' 		=> $request->get('email'),
				'created_by'	=> Auth::user()->id,
				'created_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
			]);

			$supplier->save();
			$new_id = $supplier->id;
			
			return $this->fn_get_detail($new_id);
			// return redirect('supplier/supplierDetail');
			
		}catch(\Exception $e){
			return 'Error: '.$e->getMessage();
		}
	}
	
	public function fn_update_comp(Request $request){
		
		try{
			
			$id = $request->get('id');
			
			$dataToUpdate = [
				'supplier_code'	=> $request->get('supplier_code'),
				'company_name'	=> $request->get('company_name'),
				'street1' 		=> $request->get('street1'),
				'street2'		=> $request->get('street2'),
				'poscode' 		=> $request->get('poscode'),
				'city'	 		=> $request->get('city'),
				'state' 		=> $request->get('state'),
				'country'	 	=> $request->get('country'),
				'tel'	 		=> $request->get('tel'),
				'fax'	 		=> $request->get('fax'),
				'attn_no' 		=> $request->get('attn_no'),
				'email' 		=> $request->get('email'),
				'updated_by'	=> Auth::user()->id,
				'updated_at'	=> Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
			];
			
			supplier::where('id',$id)->update($dataToUpdate);
			
		}catch(\Exception $e){
			return 'Error: '.$e;
		}
		
		$outputData = $this->fn_get_detail($id);
		return view('Supplier.supplierDetail_view',compact('outputData'));
	}
	
	public function fn_get_detail($id = null){
		
		try{
			
			$outputData = supplier::where('id',$id)->first();
			
			// return 
			return $outputData;
			
			
		}catch(\Exception $e){
			
		}
	}

	public function do_show_page(Request $request){
		
		$so = $request->get('sales_order');



		return view('Supplier.supplierDO_form', compact('so'));
	}
}
