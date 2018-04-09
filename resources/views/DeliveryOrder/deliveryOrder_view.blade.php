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
    console.log(dataReceive);
    var gt_dataToSend = {
        do_hdr  : dataReceive.do_hdr,
        do_item : dataReceive.do_item
    };

    var gt_idVerify = "";

    function get_itemDetail(e){
        console.log(e);
        var headerTitle = "Item Detail";
        gt_idVerify = e;

        var lt_data = {
            headerTitle     : "Item Detail",
            lv_order_id     : "",
            lv_product_code : "",
            lv_product_desc : "",
            lv_product_qty  : "",
            lv_product_typ  : "",
            lv_product_id   : "",
            lv_serialno_list: []
        };

        $.ajax({
            url: "/delivery_order/get_itemDetail",
            type: "POST",
            data: {_token: "{!! csrf_token() !!}",id: e.path['3'].cells['0'].textContent},
            success: function(response){

                lt_data['lv_order_id']     = e.path['3'].cells['0'].textContent;
                lt_data['lv_product_id']   = e.path['3'].cells['4'].textContent;
                lt_data['lv_product_desc'] = e.path['3'].cells['5'].textContent;
                lt_data['lv_product_qty']  = e.path['3'].cells['6'].textContent;
                lt_data['lv_product_typ']  = e.path['3'].cells['7'].textContent;
                lv_serialno_list           = response.serialnoList;

                if(lv_serialno_list.length > 0){

                    $('#serialno_switch').prop('checked', true);
                    $('#serialNo_list').empty();

                    $('#serialNo').css('display', 'inherit');
                    $('#serialNo_list').css('display', 'inherit');
                    $('#serialNo_title').css('display', 'inherit');

                    for(var j=0; j<lv_serialno_list.length; j++){
                        $('#serialNo_list').append('<div class="col-md-6" style="margin-bottom: 0.5%;"><p class="form-control-static">'+lv_serialno_list[j]+'</p></div>');
                    }

                    var total_serialno = $('#serialNo_list')['0'].children.length;
                    $('#serialNo_title').html("Serial No. List ("+total_serialno+")");
                }
                else{

                    $('#serialno_switch').prop('checked', false);
                    $('#serialNo_title').css('display', 'none');
                    $('#serialNo_list').css('display', 'none');
                }

                $('#qty_input').css('display', 'none');
                $('#qty_dsp').css('display', 'inherit');

                show_modal(lt_data);
            },
            error: function(jqXHR, errorThrown, textStatus){
                console.log(jqXHR);
                console.log(errorThrown);
                console.log(textStatus);
            }
        });
    }

    function show_modal(data){

        $('#order_id').val(data['lv_order_id']);
        $('#product_code').html(data['lv_product_id']);
        $('#product_desc').html(data['lv_product_desc']);
        $('#product_qty').html(data['lv_product_qty']);
        $('#product_typ').html(data['lv_product_typ']);

        var total_serialno = $('#serialNo_list')['0'].children.length;
        $('#serialNo_title').html("Serial No. List ("+total_serialno+")");

        $('#largeModalHead').html(data['headerTitle']);

        $("#add_delivery_order").modal("show");
    }

    function fn_toggleSwitch(e){

        if(e.target.checked){

            $('#serialNo_list').empty();

            $('#serialNo_title').css('display', 'inherit');
            $('#serialNo_list').css('display', 'inherit');

            var total_serialno = $('#serialNo_list')['0'].children.length;
            $('#serialNo_title').html("Serial No. List ("+total_serialno+")");
        }
        else{
            $('#serialNo_title').css('display', 'none');
            $('#serialNo_list').css('display', 'none');
        }
    }

    function fn_saveItemDetail(){

        var dataToStore = [];
        if($('#serialno_switch')[0].checked){
            var serialList = ($('#serialNo_list'))[0].children;
            for(var i=0; i<serialList.length; i++){
                dataToStore.push(serialList[i].children[0].textContent);
            }
        }
        else{
            dataToStore = [];
        }

        if(gt_idVerify.target.textContent == "Add New Item"){

            for(var p=0; p<dataReceive.qtytype.length; p++){
                if(dataReceive.qtytype[p].id == $('#inp_product_typ').val()){
                    var qtytype = dataReceive.qtytype[p].type;
                    break;
                }
            }

            for(var k=0; k<dataReceive.product.length; k++){
                if(dataReceive.product[k].id == $('#product_code').val()){
                    var product = dataReceive.product[k].code;
                    break;
                }
            }

            gt_dataToSend.do_item.push({
                order_id        : $('#order_id').val(),
                product_id      : $('#product_code').val(),
                product_desc    : $('#product_desc').html(),
                product_qty     : $('#inp_product_qty').val(),
                product_typ     : $('#inp_product_typ').val(),
                status          : "02",
                serialno        : dataToStore
            });

            lv_row = "<tr>";
            lv_row+= "<td style='display:none;'>"+$('#order_id').val()+"</td>";
            lv_row+= "<td>"+(+$('#tbody_item tr:last')[0].cells[1].textContent + 1)+"</td>";
            lv_row+= "<td>"+product+"</td>";
            lv_row+= "<td>"+$('#product_desc').html()+"</td>";
            lv_row+= "<td>"+$('#inp_product_qty').val()+"</td>";
            lv_row+= "<td>"+qtytype+"</td>";
            lv_row+= '<td><a href="#" onclick="get_itemDetail(event)"><span class="label label-warning">Draft</span></a></td>';
            lv_row+= "</tr>";

            $('#tbody_item').append(lv_row);
        }
        else{

            for(var x=0; x<gt_dataToSend.do_item.length; x++){
                if(gt_dataToSend.do_item[x].order_id == $('#order_id').val()){
                    gt_dataToSend.do_item[x].product_id = $('#product_code').val();
                    gt_dataToSend.do_item[x].product_desc = $('#product_desc').html();
                    gt_dataToSend.do_item[x].product_qty  = $('#product_qty').html();
                    gt_dataToSend.do_item[x].product_typ  = $('#product_typ').html();
                    gt_dataToSend.do_item[x].status       = "02";
                    gt_dataToSend.do_item[x].serialno     = dataToStore;
                    break;
                }
            }

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
            if(serialList.length >= $('#product_qty').html()){
                for(var i=0; i<serialList.length; i++){
                    if(serialList[i].children[0].textContent == ""){
                        error = true;
                        msg = "Serial No cannot be empty to verified";
                        break;
                    }

                    dataToStore.push(serialList[i].children[0].textContent);
                }
            }
            else{error = true; msg = "Serial no list not match with quantity";}
        }
        else{
            dataToStore = [];
        }

        if(error){
            console.log(msg);
            alert(msg);
        }
        else{
            console.log("Verified!");

            if(gt_idVerify.target.textContent == "Add New Item"){

                // lol
                qtytype = get_qtytyp($('#inp_product_typ').val());

                for(var k=0; k<dataReceive.product.length; k++){
                    if(dataReceive.product[k].id == $('#product_code').val()){
                        var product = dataReceive.product[k].code;
                    }
                }

                gt_dataToSend.do_item.push({
                    order_id        : $('#order_id').val(),
                    product_id      : $('#product_code').val(),
                    product_desc    : $('#product_desc').html(),
                    product_qty     : $('#inp_product_qty').val(),
                    product_typ     : $('#inp_product_typ').val(),
                    status          : "03",
                    serialno        : dataToStore
                });

                lv_row = "<tr>";
                lv_row+= "<td style='display:none;'>"+$('#order_id').val()+"</td>";
                lv_row+= "<td>"+(+$('#tbody_item tr:last')[0].cells[1].textContent + 1)+"</td>";
                lv_row+= "<td>"+product+"</td>";
                lv_row+= "<td>"+$('#product_desc').html()+"</td>";
                lv_row+= "<td>"+$('#inp_product_qty').val()+"</td>";
                lv_row+= "<td>"+qtytype+"</td>";
                lv_row+= '<td><a href="#" onclick="get_itemDetail(event)"><span class="label label-success">Verified</span></a></td>';
                lv_row+= "</tr>";

                $('#tbody_item').append(lv_row);
                
            }
            else{

                for(var x=0; x<gt_dataToSend.do_item.length; x++){
                    if(gt_dataToSend.do_item[x].order_id == $('#order_id').val()){
                        gt_dataToSend.do_item[x].product_id = $('#product_code').val();
                        gt_dataToSend.do_item[x].product_desc = $('#product_desc').html();
                        gt_dataToSend.do_item[x].product_qty  = $('#product_qty').html();
                        gt_dataToSend.do_item[x].product_typ  = $('#product_typ').html();
                        gt_dataToSend.do_item[x].status       = "03";
                        gt_dataToSend.do_item[x].serialno     = dataToStore;
                        break;
                    }
                }

                $(gt_idVerify.target).removeClass();
                $(gt_idVerify.target).addClass('label label-success').html('Verified');
            }

            $("#add_delivery_order").modal("hide");
        }

        console.log(gt_dataToSend);
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
            alert(msg);
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

        $.ajax({
            url: "create",
            type: "POST",
            data: {_token: "{!! csrf_token() !!}",gt_dataToSend},
            success: function(response){
                console.log(response);
            },
            error: function(jqXHR, errorThrown, textStatus){
                console.log(jqXHR);
                console.log(errorThrown);
                console.log(textStatus);
            }
        });
    }

    function fn_selectPC(){

        for(var i=0; i<dataReceive.product.length; i++){
            if(dataReceive.product[i].id == $('#product_code').val()){
                $('#product_desc').html(dataReceive.product[i].name);
                break;
            }
        }
    }

    function get_qtytyp(id){

        for(var x=0; x<dataReceive.qtytype.length; x++){
            if(dataReceive.qtytype[x].id == id){
                return dataReceive.qtytype[x].type;
            }
        }
    }

