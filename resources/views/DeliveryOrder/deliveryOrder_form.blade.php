@extends('header')
@section('title','Delivery Order')

@section('content')

<style type="text/css">
    label{
        color: black;
    }
</style>

<script type="text/javascript">

    // Store data from controller to temp array
    var dataReceive = JSON.parse(JSON.stringify({!! json_encode($outputData) !!}));

    var dataToSend = {
        do_hdr  : dataReceive.do_hdr,
        do_item : dataReceive.do_item
    };

    function get_itemDetail(e){

        var headerTitle = "";

        $('#serialno_switch').prop('checked', false);
        $('#serialNo').css('display', 'none');
        $('#serialNo_list').css('display', 'none');

        if(e.path['3'].cells == undefined){

            $('#product_code').val("");
            $('#product_desc').val("");
            $('#product_qty').val("");
            $('#product_typ').val("");

            headerTitle = "Add New Item";
        }
        else{

            $('#product_code').val(e.path['3'].cells['2'].textContent);
            $('#product_desc').val(e.path['3'].cells['3'].textContent);
            $('#product_qty').val(e.path['3'].cells['4'].textContent);
            $('#product_typ').val(e.path['3'].cells['5'].textContent);

            headerTitle = "Item Detail";
        }

        var total_serialno = $('#serialNo_list')['0'].children.length;
        $('#serialNo_title').html("Serial No. List ("+total_serialno+")");

        $('#largeModalHead').html(headerTitle);

        $("#add_delivery_order").modal("show");
    }

    function fn_saveItemDetail(){


    }

    function fn_add_serialno(){

        $('#serialNo_list').append('<div class="col-md-6" style="margin-bottom: 0.5%;"><input type="text" class="form-control"></div>');

        var total_serialno = $('#serialNo_list')['0'].children.length;
        $('#serialNo_title').html("Serial No. List ("+total_serialno+")");
    }

    function fn_toggleSwitch(e){

        if(e.target.checked){

            $('#serialNo_list').empty();

            $('#serialNo').css('display', 'inherit');
            $('#serialNo_list').css('display', 'inherit');

            var qty = $('#product_qty').val();

            for(var i=0; i<qty; i++){
                $('#serialNo_list').append('<div class="col-md-6" style="margin-bottom: 0.5%;"><input type="text" class="form-control"></div>');
            }

            var total_serialno = $('#serialNo_list')['0'].children.length;
            $('#serialNo_title').html("Serial No. List ("+total_serialno+")");
        }
        else{
            $('#serialNo').css('display', 'none');
            $('#serialNo_list').css('display', 'none');
        }
    }

</script>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="#">Supplier</a></li>
    <li class="active">Delivery Order</li>
</ul>
<!-- END BREADCRUMB -->     

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" action="{!! url('delivery_order/create') !!}" method="POST">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding-bottom: 0px;">
                         <div class="row">
                            <h2 class="panel-title">New DO#</h2>
                        </div>
                        <div class="row col-md-4">
                            <p>Ship To: Zulhilmi (A001)</p>
                            <p>Sales Order Date: 01 Mar 2018</p>
                        </div>
                        <div class="row col-md-4">
                            <p>Contact No: 013-5151861</p>
                            <p>Referral: Nick SKG</p>
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
                                            <label class="col-md-3 control-label">Sales Order No</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['order_hdr']->order_no !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Purchase Date</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['order_hdr']->purchase_date !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Delivery Type</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['order_hdr']->delivery_type !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- <div class="form-group">
                                            <label class="col-md-3 control-label">Invoice No</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{!! $outputData['order_hdr']->invoice_no !!}" readonly>
                                            </div>
                                        </div> -->
                                    <div class="row" style="margin-top: 2%;">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Courier Service</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="courier_id">{!! $outputData['order_hdr']->courier !!}</select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Tracking No</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="tracking_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Shipping Address</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['order_hdr']->ship_address !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Billing Address</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['order_hdr']->bill_address !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-item">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <p class="form-control-static">Item List: {!! $outputData['totalitem'] !!}</p>
                                    </div>
                                    <div class="col-md-8">
                                        <ul class="panel-controls">
                                            <li><a href="#" onclick="get_itemDetail(event)"><span class="fa fa-plus"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="display: none;">ID</th>
                                                    <th width="20">No</th>
                                                    <th width="200">Item Code</th>
                                                    <th>Description</th>
                                                    <th colspan="2">Quantity</th>
                                                    <th>Status</th>
                                                <tr>
                                            </thead>
                                            <tbody>
                                                {!! $outputData['item_list'] !!}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-default">Cancel</button>
                        <button type="button" class="btn btn-success pull-right">Ready to Pickup</button>
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 0.3%;">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODALS -->
<div class="modal fade" id="add_delivery_order" data-backdrop="static" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" action="{{ url('delivery_order/form') }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Cancel">&times;</button>
                    <h4 class="modal-title" id="largeModalHead">Add New Item</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Code</label>
                            <div class="col-md-9">
                                <input type="text" id="product_code" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-9">
                                <input type="text" id="product_desc" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Quantity</label>
                            <div class="col-md-5">
                                <input type="text" id="product_qty" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="product_typ" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Serial No</label>
                            <div class="col-md-9">
                                <label class="switch switch-small">
                                    <input id="serialno_switch" type="checkbox" onclick="fn_toggleSwitch(event)" />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div id="serialNo" class="form-group" style="display: none;">
                            <div class="col-md-4">
                                <p id="serialNo_title" class="form-control-static"></p>
                            </div>
                            <div class="col-md-8">
                                <button type="button" class="btn btn-default pull-right" onclick="fn_add_serialno()"><i class="fa fa-plus"></i>Add Serial No</button>
                            </div>
                        </div>
                        <div id="serialNo_list" class="form-group">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Verified</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODALS -->

@endsection