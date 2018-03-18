@extends('header')
<style>
textarea {
   resize: none;
}

</style>
@section('title','Stock Adjustment')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="#">Supplier</a></li>
    <li class="active">Stock In</li>
</ul>
<!-- END BREADCRUMB -->     

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
		<div class="row">
				@if(count($errors) > 0)
					@foreach($errors->all() as $row_error)
						<div class="col-md-12  alert alert-danger">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							{{ $row_error }}
						</div>
					@endforeach
				@endif
				@if(session()->has('message'))
					<div class="row"><div class="col-sm-12">
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							{{ session()->get('message') }}
						</div>
					</div></div>
				@endif
			</div>
    <div class="row">
        <div class="col-md-12">
            <form id="submit_form" class="form-horizontal" method="POST" action="{{ url('stock/stockin_insert') }}" enctype="multipart/form-data" >
				{{ csrf_field() }}
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Stock Adjustment</h3>
                    </div>
                    <div class="panel-body">
							<div class="alert alert-danger alert-dismissable alert_modal" hidden>
									already exists
								</div>
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

							</form>
						</div>
					</div>
                    </div>
                    <div class="panel-footer">
                        <input type="button" id="clearBtn" class="btn btn-default" value="Clear Form">
						<input type="button" id="submitBtn"class="btn btn-primary pull-right" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Scan Barcode</h4>
      </div>
      <div class="modal-body">
	  <form action="" id="barcode_list">
	  		<input type="text" class="input_barcode form-control">
			<textarea name="" id="textarea_barcode" cols="30" rows="10" disabled class="form-control"></textarea>
	  </form>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Done</button>
      </div>
    </div>

  </div>
</div>
<script>
$(document).ready(function() {
    $('.datepicker').datepicker('setDate', 'today');
})
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
$('#submitBtn').click(function(){
	$('#submit_form').submit();
	// var form,data;
		
	// 	$.ajax({
	// 		url: baseurl + '/',
	// 		method: "POST",
	// 		data: data,
	// 		success: function(result){
				
	// 		}
	// 	});
})
</script>

@endsection