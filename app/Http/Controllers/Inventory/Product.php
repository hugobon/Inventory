<?php
# Create by: Bhaihaqi		2018-02-05
# Modify by: Bhaihaqi		2018-02-13
namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\inventory\product_m;
use App\configuration\tax_m;

class Product extends Controller{

    public function index(){
        return redirect('product/listing');
    }
	
	public function listing(){
		$productdata = New product_m;
		$data = array(
			'countproduct' => $productdata->count(),
			'startcount' => 0,
			'productArr' => $productdata->orderBy('id', 'desc')->paginate(10),
			'typeArr' => array( '0' => '', '1' => 'By Item','2' => 'Package(Long Term)','3' => 'Monthly Promotion' ),
			'status' => array( '1' => 'On','0' => 'Off'),
		);
        return view('Inventory/product_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('product/listing');
			
		$datadecode = unserialize(base64_decode($x));
		$search = isset($datadecode['search']) ? $datadecode['search'] : '';
		$type = isset($datadecode['type']) ? $datadecode['type'] : '';
		if($search == '' && $type == '')
			return redirect('product/listing');
		
		$productdata = New product_m;
		if($search != '' && $type != ''){
			$countproduct = $productdata->where(function ($q) use($search){
											$q->where('code','LIKE','%'. $search .'%')
												->orWhere('description','LIKE','%'. $search .'%');
										})
										->where('type',$type)
										->count();
			$productArr = $productdata->where(function ($q) use($search){
											$q->where('code','LIKE','%'. $search .'%')
												->orWhere('description','LIKE','%'. $search .'%');
										})
										->where('type',$type)->orderBy('id', 'desc')->paginate(10);
		}
		else if($search != ''){
			$countproduct = $productdata->where('code','LIKE','%'. $search .'%')
										->orWhere('description','LIKE','%'. $search .'%')
										->count();
			$productArr = $productdata->where('code','LIKE','%'. $search .'%')
										->orWhere('description','LIKE','%'. $search .'%')->orderBy('id', 'desc')->paginate(10);
		}
		else{
			$countproduct = $productdata->where('type',$type)
										->count();
			$productArr = $productdata->where('type',$type)->orderBy('id', 'desc')->paginate(10);
		}
		
		$data = array(
			'countproduct' => $countproduct,
			'startcount' => 0,
			'productArr' => $productArr,
			'typeArr' => array( '0' => '', '1' => 'By Item','2' => 'Package(Long Term)','3' => 'Monthly Promotion' ),
			'status' => array( '1' => 'On','0' => 'Off'),
			'search' => $search,
			'type' => $type,
		);
        return view('Inventory/product_listing',$data);
    }
	
	public function form_search(Request $postdata){
		$search = trim($postdata->input("search"));
		$type = trim($postdata->input("type"));
		
		if($search == '' && $type == '')
			return redirect('product/listing');
			
		$rowdata = array(
			'search' => $search,
			'type' => $type,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('product/search/' . $base64data);
    }
	
	public function form(){
		# get Tax GST percentage
		$taxgst = tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
			
		$data['gstpercentage'] = $gstpercentage;
		return view('Inventory/product_form',$data);
    }
	
	public function edit($id){
		$data = product_m::where('id', $id)->first();
		if($data == false)
			return redirect("product/listing")->with("errorid"," Not Found ");
		
		# get Tax GST percentage		
		$taxgst = tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
			
		$data['gstpercentage'] = $gstpercentage;
		return view('Inventory/product_form',$data);
    }
	
	public function view($id){
		$data = product_m::where('id', $id)->first();
		if($data == false)
			return redirect("product/listing")->with("errorid"," Not Found ");
			
		$data['typestr'] =  array( '0' => '', '1' => 'By Item','2' => 'Package(Long Term)','3' => 'Monthly Promotion' );
		
		# get Tax GST percentage		
		$taxgst = tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
			
		$data['gstpercentage'] = $gstpercentage;
		
		return view('Inventory/product_view',$data);
    }
	
	public function insert(Request $postdata){
		$this->validate($postdata,[
			'code' => 'required',
			'type' => 'required',
			'description' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
		]);
		
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$description = trim(preg_replace('!\s+!', ' ', $postdata->input("description")));
		
		#check exist code
		$countcode = product_m::where('code', $code)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/form')->withErrors($messages);
		}
		
		#change datepicker to mysql date
		$start_promotion = $this->datepicker2mysql($postdata->input("start_promotion"));
		$end_promotion = null;
		if($start_promotion != null)
			$end_promotion = $this->datepicker2mysql($postdata->input("end_promotion"));
		
		$data = array(
			'code' => $code,
			'type' => $postdata->input("type"),
			'description' => $description,
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'last_purchase' => $postdata->input("last_purchase"),
			'picture_name' => '',
			'picture_path' => '',
			'start_promotion' => $start_promotion,
			'end_promotion' => $end_promotion,
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$productdata = New product_m;
		$id = $productdata->insertGetId($data);
		
		# if have new upload image
		if($postdata->hasFile('upload_image')) {
			$picture_name = $postdata->file('upload_image')->getClientOriginalName();
			$picture_type = $postdata->file('upload_image')->getMimeType();
			$pictureArr = explode("/",$picture_type); # check if image or not
			if($pictureArr[0] == 'image'){
				$new_pname = date('YmdHis') . "_" . str_replace(' ','', $picture_name);
				
				$path = Storage::putFileAs(
					'public/product_image/' . $id , $postdata->file('upload_image'), $new_pname
				);
				if($path){
					$data = array(
						'picture_name' => $picture_name,
						'picture_path' => 'product_image/' . $id . '/' . $new_pname,
					);
					#update
					$productdata->where('id',$id)->update($data);
				}
			}
		}
		
		return redirect("product/view/" . $id )->with("info","Success Submit " . $postdata->input("description") . "");
    }
	
    public function update(Request $postdata, $id){
		$checkproduct = product_m::where('id', $id)->first();
		if($checkproduct == false)
			return redirect("product/listing")->with("errorid"," Data Not Found ");
			
		$this->validate($postdata,[
			'code' => 'required',
			'type' => 'required',
			'description' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
		]);
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$description = trim(preg_replace('!\s+!', ' ', $postdata->input("description")));
		
		#change datepicker to mysql date
		$start_promotion = $this->datepicker2mysql($postdata->input("start_promotion"));
		$end_promotion = $this->datepicker2mysql($postdata->input("end_promotion"));
		
		#check exist code
		$productdata = New product_m;
		$countcode = $productdata->where('code','=',$code)->where('id','<>', $id)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/edit/' . $id)->withErrors($messages);
		}
		
		$data = array(
			'code' => $code,
			'type' => $postdata->input("type"),
			'description' => $description,
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'last_purchase' => $postdata->input("last_purchase"),
			'start_promotion' => $start_promotion,
			'end_promotion' => $end_promotion,
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		
		# if have new upload image
		if($postdata->input("upload_status") == 1){
			if($checkproduct['picture_path'] != ''){
				# remove old image if exist
				Storage::delete('public/' . $checkproduct['picture_path']);
			}
			$data['picture_name'] = '';
			$data['picture_path'] = '';
			if($postdata->hasFile('upload_image')) {
				$picture_name = $postdata->file('upload_image')->getClientOriginalName();
				$picture_type = $postdata->file('upload_image')->getMimeType();
				$pictureArr = explode("/",$picture_type); # check if image or not
				if($pictureArr[0] == 'image'){
					$new_pname = date('YmdHis') . "_" . str_replace(' ','', $picture_name);
					
					$path = Storage::putFileAs(
						'public/product_image/' . $id , $postdata->file('upload_image'), $new_pname
					);
					if($path){
						$data['picture_name'] = $picture_name;
						$data['picture_path'] = 'product_image/' . $id . '/' . $new_pname;
					}
				}
			}
		}
		
		$productdata->where('id',$id)->update($data);
		
		return redirect("product/view/" . $id)->with("info","Success Save " . $postdata->input("description") . "");
    }
	
	public function check_existcode(Request $postdata){
		$id = $postdata->input("id");
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$productdata = New product_m;
		$countcode = $productdata->where('code','=',$code)->where('id','<>', $id)->count();
		if($countcode > 0)
			return 1;
		else
			return 0;
    }
	
    public function delete($data = ''){
        $datadecode = unserialize(base64_decode($data));
		$deleteid = isset($datadecode['deleteid']) ? $datadecode['deleteid'] : 0;
		$checkproduct = product_m::where('id', $deleteid)->first();
		if($checkproduct == false)
			return redirect("product/listing")->with("errorid"," Data not found");
		
		$search = isset($datadecode['search']) ? $datadecode['search'] : '';
		
		if(product_m::where('id', $deleteid)->delete()){
			if($checkproduct['picture_path'] != ''){
				# remove image after delete
				Storage::delete('public/' . $checkproduct['picture_path']);
			}
			if($search != '')
				return redirect("product/search/" . $search)->with("info","Product " . $checkproduct['code'] . "  (" . $checkproduct['description'] . " ) Deleted Successfully!!");
			else
				return redirect("product/listing")->with("info","Product " . $checkproduct['code'] . "  (" . $checkproduct['description'] . " ) Deleted Successfully!!");
			
		}
    }
	
	function datepicker2mysql($date_dmY){
		# $date = d/m/Y format
		$tmp_date = explode("/", $date_dmY);
		if(sizeof($tmp_date) != 3)
			return null;
		
		$sql_date = $tmp_date[2] . "-" . $tmp_date[1] . "-" . $tmp_date[0];
		return $sql_date;
	}
}
