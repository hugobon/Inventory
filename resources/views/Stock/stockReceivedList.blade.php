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
                        <div class="panel-body panel-body-table">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>Stock In Date</th>
                                            <th>Stock Received No</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($dataToReturn) > 0)
                                        @foreach($dataToReturn as $stockIn)
                                        <tr class='click' data-href='{{$stockIn->stock_received_number}}'>
                                            <td  data-order="{{ Carbon\Carbon::parse($stockIn->in_stock_date)}}">{{ Carbon\Carbon::parse($stockIn->in_stock_date)->format('d/m/Y') }}</td>
                                            <td> <a href="#"> {{$stockIn->stock_received_number}} </a> </td>
                                            <td>{{$stockIn->description}}</td>
                                            <td>{{$stockIn->amount}}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="9" class="text-center"> No Data Found <br />
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a href="{{ url('stock/barcode/all') }}" class="btn btn-primary pull-right">Show All Barcode</a>
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

    $(document).ready(function($) {
        var t = $('.datatable').DataTable({
                    "order": [],
                    "columnDefs": [
                                { targets: 'no-sort', orderable: false }
                                ]
                });

    $(".click").click(function() {
            window.location = $(this).data("href");
        });
    });
    
    function fn_clear(){
        console.log("clear!");
    }
    </script>
@endsection