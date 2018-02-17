@extends('header')
@section('title','Product Listing')

@section('content')
<style>
	select{cursor:pointer;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('product/listing') }}">Product Listing</a></li>
</ul>
<!-- END BREADCRUMB -->                       

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	 <!-- START RESPONSIVE TABLES -->
	@if(session("info"))
		<div class="row"><div class="col-sm-12">
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				{{ session("info") }}
			</div>
		</div></div>
	@endif
	@if(session("errorid"))
		<div class="row"><div class="col-sm-12">
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				{{ session("errorid") }}
			</div>
		</div></div>
	@endif
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title">Product Listing</h3>
					<div class="actions pull-right">
						<a href="{{ url('product/form') }}" class="btn btn-default  btn-sm btn-circle" title="Add New Product" >
					<i class="fa fa-plus"></i> New Product </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<form id="form_search" class="form-horizontal" method="POST" action="{{ url('product/form_search') }}" >
						{{ csrf_field() }}
						<div class="panel-body">
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label class="col-md-4 control-label"> Search </label>
										<div class="col-md-8">        
											<input type="text" class="form-control product-code" name="search" 
											placeholder=" Code / Description " value="{{ isset($search) ? $search : '' }}" />									
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label class="col-md-4 control-label"> Type </label>
										<div class="col-md-8">        
											<select class="form-control product-type" name="type" >
												<option value=""> All </option>
												<option value="1" {{ isset($type) && $type == 1 ? "selected" : "" }}> By Item </option>
												<option value="2" {{ isset($type) && $type == 2 ? "selected" : "" }}> Package(Long Term)</option>
												<option value="3" {{ isset($type) && $type == 3 ? "selected" : "" }}> Monthly Promotion </option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
								<div class="col-md-1">
									<a href="{{ url('product/listing') }}" class="btn btn-danger">Reset</a>
								</div>
							</div>
						</div>
					</form>
					<div class="panel-body">
					&nbsp; Total Product: <b>{{ $countproduct }}</b>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions">
							<thead>
								<tr>
									<th ></th>
									<th >Id</th>
									<th class="col-md-3">Code</th>
									<th class="col-md-4">Description</th>
									<th class="col-md-3">Type</th>
									<th ></th>
									<th ></th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
							@if(count($productArr) > 0)
								
								@foreach($productArr->all() as $key => $row)
									<?php
										$rowarr = array('deleteid' => $row->id,'search' => Request::segment(3));
										$base64data = trim(base64_encode(serialize($rowarr)), "=.");
									?>
									<tr>
										<td>{{ $key + $productArr->firstItem() }}</td>
										<td>{{ $row->id }}</td>
										<td>{{ $row->code }}</td>
										<td>{{ $row->description }}</td>
										<td>{{ isset($typeArr[$row->type]) ? $typeArr[$row->type] : '' }}</td>
										<td>
											<a href="{{ url('product/view/' . $row->id) }}" 
											title=" View {{ $row->code.' ('.$row->description.')' }}"
											class="btn btn-info btn-rounded"><span class="fa fa-eye"></span></a>
										</td>
										<td>
											<a href="{{ url('product/edit/' . $row->id) }}" 
											title=" Edit {{ $row->code.' ('.$row->description.')' }}"
											class="btn btn-primary btn-rounded" ><span class="fa fa-edit"></span></a>
										</td>
										<td>
											<a href="javascript:;" data-base64="{{ $base64data }}" data-code="{{ $row->code }}" data-description="{{ $row->description }}"
											title=" Remove {{ $row->code.' ('.$row->description.')' }}"
											class="btn btn-danger btn-rounded confirm-delete" ><span class="glyphicon glyphicon-trash"></span></a>
										</td>
									</tr>
								@endforeach
							@else
							<tr>
								<td colspan="9" class="text-center"> No Data Found <br />
								<a href="{{ url('product/form') }}"><span class="fa fa-plus"></span> Add new product</a></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $productArr->links() }}
					</div>
				</div>
			</div>                                                

		</div>
	</div>
	<!-- END RESPONSIVE TABLES -->

</div>
<!-- END PAGE CONTENT WRAPPER -->  
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/jquery.noty.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topCenter.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topLeft.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topRight.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/themes/default.js') !!}" ></script>

<script>
$(function() {
	$('.table').on('click', '.confirm-delete', function(){
		var base64data = $(this).data('base64');
		var code = $(this).data('code');
		var description = $(this).data('description');
		noty({
			text: 'Are you sure to remove <br /> ' + code + ' ( ' + description + ' ) ?',
			layout: 'topRight',
			buttons: [
					{addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
						$noty.close();
						window.location.href = "{{ url('product/delete') }}/" + base64data;
					}
					},
					{addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
						$noty.close();
						}
					}
				]
		})
	});
});
</script>
@endsection