<?php 
# Create by: Bhaihaqi		2018-02-05
# Modify by: Bhaihaqi		2018-02-13

$formurl = "insert";
$titlehead = "New Product";
if(isset($id) && $id > 0){
	#set update
	$formurl = "update/" . $id;
	$titlehead = "Edit Product";
}
?>

@extends('header')
@section('title',$titlehead)
@section('content')
<style>
.mask_decimal, .mask_number, .mask_percentage, .tax-gst{max-width:200px;}
.uppercase{text-transform: uppercase;}
.view-picture{ height: 250px; width: 100%; display: inline-block; position: relative; }
.view-picture img { max-height: 98%; max-width: 98%; width: auto; height: auto; position: absolute;
		top: 0; bottom: 0; left: 0; right: 0; margin: auto; }
select{cursor:pointer;}
.required{ color: #ff0000;}
</style><!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li ><a href="{{ url('product/listing') }}">Product Listing</a></li>
	<li class="active">{{ $titlehead }}</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<form id="submit_form" class="form-horizontal" method="POST" action="{{ url('product/' . $formurl) }}" enctype="multipart/form-data" >
				{{ csrf_field() }}
				
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Product</strong> Form </h3>
					<ul class="panel-controls">
					</ul>
				</div>
				<div class="panel-body"> 
					<div class="row">
						@if(count($errors) > 0)
							@foreach($errors->all() as $row_error)
								<div class="col-md-12  alert alert-danger">
									<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									{{ $row_error }}
								</div>
							@endforeach
						@endif
					</div>
					<div class="alert alert-danger alert-dismissable alert_modal" hidden>
						already exists
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Product </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Code <span class="required">*</span></label>
								<div class="col-md-9">        
									<input type="text" class="form-control product-code uppercase" name="code" value="{{ isset($code) ? $code : '' }}" />  
									<span class="help-block">Minimum 3 characters.</span>									
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Type <span class="required">*</span></label>
								<div class="col-md-9">        
									<select class="form-control product-type" name="type" >
										<option value=""></option>
										<option value="1" {{ isset($type) && $type == 1 ? "selected" : "" }}> By Item </option>
										<option value="2" {{ isset($type) && $type == 2 ? "selected" : "" }}> Package(Long Term)</option>
										<option value="3" {{ isset($type) && $type == 3 ? "selected" : "" }}> Monthly Promotion </option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Description <span class="required">*</span></label>
								<div class="col-md-9">
									<input type="text" class="form-control product-description" name="description" value="{{ isset($description) ? $description : '' }}" />   
								</div>
							</div>
							<br /> &nbsp;
							<div class="col-md-12">
								<h3> Promotion </h3>
								<hr />
							</div>
							<div class="form-group promotion">
								<label class="col-md-3 control-label"> Range Date </label>
								<div class="col-md-9">
									<div class="col-md-12">
										<div class="input-daterange input-group" id="datepicker">
											<input type="text" class="input-sm form-control start_promotion" name="start_promotion" 
											value="{{ isset($start_promotion) && !in_array($start_promotion, array('0000-00-00','')) ? date('d/m/Y', strtotime($start_promotion)) : '' }}" />
											<span class="input-group-addon">to</span>
											<input type="text" class="input-sm form-control end_promotion" name="end_promotion" 
											value="{{ isset($end_promotion) && !in_array($end_promotion, array('0000-00-00','')) ? date('d/m/Y', strtotime($end_promotion)) : '' }}" />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 image" >
							<div class="col-md-12">
								<h3> Picture</h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-1 control-label"></label>
								<div class="col-md-10">
									<div class="form-control view-picture pull-center"></div>
								</div>							
							</div>
							<div class="form-group">
								<label class="col-md-1 control-label"> </label>
								<div class="col-md-10">
									<input type="file" class="fileinput upload-picture" name="filename1" id="filename1"/>
								</div>								
							</div>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Sales Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> West Malaysia <span class="required">*</span></label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="form-control product-price_wm mask_decimal" placeholder="0.00" name="price_wm" value="{{ isset($price_wm) ? number_format($price_wm, 2, '.', '') : '' }}" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> East Malaysia <span class="required">*</span></label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="form-control product-price_em mask_decimal" placeholder="0.00" name="price_em" value="{{ isset($price_em) ? number_format($price_em, 2, '.', '') : '' }}" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Staff Price </label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="form-control product-price_staff mask_decimal" placeholder="0.00" name="price_staff" value="{{ isset($price_staff) ? number_format($price_staff, 2, '.', '') : '' }}" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label tax-gst"> Tax GST </label>
								<div class="col-md-8">
									<div class="input-group">
										<input type="text" class="form-control tax_gst mask_decimal" placeholder="0.00" name="tax_gst" value="{{ isset($tax_gst) ? $tax_gst : '' }}" readonly />
										<span class="input-group-addon"> % </span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Purchasing Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Last Purchase Price </label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="form-control product-last_purchase mask_decimal" placeholder="0.00" name="last_purchase" value="{{ isset($last_purchase) ? $last_purchase : '' }}" />
									</div>
								</div>
							</div>
							<br /> &nbsp;
							<div class="col-md-12">
								<h3> Inventory </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Stock Quantity</label>
								<div class="col-md-8">
									<div class="input-group ">
										<span class="input-group-addon"><i class="glyphicon glyphicon-bookmark"></i></span>
										<input type="text" class="form-control product-quantity mask_number" placeholder="0" name="quantity" value="{{ isset($quantity) ? $quantity : '' }}" readonly />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<a class="btn btn-default" href="{{ url('product/form') }}">Clear Form</a>                                    
					<button class="btn btn-primary pull-right">Submit</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
 <!-- END PAGE CONTENT WRAPPER -->
<script type="text/javascript" src="{!! asset('joli/js/plugins/inputmask/jquery.inputmask.bundle.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/bootstrap/bootstrap-file-input.js') !!}"></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/jquery-validation/jquery.validate.js') !!}" ></script> 

<script>
var baseurl = '{{ url('') }}';
var baseid = '{{ isset($id) && $id > 0 ? $id : 0 }}';
var jvalidate = $("#submit_form").validate({
errorPlacement: function(error,element) { return true;},
ignore: [],
rules: {                                            
		code: { required: true, minlength: 3,},
		type: { required: true,},
		description: { required: true,},
		price_wm: { required: true,},
		price_em: { required: true,},
		price_staff: { required: true,},
	}                                        
});
$(function() {
	$.validator.messages.required = '';
	$(".mask_number").inputmask({
		"mask": "9",
		"repeat": 10,
		'rightAlign': true,
		"greedy": false
	});
	
	$(".mask_decimal").inputmask({
		'mask':"9{0,14}.9{0,2}", 
		'alias': 'decimal',
		'digits':'2',
		'rightAlign': true,
		'autoGroup': true,
	});
	
	$(".mask_percentage").inputmask({
		'mask':"9{0,3}.9{0,2}", 
		'alias': 'decimal',
		'digits':'2',
		'rightAlign': true,
		'autoGroup': true,
	});
	
	$('.promotion .input-daterange').datepicker({
		format: "dd/mm/yyyy",
		clearBtn: true,
		autoclose: true,
		todayHighlight: true
	});
	
	// SET OUTPUT IMAGE 
	$(".upload-picture").change(function(e) {
		if(typeof this.files[0] != 'undefined'){
			var fileval = $(this).val();
			extval = fileval.split('.').pop();
			fileType = this.files[0].type;
			var ValidImageTypes = ["image/gif", "image/jpeg", "image/png", "image/x-icon"];
			if ($.inArray(fileType, ValidImageTypes) < 0) {
				$(this).closest('.image').find(".view-picture").find('img').remove();
			}
			else{
				for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {

					var file = e.originalEvent.srcElement.files[i];

					var img = document.createElement("img");
					var reader = new FileReader();
					reader.onloadend = function() {
						 img.src = reader.result;
					}
					reader.readAsDataURL(file);
					$(this).closest('.image').find(".view-picture").html(img);
				}
			}
		}
		else{
			$(this).closest('.image').find(".view-picture").find('img').remove();
		}
	});
	
	$('#submit_form').on('change', 'input, select', function(){
		$(this).closest('.form-group').removeClass('has-error');
	});
	
	$("#submit_form").submit(function(){
		productcode = $(".product-code").val().trim();
		code_exist = 0;
		$.ajax({
			url: baseurl + '/product/check_existcode',
			method: "POST",
			data: {'code': productcode,'id': baseid, '_token': '{{ csrf_token() }}',} ,
			async: false,
			success: function(result){
				if(result == 1 || result == true)
					code_exist = 1;
			}
		});
		if(code_exist == 1){
			$(".product-code").focus();
			$("#submit_form").find(".alert_modal").html(" Product Code <b>"+productcode.toUpperCase()+"</b> already exists . ");
			$("#submit_form").find(".alert_modal").show();
			return false;
		}
	});
});
</script>
@endsection