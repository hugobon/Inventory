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

    var gt_dataToSend = {
        do_hdr  : dataReceive.do_hdr,
        do_item : dataReceive.do_item
    };

    var gt_idVerify = "";

    function get_itemDetail(e){

        var headerTitle = "Item Detail";
        gt_idVerify = e;

        var lv_order_id = "";
        var lv_product_code = "";
        var lv_product_desc = "";
        var lv_product_qty = "";
        var lv_product_typ = "";
        var lv_serialno_list = [];

        if(e.target.textContent == "Add New Item"){

            headerTitle = e.target.textContent;
            var last_id = $('#tbody_item tr:last')[0].cells[0].textContent;
            console.log(last_id);
            if(last_id.indexOf('new') > -1){
                lv_order_id = "new_"+(+last_id.split("_")[1]+1);
            }else{ lv_order_id = "new_0";}

            $('#serialno_switch').prop('checked', false);
            $('#serialNo').css('display', 'none');
            $('#serialNo_list').css('display', 'none');
        }
        else{

            for(var i=0; i<gt_dataToSend.do_item.length; i++){
                if(gt_dataToSend.do_item[i].order_id == e.path['3'].cells['0'].textContent){

                    lv_order_id     = gt_dataToSend.do_item[i].order_id;
                    lv_product_code = gt_dataToSend.do_item[i].product_code;
                    lv_product_desc = gt_dataToSend.do_item[i].product_desc;
                    lv_product_qty  = gt_dataToSend.do_item[i].product_qty;
                    lv_product_typ  = gt_dataToSend.do_item[i].product_typ;
                    lv_serialno_list= gt_dataToSend.do_item[i].serialno;
                    break;
                }
            }

            if(lv_serialno_list.length > 0){

                $('#serialno_switch').prop('checked', true);
                $('#serialNo_list').empty();

                $('#serialNo').css('display', 'inherit');
                $('#serialNo_list').css('display', 'inherit');

                for(var j=0; j<lv_serialno_list.length; j++){
                    $('#serialNo_list').append('<div class="col-md-6" style="margin-bottom: 0.5%;"><input type="text" class="form-control" value="'+lv_serialno_list[j]+'"></div>');
                }

                var total_serialno = $('#serialNo_list')['0'].children.length;
                $('#serialNo_title').html("Serial No. List ("+total_serialno+")");
            }
            else{

                $('#serialno_switch').prop('checked', false);
                $('#serialNo').css('display', 'none');
                $('#serialNo_list').css('display', 'none');
            }
        }

        $('#order_id').val(lv_order_id);
        $('#product_code').val(lv_product_code);
        $('#product_desc').val(lv_product_desc);
        $('#product_qty').val(lv_product_qty);
        $('#product_typ').val(lv_product_typ);

        var total_serialno = $('#serialNo_list')['0'].children.length;
        $('#serialNo_title').html("Serial No. List ("+total_serialno+")");

        $('#largeModalHead').html(headerTitle);

        $("#add_delivery_order").modal("show");
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

    function fn_saveItemDetail(){

        var dataToStore = [];
        var serialList = ($('#serialNo_list'))[0].children;
        for(var i=0; i<serialList.length; i++){
            dataToStore.push(serialList[i].children[0].value);
        }

        for(var x=0; x<gt_dataToSend.do_item.length; x++){
            if(gt_dataToSend.do_item[x].order_id == $('#order_id').val()){
                gt_dataToSend.do_item[x].product_code = $('#product_code').val();
                gt_dataToSend.do_item[x].product_desc = $('#product_desc').val();
                gt_dataToSend.do_item[x].product_qty  = $('#product_qty').val();
                gt_dataToSend.do_item[x].product_typ  = $('#product_typ').val();
                gt_dataToSend.do_item[x].serialno     = dataToStore;
                break;
            }
        }

        if(gt_idVerify.target.textContent == "Add New Item"){

            gt_dataToSend.do_item.push({
                order_id        : $('#order_id').val(),
                product_code    : $('#product_code').val(),
                product_desc    : $('#product_desc').val(),
                product_qty     : $('#product_qty').val(),
                product_typ     : $('#product_typ').val(),
                serialno        : dataToStore
            });

            lv_row = "<tr>";
            lv_row+= "<td style='display:none;'>"+$('#order_id').val()+"</td>";
            lv_row+= "<td>"+(+$('#tbody_item tr:last')[0].cells[1].textContent + 1)+"</td>";
            lv_row+= "<td>"+$('#product_code').val()+"</td>";
            lv_row+= "<td>"+$('#product_desc').val()+"</td>";
            lv_row+= "<td>"+$('#product_qty').val()+"</td>";
            lv_row+= "<td>"+$('#product_typ').val()+"</td>";
            lv_row+= '<td><a href="#" onclick="get_itemDetail(event)"><span class="label label-warning">Draft</span></a></td>';
            lv_row+= "</tr>";

            $('#tbody_item').append(lv_row);
        }
        else{

            $(gt_idVerify.target).removeClass();
            $(gt_idVerify.target).addClass('label label-warning').html('Draft');
        }            

        $("#add_delivery_order").modal("hide");
    }

    function fn_verifyItemDetail(){

        var error = false;
        var dataToStore = [];
        if($('#serialno_switch')[0].checked){
            var serialList = ($('#serialNo_list'))[0].children;
            if(serialList.length >= $('#product_qty').val()){
                for(var i=0; i<serialList.length; i++){
                    if(serialList[i].children[0].value == ""){
                        error = true;
                        msg = "Serial No cannot be empty to verified";
                        break;
                    }

                    dataToStore.push(serialList[i].children[0].value);
                }
            }
            else{error = true; msg = "Serial no list not match with quantity";}
        }

        if(error){
            console.log(msg);
        }
        else{
            console.log("Verified!");

            if(gt_idVerify.target.textContent == "Add New Item"){

                gt_dataToSend.do_item.push({
                    order_id        : $('#order_id').val(),
                    product_code    : $('#product_code').val(),
                    product_desc    : $('#product_desc').val(),
                    product_qty     : $('#product_qty').val(),
                    product_typ     : $('#product_typ').val(),
                    serialno        : dataToStore
                });

                lv_row = "<tr>";
                lv_row+= "<td style='display:none;'>"+$('#order_id').val()+"</td>";
                lv_row+= "<td>"+(+$('#tbody_item tr:last')[0].cells[1].textContent + 1)+"</td>";
                lv_row+= "<td>"+$('#product_code').val()+"</td>";
                lv_row+= "<td>"+$('#product_desc').val()+"</td>";
                lv_row+= "<td>"+$('#product_qty').val()+"</td>";
                lv_row+= "<td>"+$('#product_typ').val()+"</td>";
                lv_row+= '<td><a href="#" onclick="get_itemDetail(event)"><span class="label label-success">Verified</span></a></td>';
                lv_row+= "</tr>";

                $('#tbody_item').append(lv_row);
                
            }
            else{

                for(var x=0; x<gt_dataToSend.do_item.length; x++){
                    if(gt_dataToSend.do_item[x].order_id == $('#order_id').val()){
                        gt_dataToSend.do_item[x].product_code = $('#product_code').val();
                        gt_dataToSend.do_item[x].product_desc = $('#product_desc').val();
                        gt_dataToSend.do_item[x].product_qty  = $('#product_qty').val();
                        gt_dataToSend.do_item[x].product_typ  = $('#product_typ').val();
                        gt_dataToSend.do_item[x].serialno     = dataToStore;
                        break;
                    }
                }

                $(gt_idVerify.target).removeClass();
                $(gt_idVerify.target).addClass('label label-success').html('Verified');
            }

            $("#add_delivery_order").modal("hide");
        }
    }

    function fn_saveDO(){

        gt_dataToSend.do_hdr.delivery_status = "01";
        gt_dataToSend.do_hdr.courier_id = $('#courier_id').val();
        gt_dataToSend.do_hdr.tracking_no = $('#tracking_no').val();
        ajax_send();
    }

    function fn_verifyDO(){

        var tbody = $('#tbody_item')[0].children;
        var error = false;
        var msg = "";

        if($('#tracking_no').val() != ""){
            for(var i=0; i<tbody.length; i++){
                if(tbody[i].cells[6].textContent != "Verified"){
                    error = true;
                    msg = "Please verify all item before proceed to pickup";
                    break;
                }
            }
        }
        else{
            error = true;
            msg = "Please insert tracking no / consigment note";
        }

        if(error){
            console.log(msg);
        }
        else{
            console.log("DO ready to pickup!");
            gt_dataToSend.do_hdr.delivery_status = "02";
            gt_dataToSend.do_hdr.courier_id = $('#courier_id').val();
            gt_dataToSend.do_hdr.tracking_no = $('#tracking_no').val();
            ajax_send();
        }
    }

    function ajax_send(){

        console.log(gt_dataToSend);

        // $.ajax({
        //     url: "",
        //     type: "POST",
        //     data: gt_dataToSend,
        //     success: function(response){
        //         console.log(response);
        //     },
        //     error: function(jqXHR, errorThrown, textStatus){
        //         console.log(jqXHR);
        //         console.log(errorThrown);
        //         console.log(textStatus);
        //     }
        // });
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
                                                <select class="form-control" id="courier_id">{!! $outputData['order_hdr']->courier !!}</select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Tracking No</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="tracking_no">
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
                                    <!-- <div class="col-md-8"> -->
                                        <!-- <ul class="panel-controls">
                                            <li><a href="#" onclick="get_itemDetail(event)"><span class="fa fa-plus"></span></a></li>
                                        </ul> -->
                                        <button type="button" class="btn btn-default pull-right" onclick="get_itemDetail(event)"><i class="fa fa-plus"></i>Add New Item</button>
                                    <!-- </div> -->
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
                                            <tbody id="tbody_item">
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
                        <button type="button" class="btn btn-success pull-right" onclick="fn_verifyDO()">Ready to Pickup</button>
                        <button type="button" class="btn btn-primary pull-right" onclick="fn_saveDO()" style="margin-right: 0.3%;">Save</button>
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
                        <div class="form-group" style="display: none;">
                            <label class="col-md-3 control-label">ID</label>
                            <div class="col-md-9">
                                <input type="text" id="order_id" class="form-control">
                            </div>
                        </div>
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
                    <button type="button" class="btn btn-primary" onclick="fn_saveItemDetail()">Save</button>
                    <button type="button" class="btn btn-success" onclick="fn_verifyItemDetail()">Verified</button>  <!-- data-dismiss="modal" -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODALS -->

@endsection