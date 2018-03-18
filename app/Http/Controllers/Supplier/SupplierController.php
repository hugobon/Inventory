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
			
			$tbody = "";
			$totalList = count($supplier);
			if($totalList > 0){
				foreach($supplier as $k => $v){
					$tbody.= "<tr>";
					$tbody.= "<td>".$v['supplier_code']."</td>";
					$tbody.= "<td>".$v['company_name']."</td>";
					$tbody.= "<td>".$v['tel']."</td>";
					$tbody.= "<td>".$v['fax']."</td>";
					$tbody.= "<td>".$v['attn_no']."</td>";
					$tbody.= "<td>".$v['email']."</td>";
					$tbody.= "<td>
								<a href=".url('supplier/supplierDetail/view/'.$v['id'])." title=' View ".$v['id']." (".$v['company_name'].")' 
								class='btn btn-info btn-rounded'><span class='fa fa-eye'></span></a>
								<a href=".url('supplier/supplierDetail/form/'.$v['id'])." 
								title=' Edit ".$v['supplier_code']." (".$v['company_name'].")'
								class='btn btn-primary btn-rounded' ><span class='fa fa-edit'></span></a>
								<a href=".url('#')." 
								title=' Remove ".$v['supplier_code']." (".$v['company_name'].")'
								class='btn btn-danger btn-rounded confirm-delete' ><span class='glyphicon glyphicon-trash'></span></a>
							 </td>";
					/*$tbody.= "<td>
								<a href=".url('product/edit/'.$v['comp_code'])." 
								title=' Edit ".$v['comp_code']." (".$v['comp_name'].")'
								class='btn btn-primary btn-rounded' ><span class='fa fa-edit'></span></a>
							 </td>";
					$tbody.= "<td>
								<a href=".url('product/edit/'.$v['comp_code'])." 
								title=' Remove ".$v['comp_code']." (".$v['comp_name'].")'
								class='btn btn-danger btn-rounded confirm-delete' ><span class='glyphicon glyphicon-trash'></span></a>
							 </td>";*/
					$tbody.= "</tr>";
				}
			}
			else{
				$tbody = "<tr><td colspan='7' align='center'>No Data Found</td></tr>";
			}
			
			$outputData = [
				'totalList' => $totalList,
				'tbody'		=> $tbody
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
		
		return $this->fn_get_detail($id);
	}
	
	public function fn_get_detail($id = null){
		
		try{
			
			$outputData = supplier::where('id',$id)->first();
			
			return view('Supplier.supplierDetail_view',compact('outputData'));
			
			
		}catch(\Exception $e){
			
		}
	}

	public function do_show_page(Request $request){
		
		$so = $request->get('sales_order');

		return view('Supplier.supplierDO_form', compact('so'));
	}
}
