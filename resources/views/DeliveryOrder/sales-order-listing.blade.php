@extends('header')
@section('title','Sales Order Listing')
<style>
#table_listing{
    font-size: 1.2rem;
}
textarea {
   resize: none;
}
</style>
@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
    <li><a href="{{ url('order/sales/listing') }}">Order Management</a></li>
    <li><a href="{{ url('order/sales/listing') }}">Sales Order Listing</a></li>
</ul>
<!-- END BREADCRUMB -->   

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START RESPONSIVE TABLES -->
    <div class="row"><div class="col-sm-12">
 @if(session("message"))        
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                {{ session("message") }}
            </div>
        </div>
 @endif
 @if(session("errorid"))
     <div class="col-sm-12">
         <div class="alert alert-danger">
             <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
             {{ session("errorid") }}
         </div>
     </div>
 @endif
    </div>

    <div class="row">
            <div class="col-md-12">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Sales Order Listing</h3>
                            </div>

                            <div class="panel-body hide">
                                    <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <button class="btn btn-default pull-right"><i class="fa fa-search"></i>Search</button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Purchase Date</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="purchase_date">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Delivery Type</label>
                                                    <div class="col-md-9">
                                                        <select name="delivery_typ" class="form-control select">
                                                            @if(count($valuehelp['delitype'])>0)
                                                            @foreach($valuehelp['delitype'] as $key => $value)
                                                            <option value='{{$value['delivery_type']}}'>{{$value['type_description']}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Agent Code</label>
                                                    <div class="col-md-9">                                                                                
                                                        <select name="agent_code" class="form-control select" data-live-search="true">
                                                                @if(count($valuehelp['agent'])>0)
                                                                @foreach($valuehelp['agent'] as $key => $value)
                                                                <option value='{{$value['id']}}'>{{$value['name']}}</option>
                                                                @endforeach
                                                                @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Delivery Address</label>
                                                    <div class="col-md-9">
                                                        <select></select>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                </div>
                                
                            <div class="panel-body">              
                                            <p>Total listing: <b>{{ count($data) }}</b></p>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped datatable" id="table_listing">
                                                <thead>
                                                        <tr>
                                                                <th>SO No</th>
                                                                <th>Purchase Date</th>
                                                                <th>Delivery Type</th>                                                                
                                                                <th>Agent Code</th>
                                                                <th>Status</th>
                                                                <th>DO No</th>
                                                                <th>Generate DO</th>
                                                                
                                                            </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($data) > 0)
                                                    <?php $i = 1; ?>
                                                    @foreach($data as $order)       
                                                                              
                                                        <tr>
                                                            <td><a href="{{ url('order/invoice/detail')."/".$order["order_no"] }}" >{{ $order['order_no'] }} </a></td>
                                                            <td>{{ $order['purchase_date'] }} </td>
                                                            <td>{{ $order['type_description']}} </td>
                                                            
                                                            <td>{{ $order['name']}} </td>
                                                            <td>{{ $order['description']}} </td>
                                                            <td>{{ $order['do_no']}} </td>
                                                            <td>  <!--<a href="#" class="text-center" title="Generate DO" data-toggle="modal" data-target="#generate_do_modal" >
                                                                    <i class="fa fa-mail-forward"></i></a>--> 
                                                                    <button href="#" class="text-center btn generate_do_btn" title="Generate DO" id="generate_do_btn" data-order=" {{ $order['order_no'] }} ">
                                                                            <i class="fa fa-mail-forward"></i></button>
                                                                </td>
                                                            
                                                            
                                                        </tr>
                                                    @endforeach
                                                @else
                                                <tr style="display:none">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                {{-- <tr>
                                                    <td colspan="6" rowspan="2" class="text-center"> No Data Found <br />
                                                    <a href="{{ url('stock/in') }}"><span class="fa fa-plus"></span> Add new stock</a></td>
                                                </tr> --}}
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                            </div>
                    </div>
            </div>
    </div>



</div>

