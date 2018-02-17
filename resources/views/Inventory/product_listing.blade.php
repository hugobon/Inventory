@extends('header')
@section('title','Product Listing')

@section('content')
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
				</div>
				<div class="panel-body panel-body-table">
					&nbsp; Total Product: <b>{{ $countproduct }}</b>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions">
							<thead>
								<tr>
									<th ></th>
									<th >Id</th>
									<th class="col-md-2">Code</th>
									<th class="col-md-3">Type</th>
									<th class="col-md-4">Description</th>
									<th class="col-md-1">Status</th>
									<th ></th>
									<th ></th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
							@if(count($productArr) > 0)
								
								@foreach($productArr->all() as $row)
									<?php 
										$startcount++;
										$rowarr = array('deleteid' => $row->id,'code' => $row->code,'description' => $row->description);
										$base64data = trim(base64_encode(serialize($rowarr)), "=.");
									?>
									<tr>
										<td>{{ $startcount }}</td>
										<td>{{ $row->id }}</td>
										<td>{{ $row->code }}</td>
										<td>{{ $typeArr[$row->type] }}</td>
										<td>{{ $row->description }}</td>
										<td>{{ $row->status }}</td>
										<td>
											<a href="{{ url('product/view/' . $row->id) }}" class="btn btn-info btn-rounded"><span class="fa fa-eye"></span></a>
										</td>
										<td>
											<a href="{{ url('product/edit/' . $row->id) }}" class="btn btn-primary btn-rounded" ><span class="fa fa-edit"></span></a>
										</td>
										<td>
											<a href="javascript:;" data-base64="{{ $base64data }}" data-code="{{ $row->code }}" data-description="{{ $row->description }}"
											class="btn btn-danger btn-rounded confirm-delete" ><span class="glyphicon glyphicon-trash"></span></a>
										</td>
									</tr>
								@endforeach
							@else
							<tr>
								<td colspan="9" class="text-center"> No Data Found {{ url('product/delete/' . $base64data ) }}<br />
								<a href="{{ url('product/form') }}"><span class="fa fa-plus"></span> Add new product</a></td>
							</tr>
							@endif
							</tbody>
						</table>
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
			text: 'Are you sure to delete ' + code + ' ( ' + description + ' ) ?',
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