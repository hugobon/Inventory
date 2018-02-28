@extends('header')
@section('title','Stock Listing')

@section('content')
<style>
	select{cursor:pointer;}
</style>
<!-- START BREADCRUMB -->
{{--  <ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('product/listing') }}">Product Listing</a></li>
</ul>  --}}
<!-- END BREADCRUMB -->                       

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	 <!-- START RESPONSIVE TABLES -->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title">Stock Listing</h3>
				</div>
				<div class="panel-body panel-body-table">
                    <table id="stock">
                        <thead>
                            <tr>
                                <th>Supplier</th>
                                <th>Product</th>
                                <th>Barcode</th>
                                <th>In Stock Date</th>
                                <th>Stock Received</th>
                                <th>description</th>
                            </tr>                            
                        </thead>
                        <tbody>
                                @foreach($stocks as $stock)
                                <tr>
                                    <td>{{ $stock->stock_supplier }} </td>
                                    <td>{{ $stock->stock_product }} </td>
                                    <td>{{ $stock->barcode }} </td>
                                    <td>{{ $stock->in_stock_date }} </td>
                                    <td>{{ $stock->stock_received_number }}</td>
                                    <td>{{ $stock->description }} </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                    
				</div>
			</div>                                                

		</div>
	</div>
	<!-- END RESPONSIVE TABLES -->

</div>
<!-- END PAGE CONTENT WRAPPER -->  
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/jquery.noty.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topCenter.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topLeft.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topRight.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/themes/default.js') !!}" ></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    
<!-- END PAGE PLUGINS -->
<script type="text/javascript" >    
    $(document).ready(function(){
        $('#stock').DataTable();
    });
</script>

@endsection