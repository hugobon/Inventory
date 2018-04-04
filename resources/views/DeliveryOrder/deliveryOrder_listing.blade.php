@extends('header')
@section('title','Delivery Order')

@section('content')

<script type="text/javascript">

$(function() {
    $('#purchase_date').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        },
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
            console.log(response);
        },
        error: function(jqXHR, errorThrown, textStatus){
            console.log(jqXHR);
            console.log(errorThrown);
            console.log(textStatus);
        }
    });
}

</script>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="#">Delivery Order</a></li>
    <li class="active">Create Delivery Order</li>
</ul>
<!-- END BREADCRUMB -->     

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Search Sales Order</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-default pull-right" onclick="fn_search()"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </div>
                            <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Purchase Date</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="purchase_date">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Delivery Type</label>
                                    <div class="col-md-9">
                                        <select id="delivery_typ" class="form-control">
                                            <option></option>
                                            <option>Self Collect</option>
                                            <option>Delivery</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Invoice No.</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="inv_no">
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="col-md-3 control-label">Agent Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="agent_code">
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Agent Code</label>
                                    <div class="col-md-9">                                                                                
                                        <select id="agent_code" class="form-control select" data-live-search="true">
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
                    <div class="panel-body">
                        SO List: {!! $outputData['totalDO'] !!}
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SO No</th>
                                        <th>Delivery Type</th>
                                        <th>Invoice No</th>
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
                    <!-- <div class="panel-footer">
                        <button type="button" class="btn btn-default" onclick="fn_clear()">Clear Form</button>
                        <button class="btn btn-primary pull-right">Save</button>
                    </div> -->
                </div>
            </form>
        </div>
    </div>
</div>

@endsection