@extends('header')
@section('title','New Product')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="javascript:;">Inventory</a></li>                    
	<li class="{{ url('product') }}">Product</li>
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
								<p> Product </p>
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
								<p> Sales Info </p>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Code </label>
								<div class="col-md-9">                        
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Type </label>
								<div class="col-md-9">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Description </label>
								<div class="col-md-9">                         
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

@endsection