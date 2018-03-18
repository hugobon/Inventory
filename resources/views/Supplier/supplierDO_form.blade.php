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
            <form class="form-horizontal">
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
                                                <input type="text" class="form-control" name="purchase_date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Delivery Type</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="delivery_ty">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Shipping Address</label>
                                            <div class="col-md-9">
                                                <!-- <input type="text" class="form-control" name="delivery_ty"> -->
                                                <textarea class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Billing Address</label>
                                            <div class="col-md-9">
                                                <!-- <input type="text" class="form-control" name="delivery_ty"> -->
                                                <textarea class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Purchase Order No</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="purchase_date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Invoice No</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="purchase_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-item">
                                    Item List:
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default">Clear Form</button>
                        <button class="btn btn-primary pull-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection