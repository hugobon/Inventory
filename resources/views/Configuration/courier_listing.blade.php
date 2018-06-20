@extends('header')
@section('title','Config - Courier')

@section('content')
<style>
select{cursor:pointer;}
.required{ color: #ff0000;}
.uppercase{text-transform: uppercase;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('configuration/courier') }}">Config - Courier</a></li>
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
					<h3 class="panel-title">Configuration - Courier Listing</h3>
					<div class="actions pull-right">
						<a href="javascript:;" class="btn btn-default  btn-sm btn-circle addnew_courier" title="Add New Courier" >
					<i class="fa fa-plus"></i> New Courier </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<form id="form_search" class="form-horizontal" method="POST" action="{{ url('configuration/courier/form_search') }}" >
						{{ csrf_field() }}
						<div class="panel-body">
							<div class="row">
								<div class="col-md-10">
									<div class="form-group">
										<label class="col-md-2 control-label"> Search </label>
										<div class="col-md-10">        
											<input type="text" class="form-control type-search" name="search" 
											placeholder=" Code / Name / No. Tel / Email " value="{{ isset($search) ? $search : '' }}" />									
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
								<div class="col-md-1">
									<a href="{{ url('configuration/courier') }}" class="btn btn-danger">Reset</a>
								</div>
							</div>
						</div>
					</form>
					<div class="panel-body">
					&nbsp; Total Courier: <b>{{ $counttype }}</b>
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th ></th>
									<th class="text-center">Id</th>
									<th class="col-md-1 text-center">Code</th>
									<th class="col-md-4">Name</th>
									<th class="col-md-3">No. Tel</th>
									<th class="col-md-4">Email</th>
									<th ></th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
							@if(count($courierArr) > 0)
								
								@foreach($courierArr->all() as $key => $row)
									<?php
										$rowarr = array('selectid' => $row->id,'search' => Request::segment(4));
										$base64data = trim(base64_encode(serialize($rowarr)), "=.");
									?>
									<tr>
										<td class="text-center" >{{ $key + $courierArr->firstItem() }}</td>
										<td class="text-center" >{{ $row->id }}</td>
										<td class="text-center">{{ $row->courier_code }}</td>
										<td>{{ $row->courier_name }}</td>										
										<td>{{ $row->tel }}</td>
										<td>{{ $row->email }}</td>
										<td class="text-center">
											<a href="javascript:;" data-base64="{{ $base64data }}" 
												data-code="{{ $row->courier_code }}" data-name="{{ $row->courier_name }}" 
												data-address="{{ $row->address }}" data-tel="{{ $row->tel }}" 
												data-fax="{{ $row->fax }}"  data-email="{{ $row->email }}" 
											title=" Edit {{ $row->courier_name . " (" . $row->courier_code . ")" }}"
											class="edit_courier" ><span class="fa fa-edit text-info"></span></a>
										</td>
										<td class="text-center">
											<a href="javascript:;" data-base64="{{ $base64data }}" 
											data-code="{{ $row->courier_name . " (" . $row->courier_code . ")" }}"
											title=" Remove {{ $row->courier_name . " (" . $row->courier_code . ")" }}"
											class="confirm-delete" ><span class="glyphicon glyphicon-trash text-danger"></span></a>
										</td>
									</tr>
								@endforeach
							@else
							<tr>
								<td colspan="9" class="text-center"> No Data Found <br />
								<a href="javascript:;" class="addnew_courier"><span class="fa fa-plus"></span> New Courier</a></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $courierArr->links() }}
					</div>
				</div>
			</div>                                                

		</div>
	</div>
	<!-- END RESPONSIVE TABLES -->
	
	<!-- Modal -->
	<div class="modal fade" id="CourierModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Configuration - Courier Form</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<form id="submit_form" class="form-horizontal" method="POST" action="{{ url('configuration/courier/save') }}" >
								{{ csrf_field() }}
								<div class="alert alert-danger alert-dismissable alert_modal" hidden>
									already exists
								</div>
								<input type="hidden" class="form-control base64" name="base64" value="" />
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Code <span class="required">*</span></label>
										<div class="col-md-9">								
											<input type="text" maxlength="10" class="form-control courier_code uppercase" name="courier_code" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Name <span class="required">*</span></label>
										<div class="col-md-9">        
											<input type="text" maxlength="150" class="form-control courier_name uppercase" name="courier_name" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Address </label>
										<div class="col-md-9">        
											<textarea name="address" class="form-control address" rows="5" style="resize: none;" >{{ isset($description) ? $description : '' }}</textarea>							
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> No. Tel </label>
										<div class="col-md-9">        
											<input type="text" maxlength="16" class="form-control tel mask_number" name="tel" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> No. Fax </label>
										<div class="col-md-9">        
											<input type="text" maxlength="16" class="form-control fax mask_number" name="fax" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Email </label>
										<div class="col-md-9">        
											<input type="email" class="form-control email" name="email" value="" />
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

