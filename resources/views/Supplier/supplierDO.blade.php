@extends('header')
@section('title','Delivery Order')

@section('content')

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
                    <div class="panel-heading">
                        <h3 class="panel-title">Delivery Order</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Purchase Date</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                            <input type="text" class="form-control datepicker">
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control datepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Delivery Type</label>
                                    <div class="col-md-9">
                                        <select class="form-control select">
                                            <option></option>
                                            <option>Self Collect</option>
                                            <option>Delivery</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Invoice No.</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Agent Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Delivery Address</label>
                                    <div class="col-md-9">
                                        <div class="col-md-12 btn-group btn-group-lg" style="padding-left: 0px; padding-bottom: 5px;">
                                            <button type="button" class="btn btn-default">Address no 1</button>
                                        </div>
                                        <div class="col-md-12 btn-group btn-group-lg" style="padding-left: 0px; padding-bottom: 5px;">
                                            <button type="button" class="btn btn-default">Address no 1</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Courier Service</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Tracking No</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control">
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