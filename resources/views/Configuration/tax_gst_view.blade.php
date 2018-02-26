@extends('header')
@section('title','Tax GST')

<?php 
# Create by: Bhaihaqi		2018-02-16
# Modify by: Bhaihaqi		2018-02-17
?>
@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li class="active" ><a href="{{ url('configuration/gst') }}">Tax GST</a></li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	@if(session("info"))
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-sm-6">
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					{{ session("info") }}
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	@endif
		
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>GST</strong> View </h3>
					<ul class="panel-controls">
					</ul>
					<div class="actions pull-right">
						<a href="{{ url('configuration/gst/form') }}" class="btn btn-default  btn-sm btn-circle" title="Edit GST" >
							<i class="fa fa-pencil"></i> Edit </a>
					</div>
				</div>
				<div class="panel-body form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-3 control-label"> Code: </label>
								<label class="col-md-9 control-label text-left">{{ isset($code) ? strtoupper($code) : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Percentage: </label>
								<label class="col-md-9 control-label text-left">{{ isset($percent) ? strtoupper($percent) : '' }} %</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Remarks: </label>
								<label class="col-md-9 control-label text-left">{{ isset($remarks) ? $remarks : '' }}</label>
							</div>
						</div>
						<br /> &nbsp;
						<div class="col-md-12">
							<hr />
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-3 control-label"> Created by: </label>
								<label class="col-md-9 control-label text-left"> Administrator </label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Created at: </label>
								<label class="col-md-9 control-label text-left">{{ isset($created_at) && !in_array($created_at, array('0000-00-00','')) ? date('d/m/Y, h:i A', strtotime($created_at)) : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Updated by: </label>
								<label class="col-md-9 control-label text-left"> Administrator </label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Updated at: </label>
								<label class="col-md-9 control-label text-left">{{ isset($updated_at) && !in_array($updated_at, array('0000-00-00','')) ? date('d/m/Y, h:i A', strtotime($updated_at)) : '' }}</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
<script>
</script>
@endsection