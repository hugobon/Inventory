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
                                <div class="col-sm-12 col-md-10 col-md-offset-1">
                                    <table class="table table-hover table-cart-item">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Total</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $key => $value)
                                            <tr class="row-cart-item">
                                                <td class="col-sm-8 col-md-4 column-cart-item">
                                                <div class="media cart-content">
                                                    <input type="hidden" id="id" value="{{ $value->id }}">
                                                    <a class="thumbnail pull-left img-content" href="#"> <img class="media-object" src="{{ asset('FotoJet.jpg') }}" style="width: 72px; height: 72px;"> </a>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><a href="#">{{ $value->description }}</a></h4>
                                                        <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                                                    </div>
                                                </div></td>
                                                <td class="col-sm-1 col-md-1" style="text-align: center">
                                                <input type="email" class="form-control quantity" value="{{ $value->total_quantity }}">
                                                </td>
                                                <td class="col-sm-1 col-md-1 text-center"><strong>RM {{ $value->price }}</strong></td>
                                                <td class="col-sm-1 col-md-1 text-center"><strong>RM {{ $value->total_price }}</strong></td>
                                                <td class="col-sm-1 col-md-1">
                                                <button type="button" class="btn btn-danger remove-item">
                                                    <i class="glyphicon glyphicon-trash"></i>Remove
                                                </button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>   </td>
                                                <td>   </td>
                                                <td>   </td>
                                                <td><h5>Subtotal<br>Estimated shipping</h5><h3>Total</h3></td>
                                                <td class="text-right"><h5><strong>$24.59<br>$6.94</strong></h5><h3>$31.53</h3></td>
                                            </tr>
                                            <tr>
                                                <td>   </td>
                                                <td>   </td>
                                                <td>   </td>
                                                <td>
                                                <button type="button" class="btn btn-default">
                                                    <i class="glyphicon glyphicon-shopping-cart"></i> Continue Shopping
                                                </button></td>
                                                <td>
                                                <button type="button" class="btn btn-success">
                                                    Checkout <i class="glyphicon glyphicon-ok"></i>
                                                </button></td>
                                            </tr>
                                        </tfoot>
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

        console.log($(this).closest('.row-cart-item').find('input#id').val())
        
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

        // var item = {
        //     id : id
        // };

        var data = {

            _token : "{!! csrf_token() !!}",
            item   :  id
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

</script>
@endsection