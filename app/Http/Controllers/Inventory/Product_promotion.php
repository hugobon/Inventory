<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\product_m;
use App\inventory\product_promotion_m;
use App\inventory\product_promotion_gift_m;
use App\configuration\config_tax_m;
use App\User_m;

class Product_promotion extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        return redirect('product/promotion/listing');
    }

    public function listing(){
		$productdata = New product_m;
		$datap = $productdata->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($datap) > 0){
			foreach($datap->all() as $key => $row)
				$productArr[$row->id] = $row->code . ' (' . $row->name . ')';
		}
		$promotiondata = New product_promotion_m;
		$data = array(
			'countpromotion' => $promotiondata->count(),
			'promotionArr' => $promotiondata->orderBy('id', 'desc')->paginate(10),
			'productArr' => $productArr,
			'statusArr' => array( '1' => 'On','0' => 'Off'),
		);
        return view('Inventory/promotion_listing',$data);
    }
	
	public function search($x = ''){
		if($x == '' || @unserialize(base64_decode($x)) == false)
			return redirect('product/promotion/listing');
			
		$datadecode = unserialize(base64_decode($x));
		$search_product = isset($datadecode['search_product']) ? $datadecode['search_product'] : '';
		$search_status = isset($datadecode['search_status']) ? $datadecode['search_status'] : '';
		if($search_product == '' && $search_status == '')
			return redirect('product/promotion/listing');
		$promotiondata = New product_promotion_m;
		if($search_product != '' && $search_status != ''){
			$countpromotion = $promotiondata->where('product_id',$search_product)
												->where('status',$search_status)->count();
			$promotionArr = $promotiondata->where('product_id',$search_product)
												->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		else if($search_product != ''){
			$countpromotion = $promotiondata->where('product_id',$search_product)->count();
			$promotionArr = $promotiondata->where('product_id',$search_product)->orderBy('id', 'desc')->paginate(10);
		}
		else{
			$countpromotion = $promotiondata->where('status',$search_status)->count();
			$promotionArr = $promotiondata->where('status',$search_status)->orderBy('id', 'desc')->paginate(10);
		}
		
		$productdata = New product_m;
		$data = $productdata->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($data) > 0){
			foreach($data->all() as $key => $row)
				$productArr[$row->id] = $row->code . ' (' . $row->name . ')';
		}
		$data = array(
			'countpromotion' => $countpromotion,
			'promotionArr' => $promotionArr,
			'productArr' => $productArr,
			'statusArr' => array( '1' => 'On','0' => 'Off'),
			'search_product' => $search_product,
			'search_status' => $search_status,
		);
        return view('Inventory/promotion_listing',$data);
    }
	

    public function form_search(Request $postdata){
		$search_product = trim($postdata->input("search_product"));
		$search_status = trim($postdata->input("search_status"));
		
		if($search_product == '' && $search_status == '')
			return redirect('product/promotion/listing');
			
		$rowdata = array(
			'search_product' => $search_product,
			'search_status' => $search_status,
		);
		
		$base64data = trim(base64_encode(serialize($rowdata)), "=.");
		
        return redirect('product/promotion/search/' . $base64data);
    }

    public function form(){
		# get Tax GST percentage
		$taxgst = config_tax_m::where('code', 'gst')->first();
		if($taxgst == false)
			$gstpercentage = 6;
		else
			$gstpercentage = $taxgst['percent'];
		
		$productdata = New product_m;
		$datap = $productdata->orderBy('code', 'asc')->get();
		$productArr = array();
		if(count($datap) > 0){
			foreach($datap->all() as $key => $row){
				$productArr[$row->id] = array(
					'code' => ($row->type == 1 ? '(Product) - ' : '(Package) - ') . $row->code . ' (' . $row->name . ')',
					'desc' => $row->name,
				);
			}
		}
		
		$productGift = $productdata->where('type','<>',2)->orderBy('code', 'asc')->get();
		$productGiftArr = array();
		if(count($productGift) > 0){
			foreach($productGift->all() as $keygift => $rowgift)
				$productGiftArr[$rowgift->id] = $rowgift->code . ' (' . $rowgift->name . ')';
		}
		$data = array();
		$data['gstpercentage'] = $gstpercentage;
		$data['productArr'] = $productArr;
		$data['productGiftArr'] = $productGiftArr;
		return view('Inventory/product_promotion_form',$data);
    }
	
	public function edit($id = 0){
		if($id > 0){
			$promotiondata = New product_promotion_m;
			$promotion = $promotiondata->where('id', $id)->first();
			if($promotion == false)
				return redirect("product/promotion/listing")->with("errorid"," Not Found ");
				
			# get Tax GST percentage
			$taxgst = config_tax_m::where('code', 'gst')->first();
			if($taxgst == false)
				$gstpercentage = 6;
			else
				$gstpercentage = $taxgst['percent'];
			
			$product_id = $promotion['product_id'];
			$productdata = New product_m;
			$productArr = $productdata->where('id', $product_id)->first();
			
			$productGift = $productdata->where('type','<>',2)->orderBy('code', 'asc')->get();
			$productGiftArr = array();
			if(count($productGift) > 0){
				foreach($productGift->all() as $keygift => $rowgift)
					$productGiftArr[$rowgift->id] = $rowgift->code . ' (' . $rowgift->name . ')';
			}
			$giftdata = New product_promotion_gift_m;
			$data = array();
			$data = $promotion;
			$data['gstpercentage'] = $gstpercentage;
			$data['productArr'] = $productArr;
			$data['statusArr'] = array( '1' => 'On','0' => 'Off');
			$data['gift_list'] = $giftdata->where('promotion_id', $id)->get();
			$data['productGiftArr'] = $productGiftArr;
			return view('Inventory/product_promotion_form',$data);
		}
		return redirect("product/promotion/listing");
    }
	
	public function view($id = 0){
		if($id > 0){
			$promotiondata = New product_promotion_m;
			$promotion = $promotiondata->where('id', $id)->first();
			if($promotion == false)
				return redirect("product/promotion/listing")->with("errorid"," Not Found ");
				
			# get Tax GST percentage
			$taxgst = config_tax_m::where('code', 'gst')->first();
			if($taxgst == false)
				$gstpercentage = 6;
			else
				$gstpercentage = $taxgst['percent'];
			
			$product_id = $promotion['product_id'];
			$productdata = New product_m;
			$productArr = $productdata->where('id', $product_id)->first();
			
			$giftdata = New product_promotion_gift_m;
			$gift_list = $giftdata->where('promotion_id', $id)->get();

			#get gift product name
			$productGiftArr = array();
			if(count($gift_list) > 0){
				foreach($gift_list->all() as $key => $row){
					$datap = $productdata->where('id', $row->product_id)->where('type','<>', 2)->first();
					$productGiftArr[$datap['id']] = $datap['code'] . ' (' . $datap['name'] . ')';
				}
			}
			
			$data = array();
			$userdata = New User_m;
			
			$created_by_name = $updated_by_name = "";
			$user = $userdata->where('id', $promotion['created_by'])->first();
			if($user)
				$created_by_name = $user['name'];
			$user2 = $userdata->where('id', $promotion['updated_by'])->first();
			if($user2)
				$updated_by_name = $user2['name'];
			
			$data = $promotion;	
			$data['created_by_name'] = $created_by_name;
			$data['updated_by_name'] = $updated_by_name;
			$data['gstpercentage'] = $gstpercentage;
			$data['productArr'] = $productArr;
			$data['gift_list'] = $gift_list;
			$data['productGiftArr'] = $productGiftArr;
			$data['statusArr'] = array( '1' => 'On','0' => 'Off');
			return view('Inventory/product_promotion_view',$data);
		}
		return redirect("product/promotion/listing");
    }

    public function insert(Request $postdata){
		$this->validate($postdata,[
			'product_id' => 'required',
			'daterange' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
		]);
		
		$daterange = $postdata->input("daterange");
		$dateArr = explode(" - ",$daterange);
		$start = $end = '';
		if(count($dateArr) > 1){
			$startdate = trim($dateArr[0]);
			$enddate = trim($dateArr[1]);
			$start = $this->daterangepickermysql($startdate);
			$end = $this->daterangepickermysql($enddate);
		}
		if($start == '' || $end == ''){
			$messages = "Datetime Promotion Not Valid";
			return redirect('product/promotion/form')->withErrors($messages);
		}
		
		$data = array(
			'product_id' => $postdata->input("product_id"),
			'description' => $postdata->input("description") != null ? $postdata->input("description") : '',
			'price_checked' => 1,
			'gift_checked' => 1,
			'start' => $start,
			'end' => $end,
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff") != null ? $postdata->input("price_staff") : '0',
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$promotiondata = New product_promotion_m;
		$id = $promotiondata->insertGetId($data);
		if($id > 0){
			#product list insert 
			$giftid = $postdata->input("giftid");
			$promotiongift = $postdata->input("promotiongift");
			$promotionquantity = $postdata->input("promotionquantity");
			$promotiondescription = $postdata->input("promotiondescription");
			$giftdata = New product_promotion_gift_m;
			foreach($giftid as $k => $v){
				if($promotiongift[$k] > 0){
					$datagift = array(
						'promotion_id' => $id,
						'product_id' => $promotiongift[$k],
						'quantity' => $promotionquantity[$k] > 0 ? $promotionquantity[$k] : 1,
						'description' => $promotiondescription[$k] != null ? $promotiondescription[$k] : '',
						'created_by' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_by' => 1,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$giftdata->insert($datagift);
				}
			}
		}
		
		return redirect("product/promotion/view/" . $id)->with("info","Success Submit Product Promotion " . $data['description'] . " ");
    }
	
	public function update(Request $postdata, $id = 0){
		$promotiondata = New product_promotion_m;
		$promotion = $promotiondata->where('id', $id)->first();
		if($promotion == false)
			return redirect("product/promotion/listing")->with("errorid"," Not Found ");
			
		$this->validate($postdata,[
			'daterange' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
		]);
		
		$daterange = $postdata->input("daterange");
		$dateArr = explode(" - ",$daterange);
		$start = $end = '';
		if(count($dateArr) > 1){
			$startdate = trim($dateArr[0]);
			$enddate = trim($dateArr[1]);
			$start = $this->daterangepickermysql($startdate);
			$end = $this->daterangepickermysql($enddate);
		}
		if($start == '' || $end == ''){
			$messages = "Datetime Promotion Not Valid";
			return redirect('product/promotion/form')->withErrors($messages);
		}
		
		$data = array(
			'description' => $postdata->input("description") != null ? $postdata->input("description") : '',
			'start' => $start,
			'end' => $end,
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff") != null ? $postdata->input("price_staff") : '0',
			'status' => $postdata->input("status") != null ? $postdata->input("status") : '1',
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		
		$promotiondata->where('id',$id)->update($data);
		
		#product list insert  / update / delete
		$giftid = $postdata->input("giftid");
		$promotiongift = $postdata->input("promotiongift");
		$promotionquantity = $postdata->input("promotionquantity");
		$promotiondescription = $postdata->input("promotiondescription");
			
		$giftdata = New product_promotion_gift_m;
		$valid_id = array();
		foreach($giftid as $k => $v){
			if($v > 0){
				#update
				if($promotiongift[$k] > 0){
					$datagift = array(
						'promotion_id' => $id,
						'product_id' => $promotiongift[$k],
						'quantity' => $promotionquantity[$k] > 0 ? $promotionquantity[$k] : 1,
						'description' => $promotiondescription[$k] != null ? trim($promotiondescription[$k]) : '',
						'updated_by' => 1,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$giftdata->where('id',$v)->update($datagift);
					$valid_id[] = $v;
				}
			}
			else{
				#insert
				if($promotiongift[$k] > 0){
					$datagift = array(
						'promotion_id' => $id,
						'product_id' => $promotiongift[$k],
						'quantity' => $promotionquantity[$k] > 0 ? $promotionquantity[$k] : 1,
						'description' => $promotiondescription[$k] != null ? trim($promotiondescription[$k]) : '',
						'created_by' => 1,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_by' => 1,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$v = $giftdata->insertGetId($datagift);
					$valid_id[] = $v;
				}
			}
		}
		#delete
		if(count($valid_id) > 0){
			#Delete WHERE NOT IN array
			$giftdata->where('promotion_id', $id)->whereNotIn('id', $valid_id)->delete();
		}
		else{
			#Delete All
			$giftdata->where('promotion_id', $id)->delete();
		}
		
		return redirect("product/promotion/view/" . $id)->with("info","Success Save Product Promotion " . $postdata->input("description") . "");
    }
	
    public function delete($data = ''){
		if(@unserialize(base64_decode($data)) == true){
			$datadecode = unserialize(base64_decode($data));
			$delete = isset($datadecode['delete']) ? $datadecode['delete'] : 0;
			$deleteid = isset($datadecode['deleteid']) ? $datadecode['deleteid'] : 0;
			if($delete == 'promotion' && $deleteid > 0){
				$checkpromotion = product_promotion_m::where('id', $deleteid)->first();
				if($checkpromotion == false)
					return redirect("product/promotion/listing")->with("errorid"," Data not found");
				
				$search = isset($datadecode['search']) ? $datadecode['search'] : '';
				if(product_promotion_m::where('id', $deleteid)->delete()){
					#delete all gift
					$giftdata = New product_promotion_gift_m;
					$giftdata->where('promotion_id', $deleteid)->delete();
					
					if($search != '')
						return redirect("product/promotion/search/" . $search)->with("info","Product Promotion " . $checkpromotion['description'] . "  Deleted Successfully!!");
					else
						return redirect("product/promotion/listing")->with("info","Product Promotion " . $checkpromotion['description'] . " Deleted Successfully!!");
					
				}
			}
		}
		return redirect("product/promotion/listing");
    }
	
	function daterangepickermysql($datetime){
		# $datedatetime = d/m/Y h:mm A format
		$dateArr = explode(" ",$datetime);
		$sqldate = $sqltime = '';
		if(count($dateArr) > 2){
			$date = trim($dateArr[0]);
			$sqltime = trim($dateArr[1]) . ' ' . trim($dateArr[2]);
			$tmp_date = explode("/", $date);
			if(sizeof($tmp_date) != 3)
				return '';
			
			$sqldate = $tmp_date[2] . "-" . $tmp_date[1] . "-" . $tmp_date[0];
		}
		$datetime = $sqldate . ' ' . $sqltime;
		return date('Y-m-d H:i:s',strtotime($datetime));
	}
}
