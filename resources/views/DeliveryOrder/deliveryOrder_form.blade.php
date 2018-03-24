@extends('header')
@section('title','Delivery Order')

@section('content')

<script type="text/javascript">
// $(function() {
//     $('input[name="purchase_date"]').daterangepicker();
// });
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
                         <div class="row col-md-12">
                            <p>Ship To: Zulhilmi (A001)</p>
                            <p>Sales Order Date: 01 Mar 2018</p>
                        </div>
                        <div class="tabs" style="padding-top: 15px;">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#tab-order" role="tab" data-toggle="tab">Order</a></li>
                                <li><a href="#tab-item" role="tab" data-toggle="tab">Items</a></li>
                            </ul>
                        </div>
                    </div>  
                    <div class="panel-body">
                        <div class="row">
                            <div class="panel-body tab-content">
                                <div class="tab-pane active" id="tab-order">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Purchase Date</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{!! $outputData['order_hdr']->purchase_date !!}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Delivery Type</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{!! $outputData['order_hdr']->delivery_type !!}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Invoice No</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{!! $outputData['order_hdr']->invoice_no !!}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Sales Order No</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="order_no" value="{!! $outputData['order_hdr']->order_no !!}" readonly>
                                            </div>
                                        </div>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Shipping Address</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" rows="6" readonly>{!! $outputData['order_hdr']->ship_address !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Billing Address</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" rows="6" readonly>{!! $outputData['order_hdr']->bill_address !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-item">
                                    Item List: {!! $outputData['totalitem'] !!}
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="20">No</th>
                                                    <th width="200">Item Code</th>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th></th>
                                                <tr>
                                            </thead>
                                            <tbody>
                                                {!! $outputData['order_item'] !!}
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

@endsection