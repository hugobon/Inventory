@extends('header')
@section('title','Supplier')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="#">Supplier</a></li>
    <li class="active">Supplier Detail</li>
</ul>
<!-- END BREADCRUMB -->                  

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Supplier Detail</h3>
						<div class="actions pull-right">
							<a href="{{ url('supplier/supplierDetail/form') }}" class="btn btn-default  btn-sm btn-circle" title="Add New Supplier" >
							<i class="fa fa-plus"></i> Supplier </a>
						</div>
                    </div>
                    <div class="panel-body">
						<form class="form-horizontal" method="POST" action="#" >
							<div class="row">
								<div class="col-md-10">
									<div class="form-group">
										<label class="col-md-2 control-label"> Search </label>
										<div class="col-md-10">        
											<input type="text" class="form-control product-code" id="search" 
											placeholder=" Company Code / Name " value="" />									
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
								<div class="col-md-1">
									<a href="{{ url('supplier/supplierDetail') }}" class="btn btn-danger">Reset</a>
								</div>
							</div>
						</form>
                    </div>
					<div class="panel-body">
						Company List: {!! $outputData['totalList'] !!}
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Company Code</th>
										<th>Company Name</th>
										<th>Telephone</th>
										<th>Fax No.</th>
										<th>Attn No.</th>
										<th>Email</th>
									<tr>
								</thead>
								<tbody>
									{!! $outputData['tbody'] !!}
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->

@endsection