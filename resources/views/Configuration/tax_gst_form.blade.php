@extends('header')
@section('title','Config - Tax GST')

<?php 
# Create by: Bhaihaqi		2018-02-16
# Modify by: Bhaihaqi		2018-02-17
?>
@section('content')
<style>
.mask_number{max-width:150px;}
.required{ color: #ff0000;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li class="active" ><a href="{{ url('configuration/gst') }}">Config - Tax GST</a></li>
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
	@if(count($errors) > 0)
		@foreach($errors->all() as $row_error)
			<div class="row">
				<div class="col-md-12  alert alert-danger">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					{{ $row_error }}
				</div>
			</div>
		@endforeach
	@endif
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<form id="submit_form" class="form-horizontal" method="POST" action="{{ url('configuration/gst/update') }}" >
					{{ csrf_field() }}
				<div class="panel-heading">
					<h3 class="panel-title"><strong>GST</strong> Form </h3>
					<ul class="panel-controls">
					</ul>
					<div class="actions pull-right">
						<a href="{{ url('configuration/gst') }}" class="btn btn-default  btn-sm btn-circle" title="View GST" >
							<i class="fa fa-eye"></i> View </a>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-3 control-label"> Code <span class="required">*</span></label>
								<div class="col-md-9">								
									<div class="form-control ">{{ isset($code) ? strtoupper($code) : '' }}</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Percentage <span class="required">*</span></label>
								<div class="col-md-9">        
									<input type="text" class="form-control gst-percent mask_number" name="percent" value="{{ isset($percent) ? strtoupper($percent) : '' }}" />  								
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Remarks </label>
								<div class="col-md-9">        
									<input type="text" class="form-control gst-remarks" name="remarks" value="{{ isset($remarks) ? strtoupper($remarks) : '' }}" />  								
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<a class="btn btn-default" href="{{ url('configuration/gst/form') }}">Reset</a>                                    
					<button type="submit" class="btn btn-primary pull-right">Submit</button>
				</div>
				</form>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
<script type="text/javascript" src="{!! asset('joli/js/plugins/inputmask/jquery.inputmask.bundle.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/jquery-validation/jquery.validate.js') !!}" ></script> 
<script>
var jvalidate = $("#submit_form").validate({
	errorPlacement: function(error,element) { return true;},
	ignore: [],
	rules: { percent: { required: true,},}
});
$(function(){
	$(".mask_number").inputmask({
		"mask": "9",
		"repeat": 2,
		'rightAlign': true,
		"greedy": false
	});
});
</script>
@endsection