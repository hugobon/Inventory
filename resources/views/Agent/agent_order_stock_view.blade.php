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
				<div class="form-horizontal">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>Register</strong> View </h3>
						<ul class="panel-controls">
							<a href=" {{ url('agent/get_order_stock/12221112/edit') }}" id="edit_button"><span class="fa fa-edit" style="font-size:20px"></span></a>
						</ul>
					</div>
					<div class="panel-body"> 
						<div class="row" id="form-field">
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Agent Configure </span></p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Agent ID </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="agent_id_disp">
											{{ isset($data['agent_id']) ? $data['agent_id'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Country </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="country_disp">
											{{ isset($data['country']) ? $data['country'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Delivery Type </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="delivery_type_disp">
											{{ isset($data['delivery_type']) ? $data['delivery_type'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Address </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="address_disp">
											{{ isset($data['optional']) ? $data['optional'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Poscode </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="poscode_disp">
											{{ isset($data['poscode']) ? $data['poscode'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> City </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="city_disp">
											{{ isset($data['city']) ? $data['city'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group text">
									<label class="col-md-3 control-label"> State </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="state_disp">
											{{ isset($data['state']) ? $data['state'] : '' }}
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection