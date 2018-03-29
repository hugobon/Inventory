<?php

namespace App\Http\Controllers\DeliveryOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Carbon\Carbon;

use App\order_hdr;
use App\order_item;
use App\do_hdr;
use App\do_item;
use App\courier;
use App\global_nr;

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
                $item_list.= "<td>".$v['name']."</td>";
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
                $courier.= "<option value='".$v['id']."'>".$v['courier_name']."</option>";
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

            $dataReceive = $request->get('gt_dataToSend');
            $dataItemToInsert = [];
            $dataToUpdateSO_hdr = [];
            $dataToUpdateSO_itm = [];
            $do = "DO2018032900004";

            // $do = $this->generate_orderno('DO')['data'];
            // $dataReceive['do_hdr']['do_no'] = $do;
            // do_hdr::insert($dataReceive['do_hdr']);
            // order_hdr::where('order_no',$dataReceive['do_hdr']['order_no'])
            //         ->update(['status' => $dataReceive['do_hdr']['delivery_status']]);

            foreach ($dataReceive['do_item'] as $k => $v) {

                $dataToUpdateSO_itm[] = [
                    'do_no'          => $do,
                    'product_status' => $v['status']
                ];

                if(!isset($v['serialno'])){
                    $dataItemToInsert[] = [
                        'do_no'         => $do,
                        'product_id'    => $v['product_id'],
                        'serial_no'     => "",
                        'created_by'    => Auth::user()->id,
                        'created_at'    => Carbon::now()
                    ];
                }
                else{

                    foreach ($v['serialno'] as $s) {
                        $dataItemToInsert[] = [
                            'do_no'         => $do,
                            'product_id'    => $v['product_id'],
                            'serial_no'     => $s,
                            'created_by'    => Auth::user()->id,
                            'created_at'    => Carbon::now()
                        ];
                    }
                }
                
            }

            // do_item::insertGetId($dataItemToInsert);


            return compact('dataReceive', 'dataItemToInsert','dataToUpdateSO_itm');
            // die();

            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully create new DO ".$do
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to create new DO. Error: ".$e->getMessage()
            ];
        }

        return $return;
    }

    public function deliveryOrder_view($do){

        return $do;
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

    private function generate_orderno($order_typ){

        try{

            // Generate new order no
            $global_nr = global_nr::where('nrcode',$order_typ)->first();
            $current_date = Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'));

            if($current_date->format('m') > substr($global_nr->current_date, 4, 2)){
                $next_no = str_pad($global_nr->nrfrom + $global_nr->nritem, 5, '0', STR_PAD_LEFT);
            }
            else{
                $next_no = str_pad($global_nr->nrcurrent + $global_nr->nritem, 5, '0', STR_PAD_LEFT);
            }

            $dataToReturn = $global_nr->nrcode.$current_date->format('Ymd').$next_no;

            // Update global_nr table with new order no
            global_nr::where('id',$global_nr->id)
                    ->update([
                        'current_date'  => $current_date->format('Ymd'),
                        'nrcurrent'     => $next_no,
                        'updated_by'    => Auth::user()->id,
                        'updated_at'    => Carbon::now()
                    ]);

            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully generate new order no for ".$order_typ,
                'data'      => $dataToReturn
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to generate new order no for ".$order_typ.". Error: ".$e->getMessage(),
                'data'      => ""
            ];
        }

        return $return;
    }
}
