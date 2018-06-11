@extends('header')
@section('title','Barcode Listing')
<style>
#table_listing{
    font-size: 1.2rem;
}
textarea {
   resize: none;
}
</style>
@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('stock/listing') }}">Barcode Listing</a></li>
</ul>
<!-- END BREADCRUMB -->   

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START RESPONSIVE TABLES -->
    <div class="row"><div class="col-sm-12">
 @if(session("message"))        
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                {{ session("message") }}
            </div>
        </div>
 @endif
 @if(session("errorid"))
     <div class="col-sm-12">
         <div class="alert alert-danger">
             <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
             {{ session("errorid") }}
         </div>
     </div>
 @endif
    </div>

    <div class="row">
            <div class="col-md-12">

                    <div class="panel panel-default">
                            <div class="panel-heading">
                            <h3 class="panel-title">Barcode Listing for <strong>{{$product_name['name']}}</strong></h3>
                            </div>
                            
                            <div class="panel-body">              
                                            <p>Total listing: <b>{{ count($data) }}</b></p>
                                        <div class="table-responsive">
                                            <table class="table table-striped datatable" id="table_listing">
                                                <thead>
                                                    <tr>
                                                        <th width="5px" class="no-sort">No.</th>                                                        
                                                        <th>Stock In Serial Number</th>
                                                        <th>Stock In Date</th>                  
                                                        <th>Barcode</th>                            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($data) > 0)
                                                    <?php $i = 1; ?>
                                                    @foreach($data as $stock)       
                                                                              
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>                                                            
                                                            <td>{{ $stock['stock_received_number'] }} </td>
                                                            <td data-order="{{ Carbon\Carbon::parse($stock['in_stock_date'])}}">{{ Carbon\Carbon::parse($stock['in_stock_date'])->format('d/m/Y') }} </td>
                                                            <td>{{ $stock['serial_number'] }} </td>
                                                           
                                                            
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
                    </div>
            </div>
    </div>



</div>
      <script type='text/javascript' src="{!! asset('joli/js/plugins/validationengine/jquery.validationEngine.js') !!}"></script>   
      <script>
            $(document).ready(function() {
                $.fn.dataTable.ext.errMode = 'none';
                var t = $('.datatable').DataTable({
                    "order": [],
                    "columnDefs": [
                                { targets: 'no-sort', orderable: false }
                                ]
                });
            })
               

    

        
        </script>
@endsection
