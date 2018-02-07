@extends('header')
@section('title','Product Listing')

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="javascript:;">Inventory</a></li>                    
	<li class="{{ url('product') }}">Product</li>
	<li class="active">Listing</li>
</ul>
<!-- END BREADCRUMB -->                       

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	 <!-- START RESPONSIVE TABLES -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<h3 class="panel-title">Product Listing</h3>
				</div>

				<div class="panel-body panel-body-table">
				
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-actions">
							<thead>
								<tr>
									<th ></th>
									<th class="col-md-1">Id</th>
									<th class="col-md-2">type</th>
									<th class="col-md-5">Description</th>
									<th class="col-md-2">Status</th>
									<th class="col-md-1"></th>
									<th class="col-md-1"></th>
								</tr>
							</thead>
							<tbody>                                            
								<tr><td colspan="7" class="text-center"> No data Record </td></tr>
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

@endsection