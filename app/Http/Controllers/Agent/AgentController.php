<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\agentmaster;
use App\users;
use App\agent_order_stock;
use App\inventory\product_m;
use App\inventory\product_image_m;
use App\inventory\product_package_m;
use App\agent_select_product;
use App\address;
use App\delivery_type;
use App\order_hdr;
use App\order_item;
use App\global_status;
use App\config_tax;
use Auth;
use DB;

use App\Http\Controllers\Inventory\Product;
use App\Http\Controllers\DeliveryOrder\DeliveryOrderController;

class AgentController extends Controller
{
    public function fn_get_view(){
    	return view('Agent.agent_register');
    }

    public function fn_save_agent_record(Request $request){

    	try{

    		$data = [

    			'agent_type' => $request->get('agent_type'),
    			'agent_username' => $request->get('agent_username'),
    			'agent_name' => $request->get('agent_name'),
    			'agent_date_of_birth' => $request->get('agent_dateofbirth'),
    			'agent_gender' => $request->get('agent_gender'),
    			'agrnt_marital_status' => $request->get('agent_marital_status'),
    			'agent_race' => $request->get('agent_race'),
    			'agent_id_type' => $request->get('agent_id_type'),
    			'agent_id' => $request->get('agent_id'),
    			'agent_photo_id' => $request->get('agent_photo_id'),
    			'agent_profile_photo' => $request->get('agent_profile_photo'),
    			'agent_mobile_no' => $request->get('agent_number'),
    			'agent_email' => $request->get('agent_email'),
    			'agent_street' => $request->get('agent_address_street'),
    			'agent_postcode' => $request->get('agent_address_poscode'),
    			'agent_city' => $request->get('agent_address_city'),
    			'agent_country' => $request->get('agent_address_country'),
    			'agent_bank_name' => $request->get('agent_bank_name'),
    			'agent_bank_acc_no' => $request->get('agent_bank_acc_no'),
    			'agent_bank_acc_name' => $request->get('agent_bank_acc_name'),
    			'agent_bank_acc_type' => $request->get('agent_bank_acc_type'),
    			'agent_delivery_type' =>$request->get('agent_delivery_type'),
    			'agent_payment_type' => $request->get('agent_payment_type'),
    			'agent_secqurity_pass' => $request->get('agent_secqurity_pass'),
    			'agent_benefical_name' => $request->get('agent_call_name')

    		];

    		$data['created_by'] = Auth::user()->name;
    		$data['created_at'] = \Carbon\Carbon::now();

    		// echo "<pre>";
    		// echo print_r($data);
    		// echo "</pre>";
    		// die();

    		agentmaster::insert($data);

    		$return['message'] = 'succssfuly';
    		$return['status'] = '01';

    	}
    	catch(\Exception $e){

    		$return['message'] = $e->getMessage();
    		$return['status'] = '02';

    	}
    	return redirect('agent/view');
    }

    function fn_view_agent_record(){

    	try{

    		// $data = agentmaster::
    		$data = [

    			'name' => "amin"
    		];

    		$return['message'] = 'succssfuly';
    		$return['status'] = '01';
    	}
    	catch(\Exception $e){

    		$return['message'] = $e->getMessage();
    		$return['status'] = '02';
    	}

    	return view('Agent.agent_view')->with($data);
    }

    public function fn_get_agent_order_stock($mode = null,$agent_id = null){

        try{

           $data = agent_order_stock::select('agent_id','country','delivery_type','optional','poscode','city','state')
                                ->where('agent_id',$agent_id)
                                ->first();

            $return['message'] = 'succssfuly save record';
            $return['status'] = '01';
        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = '02';
        }

        
        if(isset($data)){

            if($data['delivery_type'] == "01"){
                $data['delivery_type_desc'] = "Same Address";
            }
            else if($data['delivery_type'] == "02"){
                $data['delivery_type_desc'] = "Different Address";
            }
            else if($data['delivery_type'] == "03"){
                $data['delivery_type_desc'] = "Self Collect";
            }

            if($mode == "display"){
                return view('Agent.agent_order_stock_view',['return' => $return,'data' => $data]);
            }
            else if($mode == "edit"){
                return view('Agent.agent_order_stock',['return' => $return,'data' => $data]);
            }
        }
        else{

            $data = [

                'agent_id' => $agent_id,
                'country' => "",
                'delivery_type' => "",
                'optional' => "",
                'poscode' => "",
                'city' => "",
                'state' => ""
             ];
            // return $data;
            return view('Agent.agent_order_stock',['return' => $return,'data' => $data]);
        }
    }

