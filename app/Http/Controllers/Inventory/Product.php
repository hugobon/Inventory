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
use App\configuration\config_quantitytype_m;
use App\configuration\config_productcategory_m;
use App\inventory\product_promotion_m;
use App\User_m;

use Auth;
class Product extends Controller{

	public function __construct(){
        $this->middleware('auth');
    }
	
    public function index(){
        return redirect('product/listing');
    }
	
	public function listing(){
		$productdata = New product_m;
		$data = array(
			'countproduct' => $productdata->count(),
			'productArr' => $productdata->orderBy('id', 'desc')->paginate(10),
			'typeArr' => array( '0' => '', '1' => 'Item','2' => 'Package '),
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
												->orWhere('name','LIKE','%'. $search .'%');
										})
										->where('type',$type)
										->count();
			$productArr = $productdata->where(function ($q) use($search){
											$q->where('code','LIKE','%'. $search .'%')
												->orWhere('name','LIKE','%'. $search .'%');
										})
										->where('type',$type)->orderBy('id', 'desc')->paginate(10);
		}
		else if($search != ''){
			$countproduct = $productdata->where('code','LIKE','%'. $search .'%')
										->orWhere('name','LIKE','%'. $search .'%')
										->count();
			$productArr = $productdata->where('code','LIKE','%'. $search .'%')
										->orWhere('name','LIKE','%'. $search .'%')->orderBy('id', 'desc')->paginate(10);
		}
		else{
			$countproduct = $productdata->where('type',$type)
										->count();
			$productArr = $productdata->where('type',$type)->orderBy('id', 'desc')->paginate(10);
		}
		
		$data = array(
			'countproduct' => $countproduct,
			'productArr' => $productArr,
			'typeArr' => array( '0' => '', '1' => 'Item','2' => 'Package'),
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
		# get Quantity Type
		$configquantitytypedata = New config_quantitytype_m;
		$dataquantitytype = $configquantitytypedata->orderBy('type', 'asc')->get();
		# get Product Category
		$configproductcategorydata = New config_productcategory_m;
		$dataproductcategory = $configproductcategorydata->orderBy('category', 'asc')->get();
		# get Tax GST percentage
		$taxgst = config_tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
			
		$data = array(
			'dataquantitytype' => $dataquantitytype,
			'dataproductcategory' => $dataproductcategory,
			'gstpercentage' => $gstpercentage,
			'tabform' => 'active',
			'tabgallery' => '',
		);
		
		return view('Inventory/product_form',$data);
    }
	
	public function edit($id = 0, $gallery = 0){
		if($id > 0){
			$data = product_m::where('id', $id)->first();
			if($data == false)
				return redirect("product/listing")->with("errorid"," Not Found ");
			if($data['type'] == 2)
				return redirect("product/package_edit/" . $id . ($gallery > 0 ? '/1' : ''));
			
			# get Quantity Type
			$configquantitytypedata = New config_quantitytype_m;
			$dataquantitytype = $configquantitytypedata->orderBy('type', 'asc')->get();
			# get Product Category
			$configproductcategorydata = New config_productcategory_m;
			$dataproductcategory = $configproductcategorydata->orderBy('category', 'asc')->get();
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
				
			$data['dataquantitytype'] = $dataquantitytype;
			$data['dataproductcategory'] = $dataproductcategory;
			$data['gstpercentage'] = $gstpercentage;
			$data['tabform'] = $tabform;
			$data['tabgallery'] = $tabgallery;
			
			return view('Inventory/product_form',$data);
		}
		return redirect("product/listing");
    }
	
	public function view($id = 0){
		if($id > 0){
			$productdata = New product_m;
			$data = $productdata->where('id', $id)->first();
			if($data == false)
				return redirect("product/listing")->with("errorid"," Not Found ");
				
			if($data['type'] == 2)
				return redirect("product/package_view/" . $id);
				
			$data['typestr'] =  array( '0' => '', '1' => 'Item','2' => 'Package');
			
			# get Quantity Type
			$configquantitytypedata = New config_quantitytype_m;
			$data['quantitytype'] = $configquantitytypedata->where('id', $data['qtytype_id'])->first();
			# get Product Category
			$configproductcategorydata = New config_productcategory_m;
			$data['productcategory'] = $configproductcategorydata->where('id', $data['category'])->first();
			
			# get Tax GST percentage		
			$taxgst = config_tax_m::where('code', 'gst')->first();
			if($taxgst == false)
				$gstpercentage = 6;
			else
				$gstpercentage = $taxgst['percent'];
				
			$imagedata = New product_image_m;
			$promotiondata = New product_promotion_m;
			$userdata = New User_m;
			$packagedata = New product_package_m;
			
			$created_by_name = $updated_by_name = "";
			$user = $userdata->where('id', $data['created_by'])->first();
			if($user)
				$created_by_name = $user['name'];
			$user2 = $userdata->where('id', $data['updated_by'])->first();
			if($user2)
				$updated_by_name = $user2['name'];
			
			#get package if exist
			$packageArr = array();
			$querypackage = $packagedata->where('product_id',$id)->orderBy('id', 'desc')->get();
			if(count($querypackage) > 0){
				foreach($querypackage->all() as $key => $row){
					$package_id = $row->package_id;
					$datap = $productdata->where('id', $package_id)->first();
					
					$type = "Product";
					if($datap['type'] == 2)
						$type = "Package";
						
					$productid = $datap['id'];
					
					#price after gst
					$price_wm = $datap['price_wm'];
					$price_em = $datap['price_em'];
					$price_staff = $datap['price_staff'];
					$wm_gst = $wm_aftergst = $em_gst = $em_aftergst = $staff_gst = $staff_aftergst = 0;
					if($price_wm > 0){
						$wm_gst = ($price_wm / 100) * $gstpercentage;
						$wm_aftergst = $price_wm + $wm_gst;
					}
					if($price_em > 0){
						$em_gst = ($price_em / 100) * $gstpercentage;
						$em_aftergst = $price_em + $em_gst;
					}
					if($price_staff > 0){
						$staff_gst = ($price_staff / 100) * $gstpercentage;
						$staff_aftergst = $price_staff + $staff_gst;
					}
					
					$packageArr[] = array(
						'id' => $productid,
						'code' => $datap['code'],
						'type' => $type,
						'name' => $datap['name'],
						'year' => $datap['year'],
						'category' => $datap['category'],
						'weight' => $datap['weight'],
						'point' => $datap['point'],
						'price_wm' => number_format($price_wm, 2, '.', ''),
						'wm_gst' => number_format($wm_gst, 2, '.', ''),
						'wm_aftergst' => number_format($wm_aftergst, 2, '.', ''),
						'price_em' => number_format($price_em, 2, '.', ''),
						'em_gst' => number_format($em_gst, 2, '.', ''),
						'em_aftergst' => number_format($em_aftergst, 2, '.', ''),
						'price_staff' => number_format($price_staff, 2, '.', ''),
						'staff_gst' => number_format($staff_gst, 2, '.', ''),
						'staff_aftergst' => number_format($staff_aftergst, 2, '.', ''),
						
					);
				}
			}
			
			$data['created_by_name'] = $created_by_name;
			$data['updated_by_name'] = $updated_by_name;
			$data['imageArr'] = $imagedata->where('product_id',$id)->orderBy('status', 'desc')->orderBy('id', 'desc')->get();
			$data['promotion_list'] = $promotiondata->where('product_id',$id)->orderBy('id', 'desc')->get();
			$data['statusArr'] = array('1' => 'Active', '0' => 'Inactive');
			$data['packageArr'] = $packageArr;
			$data['gstpercentage'] = $gstpercentage;
			
			return view('Inventory/product_view',$data);
		}
		return redirect("product/listing");
    }
	
	public function insert(Request $postdata){
		$this->validate($postdata,[
			'code' => 'required',
			'name' => 'required',
			'category' => 'required',
			'qtytype_id' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
		]);
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$name = trim(preg_replace('!\s+!', ' ', $postdata->input("name")));
		
		#check exist code
		$countcode = product_m::where('code', $code)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/form')->withErrors($messages);
		}
		
		$data = array(
			'code' => $code,
			'type' => 1, # item
			'name' => $name, 
			'description' => $postdata->input("description") != null ? $postdata->input("description") : '',
			'qtytype_id' => $postdata->input("qtytype_id") != null ? $postdata->input("qtytype_id") : '1',
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
			'category' => $postdata->input("category") > 0 ? $postdata->input("category") : '0',
			'created_by' => Auth::user()->id,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth::user()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$productdata = New product_m;
		$id = $productdata->insertGetId($data);
		
		return redirect("product/edit/" . $id . "/1" )->with("info","Success Submit " . $data['code'] . " (" . $data['name'] . ")");
    }
	
    public function update(Request $postdata, $id = 0){
		$checkproduct = product_m::where('id', $id)->first();
		if($checkproduct == false)
			return redirect("product/listing")->with("errorid"," Data Not Found ");
			
		$this->validate($postdata,[
			'code' => 'required',
			'name' => 'required',
			'category' => 'required',
			'qtytype_id' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
		]);
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$name = trim(preg_replace('!\s+!', ' ', $postdata->input("name")));
		
		#check exist code
		$productdata = New product_m;
		$countcode = $productdata->where('code','=',$code)->where('id','<>', $id)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/edit/' . $id)->withErrors($messages);
		}
		
		$data = array(
			'code' => $code,
			'name' => $name,
			'description' => $postdata->input("description") != null ? $postdata->input("description") : '',
			'qtytype_id' => $postdata->input("qtytype_id") != null ? $postdata->input("qtytype_id") : '1',
			'weight' => $postdata->input("weight") != null ? $postdata->input("weight") : '0',
			'point' => $postdata->input("point") != null ? $postdata->input("point") : '0',
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'last_purchase' => $postdata->input("last_purchase") > 0 ? $postdata->input("last_purchase") : 0,
			'quantity_min' => $postdata->input("quantity_min") > 0 ? $postdata->input("quantity_min") : 0,
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'year' => $postdata->input("year") > 1900 ? $postdata->input("year") : 1900,
			'category' => $postdata->input("category") > 0 ? $postdata->input("category") : '0',
			'updated_by' => Auth::user()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		
		$productdata->where('id',$id)->update($data);
		
		return redirect("product/view/" . $id)->with("info","Success Save " . $data['code'] . " (" . $data['name'] . ")");
    }
	
	public function package_form(){
		# get Quantity Type
		$configquantitytypedata = New config_quantitytype_m;
		$dataquantitytype = $configquantitytypedata->orderBy('type', 'asc')->get();
		# get Product Category
		$configproductcategorydata = New config_productcategory_m;
		$dataproductcategory = $configproductcategorydata->orderBy('category', 'asc')->get();
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
				$productArr[$row->id] = $row->code . ' (' . $row->name . ')';
		}
		
		$data = array(
			'dataquantitytype' => $dataquantitytype,
			'dataproductcategory' => $dataproductcategory,
			'gstpercentage' => $gstpercentage,
			'tabform' => 'active',
			'tabgallery' => '',
			'productArr' => $productArr, # not package product
		);
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
					$productArr[$row->id] = $row->code . ' (' . $row->name . ')';
			}
			
			$tabform = 'active';
			$tabgallery = '';
			if($gallery == 1){
				$tabform = '';
				$tabgallery = 'active';
			}
			
			$configquantitytypedata = New config_quantitytype_m;
			$configproductcategorydata = New config_productcategory_m;
			$packagedata = New product_package_m;
			$data['dataquantitytype'] = $configquantitytypedata->orderBy('type', 'asc')->get();
			$data['dataproductcategory'] = $configproductcategorydata->orderBy('category', 'asc')->get();
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
				
			$data['typestr'] =  array( '0' => '', '1' => 'Item','2' => 'Package');
			
			# get Quantity Type
			$configquantitytypedata = New config_quantitytype_m;
			$data['quantitytype'] = $configquantitytypedata->where('id', $data['qtytype_id'])->first();
			# get Product Category
			$configproductcategorydata = New config_productcategory_m;
			$data['productcategory'] = $configproductcategorydata->where('id', $data['category'])->first();
			
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
					$productArr[$datap['id']] = $datap['code'] . ' (' . $datap['name'] . ')';
				}
			}
			
			$imagedata = New product_image_m;
			$promotiondata = New product_promotion_m;
			$userdata = New User_m;
			
			$created_by_name = $updated_by_name = "";
			$user = $userdata->where('id', $data['created_by'])->first();
			if($user)
				$created_by_name = $user['name'];
			$user2 = $userdata->where('id', $data['updated_by'])->first();
			if($user2)
				$updated_by_name = $user2['name'];
				
			$data['created_by_name'] = $created_by_name;
			$data['updated_by_name'] = $updated_by_name;
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
			'name' => 'required',
			'category' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
			'qtytype_id' => 'required',
		]);
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$name = trim(preg_replace('!\s+!', ' ', $postdata->input("name")));
		
		#check exist code
		$countcode = product_m::where('code', $code)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/form')->withErrors($messages);
		}
		
		$data = array(
			'code' => $code,
			'type' => 2,
			'name' => $name,
			'description' => $postdata->input("description") != null ? $postdata->input("description") : '',
			'qtytype_id' => $postdata->input("qtytype_id") != null ? $postdata->input("qtytype_id") : '1',
			'weight' => $postdata->input("weight") != null ? $postdata->input("weight") : '0',
			'point' => $postdata->input("point") != null ? $postdata->input("point") : '0',
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			//'last_purchase' => $postdata->input("last_purchase") > 0 ? $postdata->input("last_purchase") : 0,
			//'quantity_min' => $postdata->input("quantity_min") > 0 ? $postdata->input("quantity_min") : 0,
			'quantity' => 0,
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'year' => $postdata->input("year") > 1900 ? $postdata->input("year") : 1900,
			'category' => $postdata->input("category") > 0 ? $postdata->input("category") : '0',
			'created_by' => Auth::user()->id,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth::user()->id,
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
						'created_by' => Auth::user()->id,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_by' => Auth::user()->id,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$packagedata->insert($datapraduct);
				}
			}
		}
		
		return redirect("product/package_edit/" . $id . "/1" )->with("info","Success Submit " . $data['code'] . " (" . $data['name'] . ")");
    }
	
    public function package_update(Request $postdata, $id = 0){
		$productdata = New product_m;
		$checkproduct = $productdata->where('id', $id)->where('type', 2)->first();
		if($checkproduct == false)
			return redirect("product/listing")->with("errorid"," Data Not Found ");
			
		$this->validate($postdata,[
			'code' => 'required',
			'name' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
			'qtytype_id' => 'required',
		]);
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$name = trim(preg_replace('!\s+!', ' ', $postdata->input("name")));
		
		#check exist code
		$productdata = New product_m;
		$countcode = $productdata->where('code','=',$code)->where('id','<>', $id)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/edit/' . $id)->withErrors($messages);
		}
		
		$data = array(
			'code' => $code,
			'name' => $name,
			'description' => $postdata->input("description") != null ? $postdata->input("description") : '',
			'qtytype_id' => $postdata->input("qtytype_id") != null ? $postdata->input("qtytype_id") : '1',
			'weight' => $postdata->input("weight") != null ? $postdata->input("weight") : '0',
			'point' => $postdata->input("point") != null ? $postdata->input("point") : '0',
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			//'last_purchase' => $postdata->input("last_purchase") > 0 ? $postdata->input("last_purchase") : 0,
			//'quantity_min' => $postdata->input("quantity_min") > 0 ? $postdata->input("quantity_min") : 0,
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'year' => $postdata->input("year") > 1900 ? $postdata->input("year") : 1900,
			'category' => $postdata->input("category") > 0 ? $postdata->input("category") : '0',
			'updated_by' => Auth::user()->id,
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
						'updated_by' => Auth::user()->id,
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
						'created_by' => Auth::user()->id,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_by' => Auth::user()->id,
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
		
		return redirect("product/package_view/" . $id)->with("info","Success Save " . $postdata->input("name") . "");
    }
	
	public function upload_image(Request $postdata,$id = 0){
		$imagedata = New product_image_m;
		$datajson = array(
			'status' => 'Fail',
			'remarks' => 'Product not Founds',
		);
		$checkproduct = product_m::where('id', $id)->first();
		if($checkproduct == true){
			$statusimg = 1;
			$mainimage = $imagedata->where('product_id', $id)->where('status', 1)->first();
			if($mainimage == true)
				$statusimg = 0;
			$data = array(
				'product_id' => $id,
				'description' => $postdata->input("description") != null ? $postdata->input("description") : '',
				'status' => $statusimg,
				'created_by' => Auth::user()->id,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_by' => Auth::user()->id,
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
			$data['imageArr'] = $imagedata->where('product_id',$id)->orderBy('status', 'desc')->orderBy('id', 'desc')->get();
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
						return redirect("product/search/" . $search)->with("info","Product " . $checkproduct['code'] . "  (" . $checkproduct['name'] . " ) Deleted Successfully!!");
					else
						return redirect("product/listing")->with("info","Product " . $checkproduct['code'] . "  (" . $checkproduct['name'] . " ) Deleted Successfully!!");
					
				}
			}
		}
		return redirect("product/listing");
    }
	
	public function set_mainimage(Request $postdata){
		$product_id = $postdata->input("product_id");
		$imageid = $postdata->input("imageid");
		if($product_id > 0 && $imageid > 0){
			#set all 0
			$data = array(
				'status' => 0,
			);
			$imagedata = New product_image_m;
			$imagedata->where('product_id',$product_id)->update($data);
			# set 1
			$data = array(
				'status' => 1,
				'updated_by' => Auth::user()->id,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$imagedata->where('id',$imageid)->where('product_id',$product_id)->update($data);
			return "success";
		}
		return "not found";
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
	
	#pass to Amin
	public function all_data_product(){
		$nowdatetime =  date('Y-m-d H:i:s');
		$productdata = New product_m;
		$promotiondata = New product_promotion_m;
		$imagedata = New product_image_m;
		$productQuery = $productdata->orderBy('id', 'desc')->where('status',1)->get();
		# get Tax GST percentage		
		$taxgst = config_tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
		$productArr = array(
			'Product' => array(),
			'Package' => array(),
			'Promotion' => array(),
		);
		if(count($productQuery) > 0){
			foreach($productQuery->all() as $key => $row){
				$type = "Product";
				if($row->type == 2)
					$type = "Package";
					
				$productid = $row->id;
				
				#price after gst
				$price_wm = $row->price_wm;
				$price_em = $row->price_em;
				$price_staff = $row->price_staff;
				$wm_gst = $wm_aftergst = $em_gst = $em_aftergst = $staff_gst = $staff_aftergst = 0;
				if($price_wm > 0){
					$wm_gst = ($price_wm / 100) * $gstpercentage;
					$wm_aftergst = $price_wm + $wm_gst;
				}
				if($price_em > 0){
					$em_gst = ($price_em / 100) * $gstpercentage;
					$em_aftergst = $price_em + $em_gst;
				}
				if($price_staff > 0){
					$staff_gst = ($price_staff / 100) * $gstpercentage;
					$staff_aftergst = $price_staff + $staff_gst;
				}
				
				$data = array(
					'id' => $productid,
					'code' => $row->code,
					'type' => $row->type,
					'name' => $row->name,
					'year' => $row->year,
					'category' => $row->category,
					'weight' => $row->weight,
					'point' => $row->point,
					'price_wm' => number_format($price_wm, 2, '.', ''),
					'wm_gst' => number_format($wm_gst, 2, '.', ''),
					'wm_aftergst' => number_format($wm_aftergst, 2, '.', ''),
					'price_em' => number_format($price_em, 2, '.', ''),
					'em_gst' => number_format($em_gst, 2, '.', ''),
					'em_aftergst' => number_format($em_aftergst, 2, '.', ''),
					'price_staff' => number_format($price_staff, 2, '.', ''),
					'staff_gst' => number_format($staff_gst, 2, '.', ''),
					'staff_aftergst' => number_format($staff_aftergst, 2, '.', ''),
					
				);
				#image
				$image = $imagedata->where('product_id',$productid)->orderBy('status', 'desc')->orderBy('id', 'desc')->first();
				if($image){
					$data['image_id'] = $image['id'];
					$data['image_name'] = $image['file_name'];
					$data['image_description'] = $image['description'];
					$data['image_path'] = $image['path'];
				}
				
				#in promotion range
 				$promotion = $promotiondata->where('product_id',$productid)
											->where('start','<=',$nowdatetime)
											->where('end','>=',$nowdatetime)
											->where('status',1)
											->orderBy('id', 'desc')->first();
				if($promotion){
					$type = "Promotion";
					
					#price after gst
					$price_wm = $promotion['price_wm'];
					$price_em = $promotion['price_em'];
					$price_staff = $promotion['price_staff'];
					$wm_gst = $wm_aftergst = $em_gst = $em_aftergst = $staff_gst = $staff_aftergst = 0;
					if($price_wm > 0){
						$wm_gst = ($price_wm / 100) * $gstpercentage;
						$wm_aftergst = $price_wm + $wm_gst;
					}
					if($price_em > 0){
						$em_gst = ($price_em / 100) * $gstpercentage;
						$em_aftergst = $price_em + $em_gst;
					}
					if($price_staff > 0){
						$staff_gst = ($price_staff / 100) * $gstpercentage;
						$staff_aftergst = $price_staff + $staff_gst;
					}
					$data['price_wm'] = number_format($price_wm, 2, '.', '');
					$data['wm_gst'] = number_format($wm_gst, 2, '.', '');
					$data['wm_aftergst'] = number_format($wm_aftergst, 2, '.', '');
					$data['price_em'] = number_format($price_em, 2, '.', '');
					$data['em_gst'] = number_format($em_gst, 2, '.', '');
					$data['em_aftergst'] = number_format($em_aftergst, 2, '.', '');
					$data['price_staff'] = number_format($price_staff, 2, '.', '');
					$data['staff_gst'] = number_format($staff_gst, 2, '.', '');
					$data['staff_aftergst'] = number_format($staff_aftergst, 2, '.', '');
					$data['promotion_id'] = $promotion['id'];
					$data['promotion_description'] = $promotion['description'];
					
				}
				
				$productArr[$type][] = $data;
			}
		}
		$datalisting = array(
			'nowdatetime' => $nowdatetime,
			'countproduct' => $productdata->count(),
			'productArr' => $productArr,
			'typeArr' => array( '0' => '', '1' => 'Product','2' => 'Package ','3' => 'Promotion' ),
		);
		return $datalisting;
    }
	
	public function single_data_product($id = 0){
		# Bhaihaqi modify 2018-04-09 10:27 PM
		$data = array();
		$productArr = array();
		if($id > 0){
			$productdata = New product_m;
			$datap = $productdata->where('id', $id)->first();
			if($datap){
				# get Tax GST percentage		
				$taxgst = config_tax_m::where('code', 'gst')->first();
				if($taxgst == false)
					$gstpercentage = 6;
				else
					$gstpercentage = $taxgst['percent'];
					
				# Price of Product (Calc GST)	
				$price_wm = $datap['price_wm'];
				$price_em = $datap['price_em'];
				$price_staff = $datap['price_staff'];
				$wm_gst = $wm_aftergst = $em_gst = $em_aftergst = $staff_gst = $staff_aftergst = 0;
				if($price_wm > 0){
					$wm_gst = ($price_wm / 100) * $gstpercentage;
					$wm_aftergst = $price_wm + $wm_gst;
				}
				if($price_em > 0){
					$em_gst = ($price_em / 100) * $gstpercentage;
					$em_aftergst = $price_em + $em_gst;
				}
				if($price_staff > 0){
					$staff_gst = ($price_staff / 100) * $gstpercentage;
					$staff_aftergst = $price_staff + $staff_gst;
				}
				$packagedata = New product_package_m;
				if($datap['type'] == 2){
					#Type Product Package
					$product_list = $packagedata->where('package_id', $id)->get();
					if(count($product_list) > 0){
						foreach($product_list->all() as $key => $row){
							$package_item = $productdata->where('id', $row->product_id)->where('type','<>', 2)->first();
							$productArr[$package_item['id']] = $package_item;
							
							$price_wm2 = $package_item['price_wm'];
							$price_em2 = $package_item['price_em'];
							$price_staff2 = $package_item['price_staff'];
							$wm_gst2 = $wm_aftergst2 = $em_gst2 = $em_aftergst2 = $staff_gst2 = $staff_aftergst2 = 0;
							if($price_wm2 > 0){
								$wm_gst2 = ($price_wm2 / 100) * $gstpercentage;
								$wm_aftergst2 = $price_wm2 + $wm_gst2;
							}
							if($price_em2 > 0){
								$em_gst2 = ($price_em2 / 100) * $gstpercentage;
								$em_aftergst2 = $price_em2 + $em_gst2;
							}
							if($price_staff2 > 0){
								$staff_gst2 = ($price_staff2 / 100) * $gstpercentage;
								$staff_aftergst2 = $price_staff2 + $staff_gst2;
							}
							
							$productArr[$package_item['id']]['price_wm'] = number_format($price_wm2, 2, '.', '');
							$productArr[$package_item['id']]['wm_gst'] = number_format($wm_gst2, 2, '.', '');
							$productArr[$package_item['id']]['wm_aftergst'] = number_format($wm_aftergst2, 2, '.', '');
							$productArr[$package_item['id']]['price_em'] = number_format($price_em2, 2, '.', '');
							$productArr[$package_item['id']]['em_gst'] = number_format($em_gst2, 2, '.', '');
							$productArr[$package_item['id']]['em_aftergst'] = number_format($em_aftergst2, 2, '.', '');
							$productArr[$package_item['id']]['price_staff'] = number_format($price_staff2, 2, '.', '');
							$productArr[$package_item['id']]['staff_gst'] = number_format($staff_gst2, 2, '.', '');
							$productArr[$package_item['id']]['staff_aftergst'] = number_format($staff_aftergst2, 2, '.', '');
						}
					}
					$data['productArr'] = $productArr;
					// $data['product_list'] = $product_list; x guna
					$data['typename'] = 'Package';
				}
				else{
					#Type Product
					$package_list = $packagedata->where('product_id',$id)->orderBy('id', 'desc')->get();
					if(count($package_list) > 0){
						foreach($package_list->all() as $key => $row){
							$package_id = $row->package_id;
							$package = $productdata->where('id', $package_id)->first();
							$productArr[$package['id']] = $package;
							
							$price_wm2 = $package['price_wm'];
							$price_em2 = $package['price_em'];
							$price_staff2 = $package['price_staff'];
							$wm_gst2 = $wm_aftergst2 = $em_gst2 = $em_aftergst2 = $staff_gst2 = $staff_aftergst2 = 0;
							if($price_wm2 > 0){
								$wm_gst2 = ($price_wm2 / 100) * $gstpercentage;
								$wm_aftergst2 = $price_wm2 + $wm_gst2;
							}
							if($price_em2 > 0){
								$em_gst2 = ($price_em2 / 100) * $gstpercentage;
								$em_aftergst2 = $price_em2 + $em_gst2;
							}
							if($price_staff2 > 0){
								$staff_gst2 = ($price_staff2 / 100) * $gstpercentage;
								$staff_aftergst2 = $price_staff2 + $staff_gst2;
							}
							
							$productArr[$package['id']]['price_wm'] = number_format($price_wm2, 2, '.', '');
							$productArr[$package['id']]['wm_gst'] = number_format($wm_gst2, 2, '.', '');
							$productArr[$package['id']]['wm_aftergst'] = number_format($wm_aftergst2, 2, '.', '');
							$productArr[$package['id']]['price_em'] = number_format($price_em2, 2, '.', '');
							$productArr[$package['id']]['em_gst'] = number_format($em_gst2, 2, '.', '');
							$productArr[$package['id']]['em_aftergst'] = number_format($em_aftergst2, 2, '.', '');
							$productArr[$package['id']]['price_staff'] = number_format($price_staff2, 2, '.', '');
							$productArr[$package['id']]['staff_gst'] = number_format($staff_gst2, 2, '.', '');
							$productArr[$package['id']]['staff_aftergst'] = number_format($staff_aftergst2, 2, '.', '');
						}
					}
							
					$data['productArr'] = $productArr;
					// $data['package_list'] = $package_list; x guna
					$data['typename'] = 'Product';
				}
				# get Quantity Type
				$configquantitytypedata = New config_quantitytype_m;
				$quantitytype = $configquantitytypedata->where('id', $datap['qtytype_id'])->first();
				
				$data['data'] = $datap;
				$data['quantitytype'] = $quantitytype['type'];
				$data['price_wm'] = number_format($price_wm, 2, '.', '');
				$data['wm_gst'] = number_format($wm_gst, 2, '.', '');
				$data['wm_aftergst'] = number_format($wm_aftergst, 2, '.', '');
				$data['price_em'] = number_format($price_em, 2, '.', '');
				$data['em_gst'] = number_format($em_gst, 2, '.', '');
				$data['em_aftergst'] = number_format($em_aftergst, 2, '.', '');
				$data['price_staff'] = number_format($price_staff, 2, '.', '');
				$data['staff_gst'] = number_format($staff_gst, 2, '.', '');
				$data['staff_aftergst'] = number_format($staff_aftergst, 2, '.', '');
					
				$imagedata = New product_image_m;
				$promotiondata = New product_promotion_m;
				$data['imageArr'] = $imagedata->where('product_id',$id)->orderBy('status', 'desc')->orderBy('id', 'desc')->get();
				$data['promotion_list'] = $promotiondata->where('product_id',$id)->orderBy('id', 'desc')->get();
				$data['statusArr'] = array('1' => 'Active', '0' => 'Inactive');
				$data['gstpercentage'] = $gstpercentage;
			}
		}
		dd($data);
		return $data;
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
