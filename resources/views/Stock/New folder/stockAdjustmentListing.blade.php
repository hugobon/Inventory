@extends('header')
@section('title','Stock Adjustment Listing')

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
	<li><a href="{{ url('stock/adjustment/listing') }}">Stock Adjustment</a></li>
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
					<h3 class="panel-title">Stock Adjustment Listing</h3>
					<div class="actions pull-right">
						<a href="javascript:;" class="btn btn-default  btn-sm btn-circle addstockadjustment" title="Add New Stock Adjustment" >
					<i class="fa fa-plus"></i> New Stock Adjustment </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<form id="form_search" class="form-horizontal" method="POST" action="{{ url('stock/adjustment/form_search') }}" >
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
										<label class="col-md-3 control-label"> Adjustment </label>
										<div class="col-md-9">        
											<select class="form-control search-adjustment" name="search_adjustment" >
												<option value=""> All </option>
												@if(count($adjustmentArr) > 0)
													@foreach($adjustmentArr as $adjustmentid => $adjustmentname)
														<option value="{{ $adjustmentid }}" {{ isset($search_adjustment) && $search_adjustment == $adjustmentid ? "selected" : "" }}>
														{{ $adjustmentname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
								<div class="col-md-1">
									<a href="{{ url('stock/adjustment/listing') }}" class="btn btn-danger">Reset</a>
								</div>
							</div>
						</div>
					</form>
					<div class="panel-body">
					&nbsp; Total Stock Adjustment: <b>{{ $countstockadjustment }}</b>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions">
							<thead>
								<tr>
									<th ></th>
									<th >Id</th>
									<th class="col-md-4">Product</th>
									<th class="col-md-3">Adjustment</th>
									<th class="col-md-1">Quantity</th>
									<th class="col-md-2">Created At</th>
									<th ></th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
							@if(count($stockadjustmentArr) > 0)
								
								@foreach($stockadjustmentArr->all() as $key => $row)
									<?php
										$fullrow = (isset($productArr[$row->product_id]) ? $productArr[$row->product_id] : '').', '.(isset($adjustmentArr[$row->adjustment_id]) ? $adjustmentArr[$row->adjustment_id] : '');
										$rowarr = array('delete' => 'stockadjustment','deleteid' => $row->id,'fullrow'=>$fullrow,'search' => Request::segment(4));
										$base64data = trim(base64_encode(serialize($rowarr)), "=.");
									?>
									<tr>
										<td>{{ $key + $stockadjustmentArr->firstItem() }}</td>
										<td>{{ $row->id }}</td>
										<td>{{ isset($productArr[$row->product_id]) ? $productArr[$row->product_id] : $row->product_name }}</td>
										<td>{{ isset($adjustmentArr[$row->adjustment_id]) ? $adjustmentArr[$row->adjustment_id] : '' }}</td>
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
								<td colspan="8" class="text-center"> No Data Found <br />
								<a href="javascript:;" class="addstockadjustment" ><span class="fa fa-plus"></span> Add new Stock Adjustment</a></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $stockadjustmentArr->links() }}
					</div>
				</div>
			</div>                                                

		</div>
	</div>
	<!-- END RESPONSIVE TABLES -->
	
	<!-- Modal -->
	<div class="modal fade" id="stockadjusmentModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Stock Adjustment Form</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<form id="submit_form" class="form-horizontal" method="POST" action="{{ url('stock/adjustment/submit') }}" >
								{{ csrf_field() }}
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Product <span class="required">*</span></label>
										<div class="col-md-9">        
											<select class="form-control form-product_id" name="product_id" >
												<option value=""> </option>
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
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Adjustment <span class="required">*</span></label>
										<div class="col-md-9">        
											<select class="form-control form-adjustment_id" name="adjustment_id" >
												<option value=""> </option>
												@if(count($adjustmentArr) > 0)
													@foreach($adjustmentArr as $adjustmentid => $adjustmentname)
														<option value="{{ $adjustmentid }}" {{ isset($search_adjustment) && $search_adjustment == $adjustmentid ? "selected" : "" }}>
														{{ $adjustmentname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Quantity <span class="required">*</span></label>
										<div class="col-md-9">        
											<input type="text" class="form-control mask_number form-quantity" name="quantity" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Add/Minus </label>
										<div class="col-md-9">        
										<select class="form-control form-adjustment_id" name="add_minus" >
												<option value="-">-</option>
												<option value="+">+</option>
										</select>
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Remarks </label>
										<div class="col-md-9">        
											<input type="text" class="form-control form-remarks" name="remarks" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"></label>
										<div class="col-md-9">        
											<button type="submit" class="btn btn-primary submit-button">Submit</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="viewModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Stock Adjustment View</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
						<div class="form-group">
						<input type="text" class="input_barcode col-md-4 bold text-right">
						<textarea name="" id="textarea_barcode" cols="30" rows="10" disabled class="col-md-8 product"></textarea>
						</div>
							<!-- <div class="form-group">
								<div class="col-md-4 bold text-right"> Product: </div>
								<div class="col-md-8 product"></div>
							</div> -->
						</div>
						<br /> &nbsp;
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4 bold text-right"> Adjustment: </div>
								<div class="col-md-8 adjustment"></div>
							</div>
						</div>
						<br /> &nbsp;
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4 bold text-right"> Quantity: </div>
								<div class="col-md-8 quantity"></div>
							</div>
						</div>
						<br /> &nbsp;
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4 bold text-right"> Remarks: </div>
								<div class="col-md-8 remarks"></div>
							</div>
						</div>
						<br /> &nbsp;
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-4 bold text-right"> Created At: </div>
								<div class="col-md-8 create_at"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- END PAGE CONTENT WRAPPER -->  
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/jquery.noty.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topCenter.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topLeft.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topRight.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/themes/default.js') !!}" ></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/jquery-validation/jquery.validate.js') !!}" ></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/inputmask/jquery.inputmask.bundle.min.js') !!}"></script>

