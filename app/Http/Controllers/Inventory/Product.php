<?php
# Create by: Bhaihaqi		2018-02-05
# Modify by: Bhaihaqi		2018-02-13
namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\inventory\product_m;
use App\inventory\product_image_m;
use App\inventory\product_package_m;
use App\configuration\config_tax_m;
use App\inventory\product_promotion_m;

class Product extends Controller{

    public function index(){
        return redirect('product/listing');
    }
	
	public function listing(){
		$productdata = New product_m;
		$data = array(
			'countproduct' => $productdata->count(),
			'productArr' => $productdata->orderBy('id', 'desc')->paginate(10),
			'typeArr' => array( '0' => '', '1' => 'Item','2' => 'Package ','3' => 'Monthly Promotion' ),
			'statusArr' => array( '0' => 'Inactive', '1' => 'Active'),
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
			'productArr' => $productArr,
			'typeArr' => array( '0' => '', '1' => 'Item','2' => 'Package','3' => 'Monthly Promotion' ),
			'statusArr' => array( '0' => 'Inactive', '1' => 'Active'),
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
		$taxgst = config_tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
			
		$data['gstpercentage'] = $gstpercentage;
		$data['tabform'] = 'active';
		$data['tabgallery'] = '';
		return view('Inventory/product_form',$data);
    }
	
	public function edit($id = 0, $gallery = 0){
		if($id > 0){
			$data = product_m::where('id', $id)->first();
			if($data == false)
				return redirect("product/listing")->with("errorid"," Not Found ");
			if($data['type'] == 2)
				return redirect("product/package_edit/" . $id . ($gallery > 0 ? '/1' : ''));
			
			# get Tax GST percentage		
			$taxgst = config_tax_m::where('code', 'gst')->first();
			if($taxgst == false)
				$gstpercentage = 6;
			else
				$gstpercentage = $taxgst['percent'];
			
			$tabform = 'active';
			$tabgallery = '';
			if($gallery == 1){
				$tabform = '';
				$tabgallery = 'active';
			}
				
			$data['gstpercentage'] = $gstpercentage;
			$data['tabform'] = $tabform;
			$data['tabgallery'] = $tabgallery;
			
			return view('Inventory/product_form',$data);
		}
		return redirect("product/listing");
    }
	
	public function view($id = 0){
		if($id > 0){
			$data = product_m::where('id', $id)->first();
			if($data == false)
				return redirect("product/listing")->with("errorid"," Not Found ");
				
			if($data['type'] == 2)
				return redirect("product/package_view/" . $id);
				
			$data['typestr'] =  array( '0' => '', '1' => 'Item','2' => 'Package','3' => 'Monthly Promotion' );
			
			# get Tax GST percentage		
			$taxgst = config_tax_m::where('code', 'gst')->first();
			if($taxgst == false)
				$gstpercentage = 6;
			else
				$gstpercentage = $taxgst['percent'];
				
			$imagedata = New product_image_m;
			$promotiondata = New product_promotion_m;
			$data['imageArr'] = $imagedata->where('product_id',$id)->orderBy('id', 'desc')->get();
			$data['promotion_list'] = $promotiondata->where('product_id',$id)->orderBy('id', 'desc')->get();
			$data['statusArr'] = array('1' => 'Active', '0' => 'Inactive');
			$data['gstpercentage'] = $gstpercentage;
			
			return view('Inventory/product_view',$data);
		}
		return redirect("product/listing");
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
		
		$data = array(
			'code' => $code,
			'type' => $postdata->input("type"),
			'description' => $description,
			'weight' => $postdata->input("weight") != null ? $postdata->input("weight") : '0',
			'point' => $postdata->input("point") != null ? $postdata->input("point") : '0',
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'last_purchase' => $postdata->input("last_purchase") > 0 ? $postdata->input("last_purchase") : 0,
			'quantity_min' => $postdata->input("quantity_min") > 0 ? $postdata->input("quantity_min") : 0,
			'quantity' => 0,
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'year' => $postdata->input("year") > 1900 ? $postdata->input("year") : 1900,
			'category' => $postdata->input("category") != null ? $postdata->input("category") : '',
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$productdata = New product_m;
		$id = $productdata->insertGetId($data);
		
		return redirect("product/edit/" . $id . "/1" )->with("info","Success Submit " . $data['code'] . " (" . $data['description'] . ")");
    }
	
    public function update(Request $postdata, $id = 0){
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
			'weight' => $postdata->input("weight") != null ? $postdata->input("weight") : '0',
			'point' => $postdata->input("point") != null ? $postdata->input("point") : '0',
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'last_purchase' => $postdata->input("last_purchase") > 0 ? $postdata->input("last_purchase") : 0,
			'quantity_min' => $postdata->input("quantity_min") > 0 ? $postdata->input("quantity_min") : 0,
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'year' => $postdata->input("year") > 1900 ? $postdata->input("year") : 1900,
			'category' => $postdata->input("category") != null ? $postdata->input("category") : '',
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		
		$productdata->where('id',$id)->update($data);
		
		return redirect("product/view/" . $id)->with("info","Success Save " . $data['code'] . " (" . $data['description'] . ")");
    }
	
	public function package_form(){
		# get Tax GST percentage
		$taxgst = config_tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
		
		# get all product exclude package
		$productdata = New product_m;
		$data2 = $productdata->where('type','<>',2)->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($data2) > 0){
			foreach($data2->all() as $key => $row)
				$productArr[$row->id] = $row->code . ' (' . $row->description . ')';
		}
		$data['gstpercentage'] = $gstpercentage;
		$data['tabform'] = 'active';
		$data['tabgallery'] = '';
		$productdata = New product_m;
		$data['productArr'] = $productArr; # not package product
		return view('Inventory/product_package_form',$data);
    }
	
	public function package_edit($id = 0, $gallery = 0){
		if($id > 0){
			$productdata = New product_m;
			$data = $productdata->where('id', $id)->where('type', 2)->first();
			if($data == false)
				return redirect("product/listing")->with("errorid"," Not Found ");
			
			# get Tax GST percentage		
			$taxgst = config_tax_m::where('code', 'gst')->first();
			if($taxgst == false)
				$gstpercentage = 6;
			else
				$gstpercentage = $taxgst['percent'];
			
			# get all product exclude package
			$productdata = New product_m;
			$data2 = $productdata->where('type','<>',2)->orderBy('code', 'asc')->get();
			$productArr = array();
			if(count($data2) > 0){
				foreach($data2->all() as $key => $row)
					$productArr[$row->id] = $row->code . ' (' . $row->description . ')';
			}
			
			$tabform = 'active';
			$tabgallery = '';
			if($gallery == 1){
				$tabform = '';
				$tabgallery = 'active';
			}
			
			$packagedata = New product_package_m;
			$data['product_list'] = $packagedata->where('package_id', $id)->get();
			$data['gstpercentage'] = $gstpercentage;
			$data['tabform'] = $tabform;
			$data['tabgallery'] = $tabgallery;
			$data['productArr'] = $productArr; # not package product
			return view('Inventory/product_package_form',$data);
		}
		return redirect("product/listing");
    }
	
	public function package_view($id = 0){
		if($id > 0){
			$productdata = New product_m;
			$data = $productdata->where('id', $id)->first();
			if($data == false)
				return redirect("product/listing")->with("errorid"," Not Found 1");
				
			if($data['type'] != 2)
				return redirect("product/view/" . $id);
				
			$data['typestr'] =  array( '0' => '', '1' => 'Item','2' => 'Package','3' => 'Monthly Promotion' );
			
			# get Tax GST percentage		
			$taxgst = config_tax_m::where('code', 'gst')->first();
			if($taxgst == false)
				$gstpercentage = 6;
			else
				$gstpercentage = $taxgst['percent'];
			
			#get product name
			$packagedata = New product_package_m;
			$product_list = $packagedata->where('package_id', $id)->get();
			$productArr = array();
			if(count($product_list) > 0){
				foreach($product_list->all() as $key => $row){
					$datap = $productdata->where('id', $row->product_id)->where('type','<>', 2)->first();
					$productArr[$datap['id']] = $datap['code'] . ' (' . $datap['description'] . ')';
				}
			}
			
			$imagedata = New product_image_m;
			$promotiondata = New product_promotion_m;
			$data['imageArr'] = $imagedata->where('product_id',$id)->orderBy('id', 'desc')->get();
			$data['promotion_list'] = $promotiondata->where('product_id',$id)->orderBy('id', 'desc')->get();
			$data['statusArr'] = array('1' => 'Active', '0' => 'Inactive');
			$data['gstpercentage'] = $gstpercentage;
			$data['product_list'] = $product_list;
			$data['productArr'] = $productArr; # not package product
			return view('Inventory/product_package_view',$data);
		}
		return redirect("product/listing");
    }
	
	public function package_insert(Request $postdata){
		$this->validate($postdata,[
			'code' => 'required',
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
		
		$data = array(
			'code' => $code,
			'type' => 2,
			'description' => $description,
			'weight' => $postdata->input("weight") != null ? $postdata->input("weight") : '0',
			'point' => $postdata->input("point") != null ? $postdata->input("point") : '0',
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'last_purchase' => $postdata->input("last_purchase") > 0 ? $postdata->input("last_purchase") : 0,
			'quantity_min' => $postdata->input("quantity_min") > 0 ? $postdata->input("quantity_min") : 0,
			'quantity' => 0,
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'year' => $postdata->input("year") > 1900 ? $postdata->input("year") : 1900,
			'category' => $postdata->input("category") != null ? $postdata->input("category") : '',
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$productdata = New product_m;
		$id = $productdata->insertGetId($data);
		if($id > 0){
			#product list insert 
			$packageid = $postdata->input("packageid");
			$productid = $postdata->input("productid");
			$productdescription = $postdata->input("productdescription");
			$productquantity = $postdata->input("productquantity");
			$packagedata = New product_package_m;
			foreach($packageid as $k => $v){
				if($productid[$k] > 0){
					$datapraduct = array(
						'package_id' => $id,
						'product_id' => $productid[$k],
						'quantity' => $productquantity[$k] > 0 ? $productquantity[$k] : 0,
						'description' => $productdescription[$k] != null ? $productdescription[$k] : '',
						'created_by' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_by' => 1,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$packagedata->insert($datapraduct);
				}
			}
		}
		
		return redirect("product/package_edit/" . $id . "/1" )->with("info","Success Submit " . $data['code'] . " (" . $data['description'] . ")");
    }
	
    public function package_update(Request $postdata, $id = 0){
		$productdata = New product_m;
		$checkproduct = $productdata->where('id', $id)->where('type', 2)->first();
		if($checkproduct == false)
			return redirect("product/listing")->with("errorid"," Data Not Found ");
			
		$this->validate($postdata,[
			'code' => 'required',
			'description' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
		]);
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$description = trim(preg_replace('!\s+!', ' ', $postdata->input("description")));
		
		#check exist code
		$productdata = New product_m;
		$countcode = $productdata->where('code','=',$code)->where('id','<>', $id)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/edit/' . $id)->withErrors($messages);
		}
		
		$data = array(
			'code' => $code,
			'description' => $description,
			'weight' => $postdata->input("weight") != null ? $postdata->input("weight") : '0',
			'point' => $postdata->input("point") != null ? $postdata->input("point") : '0',
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'last_purchase' => $postdata->input("last_purchase") > 0 ? $postdata->input("last_purchase") : 0,
			'quantity_min' => $postdata->input("quantity_min") > 0 ? $postdata->input("quantity_min") : 0,
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'year' => $postdata->input("year") > 1900 ? $postdata->input("year") : 1900,
			'category' => $postdata->input("category") != null ? $postdata->input("category") : '',
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		
		$productdata->where('id',$id)->update($data);
		
		#product list insert / update / delete
		$packageid = $postdata->input("packageid");
		$productid = $postdata->input("productid");
		$productdescription = $postdata->input("productdescription");
		$productquantity = $postdata->input("productquantity");
		$packagedata = New product_package_m;
		$valid_id = array();
		foreach($packageid as $k => $v){
			if($v > 0){
				#update
				if($productid[$k] > 0){
					$datapraduct = array(
						'package_id' => $id,
						'product_id' => $productid[$k],
						'quantity' => $productquantity[$k] > 0 ? $productquantity[$k] : 0,
						'description' => $productdescription[$k] != null ? $productdescription[$k] : '',
						'updated_by' => 1,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$packagedata->where('id',$v)->update($datapraduct);
					$valid_id[] = $v;
				}
			}
			else{
				#insert
				if($productid[$k] > 0){
					$datapraduct = array(
						'package_id' => $id,
						'product_id' => $productid[$k],
						'quantity' => $productquantity[$k] > 0 ? $productquantity[$k] : 0,
						'description' => $productdescription[$k] != null ? $productdescription[$k] : '',
						'created_by' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_by' => 1,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$v = $packagedata->insertGetId($datapraduct);
					$valid_id[] = $v;
				}
			}
		}
		#delete
		if(count($valid_id) > 0){
			#Delete WHERE NOT IN array
			$packagedata->where('package_id', $id)->whereNotIn('id', $valid_id)->delete();
		}
		else{
			#Delete All
			$packagedata->where('package_id', $id)->delete();
		}
		
		return redirect("product/view/" . $id)->with("info","Success Save " . $postdata->input("description") . "");
    }
	
	public function upload_image(Request $postdata,$id = 0){
		$datajson = array(
			'status' => 'Fail',
			'remarks' => 'Product not Founds',
		);
		$checkproduct = product_m::where('id', $id)->first();
		if($checkproduct == true){
			$data = array(
				'product_id' => $id,
				'description' => $postdata->input("description") != null ? $postdata->input("description") : '',
				'created_by' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_by' => 1,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			
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
						$data['file_name'] = $picture_name;
						$data['path'] = 'product_image/' . $id . '/' . $new_pname;
						$data['type'] = $picture_type;
						$imagedata = New product_image_m;
						$id = $imagedata->insertGetId($data);
						
						$datajson = array(
							'status' => 'Success',
							'remarks' => 'Upload',
						);
					}
					else{
						$datajson = array(
							'status' => 'Fail',
							'remarks' => 'Unsuccess Upload',
						);
					}
				}
				else{
					$datajson = array(
						'status' => 'Fail',
						'remarks' => 'Not Image Format',
					);
				}
			}
			else{
				$datajson = array(
					'status' => 'Fail',
					'remarks' => 'Image Not found',
				);
			}
		}
		return json_encode($datajson);
	}
	
	public function reload_image($id = 0){
		$checkproduct = product_m::where('id', $id)->first();
		if($checkproduct == true){
			$imagedata = New product_image_m;
			$data['imageArr'] = $imagedata->where('product_id',$id)->orderBy('id', 'desc')->get();
			$data['productId'] = $id; 
			$data['productName'] = $checkproduct['code'] . ' (' . $checkproduct['description'] . ') '; 
			return view('Inventory/product_reload_image',$data);
		}
		return "Not Valid";
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
		if(@unserialize(base64_decode($data)) == true){
			$datadecode = unserialize(base64_decode($data));
			$delete = isset($datadecode['delete']) ? $datadecode['delete'] : 0;
			$deleteid = isset($datadecode['deleteid']) ? $datadecode['deleteid'] : 0;
			
			if($delete == 'product' && $deleteid > 0){
				$checkproduct = product_m::where('id', $deleteid)->first();
				if($checkproduct == false)
					return redirect("product/listing")->with("errorid"," Data not found");
				
				$search = isset($datadecode['search']) ? $datadecode['search'] : '';
				
				if($checkproduct['type'] == 2){
					#delete all package product
					$packagedata = New product_package_m;
					$packagedata->where('package_id', $deleteid)->delete();
				}
				
				if(product_m::where('id', $deleteid)->delete()){
					if($checkproduct['type'] == 2){
						#delete all package product
						$packagedata = New product_package_m;
						$packagedata->where('product_id', $deleteid)->delete();
					}
					
					#delete all image
					$imagedata = New product_image_m;
					$checkimage = $imagedata->where('product_id', $deleteid)->get();
					if(count($checkimage) > 0){
						foreach($checkimage->all() as $key => $rowimage){
							if($imagedata->where('id', $rowimage->id)->delete()){
								if($rowimage->path != ''){
									# remove image after delete
									Storage::delete('public/' . $rowimage->path);
								}
							}
						}
					}
					
					if($search != '')
						return redirect("product/search/" . $search)->with("info","Product " . $checkproduct['code'] . "  (" . $checkproduct['description'] . " ) Deleted Successfully!!");
					else
						return redirect("product/listing")->with("info","Product " . $checkproduct['code'] . "  (" . $checkproduct['description'] . " ) Deleted Successfully!!");
					
				}
			}
		}
		return redirect("product/listing");
    }
	
	public function delete_image($data = ''){
		if(@unserialize(base64_decode($data)) == true){
			$datadecode = unserialize(base64_decode($data));
			$delete = isset($datadecode['delete']) ? $datadecode['delete'] : 0;
			$productId = isset($datadecode['productId']) ? $datadecode['productId'] : 0;
			$deleteid = isset($datadecode['deleteid']) ? $datadecode['deleteid'] : 0;
			if($delete == 'delete_image' && $deleteid > 0 && $productId > 0){
				$imagedata = New product_image_m;
				$checkimage = $imagedata->where('id', $deleteid)->where('product_id', $productId)->first();
				if($checkimage == false)
					return "not found";
				
				if($imagedata->where('id', $deleteid)->delete()){
					if($checkimage['path'] != ''){
						# remove image after delete
						Storage::delete('public/' . $checkimage['path']);
						
						return "success";
					}
				}
			}
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
