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
							<a href=" {{ url('agent/get_order_stock/edit') }}/{{ Auth::user()->id }}" id="edit_button"><span class="fa fa-edit" style="font-size:20px"></span></a>
						</ul>
					</div>
					<div class="panel-body"> 
						<div class="row" id="form-field">
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Agent Configure </span></p>
								</div>
								<!-- <div class="form-group">
									<label class="col-md-3 control-label"> Agent ID </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="agent_id_disp">
											{{ isset($data['agent_id']) ? $data['agent_id'] : '' }}
										</p>
									</div>
								</div> -->
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
											{{ isset($data['delivery_type']) ? $data['delivery_type_desc'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group" id="address_disp">
									<label class="col-md-3 control-label"> Address </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="">
											{{ isset($data['optional']) ? $data['optional'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group" id="poscode_disp">
									<label class="col-md-3 control-label"> Poscode </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="">
											{{ isset($data['poscode']) ? $data['poscode'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group" id="city_disp">
									<label class="col-md-3 control-label"> City </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="">
											{{ isset($data['city']) ? $data['city'] : '' }}
										</p>
									</div>
								</div>
								<div class="form-group text" id="state_disp">
									<label class="col-md-3 control-label"> State </label>
									<div class="col-md-9" id="">
										<p class="control-label text-left" id="">
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

<script type="text/javascript">
	
	$(document).ready(function(){


		if({{ $data['delivery_type'] }} == "01" || {{ $data['delivery_type'] }}  == "02"){

			$("#address_disp").show();
			$("#poscode_disp").show();
			$("#city_disp").show();
			$("#state_disp").show();
		}

		else{
			$("#address_disp").hide();
			$("#poscode_disp").hide();
			$("#city_disp").hide();
			$("#state_disp").hide();
		}
	});

</script>
@endsection