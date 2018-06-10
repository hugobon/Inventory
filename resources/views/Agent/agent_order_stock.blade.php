@extends('header')
@include('Agent.js.agent_control')
@include('Agent.css.agent_css')
@section('title','Config')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="javascript:;">Home</a></li>                    
	<li class="{{ url('agent') }}">Agent</li>
	<li class="{{ url('agent') }}">Config</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<form class="form-horizontal" method="post" action="{{ url('agent/save_agent_order_stock') }}">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>Shipment & Billing </strong> Edit </h3>
						<ul class="panel-controls">
							<a href="{{ url('agent/get_order_stock/display') }}/{{ Auth::user()->id }}" id="display_button"><span class="fa fa-eye" style="font-size:20px"></span></a>
						</ul>
					</div>
					<div class="panel-body"> 
						<div class="row" id="form-field">
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Delivery Option </span> </p>
								</div>
								<div class="form-group" hidden="">
									<label class="col-md-3 control-label"> Agent ID </label>
									<div class="col-md-9" id="" hidden>        
										<input type="text" class="form-control agent-id" name="agent_id" id="agent_id" value="{{ isset($data['agent_id']) ? $data['agent_id'] : '' }}"/>
									</div>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="agent_id_disp">
											{{ isset($data['agent_id']) ? $data['agent_id'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Country </label>
									<div class="col-md-9" id="">        
										<input type="text" type="text" class="form-control country" name="country" id="country" value="{{ isset($data['country']) ? $data['country'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Delivery Type </label>
									<div class="col-md-9" id="">        
										<select type="text" class="form-control delivery-type" name="delivery_type" id="delivery_type" onclick="fn_change_field()" value="{{ $data['delivery_type'] }}">
											<option value="" selected disabled hidden>Chose Value</option>
											<option value="01" {{ isset($data['delivery_type']) && $data['delivery_type'] == "01" ? "selected" : "" }}>Same Address</option>
											<option value="02"  {{ isset($data['delivery_type']) && $data['delivery_type'] == "02" ? "selected" : "" }}>Different Address</option>
											<option value="03"  {{ isset($data['delivery_type']) && $data['delivery_type'] == "03" ? "selected" : "" }}>Self Collect</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="poscode_label"> Name </label>
									<div class="col-md-9" id="">        
										<input type="text" class="form-control name" name="name" id="name" value=""/>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Shipment Address </span> </p>
								</div>
								<div class="form-group" hidden="">
									<label class="col-md-3 control-label"> Agent ID </label>
									<div class="col-md-9" id="" hidden>        
										<input type="text" class="form-control agent-id" name="agent_id" id="agent_id" value="{{ isset($data['agent_id']) ? $data['agent_id'] : '' }}"/>
									</div>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="agent_id_disp">
											{{ isset($data['agent_id']) ? $data['agent_id'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Country </label>
									<div class="col-md-9" id="">        
										<input type="text" type="text" class="form-control country" name="country" id="country" value="{{ isset($data['country']) ? $data['country'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Delivery Type </label>
									<div class="col-md-9" id="">        
										<select type="text" class="form-control delivery-type" name="delivery_type" id="delivery_type" onclick="fn_change_field()" value="{{ $data['delivery_type'] }}">
											<option value="" selected disabled hidden>Chose Value</option>
											<option value="01" {{ isset($data['delivery_type']) && $data['delivery_type'] == "01" ? "selected" : "" }}>Same Address</option>
											<option value="02"  {{ isset($data['delivery_type']) && $data['delivery_type'] == "02" ? "selected" : "" }}>Different Address</option>
											<option value="03"  {{ isset($data['delivery_type']) && $data['delivery_type'] == "03" ? "selected" : "" }}>Self Collect</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="address_label"> Address </label>
									<div class="col-md-9" id="" >        
										<input type="text" class="form-control address" name="address" id="address" value="{{ isset($data['optional']) ? $data['optional'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="poscode_label"> Poscode </label>
									<div class="col-md-9" id="">        
										<input type="text" class="form-control poscode" name="poscode" id="poscode" value="{{ isset($data['poscode']) ? $data['poscode'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="city_label"> City </label>
									<div class="col-md-9" id="">        
										<input type="text" class="form-control city" name="city" id="city" value="{{ isset($data['city']) ? $data['city'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="state_label"> State </label>
									<div class="col-md-9" id="">        
										<input type="text" class="form-control state" name="state" id="state" value="{{ isset($data['state']) ? $data['state'] : '' }}" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Billing Address </span> </p>
								</div>
								<div class="form-group" hidden="">
									<label class="col-md-3 control-label"> Agent ID </label>
									<div class="col-md-9" id="" hidden>        
										<input type="text" class="form-control agent-id" name="agent_id" id="agent_id" value="{{ isset($data['agent_id']) ? $data['agent_id'] : '' }}"/>
									</div>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="agent_id_disp">
											{{ isset($data['agent_id']) ? $data['agent_id'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Country </label>
									<div class="col-md-9" id="">        
										<input type="text" type="text" class="form-control country" name="country" id="country" value="{{ isset($data['country']) ? $data['country'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Delivery Type </label>
									<div class="col-md-9" id="">        
										<select type="text" class="form-control delivery-type" name="delivery_type" id="delivery_type" onclick="fn_change_field()" value="{{ $data['delivery_type'] }}">
											<option value="" selected disabled hidden>Chose Value</option>
											<option value="01" {{ isset($data['delivery_type']) && $data['delivery_type'] == "01" ? "selected" : "" }}>Same Address</option>
											<option value="02"  {{ isset($data['delivery_type']) && $data['delivery_type'] == "02" ? "selected" : "" }}>Different Address</option>
											<option value="03"  {{ isset($data['delivery_type']) && $data['delivery_type'] == "03" ? "selected" : "" }}>Self Collect</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="address_label"> Address </label>
									<div class="col-md-9" id="" >        
										<input type="text" class="form-control address" name="address" id="address" value="{{ isset($data['optional']) ? $data['optional'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="poscode_label"> Poscode </label>
									<div class="col-md-9" id="">        
										<input type="text" class="form-control poscode" name="poscode" id="poscode" value="{{ isset($data['poscode']) ? $data['poscode'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="city_label"> City </label>
									<div class="col-md-9" id="">        
										<input type="text" class="form-control city" name="city" id="city" value="{{ isset($data['city']) ? $data['city'] : '' }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" id="state_label"> State </label>
									<div class="col-md-9" id="">        
										<input type="text" class="form-control state" name="state" id="state" value="{{ isset($data['state']) ? $data['state'] : '' }}" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<a class="btn btn-default" id="clear_button" href="javascript:;">Clear Form</a>
						<!-- <input type="button" name="" value="Submit" class="btn btn-primary pull-right" onclick="fn_sumbit_agent_detail()"/>                          -->
						<button type="submit" class="btn btn-primary pull-right" id="submit_button">Submit</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function(){

		fn_change_field();
	});
</script>

@endsection