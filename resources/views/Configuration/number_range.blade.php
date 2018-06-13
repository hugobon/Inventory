@extends('header')
@section('title','Config - Number Range')

@section('content')
<style>
select{cursor:pointer;}
.required{ color: #ff0000;}
.uppercase{text-transform: uppercase;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('configuration/deliverytype') }}">Config - Delivery Type</a></li>
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
					<h3 class="panel-title">Configuration - Delivery Type Listing</h3>
					<div class="actions pull-right">
						<a href="javascript:;" class="btn btn-default  btn-sm btn-circle addnew_deliverytype" title="Add New deliverytype" >
					<i class="fa fa-plus"></i> New Delivery Type </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<form id="form_search" class="form-horizontal" method="POST" action="{{ url('configuration/deliverytype/form_search') }}" >
						{{ csrf_field() }}
						<div class="panel-body">
							<div class="row">
								<div class="col-md-10">
									<div class="form-group">
										<label class="col-md-2 control-label"> Search </label>
										<div class="col-md-10">        
											<input type="text" class="form-control type-search" name="search" 
											placeholder=" Delivery Code / Type Description " value="{{ isset($search) ? $search : '' }}" />									
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
								<div class="col-md-1">
									<a href="{{ url('configuration/deliverytype') }}" class="btn btn-danger">Reset</a>
								</div>
							</div>
						</div>
					</form>
					<div class="panel-body">
					&nbsp; Total deliverytype: <b>{{ $counttype }}</b>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions">
							<thead>
								<tr>
									<th ></th>
									<th class="col-md-1 text-center">Id</th>
									<th class="col-md-2 text-center">Code</th>
									<th class="col-md-5">Type Description</th>
									<th class="col-md-2">Create at</th>
									<th ></th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
							@if(count($deliverytypeArr) > 0)
								
								@foreach($deliverytypeArr->all() as $key => $row)
									<?php
										$rowarr = array('selectid' => $row->id,'search' => Request::segment(4));
										$base64data = trim(base64_encode(serialize($rowarr)), "=.");
									?>
									<tr>
										<td class="text-center" >{{ $key + $deliverytypeArr->firstItem() }}</td>
										<td class="text-center" >{{ $row->id }}</td>
										<td class="text-center">{{ $row->delivery_code }}</td>
										<td>{{ $row->type_description }}</td>
										<td>{{ !in_array($row->created_at, array('0000-00-00','','null')) ? date('d/m/Y, h:i A', strtotime($row->created_at)) : '' }}</td>
										<td>
											<a href="javascript:;" data-base64="{{ $base64data }}" 
												data-code="{{ $row->delivery_code }}" data-name="{{ $row->type_description }}" 
												data-address="{{ $row->address }}" data-tel="{{ $row->tel }}" 
												data-fax="{{ $row->fax }}"  data-email="{{ $row->email }}" 
											title=" Edit {{ $row->type_description . " (" . $row->delivery_code . ")" }}"
											class="btn btn-primary btn-rounded edit_deliverytype" ><span class="fa fa-edit"></span></a>
										</td>
										<td>
											<a href="javascript:;" data-base64="{{ $base64data }}" 
											data-code="{{ $row->type_description . " (" . $row->delivery_code . ")" }}"
											title=" Remove {{ $row->type_description . " (" . $row->delivery_code . ")" }}"
											class="btn btn-danger btn-rounded confirm-delete" ><span class="glyphicon glyphicon-trash"></span></a>
										</td>
									</tr>
								@endforeach
							@else
							<tr>
								<td colspan="7" class="text-center"> No Data Found <br />
								<a href="javascript:;" class="addnew_deliverytype"><span class="fa fa-plus"></span> New Delivery Type</a></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $deliverytypeArr->links() }}
					</div>
				</div>
			</div>                                                

		</div>
	</div>
	<!-- END RESPONSIVE TABLES -->
	
	<!-- Modal -->
	<div class="modal fade" id="deliverytypeModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Configuration - Delivery Type Form</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<form id="submit_form" class="form-horizontal" method="POST" action="{{ url('configuration/deliverytype/save') }}" >
								{{ csrf_field() }}
								<div class="alert alert-danger alert-dismissable alert_modal" hidden>
									already exists
								</div>
								<input type="hidden" class="form-control base64" name="base64" value="" />
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Delivery Code <span class="required">*</span></label>
										<div class="col-md-9">								
											<input type="text" maxlength="5" class="form-control delivery_code uppercase" name="delivery_code" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Type Description </label>
										<div class="col-md-9">        
											<input type="text" maxlength="20" class="form-control type_description uppercase" name="type_description" value="" />
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
	rules: { delivery_code: { required: true,},}
});
$(function() {

	$("#submit_form").submit(function(){
		delivery_code = $(".delivery_code").val().trim();
		base64 = $(".base64").val().trim();
		code_exist = 0;
		$.ajax({
			url: baseurl + '/configuration/deliverytype/check_existcode',
			method: "POST",
			data: {'code': delivery_code,'base64': base64, '_token': '{{ csrf_token() }}',} ,
			async: false,
			success: function(result){
				if(result == 1 || result == true)
					code_exist = 1;
			}
		});
		if(code_exist == 1){
			$(".delivery_code").focus();
			$("#submit_form").find(".alert_modal").html(" Delivery Code <b>"+delivery_code.toUpperCase()+"</b> already exists . ");
			$("#submit_form").find(".alert_modal").show();
			return false;
		}
		$("#submit_form").find(".alert_modal").hide();
	});
	
	$('.delivery_code').inputmask({
		"mask": "*",
		"repeat": 30,
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
						window.location.href = "{{ url('configuration/deliverytype/delete') }}/" + base64data;
					}
					},
					{addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
						$noty.close();
						}
					}
				]
		})
	});
	
	$('body').on('click', '.addnew_deliverytype', function(){
		// set new 
		$("#submit_form").find(".alert_modal").hide();
		$('#deliverytypeModal').find('.base64').val('');
		$('#deliverytypeModal').find('.delivery_code').val('');
		$('#deliverytypeModal').find('.type_description').val('');
		$('#deliverytypeModal').find('.submit-button').html('Submit');
		
		$('#deliverytypeModal').modal('show');
	});
	
	$('body').on('click', '.edit_deliverytype', function(){
		$("#submit_form").find(".alert_modal").hide();
		$('#deliverytypeModal').find('.base64').val($(this).data('base64'));
		$('#deliverytypeModal').find('.delivery_code').val($(this).data('code'));
		$('#deliverytypeModal').find('.type_description').val($(this).data('name'));
		$('#deliverytypeModal').find('.submit-button').html('Save');
		
		$('#deliverytypeModal').modal('show');
	});
});
</script>
@endsection