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
use Auth;
use DB;

use App\Http\Controllers\Inventory\Product;

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

        try{
            
            // $data = product_m::select("*")->paginate(12);

            $data = (new Product)->all_data_product();

            // echo "<pre>";
            // echo print_r($data);
            // echo "</pre>";
            // die();
            // dd($data);

            $count = agent_select_product::where('agent_id',Auth::user()->id)->count();

            $return['message'] = 'succssfuly';
            $return['status'] = '01';
        }
        catch(\Exception $e){
            $return['message'] = $e->getMessage();
            $return['status'] = '02';
            $image = "";
        }

        if($mode == "all"){
            return view('Agent.agent_product_list',compact('data','count'));
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
                                            ->leftJoin('agent_order_stock','agent_order_stock.agent_id','=','agent_select_product.agent_id')
                                            ->select('agent_select_product.id','product.id as product_id','product.name','product.description','product.price_wm','product.price_em','product.quantity_min'
                                                ,'product.quantity as stock_quantity','agent_select_product.total_price','agent_select_product.quantity as total_quantity','agent_order_stock.state')
                                            ->where('agent_select_product.agent_id','=',$agent_id)
                                            ->get();

            // var_dump($cartItems);die();
            $grandTotalPrice = 0.00;
            foreach ($cartItems as $key => $value) {

                if($value->state == "Sabah" || $value->state == "Sarawak"){
                    $cartItems[$key]['price'] = $this->fn_calc_gst_price(number_format(floatval($value->price_em),2));
                }
                else{
                    $cartItems[$key]['price'] = $this->fn_calc_gst_price(number_format(floatval($value->price_wm),2));
                }

                $cartItems[$key]['total_price'] = number_format(floatval($value->total_price),2);

                $image = product_image_m::select('type','description','file_name','path')
                                        ->where('product_id',$value->product_id)
                                        ->orderBy('status','desc')
                                        ->first();

                $cartItems[$key]['image'] = ($image['path'] == null ? '' : $image['path']);

                $grandTotalPrice = $grandTotalPrice + str_replace(",","",$value->total_price);

            }

            $grandTotalPrice = number_format(floatval($grandTotalPrice),2);

            $returnData = [

                'agent_id'        => $agent_id,
                'grandTotalPrice' => $grandTotalPrice,
                'shippingPrice'  => "0.00"
            ];

            $deliveryType = delivery_type::select('delivery_code as code','type_description as description')
                                        ->get();

            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";

        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }
        // dd($grandTotal);
        // return $return;
        return view('Agent.agent_checkout',compact('cartItems','returnData','deliveryType'));
    }

    public function fn_save_selected_items(Request $request){

            $data = (!empty($request->get('item')) ? $request->get('item') : []);

        try{
    
            $product = product_m::select('type','code','price_wm','price_em','price_staff','quantity')
                                ->where('id',$data['product_id'])
                                ->first();

            $agent = agent_order_stock::select('country','delivery_type','poscode','city','state')
                                ->where('agent_id',$data['agent_id'])
                                ->first();

            $cartItem = agent_select_product::select('id','product_id','agent_id','quantity','total_price')
                                            ->where('product_id',$data['product_id'])
                                            ->where('agent_id',$data['agent_id'])
                                            ->first();
            if($agent != null){
                if($cartItem == null){

                    if($agent->state == "Sabah" || $agent->state == "Sarawak"){

                        $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_em) * (int)$data['quantity']),2);
                    }
                    else{

                        $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_wm) * (int)$data['quantity']),2);
                    }

                    $total_price = str_replace(",", "", $total_price);
                    
                    $addToCart = Array(

                        'agent_id' => $data['agent_id'],
                        'product_id' => $data['product_id'],
                        'quantity' => $data['quantity'], 
                        'total_price' => $total_price,
                        'created_by' => Auth::user()->id,
                        'created_at' => \Carbon\Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'))
                    );

                    agent_select_product::insertGetId($addToCart);
                }
                else{

                    if($agent->state == "Sabah" || $agent->state == "Sarawak"){

                        $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_em) * (int)$data['quantity']),2);
                    }
                    else{

                        $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_wm) * (int)$data['quantity']),2);
                    }

                    // dd(str_replace(",","",$total_price));

                    $updateQuantity = $data['quantity'] + $cartItem->quantity;
                    $updateTotalPrice = number_format(floatval($total_price + $cartItem->total_price),2);
                    $updateTotalPrice = str_replace(",","",$updateTotalPrice);
                    agent_select_product::where('product_id',$data['product_id'])
                                            ->where('agent_id',$data['agent_id'])
                                            ->update([

                                                'quantity' => $updateQuantity,
                                                'total_price' => $updateTotalPrice,
                                                'updated_by' =>  Auth::user()->id,
                                                'updated_at' => \Carbon\Carbon::now()

                                            ]);

                }

                $count = agent_select_product::count();
                $return['message'] = "succssfuly inserted";
                $return['status'] = "01";
            }
            else{

                $return['message'] = "config you shipping address";
                $return['status'] = "03";
                $count = 0;
            }
            
            
        } 
        catch (\Exception $e){
            
            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        return compact('data','return','product','agent','count');
    }

    public function fn_get_place_order_items($agent_id = null,$deliveryType = null){

        // $agent_id = (!empty($request->get('agent_id')) ? $request->get('agent_id') : '');
        // $delivery_type = (!empty($request->get('delivery_type')) ? $request->get('delivery_type') : '');

        // dd($delivery_type);
        try{

            $cartItems = agent_select_product::leftJoin('product','product.id','=','agent_select_product.product_id')
                                            ->leftJoin('agent_order_stock','agent_order_stock.agent_id','=','agent_select_product.agent_id')
                                            ->select('agent_select_product.id','product.id as product_id','product.name','product.description','product.price_wm','product.price_em','product.quantity_min'
                                                ,'product.quantity as stock_quantity','agent_select_product.total_price','agent_select_product.quantity as total_quantity','agent_order_stock.state')
                                            ->where('agent_select_product.agent_id','=',$agent_id)
                                            ->get();

            // var_dump($cartItems);die();
            $grandTotalPrice = 0.00;
            foreach ($cartItems as $key => $value){

                if($value->state == "Sabah" || $value->state == "Sarawak"){
                    $cartItems[$key]['price'] = $this->fn_calc_gst_price(number_format(floatval($value->price_em),2));
                }
                else{
                    $cartItems[$key]['price'] = $this->fn_calc_gst_price(number_format(floatval($value->price_wm),2));
                }

                $cartItems[$key]['total_price'] = number_format(floatval($value->total_price),2);

                $image = product_image_m::select('type','description','file_name','path')
                                        ->where('product_id',$value->product_id)
                                        ->orderBy('status','desc')
                                        ->first();

                $cartItems[$key]['image'] = ($image['path'] == null ? '' : $image['path']);

                $grandTotalPrice = $grandTotalPrice + str_replace(",","",$value->total_price);

            }

            $grandTotalPrice = number_format(floatval($grandTotalPrice),2);


            if($deliveryType == "01"){

                $addressData = address::select('id','address_code','street1','street2','poscode','city','state','country')
                                    ->where('address_code','=',"1AGENT_01")
                                    ->first();

                $address = [

                    'name'      => "Mohd Aminuddin",
                    'address' => $addressData->street1.",".$addressData->street1.",".$addressData->poscode.",".$addressData->city.",".$addressData->state.",".$addressData->country,
                    'btnstatus' => "",
                    'code' => $addressData->address_code
                ];

            }
            elseif($deliveryType == "02"){

                $addressData = [];
                $address = [

                    'name'      => "",
                    'address' =>  "Self Pickup",
                    'btnstatus' => "hidden",
                    'code' => ""
                ];
            }

            $returnData = [

                'agent_id'        => $agent_id,
                'grandTotalPrice' => $grandTotalPrice,
                'shippingPrice'  => "0.00",
                'address' => $address
            ];


            $return['message'] = "succssfuly retrived";
            $return['status'] = "01";

            // dd($address);    
        }
        catch(\Exception $e){

            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        // return $address;
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

            $cartItem = agent_select_product::select('id','product_id','agent_id','quantity','total_price')
                                            ->where('id',$id)
                                            ->first();

            $product = product_m::select('type','code','price_wm','price_em','price_staff','quantity')
                                ->where('id',$cartItem['product_id'])
                                ->first();

            $agent = agent_order_stock::select('country','delivery_type','poscode','city','state')
                                ->where('agent_id',$cartItem['agent_id'])
                                ->first();


            if($agent->state == "Sabah" || $agent->state == "Sarawak"){

                $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_em) * (int)$quantity),2);
            }
            else{

                $total_price = number_format(floatval($this->fn_calc_gst_price($product->price_wm) * (int)$quantity),2);
            }

                $total_price = str_replace(",","", $total_price);
            // dd($total_price);

            // $updateQuantity = $quantity + $cartItem->quantity;
            // $updateTotalPrice = number_format(floatval($total_price + $cartItem->total_price),2);
            // $updateTotalPrice = str_replace(",","", $updateTotalPrice);

            agent_select_product::where('id',$id)
                                    ->update([

                                        'quantity' => $quantity,
                                        'total_price' => $total_price,
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
            
        }
        catch(\Exception $e){
            
        }

        return view('Agent.agent_product_detail');
    }

    private function fn_calc_gst_price($price){

        try{

            $AfterGst = $price * 1.06;
            $AfterGst = number_format(floatval($AfterGst),2);

        }
        catch(\Exception $e){

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

                $newAddress['address_code'] = Auth::user()->id."AGENT_01";
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

            $data = address::select('id','address_code','street1','street2','poscode','city','state','country')
                                ->where('address_code','=', "1AGENT_01")
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
            $shipping_code = (!empty($request->get('shipping_code')) ? $request->get('shipping_code') : '');
            $billing_code = (!empty($request->get('billing_code')) ? $request->get('billing_code') : '');
            $total_price = (!empty($request->get('total_price')) ? $request->get('total_price') : '');
            $shipping_fee = (!empty($request->get('shipping_fee')) ? $request->get('shipping_fee') : '');

            // dd($request);
        try{

            $cartItems = agent_select_product::leftJoin('product','product.id','=','agent_select_product.product_id')
                                            ->leftJoin('agent_order_stock','agent_order_stock.agent_id','=','agent_select_product.agent_id')
                                            ->select('agent_select_product.id','product.id as product_id','product.name','product.description','product.price_wm','product.price_em','product.quantity_min'
                                                ,'product.quantity as stock_quantity','agent_select_product.total_price','agent_select_product.quantity as total_quantity','agent_order_stock.state')
                                            ->where('agent_select_product.agent_id','=',$agent_id)
                                            ->get();
            $order_item = [];
            $total_product_quantity = 0;
            foreach($cartItems as $k => $v){

                $item = Array(

                    'order_no' => "",
                    'do_no' => "",
                    'product_id' => $v->product_id,
                    'product_qty' => $v->total_quantity,
                    'product_type' => "",
                    'product_status' => "01",
                    'created_by' =>  Auth::user()->id,
                    'created_at' => \Carbon\Carbon::now()
                );

                $order_item[] = $item;

                $total_product_quantity = $total_product_quantity + $v->total_quantity;
            }

            $orderHdr = [

                'order_no' => "",
                'agent_id' => $agent_id,
                'invoice_no' => "",
                'gst' => "6%",
                'shipping_fee' => $shipping_fee,
                'total_price' => $total_product_quantity,
                'delivery_type' => "",
                'purchase_date' => "",
                'status' => "01",
                'bill_address' => $billing_code,
                'ship_address' => $shipping_code,
                'created_by' =>  Auth::user()->id,
                'created_at' => \Carbon\Carbon::now()

            ];

            // dd($orderHdr,$order_item);

            $return['message'] = "succssfuly deleted";
            $return['status'] = "01";
        }
        catch(\Exception $e){
            
            $return['message'] = $e->getMessage();
            $return['status'] = "02";
        }

        return $return;
    }
}