    public function fn_save_agent_order_stock(Request $request){

        try{

            $data = agent_order_stock::select('agent_id')
                                ->where('agent_id',$request->get('agent_id'))
                                ->first();

            // echo "<pre>";
            // var_dump($data);
            // echo "</pre>";
            // die();

            if($data == null){

                $dataInsert = [

                    'agent_id' => $request->get('agent_id'),
                    'country' => $request->get('country'),
                    'delivery_type' => $request->get('delivery_type'),
                    'optional' => $request->get('address'),
                    'poscode' => $request->get('poscode'),
                    'city' => $request->get('city'),
                    'state' => $request->get('state'),
                    'created_by' => Auth::user()->name,
                    'created_at' => \Carbon\Carbon::now()
                ];

                agent_order_stock::insert($dataInsert);

                $return['message'] = 'succssfuly created';
                $return['status'] = '01';
            }
            else{

                $dataUpdate = [

                    'country' => $request->get('country'),
                    'delivery_type' => $request->get('delivery_type'),
                    'optional' => $request->get('address'),
                    'poscode' => $request->get('poscode'),
                    'city' => $request->get('city'),
                    'state' => $request->get('state'),
                    'updated_by' =>  Auth::user()->name,
                    'updated_at' => \Carbon\Carbon::now()
                ];

                agent_order_stock::where('agent_id',$request->get('agent_id'))
                                ->update($dataUpdate);

                $return['message'] = 'succssfuly updated';
                $return['status'] = '01';
            }

             
        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = '02';
        }

        // return $return;

        return redirect('agent/get_order_stock/'.'display'.'/'.$request->get('agent_id'))->with($return);
    }

    public function fn_get_product_list($mode = null){

            $product = Array();

        try{
            
            // $data = product_m::select("*")->paginate(12);

            $data = (new Product)->all_data_product();

            // echo "<pre>";
            // echo print_r($data);
            // echo "</pre>";
            // die();
            // dd($data);

            $product = array_merge( $data['productArr']['Product'], $data['productArr']['Package'],$data['productArr']['Promotion']);

            // dd($data,$product);

            $count = agent_select_product::where('agent_id',Auth::user()->id)->count();

            $return['message'] = 'succssfuly';
            $return['status'] = '01';
        }
        catch(\Exception $e){
            $return['message'] = $e->getMessage();
            $return['status'] = '02';
            $image = "";
        }

        // return $return;

        if($mode == "all"){
            return view('Agent.agent_product_list',compact('product','count'));
        }
        elseif($mode == "package"){
            return view('Agent.agent_product_package',compact('data','count'));
        }
        elseif ($mode == "promo") {
            return view('Agent.agent_product_promo',compact('data','count'));
        }
    }

    public function fn_get_checkout_items($agent_id = null){

        try{

            $cartItems = agent_select_product::leftJoin('product','product.id','=','agent_select_product.product_id')
                                            ->select('agent_select_product.id','product.id as product_id','product.name','product.description','product.price_wm','product.price_em','product.quantity_min'
                                                ,'product.quantity as stock_quantity','agent_select_product.quantity as total_quantity')
                                            ->where('agent_select_product.agent_id','=',$agent_id)
                                            ->get()->toArray();

            // dd($cartItems);die();
            $totalPrice_wm = 0.00;
            $totalPrice_em = 0.00;
            $grandTotalPrice_wm = 0.00;
            $grandTotalPrice_em = 0.00;
            foreach ($cartItems as $key => $value){

                $cartItems[$key]['price_wm'] = $this->fn_calc_gst_price(number_format(floatval($cartItems[$key]['price_wm']),2));
                $cartItems[$key]['price_em'] = $this->fn_calc_gst_price(number_format(floatval($cartItems[$key]['price_em']),2));

                $total_price_wm = $this->fn_calc_total_price($cartItems[$key]['total_quantity'],$cartItems[$key]['price_wm']);
                $total_price_em = $this->fn_calc_total_price($cartItems[$key]['total_quantity'],$cartItems[$key]['price_em']);

                $cartItems[$key]['total_price_wm'] = $total_price_wm;
                $cartItems[$key]['total_price_em'] = $total_price_em;

                $image = product_image_m::select('type','description','file_name','path')
                                        ->where('product_id',$cartItems[$key]['product_id'])
                                        ->orderBy('status','desc')
                                        ->first();

                $cartItems[$key]['image'] = ($image['path'] == null ? '' : $image['path']);

                $totalPrice_wm = $totalPrice_wm + str_replace(",","",$cartItems[$key]['total_price_wm']);
                $totalPrice_em = $totalPrice_em + str_replace(",","",$cartItems[$key]['total_price_em']);

            }

            // dd($grandTotalPrice_wm,$grandTotalPrice_em);
            if($totalPrice_wm < "300.00" || $totalPrice_em < "300.00"){

                $shipping_fee = number_format(floatval("10.00"),2);
            }
            else{

                $shipping_fee = number_format(floatval("0.00"),2);
            }

            $totalPrice_wm = number_format(floatval($totalPrice_wm),2);
            $totalPrice_em = number_format(floatval($totalPrice_em),2);

            $grandTotalPrice_wm = number_format(floatval($totalPrice_wm + $shipping_fee),2);
            $grandTotalPrice_em = number_format(floatval($totalPrice_em + $shipping_fee),2);

            $returnData = [

                'agent_id'        => $agent_id,
                'grandTotalPrice_wm' => $grandTotalPrice_wm,
                'grandTotalPrice_em' => $grandTotalPrice_em,
                'shippingPrice'  => $shipping_fee,
                'totalPrice_wm' => $totalPrice_wm,
                'totalPrice_em' => $total_price_em
            ];

            $deliveryType = delivery_type::select('id','delivery_code as code','type_description as description')
                                        ->get();

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";

        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }
        
        // dd($return);
        return view('Agent.agent_checkout',compact('cartItems','returnData','deliveryType'));
    }

    public function fn_save_selected_items(Request $request){

            $data = (!empty($request->get('item')) ? $request->get('item') : []);

        try{
    
            $product = product_m::select('type','code','price_wm','price_em','price_staff','quantity')
                                ->where('id',$data['product_id'])
                                ->first();

            $cartItem = agent_select_product::select('id','product_id','agent_id','quantity')
                                            ->where('product_id',$data['product_id'])
                                            ->where('agent_id',$data['agent_id'])
                                            ->first();
            if($cartItem == null){


                // $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_wm) * (int)$data['quantity']),2);

                // $total_price = str_replace(",", "", $total_price);
                
                $addToCart = Array(

                    'agent_id' => $data['agent_id'],
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'], 
                    'created_by' => Auth::user()->id,
                    'created_at' => \Carbon\Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
                );

                agent_select_product::insertGetId($addToCart);
            }
            else{

                // $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_wm) * (int)$data['quantity']),2);

                // dd(str_replace(",","",$total_price));

                // $updateQuantity = $data['quantity'] + $cartItem->quantity;
                // $updateTotalPrice = number_format(floatval($total_price + $cartItem->total_price),2);
                // $updateTotalPrice = str_replace(",","",$updateTotalPrice);
                agent_select_product::where('product_id',$data['product_id'])
                                        ->where('agent_id',$data['agent_id'])
                                        ->update([
                                            'quantity' => $updateQuantity,
                                            'updated_by' =>  Auth::user()->id,
                                            'updated_at' => \Carbon\Carbon::now()

                                        ]);

            }

            $count = agent_select_product::count();
            $return['message'] = "succssfuly inserted";
            $return['status'] = "01";            
            
        } 
        catch (\Exception $e){
            
            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        // dd($return);
        return compact('data','return','product','agent','count');
    }

    public function fn_get_place_order_items($agent_id = null,$deliveryType = null){

        // $agent_id = (!empty($request->get('agent_id')) ? $request->get('agent_id') : '');
        // $delivery_type = (!empty($request->get('delivery_type')) ? $request->get('delivery_type') : '');

        // dd($delivery_type);
        try{

            $addressData = address::select('id','name','address_code','street1','street2','poscode','city','state','country')
                                    ->where('address_code','=',$agent_id."_AGENT")
                                    ->where('reminder_flag','=','x')
                                    ->first();
                                    
            if($addressData == null){
                $addressData = address::select('id','name','address_code','street1','street2','poscode','city','state','country')
                                    ->where('address_code','=',$agent_id."_AGENT")
                                    ->first();
            }

            $cartItems = agent_select_product::leftJoin('product','product.id','=','agent_select_product.product_id')
                                            ->select('agent_select_product.id','product.id as product_id','product.name','product.description','product.price_wm','product.price_em','product.quantity_min'
                                                ,'product.quantity as stock_quantity','agent_select_product.quantity as total_quantity')
                                            ->where('agent_select_product.agent_id','=',$agent_id)
                                            ->get()->toArray();

            // dd($addressData);
            $totalPrice = 0.00;
            $grandTotalPrice = 0.00;
            foreach ($cartItems as $key => $value){

                if(strtolower($addressData->state) == strtolower("Sabah") || strtolower($addressData->state) ==  strtolower("Sarawak")){

                    $cartItems[$key]['price'] = $this->fn_calc_gst_price(number_format(floatval($cartItems[$key]['price_em']),2));
                    $total_price = $this->fn_calc_total_price($cartItems[$key]['total_quantity'],$cartItems[$key]['price']);
                    $cartItems[$key]['total_price'] = $total_price;
                }
                else{
                    $cartItems[$key]['price'] = $this->fn_calc_gst_price(number_format(floatval($cartItems[$key]['price_wm']),2));
                    $total_price = $this->fn_calc_total_price($cartItems[$key]['total_quantity'],$cartItems[$key]['price']);
                    $cartItems[$key]['total_price'] = $total_price;
                }
                
                // dd($cartItems);

                $image = product_image_m::select('type','description','file_name','path')
                                        ->where('product_id',$cartItems[$key]['product_id'])
                                        ->orderBy('status','desc')
                                        ->first();

                $cartItems[$key]['image'] = ($image->path == null ? '' : $image->path);

                $totalPrice = $totalPrice + str_replace(",","",$cartItems[$key]['total_price']);

            }
            // dd($cartItems,$image);
            //shipping fee
            if($totalPrice < "300.00"){

                $shipping_fee = number_format(floatval("10.00"),2);
            }
            else{

                $shipping_fee = number_format(floatval("0.00"),2);
            }

            //total price
            $totalPrice = number_format(floatval($totalPrice),2);
            //gandtotal price
            $grandTotalPrice = number_format(floatval($totalPrice + $shipping_fee),2);

            if($deliveryType == "01"){

                $address = [

                    'name'      => $addressData->name,
                    'address' => $addressData->street1.",".$addressData->street2.",".$addressData->poscode.",".$addressData->city.",".$addressData->state.",".$addressData->country,
                    'btnstatus' => "",
                    'id' => $addressData->id,
                    'code' => $addressData->address_code
                ];

            }
            elseif($deliveryType == "02"){

                $addressData = [];
                $address = [

                    'name'      => "",
                    'address' =>  "Self Pickup",
                    'btnstatus' => "hidden",
                    'id' => "",
                    'code' => ""
                ];
            }

            $returnData = [

                'agent_id'        => $agent_id,
                'grandTotalPrice' => $grandTotalPrice,
                'totalPrice' => $totalPrice,
                'shippingPrice'  => $shipping_fee,
                'address' => $address,
                'deliveryType' =>$deliveryType
            ];


            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";

            // dd($address);    
        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        // dd($cartItems);
        return view('Agent.agent_place_order',compact('cartItems','returnData','address','deliveryType'));
    }

    public function fn_delete_cart_item(Request $request){

            $id = $request->get('item');

        try{

            agent_select_product::where('id',$id)->delete();

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";

        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";

        }

        return compact('return');
    }

    public function fn_update_quantity_item(Request $request){

        $id = $request->get('id');
        $quantity = $request->get('quantity');
        // dd($quantity);

        try {

            $cartItem = agent_select_product::select('id','product_id','agent_id','quantity')
                                            ->where('id',$id)
                                            ->first();

            $product = product_m::select('type','code','price_wm','price_em','price_staff','quantity')
                                ->where('id',$cartItem['product_id'])
                                ->first();



            $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_wm) * (int)$quantity),2);

                $total_price = str_replace(",","", $total_price);
            // dd($total_price);

            // $updateQuantity = $quantity + $cartItem->quantity;
            // $updateTotalPrice = number_format(floatval($total_price + $cartItem->total_price),2);
            // $updateTotalPrice = str_replace(",","", $updateTotalPrice);

            agent_select_product::where('id',$id)
                                    ->update([

                                        'quantity' => $quantity,
                                        'updated_by' =>  Auth::user()->id,
                                        'updated_at' => \Carbon\Carbon::now()

                                    ]);

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";
            
        } 
        catch (\Exception $e) {

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
            
        }

