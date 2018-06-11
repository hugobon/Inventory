@extends('header')
@include('Agent.js.agent_control')
@include('Agent.css.agent_css')
@include('Agent.modal_dialog')
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
                                    <table class="table table-actions table-order-item" id="item-table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-5">Product</th>
                                                <th class="col-md-2">Quantity</th>
                                                <th class="col-md-2">Unit Price</th>
                                                <th class="col-md-2">Total</th>
                                                <th hidden=""><input type="hidden" id="agent_id" value="{{ $returnData['agent_id'] }}"></th>
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
                                                <td class="col-md-2 quantity-item" style="text-align: center">
                                                    <p>{{ $value['total_quantity'] }}</p>
                                                </td>
                                                <td class="col-sm-1 col-md-1"><strong>RM{{ $value['price'] }}</strong></td>
                                                <td class="col-sm-1 col-md-1"><strong>RM{{ $value['total_price'] }}</strong></td>
                                                <td hidden="">
                                                    <button type="button" class="btn btn-danger remove-item">
                                                        <i class="glyphicon glyphicon-trash"></i>Remove
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4" class="active" align="center">No Item</td>
                                            </tr>
                                            @endif
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
                                                        <a href="javascript:;" style="font-size: 15px;" {{ $returnData['address']['btnstatus'] }} class="editbutton"
                                                        data-code="shipping" title="Edit Address"><i class="pull-right fa fa-edit"></i></a>
                                                        <input type="hidden" class="shipping-id" value="{{ $returnData['address']['id'] }}">
                                                        <input type="hidden" class="shipping-code" value="{{ $returnData['address']['code'] }}">
                                                        <p class="shipping-name">{!! $returnData['address']['name'] !!}</p>   
                                                        <p class="shipping-address">{!! $returnData['address']['address'] !!}</p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label"> Billing To </label>
                                                    <div class="" id="">
                                                        <a href="javascript:;" style="font-size: 15px;" {{ $returnData['address']['btnstatus'] }} class="editbutton"
                                                        data-code="billing" title="Edit Address"><i class="pull-right fa fa-edit"></i></a>
                                                        <input type="hidden" class="billing-id" value="{{ $returnData['address']['id'] }}">
                                                        <input type="hidden" class="billing-code" value="{{ $returnData['address']['code'] }}">
                                                        <p class="billing-name">{!! $returnData['address']['name'] !!}</p>   
                                                        <p class="billing-address">{!! $returnData['address']['address'] !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="col-md-12">
                                        <tbody>
                                            <tr>
                                                <td><h5>Shipping Fee</h5></td>
                                                <td><h5>RM{{ $returnData['shippingPrice'] }}</h5></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Total Price</h5></td>
                                                <td><h5>RM{{ $returnData['totalPrice'] }}</h5></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><hr></td>
                                            </tr>
                                            <tr>
                                                <td><h4>Grand Total</h4></td>
                                                <td><h4>RM{{ $returnData['grandTotalPrice'] }}</h4></td>
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


<!-- Modal -->
<div class="modal fade" id="ModalAddress" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Address</h4>
                <div>
                    <a href="javascript:;" class="btn btn-default  btn-sm btn-circle createButton" title="Add New Address" id="createButton">
                        <i class="fa fa-plus"></i> Create New 
                    </a>
                    <a href="javascript:;" class="btn btn-default  btn-sm btn-circle billings-same" title="Add New Address" id="createButton">
                        <i class=""></i> Billing to same address 
                    </a>
                </div>
            </div>
            <div class="modal-body address-content">
                <div class="panel-body"> 
                    <div class="row address-row" id="form-field">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="position: relative;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var gv_address = [];
    var gv_type = "";
    var agent_id = "{{ $returnData['agent_id'] }}";

    $(document).ready(function(){

        $(window).resize(function() {
            /* Same as before */ 
        }).resize();

    $(".createButton").click(function(){

        $("#CreateAddress").modal();
        $('#ModalAddress .close').click();

    });

    $(".editbutton").click(function(){

        // var agent_id = "{{ $returnData['agent_id'] }}";

        gv_type = "";
        gv_type = $(this).data('code');

        if(gv_type == "shipping"){
            $('a.billings-same').hide();
        }
        else if(gv_type == "billing"){
            $('.billings-same').show();
        }

        fn_get_address(agent_id);
        // var data = {
        //     _token : "{!! csrf_token() !!}",
        //     agent_id : agent_id
        // };

        // $.ajax({

        //     url : "/agent/get_address",
        //     dataType : "json",
        //     type : "GET",
        //     data: data,
        //     contentType : "application/json"

        // }).done(function(response,jqXHR, textStatus){
        //     // console.log(response)
        //     gv_address = response.address;
        //     if(response.return.status == "01"){
        //         var tag = "";
        //         for(var i=0;i<response.address.length;i++){

        //             tag += "<div class='address-field'>";
        //             tag += "<p>"+(i+1)+"#</p>";
        //             tag += "<input type='hidden' class='address-id' value="+ response.address[i].id +">";
        //             tag += "<input type='hidden' class='address-code' value="+ response.address[i].address_code +">";
        //             tag += "<p class='name'>"+response.address[i].name+"</p>";
        //             tag += "<p class='address'>"+response.address[i].address+"</p>";
        //             tag += "</diV>";
                   
        //         }
        //          $('div.address-row').html(tag);
        //     }

        // }).fail(function(){

        // });

        setTimeout(function(){
            $("#ModalAddress").modal();
        },500);
        
    });


    $('.poscode').keyup(function() {
        var value = $(this).val();
        value = value.replace(/[^\d]/g, '');
        $(this).val(value);
    });
});
    
    $('.place-order-item').click(function(){

        var agent_id = "{{ $returnData['agent_id'] }}";
        var shipping_id = $('.shipping-id').val();
        var billing_id = $('.billing-id').val();
        var total_price = "{{ $returnData['grandTotalPrice'] }}";
        var shipping_fee = "{{ $returnData['shippingPrice'] }}";
        var delivery_type = "{{ $returnData['deliveryType'] }}";

        console.log(agent_id,shipping_id, billing_id,total_price,shipping_fee);

         var data = {

            _token : "{!! csrf_token() !!}",
            agent_id   :  agent_id,
            shipping_id : shipping_id,
            billing_id : billing_id,
            total_price : total_price,
            shipping_fee : shipping_fee,
            delivery_type : delivery_type
        };

        $.ajax({

            url : "/agent/procced_to_payment",
            dataType : "json",
            type : "POST",
            data: JSON.stringify(data),
            contentType : "application/json"

        }).done(function(response){
            console.log(response)
            if(response.return.status == "01"){
                // document.location.reload();
                window.location.href = "{{ url('agent/get_delivery_status') }}"+"/"+response.order_no['data'];

            }

            console.log(response)

        }).fail(function(){

        });

    });

    // $('.address-field').click(function(event){

    //     event.StopPropagation();
    //     event.StopImmediatePropagation();

    //     console.log("X");
    //     console.log($(this).find('.address-id').val())
    //     console.log($(this).find('.address-code').val())
    // });

    // function fn_select_address(x){

    //     console.log(x);
    //     console.log($(this).find('.address-id').val())
    //     console.log($(this).find('.address-code').val())
    // }

    $(document).on('click', '.address-field', function(){

        console.log($(this).find('.address-id').val())
        console.log($(this).find('.address-code').val())


        var address_id = $(this).find('.address-id').val();
        var address_code = $(this).find('.address-code').val();

        for(var i=0;i<gv_address.length;i++){
            if(gv_address[i].id == address_id && gv_address[i].address_code == address_code){

                if(gv_type == "shipping"){

                    $('.shipping-id').val(gv_address[i].id);
                    $('.shipping-code').val(gv_address[i].address_code);
                    $('.shipping-name').text(gv_address[i].name)
                    $('.shipping-address').text(gv_address[i].address)
                }
                else if(gv_type == "billing"){

                    $('.billing-id').val(gv_address[i].id);
                    $('.billing-code').val(gv_address[i].address_code);
                    $('.billing-name').text(gv_address[i].name)
                    $('.billing-address').text(gv_address[i].address)
                }
                break;
            }
        }

        $('#ModalAddress .close').click();
    });

    $('.save-address').click(function(){
    
        var id = $('#id').val();
        var address_code = $('#address-code').val();
        var name = $('#name').val();
        var street1 = $('#street1').val();
        var street2 = $('#street2').val();
        var poscode = $('#poscode').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var country = $('#country').val();

        var item = {

            id          : id,
            address_code: address_code,
            name        : name,
            street1     : street1,
            street2     : street2,
            poscode     : poscode,
            city        : city,
            state       : state,
            country     : country 

        };

        var data = {

            _token  : "{!! csrf_token() !!}",
            item    : item
        };

        $.ajax({

            url     : "/agent/save_address",
            type    : "POST",
            data    : JSON.stringify(data),
            dataType: "json",
            contentType: "application/json",

        }).done(function(response){

            if(response.return.status == "01"){

                fn_get_address(agent_id);
                // window.location.reload();
            }

        }).fail(function(){

        });

        $('#CreateAddress .close').click();
        setTimeout(function(){
            $("#ModalAddress").modal();
        },1500);
        
        
    });


    $('.billings-same').click(function(){

        var shipping_id = $('.shipping-id').val();
        var shipping_code = $('.shipping-code').val();

        for(var i=0;i<gv_address.length;i++){

            if(gv_address[i].id == shipping_id && gv_address[i].address_code == shipping_code){

                $('.billing-id').val(gv_address[i].id);
                $('.billing-code').val(gv_address[i].address_code);
                $('.billing-name').text(gv_address[i].name);
                $('.billing-address').text(gv_address[i].address);

                break;
            }
        }

         $('#ModalAddress .close').click();
    });


    function fn_get_address(agent_id){

        var data = {
            _token : "{!! csrf_token() !!}",
            agent_id : agent_id
        };

        $.ajax({

            url : "/agent/get_address",
            dataType : "json",
            type : "GET",
            data: data,
            contentType : "application/json"

        }).done(function(response,jqXHR, textStatus){
            // console.log(response)
            gv_address = response.address;
            if(response.return.status == "01"){
                var tag = "";
                for(var i=0;i<response.address.length;i++){

                    tag += "<div class='address-field'>";
                    tag += "<p>"+(i+1)+"#</p>";
                    tag += "<input type='hidden' class='address-id' value="+ response.address[i].id +">";
                    tag += "<input type='hidden' class='address-code' value="+ response.address[i].address_code +">";
                    tag += "<p class='name'>"+response.address[i].name+"</p>";
                    tag += "<p class='address'>"+response.address[i].address+"</p>";
                    tag += "</diV>";
                   
                }
                $('div.address-row').html(tag);
            }

        }).fail(function(){

        });
    }

</script>

@endsection