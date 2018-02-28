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
						<h3 class="panel-title"><strong>Register</strong> Form </h3>
						<ul class="panel-controls">
							<a href="javascript:;" onclick="fn_display_mode('display')"><span class="fa fa-edit" style="font-size:20px"></span></a>
						</ul>
					</div>
					<div class="panel-body"> 
						<div class="row" id="form-field">
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Agent Configure </span> </p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Agent ID </label>
									<div class="col-md-9">        
										<input type="text" class="form-control agent-id" name="agent_id" id="agent_id" value="{{ $data['agent_id'] }}" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Country </label>
									<div class="col-md-9">        
										<input type="text" class="form-control country" name="country" id="country" value="{{ $data['country'] }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Delivery Type </label>
									<div class="col-md-9">        
										<select class="form-control delivery-type" name="delivery_type" id="delivery_type" onclick="fn_change_field()" value="{{ $data['delivery_type'] }}">
											<option value="" selected disabled hidden>Chose Value</option>
											<option value="same_adds">Same Address</option>
											<option value="different_adds">Different Address</option>
											<option value="self_collect">Self Collect</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"></label>
									<div class="col-md-9">        
										<input class="form-control optional" name="optional" id="optional" value="{{ $data['optional'] }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Poscode </label>
									<div class="col-md-9">        
										<input class="form-control poscode" name="poscode" id="poscode" value="{{ $data['poscode'] }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> City </label>
									<div class="col-md-9">        
										<input class="form-control city" name="city" id="city" value="{{ $data['city'] }}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> State </label>
									<div class="col-md-9">        
										<input class="form-control state" name="state" id="state" value="{{ $data['state'] }}" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<a class="btn btn-default" href="javascript:;">Clear Form</a>
						<!-- <input type="button" name="" value="Submit" class="btn btn-primary pull-right" onclick="fn_sumbit_agent_detail()"/>                          -->
						<button class="btn btn-primary pull-right">Submit</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection