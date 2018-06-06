@extends('header')
@include('Agent.js.agent_control')
@include('Agent.css.agent_css')
@section('title','Config')
@section('content')

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
                                        <thead class="">
                                            <tr>
                                                <th class="col-md-5">Product</th>
                                                <th class="col-md-3">Quantity</th>
                                                <th class="col-md-2">Unit Price</th>
                                                <th class="col-md-2">Total</th>
                                                <th class=""><input type="hidden" id="agent_id" value="{{ $returnData['agent_id'] }}"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="item-body">
                                            @if(count($cartItems) > 0)
                                            @foreach($cartItems as $key => $value)
                                            <tr class="row-cart-item">
                                                <td class="col-sm-8 col-md-4 column-cart-item">
                                                    <div class="media cart-content">
                                                        <input type="hidden" id="id" value="{{ $value['id'] }}">
                                                        <input type="hidden" id="produt_id" value="{{ $value['product_id'] }}">
                                                        <a class="thumbnail pull-left img-content" href="#"> <img class="media-object" src="{{ $value['image'] == '' ? asset('invalid_image.png') : asset('storage/'.$value['image']) }}" style="width: 72px; height: 72px;"> </a>
                                                        <div class="media-body">
                                                            <h4 class="media-heading"><a href="#">{{ $value['name'] }}</a></h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="col-sm-1 col-md-1 quantity-item" style="text-align: center">
                                                    <div class="input-group col-md-12 qty">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-secondary btn-minus" type="button">-</button>
                                                        </span>
                                                        <input type="text" class="form-control quantity" id="quantity" value="{{ $value['total_quantity'] }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-secondary btn-plus" type="button">+</button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="col-sm-1 col-md-1"><strong>WM RM{{ $value['price_wm'] }}<br>EM RM{{ $value['price_em'] }}</strong></td>
                                                <td class="col-sm-1 col-md-1 column-tot-price"><strong>WM RM{{ $value['total_price_wm'] }}<br>EM RM{{ $value['total_price_em'] }}</strong></td>
                                                <td class="col-sm-1 col-md-1">
                                                    <button type="button" class="btn btn-danger remove-item">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5" class="active" align="center">No Item</td>
                                            </tr>
                                            @endif
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
                                                            <option data-code="{{ $value['id'] }}" value="{{ $value['code'] }}" >{{ $value['description'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="col-md-12" id="total-price">
                                        <tbody>
                                            <tr id="row-shipping">
                                                <td><h5>Shipping Fee</h5></td>
                                                <td id="col-shipping"><h5>RM{{ $returnData['shippingPrice'] }}</h5></td>
                                            </tr>
                                            <tr id="row-total-price">
                                                <td><h5>Total Price</h5></td>
                                                <td id="col-total-price"><h5>WM RM{{ $returnData['totalPrice_wm'] }}<br>EM RM{{ $returnData['totalPrice_em'] }}</h5></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><hr></td>
                                            </tr>
                                            <tr id="row-grand-total">
                                                <td><h4>Grand Total</h4></td>
                                                <td id="col-grand-total"><h4>WM RM{{ $returnData['grandTotalPrice_wm'] }}<br>EM RM{{ $returnData['grandTotalPrice_em'] }}</h4></td>
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

    $(".btn-minus").on("click",function(){
        console.log($(this).closest('.qty').find('input.quantity').val())
        var now = $(this).closest('.qty').find('input.quantity').val();
        var productid = $(this).closest('.row-cart-item').children('.column-cart-item').children('.cart-content').find('input#produt_id').val();
        console.log(productid)

        if ($.isNumeric(now)){
            if (parseInt(now) -1 > 0){ now--;}
            $(this).closest('.qty').find('input.quantity').val(now);
            fn_calculate_order($(this).closest('.row-cart-item'),now,productid);
        }else{
            $(this).closest('.qty').find('input.quantity').val("1");
        }
    });
    $(".btn-plus").on("click",function(){
        // console.log($(this).closest('.qty').find('input.quantity').val())
        var now = $(this).closest('.qty').find('input.quantity').val();
        var max = $(this).closest('.qty').find('input.quantity').attr('max');
        var productid = $(this).closest('.row-cart-item').children('.column-cart-item').children('.cart-content').find('input#produt_id').val();
        console.log(productid)

        if(now == max){
             $(this).closest('.qty').find('input.quantity').val(max);
        }
        else{
            if ($.isNumeric(now)){
                now = parseInt(now)+1;
                $(this).closest('.qty').find('input.quantity').val(parseInt(now));
                fn_calculate_order($(this).closest('.row-cart-item'),now,productid);
            }else{
                $(this).closest('.qty').find('input.quantity').val("1");
            }
        }
    });

    function fn_calculate_order(table,quantity,productid){

        var cartItems = {!! json_encode($cartItems) !!};
        var newTotal_wm = 0.00;
        var newTotal_em = 0.00;
        for(var i=0;i<cartItems.length;i++){
            if(cartItems[i].product_id == productid){

                newTotal_wm = parseFloat(cartItems[i].price_wm) * parseFloat(quantity);
                newTotal_em = parseFloat(cartItems[i].price_em) * parseFloat(quantity);
                newTotal_wm = newTotal_wm.toFixed(2);
                newTotal_em = newTotal_em.toFixed(2);
                quantity = quantity.toString();
                cartItems[i].total_price_wm = newTotal_wm;
                cartItems[i].total_price_em = newTotal_em;
                cartItems[i].total_quantity = quantity;
                newTotal_wm = newTotal_wm.replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                newTotal_em = newTotal_em.replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                break;
            }
        }

        // console.log(table.children('.column-tot-price'),cartItems)
        table.children('.column-tot-price').html('<strong>WM RM'+newTotal_wm+'<br>EM RM'+newTotal_em+'</strong>');

        var newTotal_price_wm = 0.00;
        var newTotal_price_em = 0.00;
        console.log(cartItems)
        for(var i=0;i<cartItems.length;i++){

            newTotal_price_wm = newTotal_price_wm + parseFloat(cartItems[i].total_price_wm.replace(",",""));
            newTotal_price_em = newTotal_price_em + parseFloat(cartItems[i].total_price_em.replace(",",""));
        }

        newTotal_price_wm = newTotal_price_wm.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        newTotal_price_em = newTotal_price_em.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

        console.log($('#total-price').children('tbody').children('tr#row-total-price').children('td#col-total-price').html('<h5>WM RM'+newTotal_price_wm+'<br>EM RM'+newTotal_price_em+'</h5>'))
        console.log($('#total-price').children('tbody').children('tr#row-grand-total').children('td#col-grand-total').html('<h4>WM RM'+newTotal_price_wm+'<br>EM RM'+newTotal_price_em+'</h4>'))
    }
    
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

    // $('.qty').find('.quantity').change(function(){
    // $('.qty').children('input.quantity, select').each(function() {
    //     $(this).change(function() {
    //         console.log('fuck')
    //         var id = $(this).closest('.row-cart-item').find('input#id').val();
    //         var quantity = $(this).closest('.quantity-item').find('.qty').find('input.quantity').val();
    //         console.log(quantity)
    //         // console.log($(this).closest('.quantity-item').find('.quantity').val())

    //         var data = {

    //             _token : "{!! csrf_token() !!}",
    //             id   :  id,
    //             quantity : quantity
    //         };

    //         $.ajax({

    //             url : "/agent/update_quantity_item",
    //             dataType : "json",
    //             type : "POST",
    //             data: JSON.stringify(data),
    //             contentType : "application/json"

    //         }).done(function(response){

    //             if(response.return.status == "01"){
    //                 // document.location.reload();
    //             }

    //             console.log(response)

    //         }).fail(function(){

    //         });
    //     });
    // });

    $('.continue-shopping').click(function(){
        
        window.location.href = "{{ url('agent/get_product_list/all') }}";
    })

    $('.checkout-item').click(function(){
       
        var agent_id = $('#agent_id').val();
        var table_item = $('.table-cart-item').find('.row-cart-item');
        var delivery_type = $('.delivery-type').val();
        var delivery_id = $('.delivery-type').children('option').data('code');

        // window.location.href = "{{ url('agent/get_place_order_items') }}"+"/"+agent_id+"/"+delivery_type;

        console.log($(this).closest('.cart-row').children('.table-cart-item'))
        console.log(table_item)

        var lv_data = [];
        for(var i=0;i<table_item.length;i++){

            var product_id = table_item.eq(i).find('td.column-cart-item').find('.cart-content').children('input').eq(1).val();
            var quantity = table_item.eq(i).find('td.quantity-item').find('.qty').children('input').val();

            lv_data.push({

                product_id : product_id,
                quantity : quantity
            });
        }

        fn_update_quantity(lv_data,agent_id,function(status){

            if(status == "01"){
                window.location.href = "{{ url('agent/get_place_order_items') }}"+"/"+agent_id+"/"+delivery_type
            }
        });

    });

    function fn_update_quantity(quantity,id,callback){

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

            // if(response.return.status == "01"){
            //     // document.location.reload();
            // }
            callback(response.return.status);

            console.log(response)

        }).fail(function(){

        });
    }

</script>
@endsection