        return compact('return');
    }

    public function fn_get_product_details($product_id = null){

        try {
            
            $data = (new Product)->single_data_product($product_id);

            // dd($data);

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";
        }
        catch(\Exception $e){
            
            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        dd($return,$data);
        return view('Agent.agent_product_detail',compact('data'));
    }

    private function fn_calc_total_price($quantity,$price){

        $total_price = ($quantity * $price);
        $total_price = number_format(floatval($total_price),2);

        return $total_price;
    }

    private function fn_calc_gst_price($price){

        try{

            $gstRate = config_tax::select('percent')
                                ->where('code',"gst")
                                ->first();


            $gst = 1 + ($gstRate->percent/100);

            $AfterGst = $price * $gst;
            $AfterGst = number_format(floatval($AfterGst),2);

            $return['message'] = "succssfuly calculate";
            $return['status'] = "01";

        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }
        // dd($AfterGst);
        return $AfterGst;
    }

    public function fn_save_address(Request $request){

        // dd($request->get('item'));
        $newAddress = $request->get('item');

        try{

            if($newAddress['id'] != "" && $newAddress['address_code'] != ""){

                $newAddress['updated_by'] =  Auth::user()->id;
                $newAddress['updated_at'] = \Carbon\Carbon::now();

                address::where('id',$newAddress['id'])
                        ->where('address_code', $newAddress['address_code'])
                        ->update($newAddress);

                $return['message'] = "succssfuly updated";
                $return['status'] = "01";

            }
            else{

                $newAddress['address_code'] = Auth::user()->id."_AGENT";
                $newAddress ['created_by'] =  Auth::user()->id;
                $newAddress['created_at'] = \Carbon\Carbon::now();

                // dd($newAddress);
                address::insert($newAddress);

                $return['message'] = "succssfuly saved";
                 $return['status'] = "01";
            }

        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";

        }

        return compact('return');
    }

    public function fn_get_address_listing(){

        try{

            $id = Auth::user()->id;

            $data = address::select('id','name','address_code','street1','street2','poscode','city','state','country')
                                ->where('address_code','=', $id."_AGENT")
                                ->get();

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";

        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        // dd($data);
        return view('Agent.agent_address',compact('return','data'));
    }

    public function fn_delete_address($id = null){

        // dd($id);
        try{

            address::where('id',$id)
                        ->delete();

            $return['message'] = "succssfuly deleted";
            $return['status'] = "01";

        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";

        }

        // dd($return);
        return back();
    }

    public function fn_proceed_to_payment(Request $request){

            $agent_id = (!empty($request->get('agent_id')) ? $request->get('agent_id') : '');
            $shipping_id = (!empty($request->get('shipping_id')) ? $request->get('shipping_id') : '');
            $billing_id = (!empty($request->get('billing_id')) ? $request->get('billing_id') : '');
            $total_price = (!empty($request->get('total_price')) ? $request->get('total_price') : '');
            $shipping_fee = (!empty($request->get('shipping_fee')) ? $request->get('shipping_fee') : '');
            $delivery_type = (!empty($request->get('delivery_type')) ? $request->get('delivery_type') : '');

            // dd($$request->get('billing_id'),$request->get('shipping_id'));
        try{

            $cartItems = agent_select_product::leftJoin('product','product.id','=','agent_select_product.product_id')
                                            ->select('agent_select_product.id','product.id as product_id','product.name','product.description'
                                                ,'product.price_wm','product.price_em','product.quantity_min'
                                                ,'product.quantity as stock_quantity','agent_select_product.quantity as total_quantity')
                                            ->where('agent_select_product.agent_id','=',$agent_id)
                                            ->get();

            // dd($cartItems);
            if(count($cartItems) > 0){

                $order_no = (new DeliveryOrderController)->generate_orderno("SO");
                // dd($order_no);
                $order_item = [];
                $total_product_quantity = 0;
                $date = new \DateTime();
                foreach($cartItems as $k => $v){

                    $item = Array(

                        'order_no' => $order_no['data'],
                        'do_no' => "",
                        'product_id' => $v['product_id'],
                        'product_qty' => $v['total_quantity'],
                        'product_typ' => "",
                        'product_status' => "01",
                        'created_by' =>  Auth::user()->id,
                        'created_at' => \Carbon\Carbon::now()
                    );

                    $order_item[] = $item;

                    $total_product_quantity = $total_product_quantity + $v->total_quantity;
                }

                $total_price = str_replace(",", "", $total_price);

                $orderHdr = [

                    'order_no' => $order_no['data'],
                    'agent_id' => $agent_id,
                    'invoice_no' => "",
                    'total_items' => $total_product_quantity,
                    'gst' => 0,
                    'shipping_fee' => $shipping_fee,
                    'total_price' => $total_price,
                    'delivery_type' => (int)$delivery_type,
                    'purchase_date' => $date->format('Y-m-d'),
                    'status' => "01",
                    'bill_address' => (int)$billing_id,
                    'ship_address' => (int)$shipping_id,
                    'created_by' =>  Auth::user()->id,
                    'created_at' => \Carbon\Carbon::now()

                ];

                $x = order_hdr::insert($orderHdr);
                // dd($orderHdr,$order_item);
                if($x){
                    foreach ($order_item as $key => $value){
                        $y = order_item::insert($order_item[$key]);
                    }
                }

                if($x && $y){
                    agent_select_product::where('agent_id',$agent_id)
                                    ->delete();

                    address::where('id',$shipping_id)
                                ->update(['reminder_flag' => 'x']);
                }

                $return['message'] = "Succssfuly placed the order";
                $return['status'] = "01";
            }
            else{

                $order_no = [

                    'data' => ''
                ];

                $return['message'] = "No order placed ";
                $return['status'] = "03";
            }
        }
        catch(\Exception $e){
            
            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        return compact('return','order_no');
    }

    public function fn_get_delivery_status($order_no = null){
        // echo $order_no;
        try{

            $orderHdr = order_hdr::leftJoin('delivery_type','delivery_type.delivery_code','=','order_hdr.delivery_type')
                            ->leftJoin('global_status','global_status.status','=','order_hdr.status')
                            ->select('order_hdr.order_no','order_hdr.agent_id','order_hdr.agent_id','order_hdr.invoice_no','order_hdr.total_items','order_hdr.total_price','order_hdr.delivery_type','order_hdr.purchase_date','order_hdr.status','delivery_type.type_description','global_status.description')
                            ->where('order_no','=',$order_no)
                            ->first();


            $date = new \DateTime($orderHdr->purchase_date);
            $orderHdr->purchase_date = $date->format('d M Y');

            $data = global_status::select('id','status','description')
                                    ->where('table','order_hdr')
                                    ->get();

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";

        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        // dd($orderHdr,$return);
        return view('Agent.agent_delivery_status',compact('return','data','orderHdr'));
    }

    public function fn_get_address(Request $request){

        $agent_id = $request->get('agent_id');
        // dd($agent_id);

        try{

        $adds = address::select('id','name','address_code','street1','street2','poscode','city','state','country')
                                    ->where('address_code','=',$agent_id."_AGENT")
                                    ->get();

        $address = [];
        foreach ($adds as $key => $value) {
            
            $addressData = Array(

                'id' => $value['id'],
                'address_code' => $value['address_code'],
                'name' => $value->name,
                'address' => $value['street1'].",".$value['street2'].",".$value['poscode'].",".$value['city'].",".$value['state'].",".$value['country'],
            );

            $address[] = $addressData;
        }

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";
        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        return compact('return','address');
    }

    public function fn_get_order_list($agent_id = null){

        try{
            
            $data = order_hdr::leftJoin('delivery_type','delivery_type.delivery_code','=','order_hdr.delivery_type')
                                ->leftJoin('global_status','global_status.status','=','order_hdr.status')
                                ->select('order_hdr.order_no','order_hdr.agent_id','order_hdr.agent_id','order_hdr.invoice_no','order_hdr.total_items','order_hdr.total_price','order_hdr.delivery_type','order_hdr.purchase_date','order_hdr.status','delivery_type.type_description','global_status.description')
                                ->where('agent_id',$agent_id)
                                ->get();

            foreach ($data as $key => $value) {
                $date = new \DateTime($value['purchase_date']);
                $value['purchase_date'] = $date->format('d M Y');;
            }

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";
        } 
        catch(\Exception $e){
            
            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        return view('Agent.agent_order_list',compact('data','order_hdr'));
    }
}