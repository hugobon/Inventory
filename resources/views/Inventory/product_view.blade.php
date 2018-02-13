@extends('header')
@section('title','View Product')

<?php 
# Create by: Bhaihaqi		2018-02-05
# Modify by: Bhaihaqi		2018-02-13

$formurl = "insert";
if(isset($id) && $id > 0){
	#set update
	$formurl = "update/" . $id;
}
?>
@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li ><a href="{{ url('product/listing') }}">Product Listing</a></li>
	<li class="active">View Product</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	@if(session("info"))
		<div class="row"><div class="col-sm-12">
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				{{ session("info") }}
			</div>
		</div></div>
	@endif
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Product</strong> view </h3>
					<ul class="panel-controls">
					</ul>
					<div class="actions pull-right">
						<a href="{{ url('product/edit/' . $id) }}" class="btn btn-default  btn-sm btn-circle">
					<i class="fa fa-pencil"></i> Edit </a>
					</div>
				</div>
				<div class="panel-body"> 
					<div class="row">
						@if(count($errors) > 0)
							@foreach($errors->all() as $row_error)
								<div class="col-md-12  alert alert-danger">
									<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									{{ $row_error }}
								</div>
							@endforeach
						@endif
					</div>
					<div class="alert alert-danger alert-dismissable alert_modal" hidden>
						already exists
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Product </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Code </label>
								<label class="col-md-9 control-label text-left">{{ isset($code) ? $code : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Type </label>
								<label class="col-md-9 control-label text-left">{{ isset($type) ? $typestr[$type] : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Description </label>
								<label class="col-md-9 control-label text-left">{{ isset($description) ? $description : '' }}</label>
							</div>
							<br /> &nbsp;
							<div class="col-md-12">
								<h3> Promotion </h3>
								<hr />
							</div>
							<div class="form-group promotion">
								<label class="col-md-3 control-label"> Range Date </label>
								
								<div class="col-md-9">
									<div class="col-md-12">
									<label class="col-md-3 control-label"> Start </label>
									<label class="col-md-8 control-label text-left">{{ isset($start_promotion) && !in_array($start_promotion, array('0000-00-00','')) ? date('d/m/Y', strtotime($start_promotion)) : '' }}</label>
									<label class="col-md-3 control-label"> End </label>
									<label class="col-md-8 control-label text-left">{{ isset($end_promotion) && !in_array($end_promotion, array('0000-00-00','')) ? date('d/m/Y', strtotime($end_promotion)) : '' }}</label>

									
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 image" >
							<div class="col-md-12">
								<h3> Picture</h3>
								<hr />
							</div>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Sales Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> West Malaysia </label>
								<label class="col-md-9 control-label text-left"> RM {{ isset($price_wm) ? number_format($price_wm, 2, '.', ',') : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> East Malaysia </label>
								<label class="col-md-9 control-label text-left"> RM {{ isset($price_em) ? number_format($price_em, 2, '.', ',') : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Staff Price </label>
								<label class="col-md-9 control-label text-left"> RM {{ isset($price_staff) ? number_format($price_staff, 2, '.', ',') : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Tax Gst </label>
								<label class="col-md-9 control-label text-left"> RM {{ isset($tax_gst) ? number_format($tax_gst, 2, '.', ',') : '' }}</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Purchasing Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Last Purchase Price </label>
								<label class="col-md-9 control-label text-left"> RM {{ isset($last_purchase) ? number_format($last_purchase, 2, '.', ',') : '' }}</label>
							</div>
							<br /> &nbsp;
							<div class="col-md-12">
								<h3> Inventory </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Stock Quantity  </label>
								<label class="col-md-9 control-label text-left"> {{ isset($quantity) ? number_format($quantity) : '' }}</label>
							</div>
						</div>
					</div>
					<div class="row">
						<br /> &nbsp;
						<div class="col-md-12">
							<hr />
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label"> Created by </label>
								<label class="col-md-9 control-label text-left"> Administrator </label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Created at </label>
								<label class="col-md-9 control-label text-left">{{ isset($created_at) && !in_array($created_at, array('0000-00-00','')) ? date('d/m/Y', strtotime($created_at)) : '' }}</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label"> Updated by </label>
								<label class="col-md-9 control-label text-left"> Administrator </label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Updated at </label>
								<label class="col-md-9 control-label text-left">{{ isset($updated_at) && !in_array($updated_at, array('0000-00-00','')) ? date('d/m/Y', strtotime($updated_at)) : '' }}</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 <!-- END PAGE CONTENT WRAPPER -->
<script type="text/javascript" src="{!! asset('joli/js/plugins/inputmask/jquery.inputmask.bundle.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/bootstrap/bootstrap-file-input.js') !!}"></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/jquery-validation/jquery.validate.js') !!}" ></script> 

<script>
</script>
@endsection