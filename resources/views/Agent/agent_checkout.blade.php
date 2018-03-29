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
                                                <th><input type="hidden" id="agent_id" value="{{ $returnData['agent_id'] }}"></th>
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
                                                    <input type="text" class="form-control quantity" id="quantity" value="{{ $value->total_quantity }}">
                                                </td>
                                                <td class="col-sm-1 col-md-1 text-center"><strong>RM{{ $value->price }}</strong></td>
                                                <td class="col-sm-1 col-md-1 text-center"><strong>RM{{ $value->total_price }}</strong></td>
                                                <td class="col-sm-1 col-md-1">
                                                    <button type="button" class="btn btn-danger remove-item">
                                                        <i class="glyphicon glyphicon-trash"></i>Remove
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 col-md-4">
                                   <div class="row" id="form-field">
                                        <div class="col-md-12">
                                            <div class="col-md-8">
                                                <p><span id="form-title"> Delivery Type </span></p>
                                                <div class="form-group">
                                                    <div class="col-md-12" id="">        
                                                        <select class="form-control delivery-type">
                                                            @foreach($deliveryType as $key => $value)
                                                            <option data-code="{{ $value->id }}" value="{{ $value->code }}" >{{ $value->description }}</option>
                                                            @endforeach
                                                        </select>
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
                                                <td>
                                                    <button type="button" class="btn btn-default continue-shopping">
                                                        Continue Shopping <i class="glyphicon glyphicon-shopping-cart"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success checkout-item">
                                                        Checkout <i class="glyphicon glyphicon-ok"></i>
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
    
    $('.remove-item').on('click', function () {

        // console.log($(this).closest('.row-cart-item').find('input#id').val())
        
        var id = $(this).closest('.row-cart-item').find('input#id').val();

        // var item = {
        //     id : id
        // };

        var data = {

            _token : "{!! csrf_token() !!}",
            item   :  id
        };

        $.ajax({

            url : "/agent/delete_cart_item",
            dataType : "json",
            type : "POST",
            data: JSON.stringify(data),
            contentType : "application/json"

        }).done(function(response){

            if(response.return.status == "01"){
                document.location.reload();
            }

            console.log(response)

        }).fail(function(){


        });
    });

    $('.quantity').change(function(){

        var id = $(this).closest('.row-cart-item').find('input#id').val();
        var quantity = $(this).closest('.quantity-item').find('input#quantity').val();
        // console.log(quantity)
        // console.log($(this).closest('.quantity-item').find('.quantity').val())

        // var item = {

        //     id       : id,
        //     quantity : quantity
        // };

        var data = {

            _token : "{!! csrf_token() !!}",
            id   :  id,
            quantity : quantity
        };

        $.ajax({

            url : "/agent/update_quantity_item",
            dataType : "json",
            type : "POST",
            data: JSON.stringify(data),
            contentType : "application/json"

        }).done(function(response){

            if(response.return.status == "01"){
                document.location.reload();
            }

            console.log(response)

        }).fail(function(){

        });
    });

    $('.continue-shopping').click(function(){
        
        window.location.href = "{{ url('agent/get_product_list/all') }}";
    })

    $('.checkout-item').click(function(){
       
        var agent_id = $('#agent_id').val();
        var table_item = $('.table-cart-item').find('.row-cart-item');
        var delivery_type = $('.delivery-type').val();
        var delivery_id = $('.delivery-type').children('option').data('code');
        var cartItems = {!! $cartItems !!};
        console.log(cartItems)
        console.log(agent_id)
        console.log(delivery_id);

        // for(var i=0;i<table_item.length;i++){

        //     console.log(table_item.eq(i).find('input').eq(0).attr('value'));
        //     console.log(table_item.eq(i).find('input').eq(2).attr('value'));
        //     console.log(table_item.eq(i).find('strong').eq(0).html());
        //     console.log(table_item.eq(i).find('strong').eq(1).html());
        // }

        // var data = {

        //     _token : "{!! csrf_token() !!}",
        //     id   :  agent_id,
        //     delivery_type : delivery_type
        // };

        // $.ajax({

        //     url : "/agent/get_place_order_items",
        //     dataType : "json",
        //     type : "GET",
        //     data: JSON.stringify(data),
        //     contentType : "application/json"

        // }).done(function(response){

        //     if(response.return.status == "01"){
        //         // document.location.reload();

        //     }

        //     console.log(response)

        // }).fail(function(){

        // });

        window.location.href = "{{ url('agent/get_place_order_items') }}"+"/"+agent_id+"/"+delivery_type

    });

</script>
@endsection