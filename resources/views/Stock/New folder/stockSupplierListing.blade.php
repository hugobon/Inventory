@extends('header')
@section('title','Current Stock Listing')

@section('content')
<style>
	select{cursor:pointer;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('stock/current') }}">Current Stock Listing</a></li>
</ul>
<!-- END BREADCRUMB -->                       

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	 <!-- START RESPONSIVE TABLES -->
	@if(session("info"))
		<div class="row"><div class="col-sm-12">
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				{{ session("info") }}
			</div>
		</div></div>
	@endif
	@if(session("errorid"))
		<div class="row"><div class="col-sm-12">
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				{{ session("errorid") }}
			</div>
		</div></div>
	@endif
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title">Current Stock Listing</h3>
					<div class="actions pull-right">
						<a href="{{ url('stock/adjustment') }}" class="btn btn-default  btn-sm btn-circle" title="Adjust Stock" >
							<i class="fa fa-plus"></i> Stock Adjustment </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<form id="form_search" class="form-horizontal" method="POST" action="#" >
						{{ csrf_field() }}
						<div class="panel-body">
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label class="col-md-4 control-label"> Search </label>
										<div class="col-md-8">        
											<input type="text" class="form-control product-code" name="search" 
											placeholder=" Code / Description " value="{{ isset($search) ? $search : '' }}" />									
										</div>
									</div>
								</div>
								<!-- <div class="col-md-5">
									<div class="form-group">
										<label class="col-md-4 control-label"> Type </label>
										<div class="col-md-8">        
											<select class="form-control product-type" name="type" >
												<option value=""> All </option>
												<option value="1" {{ isset($type) && $type == 1 ? "selected" : "" }}> By Item </option>
												<option value="2" {{ isset($type) && $type == 2 ? "selected" : "" }}> Package </option>
												<option value="3" {{ isset($type) && $type == 3 ? "selected" : "" }}> Monthly Promotion </option>
											</select>
										</div>
									</div>
								</div> -->
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
								<div class="col-md-1">
									<a href="{{ url('stock/current') }}" class="btn btn-danger">Reset</a>
								</div>
							</div>
						</div>
					</form>
					<div class="panel-body">
					&nbsp; Total Stocks list: <b>{{ count($stocks) }}</b>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions">
							<thead>
								<tr>
                                    <th></th>
                                    <!-- <th>Supplier</th> -->
                                    <th>Product Name</th>
                                    <th>Stock left</th>
                                    <!-- <th>In Stock Date</th>
                                    <th>Stock Received</th>
                                    <th>Stock Description</th> -->
                                    <th></th>
                                    <!-- <th></th>
                                    <th></th> -->
								</tr>
							</thead>
							<tbody>
							@if(count($stocks) > 0)
                                <?php $i = 1;
                                ?>
								@foreach($stocks as $stock)
                               
									<tr>
										<td><?php echo $i++; ?></td>
										<td>{{ $stock->product_description }} </td>
										<td>{{ $stock->stocksCount }} </td>
<!--                                        
                                        <td><a href="#" class="btn">To Barcode list page{{ $stock->barcode }}</a> </td>
                                        <td>{{ $stock->in_stock_date }} </td>
                                        <td>{{ $stock->stock_received_number }}</td>
                                        <td>{{ $stock->description }} </td> -->
										<td>
											<a href="#" 
											class="btn btn-info btn-rounded"><span class="fa fa-eye"></span></a>
										</td>
										<!-- <td>
											<a href="#" 
											class="btn btn-primary btn-rounded" ><span class="fa fa-edit"></span></a>
										</td>
										<td>
											<a href="#" 									
											class="btn btn-danger btn-rounded confirm-delete" ><span class="glyphicon glyphicon-trash"></span></a>
										</td> -->
									</tr>
								@endforeach
							@else
							<tr>
								<td colspan="9" class="text-center"> No Data Found <br />
								<a href="{{ url('stock/in') }}"><span class="fa fa-plus"></span> Add new stock</a></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					{{-- $productArr->links() --}}
					</div>
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

<script>
$(function() {
	$('.table').on('click', '.confirm-delete', function(){
		var base64data = $(this).data('base64');
		var code = $(this).data('code');
		var description = $(this).data('description');
		noty({
			text: 'Are you sure to remove <br /> ' + code + ' ( ' + description + ' ) ?',
			layout: 'topRight',
			buttons: [
					{addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
						$noty.close();
						window.location.href = "{{ url('product/delete') }}/" + base64data;
					}
					},
					{addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
						$noty.close();
						}
					}
				]
		})
	});
});
</script>
@endsection