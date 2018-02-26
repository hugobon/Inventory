@extends('header')
@section('title','View Product')

<?php 
# Create by: Bhaihaqi		2018-02-05
# Modify by: Bhaihaqi		2018-02-13

$wm_gst = $wm_aftergst = $em_gst = $em_aftergst = $staff_gst = $staff_aftergst = 0;
if(isset($id) && $id > 0){
	$wm_gst = $wm_aftergst = $em_gst = $em_aftergst = $staff_gst = $staff_aftergst = 0;
	if($price_wm > 0){
		$wm_gst = ($price_wm / 100) * $gstpercentage;
		$wm_aftergst = $price_wm + $wm_gst;
	}
	if($price_em > 0){
		$em_gst = ($price_em / 100) * $gstpercentage;
		$em_aftergst = $price_em + $em_gst;
	}
	if($price_staff > 0){
		$staff_gst = ($price_staff / 100) * $gstpercentage;
		$staff_aftergst = $price_staff + $staff_gst;
	}
}
?>
@section('content')
<style>
.view-picture{ height: 250px; width: 100%; display: inline-block; position: relative; }
.view-picture img { max-height: 98%; max-width: 98%; width: auto; height: auto; position: absolute;
		top: 0; bottom: 0; left: 0; right: 0; margin: auto; }
</style>
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
						<a href="{{ url('product/form') }}" class="btn btn-default  btn-sm btn-circle" title="Add New Product" >
							<i class="fa fa-plus"></i> New Product </a>
						<a href="{{ url('product/edit/' . $id) }}" class="btn btn-default  btn-sm btn-circle" title="Edit {{ $code .' ('. $description .')' }}" >
							<i class="fa fa-pencil"></i> Edit </a>
					</div>
				</div>
				<div class="panel-body form-horizontal">
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-12">
								<h3> Product </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Code: </label>
								<label class="col-md-9 control-label text-left">{{ isset($code) ? $code : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Type: </label>
								<label class="col-md-9 control-label text-left">{{ isset($type) ? $typestr[$type] : '' }}</label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Description: </label>
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
									<label class="col-md-3 control-label"> Start: </label>
									<label class="col-md-8 control-label text-left">{{ isset($start_promotion) && !in_array($start_promotion, array('0000-00-00','')) ? date('d/m/Y', strtotime($start_promotion)) : ' &nbsp; ' }}</label>
									<label class="col-md-3 control-label"> End: </label>
									<label class="col-md-8 control-label text-left">{{ isset($end_promotion) && !in_array($end_promotion, array('0000-00-00','')) ? date('d/m/Y', strtotime($end_promotion)) : ' &nbsp; ' }}</label>

									
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 image" >
							<div class="col-md-12">
								<h3> Picture</h3>
								<hr />
								<div class="form-group">
									<label class="col-md-1 control-label"></label>
									<div class="col-md-10">
										<div class="form-control view-picture pull-center">
											<?php if($picture_path != null AND $picture_path != ''){ ?>
											<img src="{{ url('storage/' . $picture_path) }}" title="{{ isset($picture_name) ? $picture_name : '' }}" />
											<?php } ?>
										</div>
									</div>							
								</div>
							</div>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-8">
							<h3> Sales Info </h3>
							<hr />
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="col-md-2 text-right" ></th>
												<th class="col-md-2 text-right" >Price</th>
												<th class="col-md-2 text-right" >GST ({{ isset($gstpercentage) ? number_format($gstpercentage) : '0' }}%)</th>
												<th class="col-md-2 text-right" >After GST</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th class="text-right"> West Malaysia </th>
												<td class="text-right"> RM {{ isset($price_wm) ? number_format($price_wm, 2, '.', '') : '' }} </td>
												<td class="text-right"> RM {{ isset($wm_gst) ? number_format($wm_gst, 2, '.', '') : '' }} </td>
												<td class="text-right"> RM {{ isset($wm_aftergst) ? number_format($wm_aftergst, 2, '.', '') : '' }} </td>
											</tr>
											<tr>
												<th class="text-right"> East Malaysia </th>
												<td class="text-right"> RM {{ isset($price_em) ? number_format($price_em, 2, '.', '') : '' }} </td>
												<td class="text-right"> RM {{ isset($em_gst) ? number_format($em_gst, 2, '.', '') : '' }} </td>
												<td class="text-right"> RM {{ isset($em_aftergst) ? number_format($em_aftergst, 2, '.', '') : '' }} </td>
											</tr>
											<tr>
												<th class="text-right"> Staff Price </th>
												<td class="text-right"> RM {{ isset($price_staff) ? number_format($price_staff, 2, '.', '') : '' }} </td>
												<td class="text-right"> RM {{ isset($staff_gst) ? number_format($staff_gst, 2, '.', '') : '' }} </td>
												<td class="text-right"> RM {{ isset($staff_aftergst) ? number_format($staff_aftergst, 2, '.', '') : '' }} </td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>	
						</div>
						<div class="col-md-4">
							<div class="col-md-12">
								<h3> Purchasing Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Last Purchase Price: </label>
								<label class="col-md-6 control-label text-left"> RM {{ isset($last_purchase) ? number_format($last_purchase, 2, '.', ',') : '' }}</label>
							</div>
							<br /> &nbsp;
							<div class="col-md-12">
								<h3> Inventory </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Stock Reminder: </label>
								<label class="col-md-6 control-label text-left"> {{ isset($quantity_min) ? number_format($quantity_min) : '' }} &nbsp; <small>(min quantity)</small></label>
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Stock Quantity: </label>
								<label class="col-md-6 control-label text-left"> {{ isset($quantity) ? number_format($quantity) : '' }}</label>
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
								<label class="col-md-3 control-label"> Created by: </label>
								<label class="col-md-9 control-label text-left"> Administrator </label>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"> Created at: </label>
								<label class="col-md-9 control-label text-left">{{ isset($created_at) && !in_array($created_at, array('0000-00-00','')) ? date('d/m/Y, h:i A', strtotime($created_at)) : '' }}</label>
							</div>
						</div>
						<div class="col-md-6">
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
	</div>
</div>
<script>
</script>
@endsection