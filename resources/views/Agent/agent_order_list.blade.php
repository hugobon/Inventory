@extends('header')
@include('Agent.js.agent_control')
@include('Agent.css.agent_css')
@section('title','Config')
@section('content')

<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li class="{{ url('agent') }}">Agent</li>
	<li class="{{ url('agent') }}">Order Listing</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	 <!-- START RESPONSIVE TABLES -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title">Order Listing</h3>
					<div class="actions pull-right" hidden>
						<a href="javascript:;" class="btn btn-default  btn-sm btn-circle createButton" title="Add New Address" id="createButton">
							<i class="fa fa-plus"></i> Address </a>
					</div>
				</div>
				<div class="panel-body panel-body-table">
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions table-order-list">
							<thead>
								<tr>
									<th>No.</th>
									<th hidden>Id</th>
									<th class="col-md-2">Order No.</th>
									<th class="col-md-2">Invoice No.</th>
									<th class="col-md-1">Total Items</th>
									<th class="col-md-2">Total Price</th>
									<th class="col-md-1">Delivery Type</th>
									<th class="col-md-2">Purchase Date</th>
									<th class="col-md-1">Status</th>
									<th class="col-md-1">View Status</th>
									<th hidden></th>
								</tr>
							</thead>
							<tbody>
							@if(count($data) > 0)
							@foreach($data as $key => $value)
							<tr>
								<td> {{ $key+1 }} </td>
								<td hidden> {{ $value->agent_id }}</td>
								<td class="col-md-2"> {{ $value->order_no }}</td>
								<td class="col-md-2"> {{ $value->invoice_no }}</td>
								<td class="col-md-1"> {{ $value->total_items }}</td>
								<td class="col-md-2"> RM{{ $value->total_price }}</td>
								<td class="col-md-1"> {{ $value->type_description }}</td>
								<td class="col-md-2"> {{ $value->purchase_date }}</td>
								<td class="col-md-1"> {{ $value->description }}</td>
								<td class="col-md-1 text-center">
									 <a href="javascript:;" title="view status" data-code="{{ $value->order_no }}" class="btn btn-primary btn-rounded view-status">
									 	<span class="fa fa-eye"></span></a>
								</td>
								<td hidden>
									<a href="javascript:;" title="edit" data-code="{{ $key }}" class="btn btn-primary btn-rounded editbutton" id="editbutton"><span class="fa fa-edit"></span></a>
								</td>
								<td hidden>
									<a href="javascript:;" title="delete" data-code="{{ $value->id }}"" class="btn btn-danger btn-rounded confirm-delete" ><span class="glyphicon glyphicon-trash"></span></a>
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="10" class="text-center"> No Data Found <br/></td>
							</tr>
							@endif
							</tbody>
						</table>
					</div>
					</div>
				</div>
			</div>                                                
		</div>
	</div>
	<!-- END RESPONSIVE TABLES -->
</div>
<!-- END PAGE CONTENT WRAPPER -->

<script type="text/javascript">
	
	// $('.table-order-list').on('click','.view-status', function(){

	// 	console.log($('.order-no').text());

	// 	// window.location.href = "{{ url('agent/delete_address') }}/"+code;
	// });

	$('.view-status').click(function(){

		// var order_no = $(this).closest('tr').eq(0).find('td').eq(2).text();
		var order_no = $(this).data('code');
		window.location.href = "{{ url('agent/get_delivery_status') }}"+"/"+order_no;
	});

</script>
@endsection