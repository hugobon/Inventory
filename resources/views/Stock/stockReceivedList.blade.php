@extends('header')
@section('title','Stock Received Listing')
@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="#">Stock</a></li>
        <li class="active">Stock In Listing</li>
    </ul>
    <!-- END BREADCRUMB -->     
    
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <h3 class="panel-title">Stock In Listing as {{date('d/m/Y')}}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    {{--  <div class="form-group">
                                        <label class="col-md-3 control-label">Purchase Date</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="purchase_date">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Delivery Type</label>
                                        <div class="col-md-9">
                                            <select class="form-control">
                                                <option></option>
                                                <option>Self Collect</option>
                                                <option>Delivery</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Invoice No.</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="inv_no">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Agent Code</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="agent_code">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Delivery Address</label>
                                        <div class="col-md-9">
                                            <input type="text" name="street1" class="form-control" placeholder="Street 1">
                                        </div>
                                    </div>
                                    <div class="form-group">
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
                                    </div>  --}}
                                   <!--  <div class="form-group">
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
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Stock In Date</th>
                                            <th>Stock Received No</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th></th>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataToReturn as $stockIn)
                                        <tr>
                                        <td>{{$stockIn->in_stock_date}}</td>
                                        <td>{{$stockIn->stock_received_number}}</td>
                                        <td>{{$stockIn->description}}</td>
                                        <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" onclick="fn_clear()">Clear Form</button>
                            <button class="btn btn-primary pull-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $(function() {
        $('input[name="purchase_date"]').daterangepicker();
        
    });
    
    function fn_clear(){
        console.log("clear!");
    }
    </script>
@endsection