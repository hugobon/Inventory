@extends('header')
@section('title','Product Promotion Listing')

@section('content')
<style>
	select{cursor:pointer;}
	.mask_number{max-width:150px;}
	.required{ color: #ff0000;}
	.bold{ font-weight: bold;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('product/promotion/listing') }}">Product Promotion</a></li>
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
					<h3 class="panel-title">Product Promotion Listing</h3>
					<div class="actions pull-right">
						<a href="{{ url('product/promotion/form') }}" class="btn btn-default  btn-sm btn-circle add-promotion" title="Add New Product Promotion" >
					<i class="fa fa-plus"></i> Product Promotion </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<form id="form_search" class="form-horizontal" method="POST" action="{{ url('product/promotion/form_search') }}" >
						{{ csrf_field() }}
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label"> Product </label>
										<div class="col-md-9">        
											<select class="form-control search-product" name="search_product" >
												<option value=""> All </option>
												@if(count($productArr) > 0)
													@foreach($productArr as $productid => $productname)
														<option value="{{ $productid }}" {{ isset($search_product) && $search_product == $productid ? "selected" : "" }}>
														{{ $productname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-md-3 control-label"> Status </label>
										<div class="col-md-9">        
											<select class="form-control search-status" name="search_status" >
												<option value=""> All </option>
												<option value="1" {{ isset($search_status) && $search_status == 1 ? "selected" : "" }}> ON </option>
												<option value="0" {{ isset($search_status) && $search_status == 0 ? "selected" : "" }}> OFF </option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
								<div class="col-md-1">
									<a href="{{ url('product/promotion/listing') }}" class="btn btn-danger">Reset</a>
								</div>
							</div>
						</div>
					</form>
					<div class="panel-body">
					&nbsp; Total Product Promotion: <b>{{ $countpromotion }}</b>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions">
							<thead>
								<tr>
									<th ></th>
									<th >Id</th>
									<th class="col-md-4">Product</th>
									<th class="col-md-3">Date Range</th>
									<th class="col-md-4">description</th>
									<th class="col-md-1">Status</th>
									<th ></th>
									<th ></th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
							@if(count($promotionArr) > 0)
								
								@foreach($promotionArr->all() as $key => $row)
									<?php
										$fullrow = (isset($productArr[$row->product_id]) ? $productArr[$row->product_id] : '').', '.(isset($adjustmentArr[$row->adjustment_id]) ? $adjustmentArr[$row->adjustment_id] : '');
										$rowarr = array('delete' => 'stockadjustment','deleteid' => $row->id,'fullrow'=>$fullrow,'search' => Request::segment(4));
										$base64data = trim(base64_encode(serialize($rowarr)), "=.");
									?>
									<tr>
										<td>{{ $key + $promotionArr->firstItem() }}</td>
										<td>{{ $row->id }}</td>
										<td>{{ isset($productArr[$row->product_id]) ? $productArr[$row->product_id] : $row->product_name }}</td>
										<td>{{ isset($statusArr[$row->adjustment_id]) ? $statusArr[$row->adjustment_id] : '' }}</td>
										<td>{{ $row->quantity }}</td>
										<td>{{ !in_array($row->created_at, array('0000-00-00','','null')) ? date('d/m/Y, h:i A', strtotime($row->created_at)) : '' }}</td>
										<td>
											<a href="javascript:;" 
											data-product="{{ isset($productArr[$row->product_id]) ? $productArr[$row->product_id] : $row->product_name }}" 
											data-adjustment=" {{ isset($adjustmentArr[$row->adjustment_id]) ? $adjustmentArr[$row->adjustment_id] : '' }}"
											data-quantity="{{ $row->quantity }}" data-remarks=" {{ $row->remarks }}" 
											data-create_at="{{ !in_array($row->created_at, array('0000-00-00','','null')) ? date('d/m/Y, h:i A', strtotime($row->created_at)) : '' }}"
											title=" View {{ $fullrow }}"
											class="btn btn-info btn-rounded viewstockadjustment"><span class="fa fa-eye"></span></a>
										</td>
										<td>
											<a href="javascript:;" data-base64="{{ $base64data }}" 
											data-product="{{ isset($productArr[$row->product_id]) ? $productArr[$row->product_id] : $row->product_name }}" 
											data-adjustment=" {{ isset($adjustmentArr[$row->adjustment_id]) ? $adjustmentArr[$row->adjustment_id] : '' }}"
											title=" Remove {{ $fullrow }}"
											class="btn btn-danger btn-rounded confirm-delete" ><span class="glyphicon glyphicon-trash"></span></a>
										</td>
									</tr>
								@endforeach
							@else
							<tr>
								<td colspan="9" class="text-center"> No Data Found <br />
								<a href="{{ url('product/promotion/form') }}" class="add-promotion" ><span class="fa fa-plus"></span> Add new Product Promotion</a></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $promotionArr->links() }}
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
		var product = $(this).data('product');
		var adjustment = $(this).data('adjustment');
		noty({
			text: 'Are you sure to remove <br /> ' + product + ',<br /> ' + adjustment + ' ?',
			layout: 'topRight',
			buttons: [
					{addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
						$noty.close();
						window.location.href = "{{ url('product/promotion/delete') }}/" + base64data;
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