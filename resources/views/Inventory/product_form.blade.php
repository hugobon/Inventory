@extends('header')
@section('title','New Product')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="javascript:;">Inventory</a></li>                    
	<li ><a href="javascript:;">Product</a></li>
	<li class="active">Form</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<form class="form-horizontal" method="POST" action="{{ url('product/save') }}" >
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Product</strong> Form </h3>
					<ul class="panel-controls">
					</ul>
				</div>
				<div class="panel-body"> 
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Product </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Code </label>
								<div class="col-md-9">        
									<input type="text" class="form-control product-code" name="code" value="" />                         
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Type </label>
								<div class="col-md-9">        
									<select class="form-control product-type" name="type" >
										<option value=""></option>
										<option value="1"> By Item </option>
										<option value="2"> Package(Long Term)</option>
										<option value="3"> Monthly Promotion </option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Description </label>
								<div class="col-md-9">
									<input type="text" class="form-control product-description" name="description" value="" />   
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Sales Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> West Malaysia </label>
								<div class="col-md-9">
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="form-control product-price_wm" placeholder="0.00" name="price_wm" value="" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> East Malaysia </label>
								<div class="col-md-9">
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="form-control product-price_em" placeholder="0.00" name="price_em" value="" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Staff Price </label>
								<div class="col-md-9">
									<div class="input-group">
										<span class="input-group-addon">RM</span>
										<input type="text" class="form-control product-price_staff" placeholder="0.00" name="price_staff" value="" />
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Promotion </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Range Date </label>
								<div class="col-md-9">
									<div class="col-md-12">
										<div class="input-daterange input-group" id="datepicker">
											<input type="text" class="input-sm form-control start_promotion" name="start_promotion" />
											<span class="input-group-addon">to</span>
											<input type="text" class="input-sm form-control end_promotion" name="end_promotion" />
										</div>
									</div>
									<div class="form-group">
										<small><a href="javascript:;" class="btn btn-default btn-xs"> Reset</a><small>
									<div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<a class="btn btn-default" href="{{ url('product/form') }}">Clear Form</a>                                    
					<button class="btn btn-primary pull-right">Submit</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
 <!-- END PAGE CONTENT WRAPPER -->
<script>
$(function() {
	$('.input-daterange').datepicker({
		format: "dd/mm/yyyy",
		autoclose: true,
		clearBtn: true,
		keyboardNavigation: false,
		todayHighlight: true,
	});
});
</script>
@endsection