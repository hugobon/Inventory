@extends('header')
@include('Agent.js.agent_control')
@include('Agent.css.agent_css')
@section('title','Config')

@section('content')

<!-- <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li class="{{ url('agent') }}">Agent</li>
	<li class="{{ url('agent') }}">Address Confiure</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	 <!-- START RESPONSIVE TABLES -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title">Address Listing</h3>
					<div class="actions pull-right">
						<a href="javascript:;" class="btn btn-default  btn-sm btn-circle createButton" title="Add New Address" id="createButton">
							<i class="fa fa-plus"></i> Address </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions table-address">
							<thead>
								<tr>
									<th>No.</th>
									<th hidden>Id</th>
									<th class="col-md-3">Name</th>
									<th class="col-md-4">Street1</th>
									<th class="col-md-4">Street2</th>
									<th class="col-md-3">Poscode</th>
									<th class="col-md-3">City</th>
									<th class="col-md-3">State</th>
									<th class="col-md-3">Country</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							@if($data != "")
							@foreach($data as $key => $value)
							<tr>
								<td> {{ $key+1 }} </td>
								<td hidden> {{ $value->id}} </td>
								<td> {{ $value->street1 }}</td>
								<td> {{ $value->street1 }}</td>
								<td> {{ $value->street2 }}</td>
								<td> {{ $value->poscode }}</td>
								<td> {{ $value->city }}</td>
								<td> {{ $value->state }}</td>
								<td> {{ $value->country }}</td>
								<td>
									<a href="javascript:;" title="edit" data-code="{{ $key }}" class="btn btn-primary btn-rounded editbutton" id="editbutton"><span class="fa fa-edit"></span></a>
								</td>
								<td>
									<a href="javascript:;" title="delete" data-code="{{ $value->id }}"" class="btn btn-danger btn-rounded confirm-delete" ><span class="glyphicon glyphicon-trash"></span></a>
								</td>
							</tr>
							@endforeach
							@elseif($data == "")
							<tr>
								<td colspan="10" class="text-center"> No Data Found <br/></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					</div>
				</div>
			</div>                                                
		</div>
	</div>
	<!-- END RESPONSIVE TABLES -->
</div>
<!-- END PAGE CONTENT WRAPPER -->

<div class="page-content-wrap">
	 <!-- START RESPONSIVE TABLES -->
	<div class="row">
		<div class="col-md-12">
			<!-- Modal -->
			<div class="modal fade" id="ModalAddress" role="dialog">
				<div class="modal-dialog">
			      	<!-- Modal content-->
				    <div class="modal-content">
				        <div class="modal-header">
				          	<button type="button" class="close" data-dismiss="modal">&times;</button>
				          	<h4 class="modal-title">New Address</h4>
				        </div>
			        	<div class="modal-body">
			          		<div class="panel-body"> 
								<div class="row" id="form-field">
									<div class="col-md-12">
		                                <div class="form-group address-group" hidden="">
		                                    <label class="col-md-3 control-label"> Address Code </label>
		                                    <div class="col-md-9" id="" hidden>
		                                    	<input type="hidden" class="form-control id" id="id" name="id" value=""/>
		                                        <input type="hidden" class="form-control address-code" name="address-code" id="address-code" value=""/>
		                                    </div>
		                                    <div class="col-md-9" id="">
		                                        <p class="control-label text-left" id="agent_id_disp">
		                                        </p>
		                                    </div>
		                                </div>
		                                <div class="form-group address-group">
		                                    <label class="col-md-3 control-label" id="address_label"> Name </label>
		                                    <div class="col-md-9" id="" >        
		                                        <input type="text" class="form-control street1" name="street1" id="street1" value=""/>
		                                    </div>
		                                </div>
		                                <div class="form-group address-group">
		                                    <label class="col-md-3 control-label" id="address_label"> Street 1 </label>
		                                    <div class="col-md-9" id="" >        
		                                        <input type="text" class="form-control street1" name="street1" id="street1" value=""/>
		                                    </div>
		                                </div>
		                                <div class="form-group address-group">
		                                    <label class="col-md-3 control-label" id="address_label"> Street 2 </label>
		                                    <div class="col-md-9" id="" >        
		                                        <input type="text" class="form-control street2" name="street2" id="street2" value=""/>
		                                    </div>
		                                </div>
		                                <div class="form-group address-group">
		                                    <label class="col-md-3 control-label" id="poscode_label"> Poscode </label>
		                                    <div class="col-md-9" id="">        
		                                        <input type="text" class="form-control poscode" name="poscode" id="poscode" value=""/>
		                                    </div>
		                                </div>
		                                <div class="form-group address-group">
		                                    <label class="col-md-3 control-label" id="city_label"> City </label>
		                                    <div class="col-md-9" id="">        
		                                        <input type="text" class="form-control city" name="city" id="city" value=""/>
		                                    </div>
		                                </div>
		                                <div class="form-group address-group">
		                                    <label class="col-md-3 control-label" id="state_label"> State </label>
		                                    <div class="col-md-9" id="">        
		                                        <input type="text" class="form-control state" name="state" id="state" value=""/>
		                                    </div>
		                                </div>
		                                <div class="form-group address-group">
		                                    <label class="col-md-3 control-label"> Country </label>
		                                    <div class="col-md-9" id="">        
		                                        <input type="text" class="form-control country" name="country" id="country" value=""/>
		                                    </div>
		                                </div>
									</div>
								</div>
							</div>
			        	</div>
			        	<div class="modal-footer" style="position: relative;">
			          		<button type="button" class="btn btn-success save-address">OK</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			        	</div>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