<!-- Modal -->
<div id="generate_do_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Generate DO</h4>
            </div>
            <div class="modal-body">
                    <div class="panel panel-default">
                            <div class="panel-heading" style="padding-bottom: 0px;">
                                 <div class="row" style="padding-bottom: 1%;">
                                    <div class="panel-title form-group">
                                        <h2 id="orderNo" style="display: inline;">SO No</h2>
                                        <h4 id="so_no_title" style="display: inline;">()</h4>
                                        
                                    </div>
                                    <ul class="panel-controls">
                                        <li><button type="button" class="btn btn-success pull-right">Collected</button></li>
                                    </ul>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p id="ship_to_title">Ship To:</p>
                                        <p id="sales_order_date_title">Sales Order Date: 11 Apr 2018</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p id="contact_title">Contact No:</p>
                                        <p id="referal_title">Referral:</p>
                                    </div>
                                </div>
                                <div class="tabs" style="padding-top: 15px;">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#tab-order" role="tab" data-toggle="tab">Order</a></li>
                                        <li><a href="#tab-item" role="tab" data-toggle="tab">Items</a></li>
                                    </ul>
                                </div>
                            </div>  
                            <div class="panel-body">
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab-order">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Purchase Date</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static" id="purchase_date_info">TEST</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Delivery Type</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"  id="delivery_type_info">TEST</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Courier Service</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"  id="courier_service_info">1</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row hide">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Tracking No</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static">TEST</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Shipping Address</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static" id="shipping_address_info">TEST</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Billing Address</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static" id="billing_address_info">TEST</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-item">
                                        <div class="form-group">
                                            <p class="form-control-static">Item List: TEST</p>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="order_item_table">
                                                    <thead>
                                                        <tr>
                                                            <th width="20">No</th>
                                                            <th width="200">Item Code</th>
                                                            <th width="200">Product Barcode</th>
                                                            <th>Description</th>
                                                            <th>Quantity</th>
                                                            <th>Status</th>
                                                        <tr>
                                                    </thead>
                                                    <tbody id="tbody_item">
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" onclick="$('#generate_do_modal').modal().hide();">Cancel</button>
                    <button class="btn btn-primary pull-right" onclick="createDO()">Create</button>
            </div>
          </div>
      
        </div>
      </div>
      <script type='text/javascript' src="{!! asset('joli/js/plugins/validationengine/jquery.validationEngine.js') !!}"></script>   
      <script>
            $(document).ready(function() {


                $('input[name="purchase_date"]').daterangepicker({
                    locale: {
                    format: 'DD/MM/YYYY'
                    }
                });

                var t = $('.datatable').DataTable({
                    // "processing": true,
                    // "serverSide": true,
                    // "ajax":{
                    //         "url": "{{ url('order/sales/listing/process') }}",
                    //         "dataType": "json",
                    //         "type": "GET",
                    //         "data":{ _token: "{{csrf_token()}}"}
                    //     },
                    // "columns": [
                    //     { "data": "so_no" },
                    //     { "data": "purchase_date" },
                    //     { "data": "delivery_type" },
                    //     { "data": "do_no" },
                    //     { "data": "agent_code" },
                    //     { "data": "status" }
                    // ],
                    "order": [],
                    "columnDefs": [
                                { targets: 'no-sort', orderable: false }
                                ]
                });

                $('.generate_do_btn').click(function(){
                   let order_no =  $(this).data("order")
                   
                    $.ajax({
                            "url": "detail/"+order_no.trim(),
                            "type": "GET",
                            
                    }).done(function(result){
                        $('#so_no_title').text("("+result.data.order_no+")")
                        $('#ship_to_title').text("Ship to: "+result.data.name)
                        $('#sales_order_date_title').text("Sales Order Date: "+result.data.created_at)
                        // $('#contact_title').text("Contact No: "+result.data.order_no)
                        // $('#referal_title').text("Referral: "+result.data.order_no)

                        $('#purchase_date_info').text(result.data.purchase_date)
                        $('#delivery_type_info').text(result.data.delivery_code)
                        // $('#courier_service_info').text(result.data.order_no)
                        $('#shipping_address_info').text(result.data.street1+',\n'+result.data.street2+',\n'+result.data.state)
                        $('#billing_address_info').text(result.data.street1+',\n'+result.data.street2+',\n'+result.data.state)
                         console.log(result)
                         $("#order_item_table > tbody").html("");
                         var no = 0;
                         var product_name,product_description,product_qty,product_code
                        result.item.forEach(function(el){
                             no++;
                             product_name = el.name || ""
                             product_description = el.description || ""
                             product_qty = el.product_qty || ""
                             product_id = el.id || ""
                             product_code = el.code || ""

                            
                        $('#order_item_table > tbody:last-child').append('<tr><td>'+no+'</td><td>'+product_code+'</td><td contenteditable="true" class="input_barcode"></td><td>'+product_name+'</td><td>'+product_qty+'</td><td></td><td class="hide">'+product_id+'</td></tr>');
                        })
                        $('#generate_do_modal').modal().show();
                    })
                
            })
            })

            function createDO(){

                var items = [];
                $('#order_item_table >tbody tr').each(function () {
                    items.push(
                        {
                            "serial" : $(this).find('td').eq(1).text(),
                            "id"     : $(this).find('td').eq(5).text()
                        }
                        );
                });


                let data = {
                    "header" : {
                        "order_no"      : $('#so_no_title').text(),
                        "tracking_no"   : "",//$('#so_no_title').text()
                        "courier_id"    : $('#courier_service_info').text()
                    },
                    "item"  :   items
                }

                console.log(data)

                $.ajax({
                            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            "url": "generate_do",
                            "type": "POST",
                            "data":{"data":data}
                            
                    }).done(function(result){
                        location.reload();
            })
            }

            

            

        
        </script>
@endsection