</script>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="#">Delivery Order</a></li>
    <li class="active">View Delivery Order</li>
</ul>
<!-- END BREADCRUMB -->     

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" onsubmit="return false;">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding-bottom: 0px;">
                         <div class="row" style="padding-bottom: 1%;">
                            <div class="panel-title form-group">
                                <h2 style="display: inline;">{!! $outputData['do_no'] !!}</h2>
                                <h4 style="display: inline;">({!! $outputData['description'] !!})</h4>
                                
                            </div>
                            <ul class="panel-controls">
                                <li><button type="button" class="btn btn-success pull-right">Collected</button></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>Ship To: {!! $outputData['user'] !!}</p>
                                <p>Sales Order Date: {!! $outputData['purchase_date'] !!}</p>
                            </div>
                            <div class="col-md-4">
                                <p>Contact No: 013-5151861</p>
                                <p>Referral: Nick SKG</p>
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
                                            <label class="col-md-3 control-label">Sales Order No</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['order_no'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Purchase Date</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['purchase_date'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Delivery Type</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['delivery_type'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Courier Service</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['courier'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Tracking No</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['tracking_no'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Shipping Address</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['ship_address'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Billing Address</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static">{!! $outputData['bill_address'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-item">
                                <div class="form-group">
                                    <p class="form-control-static">Item List: {!! $outputData['totalitem'] !!}</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="display: none;">ID</th>
                                                    <th style="display: none;">Product ID</th>
                                                    <th style="display: none;">Product Typ</th>
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
                        <!-- <button type="button" class="btn btn-default">Cancel</button>
                        <button type="button" class="btn btn-success pull-right" onclick="fn_verifyDO()">Ready to Pickup</button>
                        <button type="button" class="btn btn-primary pull-right" onclick="fn_saveDO()" style="margin-right: 0.3%;">Save</button> -->
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
            <form class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" data-placement="left" title="Cancel">&times;</button>
                    <h4 class="modal-title" id="largeModalHead">Add New Item</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group" style="display: none;">
                            <label class="col-md-3 control-label">ID</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="order_id"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Code</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="product_code"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Name</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="product_desc"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Quantity</label>
                            <div class="col-md-1">
                                <p class="form-control-static" id="product_qty"></p>
                            </div>
                            <div class="col-md-8">
                                <p class="form-control-static" id="product_typ"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="serialNo_area" class="form-group has-feedback">
                            <label class="col-md-3 control-label">Serial No</label>
                            <div class="col-md-1">
                                <label class="switch switch-small">
                                    <input id="serialno_switch" type="checkbox" disabled /><span></span>
                                </label>
                            </div>
                        </div>
                        <p id="serialNo_title" class="form-control-static" style="display: none;"></p>
                        <div id="serialNo_list" class="form-group">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODALS -->

@endsection