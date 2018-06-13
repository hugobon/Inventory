@extends('header')
@section('title','Delivery Order')

@section('content')

<script type="text/javascript">

$(function() {
    // $('#purchase_date')
    
    $('input[name="purchase_date"]').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        },
        startDate: "{!! $outputData['startDate'] !!}",
        endDate: "{!! $outputData['endDate'] !!}"
    });
});

function fn_clear(){
    console.log("clear!");
}

function fn_search(){

    var lt_data = {
        _token : "{!! csrf_token() !!}",
        parameter : {
            purchase_date   : $('#purchase_date').val(),
            delivery_typ    : $('#delivery_typ').val(),
            inv_no          : $('#inv_no').val(),
            agent_code      : $('#agent_code').val(),

        }
    }

    $.ajax({
        url: "listing",
        type: "POST",
        data: lt_data,
        success: function(response){
            console.log("{!! $outputData['doListing'] !!}");
            $('#soListing').html("{!! $outputData['doListing'] !!}")
            // console.log({!! $outputData['doListing'] !!});  onclick="fn_search()"
        },
        error: function(jqXHR, errorThrown, textStatus){
            console.log(jqXHR);
            console.log(errorThrown);
            console.log(textStatus);
        }
    });
}

function generateDO(e){

    if(e.target.textContent == "Pending"){
        $.ajax({
            url: "form",
            type: "POST",
            data: {
                _token : "{!! csrf_token() !!}",
                sales_order: e.path[3].cells[0].textContent
            },
            success: function(response){
                console.log(response);
                // document.write(response);
            },
            error: function(jqXHR, errorThrown, textStatus){
                console.log(jqXHR);
                console.log(errorThrown);
                console.log(textStatus);
            }
        });
    }
}

function fn_openSO(e){

    console.log(e.target.textContent);
    $('#orderNo').html('SO '+e.target.textContent);
    $('#cdo').click();
}

</script>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="#">Delivery Order</a></li>
    <li class="active">Search Sales Order</li>
</ul>
<!-- END BREADCRUMB -->     

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" action="listing" method="POST">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Search Sales Order</h3>
                    </div>
                    <div class="panel-body">
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
                                            {!! $outputData['delitypOption'] !!}
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="col-md-3 control-label">Invoice No.</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="inv_no">
                                    </div>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label class="col-md-3 control-label">Agent Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="agent_code">
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Agent Code</label>
                                    <div class="col-md-9">                                                                                
                                        <select name="agent_code" class="form-control select" data-live-search="true">
                                            {!! $outputData['agentListing'] !!}
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
                                <!-- <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <input type="text" name="street2" class="form-control" placeholder="Street 2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-4">
                                        <input type="text" name="poscode" class="form-control" placeholder="Postal Code">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="city" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-4">
                                        <input type="text" name="state" class="form-control" placeholder="State">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="country" class="form-control" placeholder="Country">
                                    </div>
                                </div> -->
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form class="form-horizontal">
                <!-- {{ csrf_field() }} -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <button id="cdo" type="button" class="btn btn-default mb-control" data-box="#create_delivery_order" style="display: none;"></button>
                        SO List: {!! $outputData['totalDO'] !!}
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SO No</th>
                                        <th>Purchase Date</th>
                                        <th>Delivery Type</th>
                                        <th>DO No</th>
                                        <th>Agent Code</th>
                                        <th>Status</th>
                                    <tr>
                                </thead>
                                <tbody>
                                    {!! $outputData['doListing'] !!}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <!-- <button type="button" class="btn btn-default" onclick="fn_clear()">Clear Form</button> -->
                        <!-- <button class="btn btn-primary pull-right">Save</button> -->
                    </div>
                </div>
            </form>
        </div>

        <!-- START MESSAGE BOX UTK SO DETAILS-->
        <div class="message-box animated fadeIn" id="create_delivery_order">
            <div class="mb-container" style="background: none !important;">
                <div class="mb-middle">
                    <div class="mb-content">
                        <form class="form-horizontal" action="{{ url('delivery_order/form') }}" method="POST">
                            {{ csrf_field() }}
                            <!-- <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">New Delivery Order</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" style="color: black;">Sales Order</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="sales_order">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default mb-control-close">Cancel</button>
                                    <button class="btn btn-primary pull-right">Create</button>
                                </div>
                            </div> -->

                            <!-- START PAGE SO CONTENT -->
                            <div class="panel panel-default">
                                <div class="panel-heading" style="padding-bottom: 0px;">
                                     <div class="row" style="padding-bottom: 1%;">
                                        <div class="panel-title form-group">
                                            <h2 id="orderNo" style="display: inline;">SO No</h2>
                                            <!-- <h4 style="display: inline;">()</h4> -->
                                            
                                        </div>
                                        <ul class="panel-controls">
                                            <li><button type="button" class="btn btn-success pull-right">Collected</button></li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Ship To: Zulhilmi (Z001)</p>
                                            <p>Sales Order Date: 11 Apr 2018</p>
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
                                                            <p class="form-control-static">TEST</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Purchase Date</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static">TEST</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Delivery Type</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static">TEST</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Courier Service</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static">TEST</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
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
                                                            <p class="form-control-static">TEST</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Billing Address</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static">TEST</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-item">
                                            <div class="form-group">
                                                <p class="form-control-static">Item List: TEST</p>
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
                                    <button class="btn btn-default mb-control-close">Cancel</button>
                                    <button class="btn btn-primary pull-right">Create</button>
                                </div>
                            </div>
                            <!-- END OF PAGE SO CONTENT -->

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX -->
    </div>
</div>

@endsection