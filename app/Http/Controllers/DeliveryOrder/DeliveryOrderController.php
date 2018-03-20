<?php

namespace App\Http\Controllers\DeliveryOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\order_hdr;
use App\order_item;
use App\do_hdr;
use App\do_item;

class DeliveryOrderController extends Controller
{
    public function deliveryOrder_show_page(){
    	return view('DeliveryOrder.deliveryOrder_listing');
    }

    public function deliveryOrder_form(Request $request){
    	$so = $request->get('sales_order');

    	$order_hdr = order_hdr::join('address as bill', 'bill.id','=','order_hdr.bill_address')
    					->join('address as ship', 'ship.id','=','order_hdr.ship_address')
    					->select('order_hdr.*',
    						'bill.street1 as bill_street1',
    						'bill.street2 as bill_street2',
    						'bill.poscode as bill_poscode',
    						'bill.city as bill_city',
    						'bill.state as bill_state',
    						'bill.country as bill_country',
    						'ship.street1 as ship_street1',
    						'ship.street2 as ship_street2',
    						'ship.poscode as ship_poscode',
    						'ship.city as ship_city',
    						'ship.state as ship_state',
    						'ship.country as ship_country'
    					)
    					->where('order_hdr.order_no',$so)
    					->first();

    	$order_item = order_item::join('product','product.id','=','order_item.product_id')
                            ->where('order_item.order_no', $so)->get();

        // return compact('order_hdr', 'order_item');
        $item_list = "";
    	foreach ($order_item as $k => $v) {
            $no = $k + 1;
            $item_list.= "<tr>";
                $item_list.= "<td>".$no."</td>";
                $item_list.= "<td>".$v['code']."</td>";
                $item_list.= "<td>".$v['description']."</td>";
                $item_list.= "<td>".$v['product_qty']."</td>";
                $item_list.= "<td></td>";
            $item_list.= "</tr>";
        }

        $outputData = [
            'order_hdr'     => $order_hdr,
            'order_item'    => $item_list,
            'totalitem'     => count($order_item)
        ];

		return view('DeliveryOrder.deliveryOrder_form', compact('outputData'));
    }
}
