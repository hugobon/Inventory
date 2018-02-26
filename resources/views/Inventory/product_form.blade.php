<?php 
# Create by: Bhaihaqi		2018-02-05
# Modify by: Bhaihaqi		2018-02-13

$formurl = "insert";
$clearurl = "form";
$titlehead = "New Product";
$havefile = 0;
if(isset($id) && $id > 0){
	#set update
	$formurl = "update/" . $id;
	$clearurl = "edit/" . $id;
	$titlehead = "Edit Product";
	if($picture_path != null AND $picture_path != '')
		$havefile = 1;
	
	$wm_gst = $wm_aftergst = $em_gst = $em_aftergst = $staff_gst = $staff_aftergst = 0;
	if($price_wm > 0){
		$wm_gst = ($price_wm / 100) * $gstpercentage;
		$wm_aftergst = $price_wm + $wm_gst;
	}
	if($price_em > 0){
		$em_gst = ($price_em / 100) * $gstpercentage;
		$em_aftergst = $price_em + $em_gst;
	}
	if($price_staff > 0){
		$staff_gst = ($price_staff / 100) * $gstpercentage;
		$staff_aftergst = $price_staff + $staff_gst;
	}
}
?>

@extends('header')
@section('title',$titlehead)
@section('content')
<style>
.mask_decimal, .mask_number, .mask_percentage, .tax-gst, .aftergst-info, .gst-info{max-width:150px;}
.uppercase{text-transform: uppercase;}
.view-picture{ height: 250px; width: 100%; display: inline-block; position: relative; }
.view-picture img { max-height: 98%; max-width: 98%; width: auto; height: auto; position: absolute;
		top: 0; bottom: 0; left: 0; right: 0; margin: auto; }
select{cursor:pointer;}
.required{ color: #ff0000;}
</style>
<!-- START BREADCRUMB -->
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
					<?php if(isset($id) && $id > 0){ ?>
					<div class="actions pull-right">
						<a href="{{ url('product/view/' . $id) }}" class="btn btn-default  btn-sm btn-circle">
					<i class="fa fa-eye"></i> View </a>
					</div>
					<?php } ?>
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
									<div class="form-control view-picture pull-center">
										<?php if($havefile == 1){ ?>
										<img src="{{ url('storage/' . $picture_path) }}" />
										<?php } ?>
									</div>
								</div>							
							</div>
							<div class="form-group">
								<label class="col-md-1 control-label"> </label>
								<div class="col-md-10 button-browse" {{ $havefile == 1 ? 'hidden' : ''}} >
									<input type='hidden' name="upload_status" id="upload_status" value="{{ $havefile == 1 ? '0' : '1'}}" />
									<input type="file" class="fileinput upload-picture" name="upload_image" id="filename1" accept="image/*" />
								</div>
								<div class="col-md-10 button-remove" {{ $havefile == 0 ? 'hidden' : ''}} >
									<a href='javascript:;' id="remove-picture" class='btn btn-danger' />Remove</a> &nbsp; {{ isset($picture_name) ? $picture_name : '' }}
								</div>									
							</div>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-8">
							<div class="col-md-12">
								<h3> Sales Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><br /> West Malaysia <span class="required">*</span></label>
								<div class="col-md-3">
									<span class="help-block"> Price </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="sales-info form-control product-price_wm mask_decimal" placeholder="0.00" name="price_wm" value="{{ isset($price_wm) ? number_format($price_wm, 2, '.', '') : '' }}" />
									</div>
								</div>
								<div class="col-md-3">
									<span class="help-block"> GST {{ $gstpercentage }} %</span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="gst-info form-control text-right" >
											{{ isset($wm_gst) ? number_format($wm_gst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<span class="help-block">After GST </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="aftergst-info form-control text-right" >
											{{ isset($wm_aftergst) ? number_format($wm_aftergst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><br /> East Malaysia <span class="required">*</span></label>
								<div class="col-md-3">
									<span class="help-block"> Price </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="sales-info form-control product-price_em mask_decimal" placeholder="0.00" name="price_em" value="{{ isset($price_em) ? number_format($price_em, 2, '.', '') : '' }}" />
									</div>
								</div>
								<div class="col-md-3">
									<span class="help-block"> GST {{ $gstpercentage }} %</span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="gst-info form-control text-right" >
											{{ isset($em_gst) ? number_format($em_gst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<span class="help-block">After GST </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="aftergst-info form-control text-right" >
											{{ isset($em_aftergst) ? number_format($em_aftergst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><br /> Staff Price <span class="required">*</span></label>
								<div class="col-md-3">
									<span class="help-block"> Price </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="sales-info form-control product-price_staff mask_decimal" placeholder="0.00" name="price_staff" value="{{ isset($price_staff) ? number_format($price_staff, 2, '.', '') : '' }}" />
									</div>
								</div>
								<div class="col-md-3">
									<span class="help-block"> GST {{ $gstpercentage }} %</span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="gst-info form-control text-right" >
											{{ isset($staff_gst) ? number_format($staff_gst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<span class="help-block">After GST </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="aftergst-info form-control text-right" >
											{{ isset($staff_aftergst) ? number_format($staff_aftergst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-md-12">
								<h3> Purchasing Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Last Purchase Price </label>
								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="form-control product-last_purchase mask_decimal" placeholder="0.00" 
										name="last_purchase" value="{{ isset($last_purchase) ? number_format($last_purchase, 2, '.', '') : '0.00' }}" />
									</div>
								</div>
							</div>
							<br /> &nbsp;
							<div class="col-md-12">
								<h3> Inventory </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Stock Reminder </label>
								<div class="col-md-6">
									<div class="input-group ">
										<span class="input-group-addon"><i class="glyphicon glyphicon-bookmark"></i></span>
										<input type="text" class="form-control product-quantity_min mask_number" placeholder="0" name="quantity_min" value="{{ isset($quantity_min) ? $quantity_min : '' }}" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Stock Quantity</label>
								<div class="col-md-6">
									<div class="input-group ">
										<span class="input-group-addon"><i class="glyphicon glyphicon-bookmark"></i></span>
										<input type="text" class="form-control product-quantity mask_number" placeholder="0" value="{{ isset($quantity) ? $quantity : '' }}" readonly />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<a class="btn btn-default" href="{{ url('product/' . $clearurl ) }}">{{ isset($id) && $id > 0 ? 'Reset' : 'Clear Form' }}</a>                                    
					<button type="submit" class="btn btn-primary pull-right">Submit</button>
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
var gstpercentage = '{{ $gstpercentage }}';
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
function setnumber_decimal(numberd){
	if(numberd > 0){
		v = parseFloat(numberd);
		return v.toFixed(2);
	}
	return 0.00;
}
$(function() {
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
	
	$('body').on('change', '.sales-info', function(){
		var numberd = $(this).val();
		$(this).val(setnumber_decimal(numberd));
		
		var gst = 0;
		var aftergst = 0;
		if(numberd > 0){
			gst = (parseFloat(numberd) / 100) * gstpercentage;
			aftergst = parseFloat(numberd) + parseFloat(gst);
		}
		$(this).closest('.form-group').find('.gst-info').html(setnumber_decimal(gst));
		$(this).closest('.form-group').find('.aftergst-info').html(setnumber_decimal(aftergst));
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
	
	// remove image
	$('#submit_form').on('click', '#remove-picture', function(){
		$(this).closest('.image').find(".view-picture").find('img').remove();
		$(this).closest('.button-remove').hide();
		$(this).closest('.image').find('.button-browse').show();
		$(this).closest('.image').find('#upload_status').val(1);
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