</div>
<!-- END PAGE CONTENT WRAPPER -->  
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/jquery.noty.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topCenter.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topLeft.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topRight.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/themes/default.js') !!}" ></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/inputmask/jquery.inputmask.bundle.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/jquery-validation/jquery.validate.js') !!}" ></script> 
<script>
var baseurl = '{{ url('') }}';
var jvalidate = $("#submit_form").validate({
	errorPlacement: function(error,element) { return true;},
	ignore: [],
	rules: { courier_code: { required: true,},courier_name: { required: true,},}
});
$(function() {

	$("#submit_form").submit(function(){
		courier_code = $(".courier_code").val().trim();
		base64 = $(".base64").val().trim();
		code_exist = 0;
		$.ajax({
			url: baseurl + '/configuration/courier/check_existcode',
			method: "POST",
			data: {'code': courier_code,'base64': base64, '_token': '{{ csrf_token() }}',} ,
			async: false,
			success: function(result){
				if(result == 1 || result == true)
					code_exist = 1;
			}
		});
		if(code_exist == 1){
			$(".courier_code").focus();
			$("#submit_form").find(".alert_modal").html(" Courier Code <b>"+courier_code.toUpperCase()+"</b> already exists . ");
			$("#submit_form").find(".alert_modal").show();
			return false;
		}
		$("#submit_form").find(".alert_modal").hide();
	});
	
	$('.courier_code').inputmask({
		"mask": "*",
		"repeat": 30,
		"greedy": false
	});
	
	$(".mask_number").inputmask({
		"mask": "9",
		"repeat": 10,
		"greedy": false
	});
	
	$('.table').on('click', '.confirm-delete', function(){
		var base64data = $(this).data('base64');
		var code = $(this).data('code');
		noty({
			text: 'Are you sure to remove <br /> ' + code + ' ?',
			layout: 'topRight',
			buttons: [
					{addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
						$noty.close();
						window.location.href = "{{ url('configuration/courier/delete') }}/" + base64data;
					}
					},
					{addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
						$noty.close();
						}
					}
				]
		})
	});
	
	$('body').on('click', '.addnew_courier', function(){
		// set new 
		$("#submit_form").find(".alert_modal").hide();
		$('#CourierModal').find('.base64').val('');
		$('#CourierModal').find('.courier_code').val('');
		$('#CourierModal').find('.courier_name').val('');
		$('#CourierModal').find('.address').val('');
		$('#CourierModal').find('.tel').val('');
		$('#CourierModal').find('.fax').val('');
		$('#CourierModal').find('.email').val('');
		$('#CourierModal').find('.submit-button').html('Submit');
		
		$('#CourierModal').modal('show');
	});
	
	$('body').on('click', '.edit_courier', function(){
		$("#submit_form").find(".alert_modal").hide();
		$('#CourierModal').find('.base64').val($(this).data('base64'));
		$('#CourierModal').find('.courier_code').val($(this).data('code'));
		$('#CourierModal').find('.courier_name').val($(this).data('name'));
		$('#CourierModal').find('.address').val($(this).data('address'));
		$('#CourierModal').find('.tel').val($(this).data('tel'));
		$('#CourierModal').find('.fax').val($(this).data('fax'));
		$('#CourierModal').find('.email').val($(this).data('email'));
		$('#CourierModal').find('.submit-button').html('Save');
		
		$('#CourierModal').modal('show');
	});
});
</script>
@endsection