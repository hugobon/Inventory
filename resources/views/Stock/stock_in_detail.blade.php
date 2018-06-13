@extends('header')
@section('title','Stock In Detail')

@section('content')
 <!-- START BREADCRUMB -->
<ul class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>                    
        <li><a href="{{ url('stock/report/balance') }}">Stock In Detail</a></li>
    </ul>
    <!-- END BREADCRUMB -->  
    
    
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
               
        <div class="row">
                <div class="col-md-12">
                        <div class="panel panel-default">
                                        <div class="panel-heading">
                                                        <div class="actions pull-right">
                                                                <a href="{{ url('stock/report/receive') }}" class="btn btn-default  btn-sm btn-circle" title="Stock In" >
                                                                        <i class="fa fa-list"></i> Stock In List</a>
                                                        </div>
                                                        <h4><strong>Stock In No:</strong>  {{ $stock_in_detail->stock_received_number }} </h4>
                                                        <h4><strong>Date:</strong>  {{ Carbon\Carbon::parse($stock_in_detail->in_stock_date)->format('d/m/Y') }} </h4>
                                                        <h4><strong>Description:</strong>  {{ $stock_in_detail->description }} </h4>
                                        </div>
                                <div class="panel-body">
                                <div class="table-responsive">
                                        <table class="table table-hover table-bordered" >
                                                <thead>
                                                        <tr>
                                                           <td>Products</td>                                                                                              
                                                           <td>Barcode</td>
                                                           <td>Total</td>
                                                           <td>Supplier</td> 
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach($stocks as $stock)
                                                        <tr>
                                                            
                                                            <td>{{$stock->name}}</td>
                                                            <td>{{$stock->serial_number}}</td>
                                                            <td>{{$stock->supplier_id}}</td>                                                            
                                                            <td>{{$stock->company_name}}</td>
                                                            
                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
    

</div>
@endsection
@section('script')
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="{!! asset('joli/js/daterangepicker/moment.min.js') !!}" ></script> 
<script type="text/javascript" src="{!! asset('joli/js/daterangepicker/daterangepicker.js') !!}" ></script>

@endsection