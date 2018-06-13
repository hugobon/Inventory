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
use App\product_serial_number;
use App\stock_in;
use App\delivery_type;
use App\users;
use App\inventory\product_m;
use App\configuration\config_quantitytype_m;

class DeliveryOrderController extends Controller
{
    public function deliveryOrder_show_page(Request $request){

        $purchase_date = $request->get('purchase_date');
        $agent_code = $request->get('agent_code');
        $delivery_typ = $request->get('delivery_typ');

        $doListing = "";
        $agentListing = "<option></option>";

        $orderTable = order_hdr::join('users','users.id','=','order_hdr.agent_id')
                        ->join('global_status', function($join){
                            $join->on('global_status.status','=','order_hdr.status')
                                ->where('global_status.table','=',"order_hdr");
                        })
                        ->join('delivery_type', 'delivery_type.id','=','order_hdr.delivery_type')
                        ->leftJoin('do_hdr','do_hdr.order_no','=','order_hdr.order_no')
                        ->select('order_hdr.order_no','order_hdr.delivery_type','order_hdr.invoice_no','order_hdr.status','order_hdr.purchase_date','users.code','users.name','global_status.description','delivery_type.type_description','do_hdr.do_no')
                        ->orderBy('order_hdr.order_no', 'desc');
                        
        if(is_null($purchase_date)){
            $startDate = Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'));
            $endDate = Carbon::now(new \DateTimeZone('Asia/Kuala_Lumpur'));
        }
        else{

            list($x, $y) = explode(" - ", $purchase_date);

            list($xd, $xm, $xY) = explode("/", $x);
            list($yd, $ym, $yY) = explode("/", $y);

            $startDate = new \DateTime($xY."-".$xm."-".$xd);
            $endDate   = new \DateTime($yY."-".$ym."-".$yd);

            if(!is_null($agent_code)){
                
            }

            if(!is_null($delivery_typ)){
            	dd($delivery_typ);
            }
        }

        $order_hdr = $orderTable->whereBetween('order_hdr.purchase_date',[$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            						->get();

        $agent = users::select('id','code','name')->get();

        $delityp = $this->getValueHelp()['delityp'];

        $delitypOption = "";
        foreach ($delityp as $k => $v) {
        	$delitypOption.= "<option value='".$v['delivery_type']."'>".$v['type_description']."</option>";
        }
        
        if(count($order_hdr) > 0){
            foreach ($order_hdr as $k => $v) {
                $a = "#";
                $linkSubmit = "";
                if($v['status'] == "01"){
                    $a = "javascript:;";
                    $linkSubmit = "onclick='";
                    $linkSubmit.= "$('#tableData').submit();";
                    $linkSubmit.= "'";

                    $classLabel = "class='label label-danger' data-toggle='tooltip' data-placement='top' title='Generate DO'";
                }
                else if($v['status'] == "02"){
                    $classLabel = "class='label label-warning' style='background-color: orange !important;'";
                }
                else if($v['status'] == "03"){
                    $classLabel = "class='label label-warning'";
                }
                else if($v['status'] == "04"){
                    $classLabel = "class='label label-success'";
                }
                

                $doListing.= "<tr>";
                $doListing.= "<td>".$v['order_no']."</td>";
                $doListing.= "<td>".(new \DateTime($v['purchase_date']))->format('d M Y')."</td>";
                $doListing.= "<td>".$v['type_description']."</td>";
                $doListing.= "<td>".$v['do_no']."</td>";
                $doListing.= "<td>".$v['name']." (".$v['code'].")</td>";
                $doListing.= "<td><a href='".$a."' ".$linkSubmit."><span ".$classLabel.">".$v['description']."</span></a></td>";
                $doListing.= "</tr>";
            }
        }
        else{
            $doListing.= "<tr><td colspan='6' align='center'>No data found</td></tr>";
        }

        foreach ($agent as $k => $v) {
            $agentListing.= "<option value=".$v['id'].">".$v['name']." (".$v['code'].")</option>";
        }

        $outputData = [
            'orderList'     => $order_hdr,
            'doListing'     => $doListing,
            'totalDO'       => count($order_hdr),
            'agentListing'  => $agentListing,
            'startDate'		=> $startDate->format('d/m/Y'),
            'endDate'		=> $endDate->format('d/m/Y'),
            'delitypOption' => $delitypOption
        ];

    	return view('DeliveryOrder.deliveryOrder_listing', compact('outputData'));
    }

    public function search_so(Request $request){

        try{

            $dataReceive = $request->get('parameter');
            list($dateFrom, $dateTo) = explode(" - ", $dataReceive['purchase_date']);


            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully retrieve SO"
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to retrieve SO. Error: ".$e->getMessage()
            ];
        }

        return compact('return','courier', 'product','qtytype','delityp');
    }

    private function get_soListing($dateFrom, $dateTo){

        return order_hdr::join('users','users.id','=','order_hdr.agent_id')
                        ->select('order_hdr.order_no','order_hdr.delivery_type','order_hdr.invoice_no','order_hdr.status','users.code','users.name')
                        ->whereBetween('order_hdr.purchase_date',[$dateFrom, $dateTo])
                        ->orderBy('order_hdr.order_no', 'desc')
                        ->get();
    }

    public function deliveryOrder_form(Request $request){

    	$so = $request->get('sales_order');
        $do = $request->get('delivery_order');

        $orderDetail = $this->get_orderDetail($so, $do);

        // get value help related to field needed
        $valueHelp = $this->getValueHelp();

        $courier = "";
        $product = "";
        $qtytype = "";
        if(!$valueHelp['return']['error']){
            foreach ($valueHelp['courier'] as $k => $v) {
                $courier.= "<option value='".$v['id']."'>".$v['courier_name']."</option>";
            }

            foreach ($valueHelp['product'] as $k => $v) {
                $product.= "<option value='".$v['id']."'>".$v['code']."</option>";
            }

            foreach ($valueHelp['qtytype'] as $kk => $v) {
                $qtytype.= "<option value='".$v['id']."'>".$v['type']."</option>";
            }
        }

        $orderDetail['order_hdr']->courier = $courier;
        $orderDetail['order_hdr']->product = $product;
        $orderDetail['order_hdr']->qtytype = $qtytype;

        $outputData = [
            'order_hdr'     => $orderDetail['order_hdr'],
            'order_item'    => $orderDetail['order_item'],
            'item_list'     => $orderDetail['item_list'],
            'totalitem'     => count($orderDetail['order_item']),
            'product'       => $valueHelp['product'],
            'qtytype'       => $valueHelp['qtytype']
        ];
        // return compact('outputData');
		return view('DeliveryOrder.deliveryOrder_form', compact('outputData'));
    }

    private function get_orderDetail($order_no, $do_no){

        // Get header information
        $order_hdr = order_hdr::join('address as bill', 'bill.id','=','order_hdr.bill_address')
                        ->join('address as ship', 'ship.id','=','order_hdr.ship_address')
                        ->join('delivery_type','delivery_type.id','=','order_hdr.delivery_type')
                        ->join('users','users.id','=','order_hdr.created_by')
                        ->select('order_hdr.*','delivery_type.type_description','users.code','users.name',
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
                        ->where('order_hdr.order_no',$order_no)
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
                            ->select('order_item.*','product.id as productID','product.code','product.name')
                            ->where('order_item.order_no', $order_no)
                            ->get();

        $qtytype = $this->getValueHelp()['qtytype'];

        $item_list = "";
        $do_item = [];
        foreach ($order_item as $k => $v) {

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
                $item_list.= "<td style='display:none;'>".$v['productID']."</td>";
                $item_list.= "<td style='display:none;'>".$v['product_typ']."</td>";
                $item_list.= "<td>".$no."</td>";
                $item_list.= "<td>".$v['code']."</td>";
                $item_list.= "<td>".$v['name']."</td>";
                $item_list.= "<td>".$v['product_qty']."</td>";
                foreach ($qtytype as $x => $y) {
                    if($y['id'] == $v['product_typ']){
                        $item_list.= "<td>".$y['type']."</td>";
                        break;
                    }
                }                
                $item_list.= $itemStatus;
            $item_list.= "</tr>";

            $do_item[] = [
                "order_id"      => $v['id'],
                "product_id"    => "",
                "product_desc"  => "",
                "product_qty"   => "",
                "product_typ"   => "",
                "serialno"      => [],
            ];
        }

        return compact('order_hdr','order_item','item_list','do_item');
    }

    public function getValueHelp(){

        try{

            $courier = courier::get();
            $product = product_m::select('id','code','name')->get();
            $qtytype = config_quantitytype_m::get();
            $delityp = delivery_type::get();

            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully retrieve all value help"
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to retrieve all value help. Error: ".$e->getMessage()
            ];
        }

        return compact('return','courier', 'product','qtytype','delityp');
    }

    public function deliveryOrder_create(Request $request){
        
        try{

            $dataReceive = $request->get('gt_dataToSend');
            $dataItemToInsert = [];
            $dataToUpdateSO_hdr = [];
            $dataToUpdateSO_itm = [];
            $dataToInsertSO_itm = [];

            $do = $this->generate_orderno('DO')['data'];
            $dataReceive['do_hdr']['do_no'] = $do;
            $dataReceive['do_hdr']['created_by'] = Auth::user()->id;
            $dataReceive['do_hdr']['created_at'] = Carbon::now();
            do_hdr::insert($dataReceive['do_hdr']);
            order_hdr::where('order_no',$dataReceive['do_hdr']['order_no'])
                    ->update([
                        'status' => $dataReceive['do_hdr']['delivery_status'],
                        'updated_by' => Auth::user()->id,
                        'updated_at' => Carbon::now()
                    ]);

            foreach ($dataReceive['do_item'] as $k => $v) {

                $order_id = $v['order_id'];

                if(strpos($v['order_id'], "_") !== false){

                    $order_item = new order_item([
                        'order_no'       => $dataReceive['do_hdr']['order_no'],
                        'do_no'          => $do,
                        'product_id'     => $v['product_id'],
                        'product_qty'    => $v['product_qty'],
                        'product_typ'    => $v['product_typ'],
                        'product_status' => $v['status'],
                        'created_by'     => Auth::user()->id,
                        'created_at'     => Carbon::now()
                    ]);

                    $order_item->save();
                    $order_id = $order_item->id;
                }
                else{

                    order_item::where('id',$order_id)
                            ->update(['do_no' => $do, 'product_status' => $v['status']]);
                }

                if(!isset($v['serialno'])){
                    $dataItemToInsert[] = [
                        'do_no'         => $do,
                        'order_item_id' => $order_id,
                        'serial_no'     => "",
                        'created_by'    => Auth::user()->id,
                        'created_at'    => Carbon::now()
                    ];
                }
                else{

                    foreach ($v['serialno'] as $s) {
                        $dataItemToInsert[] = [
                            'do_no'         => $do,
                            'order_item_id' => $order_id,
                            'serial_no'     => $s,
                            'created_by'    => Auth::user()->id,
                            'created_at'    => Carbon::now()
                        ];
                    }
                }
                
            }

            do_item::insert($dataItemToInsert);

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

        return compact('return','do','dataReceive', 'dataItemToInsert');
    }

    public function deliveryOrder_view($do){

        try{

            $do_hdr = do_hdr::join('courier','courier.id','=','do_hdr.courier_id')
                            ->join('global_status', function($join){
                                $join->on('global_status.status','=','do_hdr.delivery_status')
                                    ->where('global_status.table','=',"do_hdr");
                            })
                            ->select('do_hdr.do_no','do_hdr.order_no','do_hdr.tracking_no','courier.courier_name','global_status.description')
                            ->where('do_no',$do)
                            ->first();

            $orderDetail = $this->get_orderDetail($do_hdr->order_no);

            $outputData = [
                'do_no'         => $do_hdr->do_no,
                'description'   => $do_hdr->description,
                'order_no'      => $do_hdr->order_no,
                'user'          => $orderDetail['order_hdr']->name." (".$orderDetail['order_hdr']->code.")",
                'purchase_date' => (new \DateTime($orderDetail['order_hdr']->purchase_date))->format('d F Y'),
                'delivery_type' => $orderDetail['order_hdr']->type_description,
                'courier'       => $do_hdr->courier_name,
                'tracking_no'   => $do_hdr->tracking_no,
                'ship_address'  => $orderDetail['order_hdr']->ship_address,
                'bill_address'  => $orderDetail['order_hdr']->bill_address,
                'item_list'     => $orderDetail['item_list'],
                'totalitem'     => count($orderDetail['order_item']),
            ];

            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully retrieve DO ".$do
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to retrieve DO. Error: ".$e->getMessage()
            ];
        }

        return view('DeliveryOrder.deliveryOrder_view', compact('outputData'));
    }

    public function get_itemDetail(Request $request){

        $id = $request->get('id');

        try{

            $do_item = do_item::select('serial_no')->where('order_item_id', $id)->get();

            $serialnoList = [];
            foreach ($do_item as $k => $v) {
                if($v['serial_no'] != ""){
                    $serialnoList[] = $v['serial_no'];
                }
            }
            

            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully retrieve item detail"
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to retrieve item detail. Error: ".$e->getMessage()
            ];
        }

        return compact('return','serialnoList');
    }

    public function generate_orderno($order_typ){

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

    public function verify_serialno(Request $request){

        try{

            $serialno = $request->get('serial_no');
            $product_id = $request->get('product_id');

            $serialnoExist = product_serial_number::where('product_id', $product_id)
                                                ->where('serial_number', $serialno)
                                                ->where('product_serial_number.status','01')
                                                ->first();

            $return = [
                'status'    => "01",
                'error'     => false,
                'message'   => "Successfully verify serial number:  ".$serialno
            ];
        }catch(\Exception $e){
            $return = [
                'status'    => "02",
                'error'     => true,
                'message'   => "Failed to verify serial number:  ".$serialno.". Error: ".$e->getMessage()
            ];
        }

        return compact('return','serialnoExist');
    }
}
