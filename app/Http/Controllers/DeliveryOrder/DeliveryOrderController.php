<?php

namespace App\Http\Controllers\DeliveryOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\order_hdr;
use App\order_item;
use App\do_hdr;
use App\do_item;
use App\courier;

class DeliveryOrderController extends Controller
{
    public function deliveryOrder_show_page(){
    	return view('DeliveryOrder.deliveryOrder_listing');
    }

    public function deliveryOrder_form(Request $request){
    	$so = $request->get('sales_order');

        // Get header information
    	$order_hdr = order_hdr::join('address as bill', 'bill.id','=','order_hdr.bill_address')
    					->join('address as ship', 'ship.id','=','order_hdr.ship_address')
    					->select('order_hdr.*',
                            'bill.name as bill_name',
    						'bill.street1 as bill_street1',
    						'bill.street2 as bill_street2',
    						'bill.poscode as bill_poscode',
    						'bill.city as bill_city',
    						'bill.state as bill_state',
    						'bill.country as bill_country',
                            'ship.name as ship_name',
    						'ship.street1 as ship_street1',
    						'ship.street2 as ship_street2',
    						'ship.poscode as ship_poscode',
    						'ship.city as ship_city',
    						'ship.state as ship_state',
    						'ship.country as ship_country'
    					)
    					->where('order_hdr.order_no',$so)
    					->first();

        $order_hdr->ship_address = $order_hdr->ship_name."<br>";
        $order_hdr->ship_address.= $order_hdr->ship_street1."<br>".$order_hdr->ship_street2."<br>";
        $order_hdr->ship_address.= $order_hdr->ship_city."<br>".$order_hdr->ship_state."<br>";
        $order_hdr->ship_address.= $order_hdr->ship_poscode."<br>".$order_hdr->ship_country;

        $order_hdr->bill_address = $order_hdr->bill_name."<br>";
        $order_hdr->bill_address.= $order_hdr->bill_street1."<br>".$order_hdr->bill_street2."<br>";
        $order_hdr->bill_address.= $order_hdr->bill_city."<br>".$order_hdr->bill_state."<br>";
        $order_hdr->bill_address.= $order_hdr->bill_poscode."<br>".$order_hdr->bill_country;

        // Get item information
    	$order_item = order_item::join('product','product.id','=','order_item.product_id')
                            ->where('order_item.order_no', $so)->get();

        $item_list = "";
        $do_item = [];
    	foreach ($order_item as $k => $v) {

            $do_itemCount = do_item::join('do_hdr', 'do_hdr.do_no','=','do_item.do_no')
                                    ->where('product_id', $v['product_id'])
                                    ->where('do_hdr.order_no', $so)
                                    ->count();

            if($v['product_status'] == "01"){
                $itemStatus = '<td><a href="#" onclick="get_itemDetail(event)"><span class="label label-danger">Not Verify</span></a></td>';
            }
            else if($v['product_status'] == "02"){
                $itemStatus = '<td><a href="#" onclick="get_itemDetail(event)"><span class="label label-warning">Draft</span></a></td>';
            }
            else if($v['product_status'] == "03"){
                $itemStatus = '<td><a href="#" onclick="get_itemDetail(event)"><span class="label label-success">Verified</span></a></td>';
            }

            $no = $k + 1;
            $item_list.= "<tr>";
                $item_list.= "<td style='display:none;'>".$v['id']."</td>";
                $item_list.= "<td>".$no."</td>";
                $item_list.= "<td>".$v['code']."</td>";
                $item_list.= "<td>".$v['description']."</td>";
                $item_list.= "<td>".$v['product_qty']."</td>";
                $item_list.= "<td>".$v['product_typ']."</td>";
                // $item_list.= ($do_itemCount == $v['product_qty']) ? "<td><span class='label label-success'>Ready to pickup</span></td>" : "<td><span class='label label-warning'>New</span></td>";
                $item_list.= $itemStatus;
            $item_list.= "</tr>";

            $do_item[] = [
                "order_id"    => $v['id'],
                "product_id"  => $v['product_id'],
                "product_code"=> $v['code'],
                "product_desc"=> $v['name'],
                "product_qty" => $v['product_qty'],
                "product_typ" => $v['product_typ'],
                "status"      => $v['product_status'],
                "serialno"    => []
            ];
        }

        // get value help related to field needed
        $courierList = $this->getCourierListing();

        $courier = "";
        if(!$courierList['error']){
            foreach ($courierList['data'] as $k => $v) {
                $courier.= "<option value='".$v['courier_code']."'>".$v['courier_name']."</option>";
            }
        }

        $order_hdr->courier = $courier;

        $outputData = [
            'order_hdr'     => $order_hdr,
            'order_item'    => $order_item,
            'item_list'     => $item_list,
            'totalitem'     => count($order_item),
            'do_hdr'        => [
                "order_no"          => $order_hdr->order_no,
                "tracking_no"       => "",
                "courier_id"        => "",
                "delivery_status"   => ""
            ],
            'do_item'       => $do_item
        ];
        // return compact('outputData');
		return view('DeliveryOrder.deliveryOrder_form', compact('outputData'));
    }

    public function getCourierListing(){

        try{

            $courier = courier::get();


            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully retrieve all courier data",
                'data'      => $courier
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to retrieve all courier data. Error: ".$e->getMessage(),
                'data'      => ""
            ];
        }

        return $return;
    }

    public function deliveryOrder_create(Request $request){
        
        try{

            return $request->all();

            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully retrieve all courier data",
                'data'      => $courier
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to retrieve all courier data. Error: ".$e->getMessage(),
                'data'      => ""
            ];
        }

        return $return;
    }

    public function get_itemDetail(Request $request){

        $id = $request->get('id');

        try{

            // $order_item

            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully retrieve all courier data",
                'data'      => $courier
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to retrieve all courier data. Error: ".$e->getMessage(),
                'data'      => ""
            ];
        }

        return $return;
    }
}