</div>

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
		var name = $(this).data('name');
		noty({
			text: 'Are you sure to remove',
			layout: 'topCenter',
			buttons: [
				{
					addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
					window.location.href = "{{ url('agent/delete_address') }}/"+code;
					$noty.close();
					// window.location.reload();
					}
				},
				{
					addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
						$noty.close();
					}
				}
			]
		})
	});
});


$(document).ready(function(){

    $(".createButton").click(function(){
    	console.log("yyyy")
    	$('#id').val('');
    	$('#address-code').val('');
    	$('agent_id').val('');
		$('#street1').val('');
		$('#street2').val('');
		$('#poscode').val('');
		$('#city').val('');
		$('#state').val('');
		$('#country').val('');

        $("#ModalAddress").modal();
    });

    $(".editbutton").click(function(){

    	var key = $(this).data('code');

    	var data = {!! $data !!};

    	$('#id').val(data[key]['id']);
    	$('#address-code').val(data[key]['address_code']);
		$('#street1').val(data[key]['street1']);
		$('#street2').val(data[key]['street2']);
		$('#poscode').val(data[key]['poscode']);
		$('#city').val(data[key]['city']);
		$('#state').val(data[key]['state']);
		$('#country').val(data[key]['country']);

        $("#ModalAddress").modal();
    });
});

$('.save-address').click(function(){
	
	var id = $('#id').val();
	var address_code = $('#address-code').val();
	var street1 = $('#street1').val();
	var street2 = $('#street2').val();
	var poscode = $('#poscode').val();
	var city = $('#city').val();
	var state = $('#state').val();
	var country = $('#country').val();


	var item = {

		id 			: id,
		address_code: address_code,
		street1 	: street1,
		street2 	: street2,
		poscode 	: poscode,
		city 		: city,
		state 		: state,
		country 	: country 

	};

	var data = {

		_token	: "{!! csrf_token() !!}",
		item 	: item
	};

	$.ajax({

		url 	: "/agent/save_address",
		type 	: "POST",
		data 	: JSON.stringify(data),
		dataType: "json",
		contentType: "application/json",

	}).done(function(response){

		if(response.return.status == "01"){

			window.location.reload();
		}

	}).fail(function(){

	});

	$('#ModalAddress .close').click();
	
});


</script>

@endsection