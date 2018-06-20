@extends('header')
@section('title','Config - Product Category')

@section('content')
<style>
select{cursor:pointer;}
.required{ color: #ff0000;}
.bold{ font-weight: bold;}
</style>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('configuration/productcategory') }}">Config - Product Category</a></li>
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
					<h3 class="panel-title">Configuration - Product Category Listing</h3>
					<div class="actions pull-right">
						<a href="javascript:;" class="btn btn-default  btn-sm btn-circle addnewcategory" title="Add New Product Category" >
					<i class="fa fa-plus"></i> New Product Category </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<form id="form_search" class="form-horizontal" method="POST" action="{{ url('configuration/productcategory/form_search') }}" >
						{{ csrf_field() }}
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label"> Search </label>
										<div class="col-md-9">        
											<input type="text" class="form-control category-search" name="search" 
											placeholder=" Category / Remarks " value="{{ isset($search) ? $search : '' }}" />									
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-md-4 control-label"> Status </label>
										<div class="col-md-8">        
											<select class="form-control category-status" name="search_status" >
												<option value=""> All </option>
												<option value="1" {{ isset($search_status) && $search_status == '1' ? "selected" : "" }}> Active </option>
												<option value="0" {{ isset($search_status) && $search_status == '0' ? "selected" : "" }}> Inactive </option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
								<div class="col-md-1">
									<a href="{{ url('configuration/productcategory') }}" class="btn btn-danger">Reset</a>
								</div>
							</div>
						</div>
					</form>
					<div class="panel-body">
					&nbsp; Total Product Category: <b>{{ $countcategory }}</b>
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th ></th>
									<th class="text-center">Id</th>
									<th class="col-md-3">Product Category</th>
									<th class="col-md-4">Remarks</th>
									<th class="col-md-2 text-center">Status</th>
									<th class="col-md-2">Create at</th>
									<th ></th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
							@if(count($categoryArr) > 0)
								
								@foreach($categoryArr->all() as $key => $row)
									<?php
										$rowarr = array('selectid' => $row->id,'search' => Request::segment(4));
										$base64data = trim(base64_encode(serialize($rowarr)), "=.");
									?>
									<tr>
										<td class="text-center">{{ $key + $categoryArr->firstItem() }}</td>
										<td class="text-center">{{ $row->id }}</td>
										<td >{{ $row->category }}</td>
										<td>{{ $row->remarks }}</td>										
										<td class="text-center"><?php echo isset($status[$row->status]) ? $status[$row->status] : 'Active'; ?></td>
										<td>{{ !in_array($row->created_at, array('0000-00-00','','null')) ? date('d/m/Y, h:i A', strtotime($row->created_at)) : '' }}</td>
										<td class="text-center">
											<a href="javascript:;" data-base64="{{ $base64data }}" data-category="{{ $row->category }}"
												data-remarks="{{ $row->remarks }}" data-status="{{ $row->status }}" 
											title=" Edit {{ $row->category }}"
											class="editcategory" ><span class="fa fa-edit text-info"></span></a>
										</td>
										<td class="text-center">
											<a href="javascript:;" data-base64="{{ $base64data }}" data-category="{{ $row->category }}"
											title=" Remove {{ $row->category }}"
											class="confirm-delete" ><span class="glyphicon glyphicon-trash text-danger"></span></a>
										</td>
									</tr>
								@endforeach
							@else
							<tr>
								<td colspan="9" class="text-center"> No Data Found <br />
								<a href="javascript:;" class="addnewcategory"><span class="fa fa-plus"></span> New Product Category</a></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					{{ $categoryArr->links() }}
					</div>
				</div>
			</div>                                                

		</div>
	</div>
	<!-- END RESPONSIVE TABLES -->
	
	<!-- Modal -->
	<div class="modal fade" id="categoryModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Configuration - Product Category Form</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<form id="submit_form" class="form-horizontal" method="POST" action="{{ url('configuration/productcategory/save') }}" >
								{{ csrf_field() }}
								<input type="hidden" class="form-control base64" name="base64" value="" />
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Product Category <span class="required">*</span></label>
										<div class="col-md-9">								
											<input type="text" class="form-control category" name="category" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Remarks </label>
										<div class="col-md-9">        
											<input type="text" class="form-control remarks" name="remarks" value="" />
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"> Status </label>
										<div class="col-md-9">        
											<select class="form-control status" name="status" >
												<option value="1" > Active </option>
												<option value="0" > Inactive </option>
											</select>
										</div>
									</div>
								</div>
								<br /> &nbsp;
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-3 control-label"></label>
										<div class="col-md-9">        
											<button type="submit" class="btn btn-primary submit-button">Submit</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- END PAGE CONTENT WRAPPER -->  
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/jquery.noty.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topCenter.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topLeft.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/layouts/topRight.js') !!}" ></script>
<script type='text/javascript' src="{!! asset('joli/js/plugins/noty/themes/default.js') !!}" ></script>
<script type="text/javascript" src="{!! asset('joli/js/plugins/jquery-validation/jquery.validate.js') !!}" ></script> 
<script>
var jvalidate = $("#submit_form").validate({
	errorPlacement: function(error,element) { return true;},
	ignore: [],
	rules: { category: { required: true,},}
});
$(function() {
	$('.table').on('click', '.confirm-delete', function(){
		var base64data = $(this).data('base64');
		var category = $(this).data('category');
		noty({
			text: 'Are you sure to remove <br /> ' + category + ' ?',
			layout: 'topRight',
			buttons: [
					{addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
						$noty.close();
						window.location.href = "{{ url('configuration/productcategory/delete') }}/" + base64data;
					}
					},
					{addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
						$noty.close();
						}
					}
				]
		})
	});
	
	$('body').on('click', '.addnewcategory', function(){
		// set new 
		$('#categoryModal').find('.base64').val('');
		$('#categoryModal').find('.category').val('');
		$('#categoryModal').find('.remarks').val('');
		$('#categoryModal').find('.operator').val('');
		$('#categoryModal').find('.status').val('1');
		$('#categoryModal').find('.submit-button').html('Submit');
		
		$('#categoryModal').modal('show');
	});
	
	$('body').on('click', '.editcategory', function(){
		$('#categoryModal').find('.base64').val($(this).data('base64'));
		$('#categoryModal').find('.category').val($(this).data('category'));
		$('#categoryModal').find('.operator').val($(this).data('operator'));
		$('#categoryModal').find('.remarks').val($(this).data('remarks'));
		$('#categoryModal').find('.status').val($(this).data('status'));
		$('#categoryModal').find('.submit-button').html('Save');
		
		$('#categoryModal').modal('show');
	});
});
</script>
@endsection