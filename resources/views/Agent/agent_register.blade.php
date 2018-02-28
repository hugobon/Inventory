@include('Agent.js.agent_control')
@include('Agent.css.agent_css')
@extends('header')
@section('title','New Product')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="javascript:;">Home</a></li>                    
	<li class="{{ url('agent') }}">Agent</li>
	<li class="{{ url('agent') }}">Agent Register</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<form class="form-horizontal" method="post" action="{{ url('agent/save') }}">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>Register</strong> Form </h3>
						<ul class="panel-controls">
						</ul>
					</div>
					<div class="panel-body"> 
						<div class="row" id="form-field">
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Personal Information </span> </p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Agent Type</label>
									<div class="col-md-9">        
										<select name="agent_type" id="agent_type" class="form-control agent-type">
											<option value="">Chooese Value</option>
											<option value="Personal">Personal</option>
											<option value="Business">Business</option>
										</select>                         
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Name </label>
									<div class="col-md-9">        
										<input type="text" class="form-control agent-name" name="agent_name" id="agent_name" value="" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Username </label>
									<div class="col-md-9">
										<input type="text" class="form-control agent-username" name="agent_username" id="agent_username" value="" />   
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Date Of Brith </label>
									<div class="col-md-9">
										<input type="date" class="form-control agent-dob" name="agent_dateofbirth" id="agent_dateofbirth" value="" />   
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Geder </label>
									<div class="col-md-9">
										<select name="agent_gender" id="agent_gender" class="form-control agent-gender">
											<option value="">Chooese Value</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>    
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Marital Status </label>
									<div class="col-md-9">
										<select class="form-control agent-mritlstatus" name="agent_marital_status" id="agent_marital_status">
											<option value="">Chooese Value</option>
											<option value="Single">Single</option>
											<option value="Married">Married</option>
											<option value="Divorced">Divorced</option>
										</select>   
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Race </label>
									<div class="col-md-9">
										<select class="form-control agent-race" name="agent_race" id="agent_race">  
											<option value="">Chooese Value</option>
											<option value="Malayu">Malayu</option>
											<option value="Cina">Cina</option>
											<option value="India">India</option>
											<option value="Other">Other</option>
										</select> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> ID Type </label>
									<div class="col-md-9">
										<select name="agent__id_type" id="agent__id_type" class="form-control agent-idtype">
											<option value="">Chooese Value</option>
											<option value="Personal">IC</option>
											<option value="Business">Passport</option>
										</select>   
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Agent ID </label>
									<div class="col-md-9">
										<input type="text" class="form-control agent-id" name="agent_id" id="agent_id" value="" />   
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Upload Image </label>
									<div class="col-md-9">
										<input type="file" class="form-control agent-idphoto" name="agent_photo_id" id="agent_photo_id" value="" />   
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-12">
									<p> </p>
								</div>
								<div class="form-group" id="agent-photo">
									<label class="col-md-3 control-label"> Photo </label>
									<div class="col-md-9">
										<label for="file-input">
										<img id="profile-photo" src="{{ asset('register-photo.png') }}" width="170" height="150"> </label>
										<input type="file" id="file-input" name="agent_profile_photo" onchange="readURL(this);"/>                     
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Contact Info. </span></p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Mobile Tel. </label>
									<div class="col-md-9">
										<input type="number" class="form-control agent-number" name="agent_number" id="agent_number" value="" />                     
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Email </label>
									<div class="col-md-9">
										<input type="email" class="form-control agent-email" name="agent_email" id="agent_email" value="" />                     
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="form-field">
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Address </span></p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Street</label>
									<div class="col-md-9">        
										<input type="text" class="form-control agent-street" name="agent_address_street" id="agent_address_street" value="" />                       
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Poscode </label>
									<div class="col-md-9">        
										<input type="text" class="form-control agent-poscode" name="agent_address_poscode" id="agent_address_poscode" value="" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> City </label>
									<div class="col-md-9">
										<input type="text" class="form-control agent-city" name="agent_address_city" id="agent_address_city" value="" />   
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Country </label>
									<div class="col-md-9">
										<input type="text" class="form-control agent-country" name="agent_address_country" id="agent_address_country" value="" />   
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Bank Account Info. </span></p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Bank Name </label>
									<div class="col-md-9">
										<input type="text" class="form-control agent-bank-name" name="agent_bank_name" id="agent_bank_name" value="" />                     
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Bank Account </label>
									<div class="col-md-9">
										<input type="text" class="form-control agent-bank-name" name="agent_bank_acc_no" id="agent_bank_acc_no" value="" />                     
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Bank Account Name </label>
									<div class="col-md-9">
										<input type="text" class="form-control agent-bank-acc-name" name="agent_bank_acc_name" id="agent_bank_acc_name" value="" />                     
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Bank Account Type </label>
									<div class="col-md-9">
										<input type="text" class="form-control agent-bank-acc-type" name="agent_bank_acc_type" id="agent_bank_acc_type" value="" />                     
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="form-field">
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Delivery Info. </span></p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Delivery Type</label>
									<div class="col-md-9">        
										<select name="agent_delivery_type" class="form-control agent-delivery-type">
											<option value="">Chooese Value</option>
											<option value="Package">Package</option>
											<option value="Checkout">Checkout</option>
										</select>                      
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Payment Type </label>
									<div class="col-md-9">        
										<select name="agent_payment_type" class="form-control agent-payment-type">
											<option value="">Chooese Value</option>
											<option value="Online_Banking">Online Banking</option>
											<option value="Kredit">Kredit</option>
											<option value="Debit">Debit</option>
										</select> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Secqurity Password </label>
									<div class="col-md-9">
										<input type="password" class="form-control agent-sec-pass" name="agent_secqurity_pass" id="agent_secqurity_pass" value="" />   
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Payment Detail </span></p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Payment Type </label>
									<div class="col-md-9"> 
										<select name="agent_payment_type" class="form-control agent-payment-type">
											<option value="">Chooese Value</option>
										</select> 
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="form-field">
							<div class="col-md-6">
								<div class="col-md-12">
									<p><span id="form-title"> Other Info. </span></p>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"> Benifical Name </label>
									<div class="col-md-9">        
										<input type="text" class="form-control agent-benifical-name" name="agent_call_name" id="agent_call_name" value="" />                    
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<a class="btn btn-default" href="{{ url('product/form') }}">Clear Form</a>
						<!-- <input type="button" name="" value="Submit" class="btn btn-primary pull-right" onclick="fn_sumbit_agent_detail()"/>                          -->
						<button class="btn btn-primary pull-right">Submit</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
 <!-- END PAGE CONTENT WRAPPER -->

@endsection