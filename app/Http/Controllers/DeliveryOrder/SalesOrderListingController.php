<?php
namespace App\Http\Controllers\DeliveryOrder;   

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\stock_in;
use App\inventory\product_m;
use App\supplier;
use App\product_serial_number;
use App\inventory\stockadjustment_m;
use App\configuration\config_stockadjustment_m;
use App\product_woserialnum;
use DB;
use App\order_hdr;
use App\order_item;
use App\do_hdr;
use App\do_item;
use App\courier;
use App\global_nr;
use App\delivery_type;
use App\users;
use App\configuration\config_quantitytype_m;

use Auth;
use Carbon\Carbon;

class SalesOrderListingController  extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $valuehelp = [];

        try{

            $courier = courier::get();
            $product = product_m::select('id','code','name')->get();
            $qtytype = config_quantitytype_m::get();
            $delityp = delivery_type::get();
            $agent = users::select('id','code','name')->get();

            $valuehelp = [
                'courier' => $courier,
                'product' => $product,
                'qtytype' => $qtytype,
                'delitype'=> $delityp,
                'agent'   => $agent
            ];
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
        $purchase_date = null;

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

            if(is_null($purchase_date)){
                $data = $orderTable->get();
            }else{
                $data = $orderTable->whereBetween('order_hdr.purchase_date',[$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                                ->get();
            }
            
        return view('DeliveryOrder.sales-order-listing',compact('data','valuehelp'));
        // return compact('data','product_name','product_id');
    }

    public function process(Request $request){
      

        $columns = array( 
            0 =>'id', 
            1 =>'title',
            2=> 'body',
            3=> 'created_at',
            4=> 'id',
        );

            $totalData = Post::count();

            $totalFiltered = $totalData; 

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value')))
            {            
            $posts = Post::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
            }
            else {
            $search = $request->input('search.value'); 

            $posts =  Post::where('id','LIKE',"%{$search}%")
                        ->orWhere('title', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Post::where('id','LIKE',"%{$search}%")
                        ->orWhere('title', 'LIKE',"%{$search}%")
                        ->count();
            }

            $data = array();
            if(!empty($posts))
            {
            foreach ($posts as $post)
            {
            $show =  route('posts.show',$post->id);
            $edit =  route('posts.edit',$post->id);

            $nestedData['id'] = $post->id;
            $nestedData['title'] = $post->title;
            $nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
            $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
            $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                    &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
            $data[] = $nestedData;

            }
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
                );

            echo json_encode($json_data); 
    }

    public function getOrderDetails($order_no){

        $data = order_hdr::join('users','users.id','=','order_hdr.agent_id')
        ->join('global_status', function($join){
            $join->on('global_status.status','=','order_hdr.status')
                ->where('global_status.table','=',"order_hdr");
        })
        ->join('delivery_type', 'delivery_type.id','=','order_hdr.delivery_type')
        ->where('order_hdr.order_no',$order_no)->first();

        $item = order_item::leftjoin('product','product.id','=','order_item.product_id')
        ->where('order_no',$order_no)->get();
        return compact('data','item');
    }

}