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
	.panel-heading{ background-color: #e6e6ff !important; }
	.btn-default{ background-color: #ccccff !important; }
	.btn-default:hover{ background-color: #b3b3ff !important; }
	.bold{ font-weight: bold;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li ><a href="{{ url('product/listing') }}">Product Listing</a></li>
	<li class="active">View Product Package</li>
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
					<h3 class="panel-title"><strong>Product Package</strong> view </h3>
					<ul class="panel-controls">
					</ul>
					<div class="actions pull-right">
						<a href="{{ url('product/package_form') }}" class="btn btn-default  btn-sm btn-circle" title="Add New Product" >
							<i class="fa fa-plus"></i> Product Package</a>
						<a href="{{ url('product/package_edit/' . $id) }}" class="btn btn-default  btn-sm btn-circle" title="Edit {{ $code .' ('. $name .')' }}" >
							<i class="fa fa-pencil"></i> Edit </a>
					</div>
				</div>
				<div class="panel-body form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<h3> Product Package</h3>
							<hr />
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-4 control-label"> Code: </label>
								<div class="col-md-8 control-label text-left">{{ isset($code) ? $code : '' }}</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Name: </label>
								<div class="col-md-8 control-label text-left">{{ isset($name) ? $name : '' }}</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Category: </label>
								<div class="col-md-8 control-label text-left">{{ isset($productcategory['category']) > 0 ? $productcategory['category'] : '' }}</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Weight (g): </label>
								<div class="col-md-8 control-label text-left">{{ isset($weight) ? number_format($weight, 2, '.', '') : '' }}</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-4 control-label"> Status: </label>
								<div class="col-md-8 control-label text-left"><?php echo isset($statusArr[$status]) ? $statusArr[$status] : ''; ?></div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Qty Type: </label>
								<div class="col-md-8 control-label text-left">{{ isset($quantitytype['type']) > 0 ? $quantitytype['type'] : '' }}</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Year: </label>
								<div class="col-md-8 control-label text-left">{{ isset($year) && $year > 1900 ? $year : '' }}, {{ isset($monthArr[$month]) ? $monthArr[$month] : '' }}</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Point: </label>
								<div class="col-md-8 control-label text-left">{{ isset($point) ? $point : '0' }}</div>
							</div>
						</div>
						<br /> &nbsp;
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-2 control-label"> Description: </label>
								<div class="col-md-10 control-label text-left"><?php echo isset($description) ? nl2br(htmlentities($description)) : '' ?></div>
							</div>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-12">
							<h3> Product List </h3>
							<hr />
						</div>
						<div class="col-md-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="col-md-5"> Product</th>
										<th class="col-md-2"> Quantity</th>
										<th class="col-md-4"> Description </th>
									</tr>
								</thead>
								<tbody class="tbody-product">
									@if(isset($product_list) && count($product_list) > 0)
										
										@foreach($product_list->all() as $key => $row)
										<tr class="">
											<td class="text-center">{{ ($key + 1) }}</td>
											<td><a href="{{ url('product/view/' . $row->product_id) }}" 
												title=" View {{ isset($productArr[$row->product_id]) ? $productArr[$row->product_id] : '' }}"
												class="">{{ isset($productArr[$row->product_id]) ? $productArr[$row->product_id] : '' }}</a></td>
											<td>{{ $row->quantity }}</td>
											<td>{{ $row->description }}</td>
										</tr>
										@endforeach
									@else
									<tr class="">
										<td class="text-center" colspan="4"> Product Not Found ! </td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-12">
							<h3> Sales Info </h3>
							<hr />
							<div class="panel-body">
								<div class="table-responsive">
									@if(isset($notforsale) && $notforsale == 1)
										<h4><i style="color: #ff0000;"> &nbsp; &nbsp; <span class="fa fa-check-square-o"></span> &nbsp; Not For Sale </i></h4>
									@endif
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
												<td class="text-right"> {{ isset($price_wm) && $price_wm > 0 ? 'RM ' . number_format($price_wm, 2, '.', '') : '-' }} </td>
												<td class="text-right"> {{ isset($wm_gst) && $wm_gst > 0 ? 'RM ' . number_format($wm_gst, 2, '.', '') : '-' }} </td>
												<td class="text-right"> {{ isset($wm_aftergst) && $wm_aftergst > 0 ? 'RM ' . number_format($wm_aftergst, 2, '.', '') : '-' }} </td>
											</tr>
											<tr>
												<th class="text-right"> East Malaysia </th>
												<td class="text-right"> {{ isset($price_em) && $price_em > 0 ? 'RM ' . number_format($price_em, 2, '.', '') : '-' }} </td>
												<td class="text-right"> {{ isset($em_gst) && $em_gst > 0 ? 'RM ' . number_format($em_gst, 2, '.', '') : '-' }} </td>
												<td class="text-right"> {{ isset($em_aftergst) && $em_aftergst > 0 ? 'RM ' . number_format($em_aftergst, 2, '.', '') : '-' }} </td>
											</tr>
											<tr>
												<th class="text-right"> Staff Price </th>
												<td class="text-right"> {{ isset($price_staff) && $price_staff > 0 ? 'RM ' . number_format($price_staff, 2, '.', '') : '-' }} </td>
												<td class="text-right"> {{ isset($staff_gst) && $staff_gst > 0 ? 'RM ' . number_format($staff_gst, 2, '.', '') : '-' }} </td>
												<td class="text-right"> {{ isset($staff_aftergst) && $staff_aftergst > 0 ? 'RM ' . number_format($staff_aftergst, 2, '.', '') : '-' }} </td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>	
						</div>
						<?php /*
						<div class="col-md-5">
							<div class="col-md-12">
								<h3> Purchasing Info </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Last Purchase Price: </label>
								<div class="col-md-6 control-label text-left"> RM {{ isset($last_purchase) ? number_format($last_purchase, 2, '.', ',') : '' }}</div>
							</div>
							<br /> &nbsp;
							<div class="col-md-12">
								<h3> Inventory </h3>
								<hr />
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Stock Reminder: </label>
								<div class="col-md-6 control-label text-left"> {{ isset($quantity_min) ? number_format($quantity_min) : '' }} &nbsp; <small>(min quantity)</small></div>
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label"> Stock Quantity: </label>
								<div class="col-md-6 control-label text-left"> {{ isset($quantity) ? number_format($quantity) : '' }}</div>
							</div>
						</div>
						*/ ?>
					</div>
					<div class="row">
						<br /> &nbsp;
						<div class="col-md-12">
							<h3> Gallery <a href="{{ url('product/package_edit/' . $id . '/1') }}" class="btn btn-default  pull-right btn-sm btn-circle" title="Edit Gallery {{ $code .' ('. $description .')' }}" >
									<i class="fa fa-pencil"></i> Edit </a></h3>
								
							<hr />
						</div>
						<div class="col-md-12">
							<div class="gallery text-left" id="links" style="min-height:100px;" >
								@if(count($imageArr) > 0)
									@foreach($imageArr->all() as $key => $row)
										@if(trim($row->path) != '')
											<a class="gallery-item" href="{{ url('storage/' . $row->path) }}" title="{{ $row->description != '' ? $row->description  : $code . ' (' . $description . ')' }}" data-gallery>
												<div class="image">                              
													<img src="{{ url('storage/' . $row->path) }}" alt="{{ $row->description != '' ? $row->description  : $code . ' (' . $description . ')' }}"/>                                        
													<ul class="gallery-item-controls">
													</ul>                                                                    
												</div>
												<div class="meta">
													<strong>{{ $row->description != '' ? $row->description  : $code . ' (' . $description . ')' }}</strong>
												</div>                                
											</a>
										@endif
									@endforeach
								@else	
									No Image found
								@endif
							</div>
						</div>
					</div>
					<br /> &nbsp;
					<div class="row">
						<div class="col-md-12">
							<h3> Product Promotion </h3>
							<hr />
						</div>
						<div class="col-md-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th ></th>
										<th >Id</th>
										<th class="col-md-4"> Description </th>
										<th class="col-md-6"> Date Range </th>
										<th class="col-md-1"> Status </th>
									</tr>
								</thead>
								<tbody class="tbody-product">
									@if(isset($promotion_list) && count($promotion_list) > 0)
										
										@foreach($promotion_list->all() as $key => $row)
										<tr class="">
											<td>{{ $key + 1 }}</td>
											<td>{{ $row->id }}</td>
											<td><a href="{{ url('product/promotion/view/' . $row->id) }}" 
												title=" View {{ $row->code.' ('.$row->description.')' }}"
												class="">{{ $row->description }}</a></td>
											<td>{{ date('d/m/Y h:i A', strtotime($row->start)) . ' - '. date('d/m/Y h:i A', strtotime($row->end)) }}</td>
											<td><?php echo $row->status == 1 ? '<span class="text-success bold"> On </span>' : ($row->status == 0 ? '<span class="text-danger bold"> Off </span>' : 'Unknown'); ?></td>
										
										</tr>
										@endforeach
									@else
									<tr class="">
										<td class="text-center" colspan="5"> This product still has no promotion yet </td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<br /> &nbsp;
						<div class="col-md-12">
							<hr />
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-4 control-label"> Created by: </label>
								<div class="col-md-8 control-label text-left">{{ $created_by_name }}</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Created at: </label>
								<div class="col-md-8 control-label text-left">{{ isset($created_at) && !in_array($created_at, array('0000-00-00','')) ? date('d/m/Y, h:i A', strtotime($created_at)) : '' }}</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-4 control-label"> Updated by: </label>
								<div class="col-md-8 control-label text-left">{{ $updated_by_name }}</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"> Updated at: </label>
								<div class="col-md-8 control-label text-left">{{ isset($updated_at) && !in_array($updated_at, array('0000-00-00','')) ? date('d/m/Y, h:i A', strtotime($updated_at)) : '' }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- BLUEIMP GALLERY -->
		<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
			<div class="slides"></div>
			<h3 class="title"></h3>
			<a class="prev">‹</a>
			<a class="next">›</a>
			<a class="close">×</a>
			<a class="play-pause"></a>
			<ol class="indicator"></ol>
		</div>      
		<!-- END BLUEIMP GALLERY -->
	</div>
</div>
<script type="text/javascript" src="{!! asset('joli/js/plugins/blueimp/jquery.blueimp-gallery.min.js') !!}"></script>
<script>
</script>
@endsection