<script>
var jvalidate = $("#submit_form").validate({
	errorPlacement: function(error,element) { return true;},
	ignore: [],
	rules: { product_id: { required: true,},adjustment_id: { required: true,},quantity: { required: true,}}
});
$(function() {
	$(".mask_number").inputmask({
		"mask": "9",
		"repeat": 10,
		'rightAlign': true,
		"greedy": false
	});
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
						window.location.href = "{{ url('stock/adjustment/delete') }}/" + base64data;
					}
					},
					{addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
						$noty.close();
						}
					}
				]
		})
	});
	
	$('body').on('click', '.addstockadjustment', function(){
		$('#stockadjusmentModal').modal('show');
	});

	$(".input_barcode").keyup(function(event) {
    if (event.keyCode === 13 || event.keyCode === 116) {
        var input = $('.input_barcode').val();
		$('#textarea_barcode').append(input+"\n");
		$('.input_barcode').val('');

		var barcode_val = $("#textarea_barcode").val() 
		var barcode_arr = barcode_val.split("\n")
		var temp = [];

		for(let i of barcode_arr)
			i && temp.push(i); // copy each non-empty value to the 'temp' array

		barcode_arr = temp;
		delete temp; 
		$('#barcode_scan_hidden').val(JSON.stringify(barcode_arr));
		
		$('#quantity').val(barcode_arr.length)
    } 
});
$('#barcode_list').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
	
	$('body').on('click', '.viewstockadjustment', function(){
		$('#viewModal').find('.product').html( $(this).data('product'));
		$('#viewModal').find('.adjustment').html( $(this).data('adjustment'));
		$('#viewModal').find('.quantity').html( $(this).data('quantity'));
		$('#viewModal').find('.remarks').html( $(this).data('remarks'));
		$('#viewModal').find('.create_at').html( $(this).data('create_at'));
		$('#viewModal').modal('show');
	});
});
</script>
@endsection