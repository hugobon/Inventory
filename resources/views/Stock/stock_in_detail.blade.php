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
                                <div class="panel-body">
                                <div class="table-responsive">
                                        <table class="table table-hover table-bordered" >
                                                <thead>
                                                        <tr>
                                                           <td>Products</td>
                                                           <td>Supplier                                                            
                                                           <td>Total</td>
                                                           <td>Barcode</td>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach($stocks as $stock)
                                                        <tr>
                                                            
                                                            <td>{{$stock->supplier_id}}</td>
                                                            <td>{{$stock->company_name}}</td>
                                                            <td>{{$stock->supplier_id}}</td>
                                                            <td>{{$stock->supplier_id}}</td>
                                                            
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