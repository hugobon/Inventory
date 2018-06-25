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

class InvoiceOrderDetailController  extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($order_no){
        $order_hdr = order_hdr::where('order_no',$order_no)->first();

        $do_hdr = do_hdr::where('order_no',$order_no)->get();

        $data = [
            "order" => $order_hdr
        ];

        $item = order_item::leftjoin('product','product.id','=','order_item.product_id')->where('order_no',$order_no)->get();
        

        // return compact('data','do_hdr','item');
        return view('DeliveryOrder.invoice-details',compact('data','do_hdr','item'));
    }

}