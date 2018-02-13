<?php
# Create by: Bhaihaqi		2018-02-05
# Modify by: Bhaihaqi		2018-02-13
namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory\product_m;

class Product extends Controller
{

    public function index()
    {
        return redirect('product/listing');
    }
	
	public function listing()
    {
		$data = array(
			'countproduct' => product_m::count(),
			'startcount' => 0,
			'productArr' => product_m::All(),
			'typeArr' => array( '0' => '', '1' => 'By Item','2' => 'Package(Long Term)','3' => 'Monthly Promotion' ),
			'status' => array( '1' => 'On','0' => 'Off'),
		);
        return view('Inventory/product_listing',$data);
    }
	
	public function form()
    {
        return view('Inventory/product_form');
    }
	
	public function insert(Request $postdata)
    {
		$this->validate($postdata,[
			'code' => 'required',
			'type' => 'required',
			'description' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
		]);
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$description = trim(preg_replace('!\s+!', ' ', $postdata->input("description")));
		
		#check exist code
		$countcode = product_m::where('code', $code)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/form')->withErrors($messages);
		}
		
		#change datepicker to mysql date
		$start_promotion = $this->datepicker2mysql($postdata->input("start_promotion"));
		$end_promotion = $this->datepicker2mysql($postdata->input("end_promotion"));
		
		$data = array(
			'code' => $code,
			'type' => $postdata->input("type"),
			'description' => $description,
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'start_promotion' => $start_promotion,
			'end_promotion' => $end_promotion,
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		$productdata = New product_m;
		$productdata->insert($data);
		
		return redirect("product/listing")->with("info","Success Submit " . $postdata->input("description") . "");
    }
	
    public function edit($id)
    {
		$data = product_m::where('id', $id)->first();
		if($data == false)
			return redirect("product/listing")->with("errorid"," Not Found ");
			
		return view('Inventory/product_form',$data);
    }
	
	public function view($id)
    {
		$data = product_m::where('id', $id)->first();
		if($data == false)
			return redirect("product/listing")->with("errorid"," Not Found ");
			
		$data['typestr'] =  array( '0' => '', '1' => 'By Item','2' => 'Package(Long Term)','3' => 'Monthly Promotion' );
		return view('Inventory/product_view',$data);
    }
	
    public function update(Request $postdata, $id)
    {
		
		$this->validate($postdata,[
			'code' => 'required',
			'type' => 'required',
			'description' => 'required',
			'price_wm' => 'required',
			'price_em' => 'required',
			'price_staff' => 'required',
		]);
		
		
		#uppercase & Replacing multiple spaces with a single space
		$code = trim(preg_replace('!\s+!', ' ', strtoupper($postdata->input("code"))));
		$description = trim(preg_replace('!\s+!', ' ', $postdata->input("description")));
		
		#change datepicker to mysql date
		$start_promotion = $this->datepicker2mysql($postdata->input("start_promotion"));
		$end_promotion = $this->datepicker2mysql($postdata->input("end_promotion"));
		
		#check exist code
		$productdata = New product_m;
		$countcode = $productdata->where('code','=',$code)->where('id','<>', $id)->count();
		if($countcode > 0){
			$messages = "Code " . trim($postdata->input("code")) . " already exist";
			return redirect('product/edit/' . $id)->withErrors($messages);
		}
		
		$data = array(
			'code' => $code,
			'type' => $postdata->input("type"),
			'description' => $description,
			'price_wm' => $postdata->input("price_wm"),
			'price_em' => $postdata->input("price_em"),
			'price_staff' => $postdata->input("price_staff"),
			'start_promotion' => $start_promotion,
			'end_promotion' => $end_promotion,
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
		);
		$productdata->where('id',$id)->update($data);
		
		return redirect("product/view/" . $id)->with("info","Success Save " . $postdata->input("description") . "");
    }
	
	public function check_existcode(Request $postdata)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($data)
    {
        $datadecode = unserialize(base64_decode($data));
		product_m::where('id', $datadecode['deleteid'])->delete();
		
		return redirect("product/listing")->with("info","Product " . $datadecode['code'] . "  (" . $datadecode['description'] . " ) Deleted Successfully!!");
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
