@extends('header')
@include('Agent.js.agent_control')
@include('Agent.css.agent_css')
@section('title','Config')
@section('content')

<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->
<!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!-- Include the above in your HEAD tag -->

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="javascript:;">Home</a></li>                    
    <li class="{{ url('agent') }}">Agent</li>
    <li class="{{ url('agent') }}">Select Product</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="horizontal">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Cart List</strong> </h3>
                        <ul class="panel-controls">
                            <!-- <a href=" {{ url('agent/get_order_stock/12221112/edit') }}" id="edit_button"><span class="fa fa-edit" style="font-size:20px"></span></a> -->
                        </ul>
                    </div>
                </div>
                <div class="panel-body form-horizontal">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="col-md-2 col-md-offset-5">
                                <p><span id="form-title"> </span></p>
                            </div>
                        </div>
                        <div class="container cart-list" style="margin-top:0px;">
                            <div class="row cart-row">
                                <div class="col-sm-12 col-md-8">
                                    <table class="table table-actions table-cart-item" id="item-table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Total</th>
                                                <th hidden=""><input type="hidden" id="agent_id" value="{{ $returnData['agent_id'] }}"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $key => $value)
                                            <tr class="row-cart-item">
                                                <td class="col-sm-8 col-md-4 column-cart-item">
                                                    <div class="media cart-content">
                                                        <input type="hidden" id="id" value="{{ $value->id }}">
                                                        <input type="hidden" id="produt_id" value="{{ $value->product_id }}">
                                                        <a class="thumbnail pull-left img-content" href="#"> <img class="media-object" src="{{ $value['image'] == '' ? asset('invalid_image.png') : asset('storage/'.$value['image']) }}" style="width: 72px; height: 72px;"> </a>
                                                        <div class="media-body">
                                                            <h4 class="media-heading"><a href="#">{{ $value->name }}</a></h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="col-sm-1 col-md-1 quantity-item" style="text-align: center">
                                                    <p>{{ $value->total_quantity }}</p>
                                                </td>
                                                <td class="col-sm-1 col-md-1 text-center"><strong>RM{{ $value->price }}</strong></td>
                                                <td class="col-sm-1 col-md-1 text-center"><strong>RM{{ $value->total_price }}</strong></td>
                                                <td hidden="">
                                                    <button type="button" class="btn btn-danger remove-item">
                                                        <i class="glyphicon glyphicon-trash"></i>Remove
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                   <div class="row" id="form-field">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <p><span id="form-title"> Shipping & Billing</span></p>
                                                <div class="form-group col-md-12">
                                                   <label class="control-label"> Shiping To </label>
                                                    <div class="" id="">
                                                        <a href="#" style="font-size: 15px;" {{ $returnData['address']['btnstatus'] }}><i class="pull-right fa fa-edit"></i></a>
                                                        <p>{!! $returnData['address']['name'] !!}</p>   
                                                        <p>{!! $returnData['address']['address'] !!}</p>
                                                        <input type="hidden" id="shipping-code" value="{{ $returnData['address']['code'] }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label"> Billing To </label>
                                                    <div class="" id="">
                                                        <a href="#" style="font-size: 15px;" {{ $returnData['address']['btnstatus'] }}><i class="pull-right fa fa-edit"></i></a> 
                                                        <p>{!! $returnData['address']['name'] !!}</p>   
                                                        <p>{!! $returnData['address']['address'] !!}</p>
                                                        <input type="hidden" id="billing-code" value="{{ $returnData['address']['code'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="col-md-12">
                                        <tbody>
                                            <tr>
                                                <td><h4>Shipping Fee</h4></td>
                                                <td><h4>RM{{ $returnData['shippingPrice'] }}</h4></td>
                                            </tr>
                                            <tr>
                                                <td><h3>Grand Total</h3></td>
                                                <td><h3>RM{{ $returnData['grandTotalPrice'] }}</h3></td>
                                            </tr>
                                            <tr>
                                                <td hidden="">
                                                    <button type="button" class="btn btn-default continue-shopping">
                                                        Continue Shopping <i class="glyphicon glyphicon-shopping-cart"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success place-order-item">
                                                        Place order <i class="glyphicon glyphicon-ok"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $('.place-order-item').click(function(){

        var agent_id = "{{ $returnData['agent_id'] }}";
        var shiping_code = $('#shipping-code').val();
        var billing_code = $('#billing-code').val();
        var total_price = "{{ $returnData['grandTotalPrice'] }}";
        var shipping_fee = "{{ $returnData['shippingPrice'] }}";

        console.log(agent_id,shiping_code, billing_code,total_price,shipping_fee);

         var data = {

            _token : "{!! csrf_token() !!}",
            agent_id   :  agent_id,
            shiping_code : shiping_code,
            billing_code : billing_code,
            total_price : total_price,
            shipping_fee : shipping_fee
        };

        $.ajax({

            url : "/agent/procced_to_payment",
            dataType : "json",
            type : "POST",
            data: JSON.stringify(data),
            contentType : "application/json"

        }).done(function(response){

            if(response.return.status == "01"){
                // document.location.reload();

            }

            console.log(response)

        }).fail(function(){

        });

    });

</script>

@endsection