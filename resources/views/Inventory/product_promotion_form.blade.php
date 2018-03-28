<?php 
# Create by: Bhaihaqi		2018-02-27
# Modify by: Bhaihaqi		2018-02-28

$formurl = "insert";
$clearurl = "form";
$titlehead = "New Promotion";
$havefile = 0;
if(isset($id) && $id > 0){
	#set update
	$formurl = "update/" . $id;
	$clearurl = "edit/" . $id;
	$titlehead = "Edit Promotion";
	
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
<link rel="stylesheet" type="text/css" id="theme" href="{!! asset('joli/js/daterangepicker/daterangepicker.css') !!}"/>
<style>
.mask_decimal, .mask_number, .mask_percentage, .tax-gst, .aftergst-info, .gst-info{max-width:150px;}
.uppercase{text-transform: uppercase;}
.view-picture{ height: 250px; width: 100%; display: inline-block; position: relative; }
.view-picture img { max-height: 98%; max-width: 98%; width: auto; height: auto; position: absolute;
		top: 0; bottom: 0; left: 0; right: 0; margin: auto; }
select{cursor:pointer;}
.required{ color: #ff0000;}
.datepromotion{ cursor:pointer !important; color:black !important;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li ><a href="{{ url('product/promotion/listing') }}">Promotion Listing</a></li>
	<li class="active">{{ $titlehead }}</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<form id="submit_form" class="form-horizontal" method="POST" action="{{ url('product/promotion/' . $formurl) }}" enctype="multipart/form-data" >
				{{ csrf_field() }}
				
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Promotion</strong> Form </h3>
					<ul class="panel-controls">
					</ul>
					@if(isset($id) && $id > 0)
					<div class="actions pull-right">
						<a href="{{ url('product/promotion/form') }}" class="btn btn-default  btn-sm btn-circle" title="Add New Product" >
							<i class="fa fa-plus"></i> Product Promotion </a>
						<a href="{{ url('product/promotion/view/' . $id) }}" class="btn btn-default  btn-sm btn-circle">
							<i class="fa fa-eye"></i> View </a>
					</div>
					@endif
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
						<div class="col-md-12">
							<h3> Details </h3>
							<hr />
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-3 control-label"> Product / Package <span class="required">*</span></label>
								<div class="col-md-7">
									@if(isset($id) && $id > 0)
										<div class="form-control">
											{{ $productArr['code'] . ' (' . $productArr['name'] . ')' }}
										</div>
									@else
									<select class="form-control select-product" name="product_id" >
										<option value=""> </option>
										@if(count($productArr) > 0)
											@foreach($productArr as $productid => $productdata)
												<option value="{{ $productid }}" {{ isset($product_id) && $product_id == $productid ? "selected" : "" }}
												data-desc="{{ $productdata['desc']  }}">
												{{ $productdata['code'] }}</option>
											@endforeach
										@endif
									</select>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Description </label>
								<div class="col-md-7">
									<input type="text" class="form-control promotion-description" name="description" value="{{ isset($description) ? $description : '' }}" />   
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Status </label>
								<div class="col-md-7">        
									<select class="form-control search-status" name="status" >
										<option value="1" {{ isset($status) && $status == 1 ? "selected" : "" }} > On </option>
										<option value="0" {{ isset($status) && $status == 0 ? "selected" : "" }}> Off </option>
									</select>									
								</div>
							</div>
							<div class="form-group promotion">
								<label class="col-md-3 control-label"> Datetime Promotion <span class="required">*</span></label>
								<div class="col-md-7">
									<input type="text" class="form-control datepromotion" name="daterange" 
									value="{{ isset($start) && isset($end) ? date('d/m/Y h:i A', strtotime($start)) . ' - '. date('d/m/Y h:i A', strtotime($end)) : '' }}" readonly />
								</div>
							</div>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-12">
							<h3> Gift </h3>
							<hr />
						</div>
						<div class="col-md-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="col-md-5"> Gift <span class="required">*</span></th>
										<th class="col-md-2"> Quantity <span class="required">*</span></th>
										<th class="col-md-4"> Description </th>
										<th class="text-center">
											<a href="javascript:;" title="Add New Row Product"
											class="btn btn-success btn-xs add-gift " ><span class="fa fa-plus"></span></a>
										</th>
									</tr>
								</thead>
								<tbody class="tbody-product">
									@if(isset($gift_list) && count($gift_list) > 0)
										@foreach($gift_list->all() as $key => $row)
										<tr class="row-giftlist">
											<td class="text-center product-number">{{ ($key + 1) }}</td>
											<td>
												<input type="hidden" class="giftid" name="giftid[]" value="{{ $row->id }}" />
												<input type="text" class="form-control promotiongift" 
												name="promotiongift[]" value="{{ $row->gift }}" /></td>
											<td><input type="text" class="form-control promotionquantity mask_number" 
												name="promotionquantity[]" value="{{ $row->quantity }}" /></td>
											<td><input type="text" class="form-control productdescription" 
												name="promotiondescription[]" value="{{ $row->description }}" /></td>
											<td class="text-center">
												<a href="javascript:;" title="Remove This Row Gift"
												class="btn btn-danger btn-xs remove-gift" ><span class="fa fa-times"></span></a>
											</td>
										</tr>
										@endforeach
									@else
									<tr class="row-giftlist">
										<td class="text-center product-number">1</td>
										<td>
											<input type="hidden" class="giftid" name="giftid[]" value="" />
											<input type="text" class="form-control promotiongift" 
											name="promotiongift[]" value="" /></td>
										<td><input type="text" class="form-control promotionquantity mask_number" 
											name="promotionquantity[]" value="" /></td>
										<td><input type="text" class="form-control productdescription" 
											name="promotiondescription[]" value="" /></td>
										<td class="text-center">
											<a href="javascript:;" title="Remove This Row Gift"
											class="btn btn-danger btn-xs remove-gift" ><span class="fa fa-times"></span></a>
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-12">
							<h3> Promotion Sales </h3>
							<hr />
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-3 control-label"><br /> West Malaysia <span class="required">*</span></label>
								<div class="col-md-2">
									<span class="help-block"> Price </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="sales-info form-control product-price_wm mask_decimal" placeholder="0.00" name="price_wm" value="{{ isset($price_wm) ? number_format($price_wm, 2, '.', '') : '' }}" />
									</div>
								</div>
								<div class="col-md-2">
									<span class="help-block"> GST {{ $gstpercentage }} %</span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="gst-info form-control text-right" >
											{{ isset($wm_gst) ? number_format($wm_gst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<span class="help-block">After GST </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="aftergst-info form-control mask_decimal" placeholder="0.00" 
										value="{{ isset($wm_aftergst) ? number_format($wm_aftergst, 2, '.', '') : '' }}" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><br /> East Malaysia <span class="required">*</span></label>
								<div class="col-md-2">
									<span class="help-block"> Price </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="sales-info form-control product-price_em mask_decimal" placeholder="0.00" name="price_em" value="{{ isset($price_em) ? number_format($price_em, 2, '.', '') : '' }}" />
									</div>
								</div>
								<div class="col-md-2">
									<span class="help-block"> GST {{ $gstpercentage }} %</span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="gst-info form-control text-right" >
											{{ isset($em_gst) ? number_format($em_gst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<span class="help-block">After GST </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="aftergst-info form-control mask_decimal" placeholder="0.00" 
										value="{{ isset($em_aftergst) ? number_format($em_aftergst, 2, '.', '') : '' }}" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><br /> Staff Price <span class="required">*</span></label>
								<div class="col-md-2">
									<span class="help-block"> Price </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="sales-info form-control product-price_staff mask_decimal" placeholder="0.00" 
										name="price_staff" value="{{ isset($price_staff) ? number_format($price_staff, 2, '.', '') : '' }}" />
									</div>
								</div>
								<div class="col-md-2">
									<span class="help-block"> GST {{ $gstpercentage }} %</span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<div class="gst-info form-control text-right" >
											{{ isset($staff_gst) ? number_format($staff_gst, 2, '.', '') : '0.00' }}
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<span class="help-block">After GST </span>
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="aftergst-info form-control mask_decimal" placeholder="0.00" 
										value="{{ isset($staff_aftergst) ? number_format($staff_aftergst, 2, '.', '') : '' }}" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<a class="btn btn-default" href="{{ url('product/promotion/' . $clearurl ) }}">{{ isset($id) && $id > 0 ? 'Reset' : 'Clear Form' }}</a>                                    
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
<script type="text/javascript" src="{!! asset('joli/js/daterangepicker/moment.min.js') !!}" ></script> 
<script type="text/javascript" src="{!! asset('joli/js/daterangepicker/daterangepicker.js') !!}" ></script>

<script>
var baseurl = '{{ url('') }}';
var baseid = '{{ isset($id) && $id > 0 ? $id : 0 }}';
var gstpercentage = '{{ $gstpercentage }}';
var jvalidate = $("#submit_form").validate({
errorPlacement: function(error,element) { return true;},
ignore: [],
rules: {                                            
		product_id: { required: true,},
		daterange:{ required: true,},
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
function product_number(){
	for(i = 0; i < $('.row-giftlist').length; i++){
		$($('.row-giftlist')[i]).find('.product-number').html((i + 1));
	}
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
	
	$('body').on('change', '.sales-info', function(){
		var numberd = $(this).val();
		var gst = 0;
		var aftergst = 0;
		if(numberd > 0){
			$(this).val(setnumber_decimal(numberd));
			gst = (parseFloat(numberd) / 100) * gstpercentage;
			aftergst = parseFloat(numberd) + parseFloat(gst);
			$(this).closest('.form-group').find('.gst-info').html(setnumber_decimal(gst));
			$(this).closest('.form-group').find('.aftergst-info').val(setnumber_decimal(aftergst));
		}
		else{
			$(this).val('');
			$(this).closest('.form-group').find('.gst-info').html('');
			$(this).closest('.form-group').find('.aftergst-info').val('');
		}
	});
	
	$('body').on('change', '.aftergst-info', function(){
		var numberd = $(this).val();
		var gst = 0;
		var beforegst = 0;
		if(numberd > 0){
			$(this).val(setnumber_decimal(numberd));
			gst = (parseFloat(numberd) / (parseFloat(100) + parseFloat(gstpercentage))) * gstpercentage;
			beforegst = parseFloat(numberd) - parseFloat(gst);
			$(this).closest('.form-group').find('.gst-info').html(setnumber_decimal(gst));
			$(this).closest('.form-group').find('.sales-info').val(setnumber_decimal(beforegst));
		}
		else{
			$(this).val('');
			$(this).closest('.form-group').find('.gst-info').html('');
			$(this).closest('.form-group').find('.sales-info').val('');
		}
	});
	
	$('input[name="daterange"]').daterangepicker({
        timePicker: true,
        timePickerIncrement: 1,
        locale: {
            format: 'DD/MM/YYYY h:mm A'
        }
    });
	$('#submit_form').on('change', '.select-product', function(){
		datadesc = $(this).find(':selected').data('desc');
		$('.promotion-description').val(datadesc);
	});
	
	$('#submit_form').on('change', 'input, select', function(){
		$(this).closest('.form-group').removeClass('has-error');
	});
	
	$("#submit_form").submit(function(){
	});
	
	$('body').on('click', '.add-gift', function(){
		var show = true;
		for(i = 0; i < $('.row-giftlist').length; i++){
			$($('.row-giftlist')[i]).find('input[name="promotiongift[]"]').closest('td').removeClass('has-error');
			$($('.row-giftlist')[i]).find('input[name="promotionquantity[]"]').closest('td').removeClass('has-error');
			promotiongift = $($('.row-giftlist')[i]).find('input[name="promotiongift[]"]').val().trim();
			if(promotiongift == ""){
				$($('.row-giftlist')[i]).find('input[name="promotiongift[]"]').closest('td').addClass('has-error');
				show = false;
			}
			productquantity = $($('.row-giftlist')[i]).find('input[name="promotionquantity[]"]').val().trim();
			if(productquantity == "" || productquantity == 0){
				$($('.row-giftlist')[i]).find('input[name="promotionquantity[]"]').closest('td').addClass('has-error');
				show = false;
			}
		}
		if(show == true){
			var new_row = $($('.row-giftlist')[0]).clone();
			new_row.find('input[name="giftid[]"]').val("");
			new_row.find('input[name="promotiongift[]"]').val("");
			new_row.find('input[name="promotiondescription[]"]').val("");
			new_row.find('input[name="promotionquantity[]"]').val("");
			new_row.find('input[name="promotionquantity[]"]').inputmask({"mask": "9","repeat": 10,'rightAlign': true,"greedy": false});
			$('.tbody-product').append(new_row);
			product_number();
		}
	});
	
	$('body').on('click', '.remove-gift', function(){
		var row_length = $('.row-giftlist').length;
		if(row_length == 1){
			var row_1 = $('.row-giftlist');
			row_1.find('input[name="giftid[]"]').val("");
			row_1.find('input[name="promotiongift[]"]').val("");
			row_1.find('input[name="promotiondescription[]"]').val("");
			row_1.find('input[name="promotionquantity[]"]').val("");
		}
		else{
			$(this).closest('.row-giftlist').remove();
			product_number();
		}
	});
});
</script>
@endsection