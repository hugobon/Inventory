@extends('header')
@section('title','Supplier')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="{{ url('supplier/supplierDetail') }}">Supplier</a></li>
    <li class="active">Supplier Detail</li>
</ul>
<!-- END BREADCRUMB -->                  

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form id="submit_form" class="form-horizontal" method="post" action="{{ url('supplier/supplierDetail/create_comp') }}">
				{{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Supplier Detail</h3>
						<div class="actions pull-right">
							<a href="{{ url('supplier/supplierDetail/form/'.$outputData->id) }}" class="btn btn-default  btn-sm btn-circle" title="Edit" >
							<i class="fa fa-edit"></i> Edit </a>
						</div>
                    </div>
                    <div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-3 control-label">Supplier Code</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->supplier_code !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Company Name</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->company_name !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Address 1</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->street1 !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Address 2</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->street2 !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Postal Code</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->poscode !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">City</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->city !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">State</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->state !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Country</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->country !!}</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-3 control-label">Telephone</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->tel !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Fax No</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->fax !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Attn no</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->attn_no !!}</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Email</label>
									<div class="col-md-9">
										<p class="form-control-static">{!! $outputData->email !!}</p>
									</div>
								</div>
								
							</div>
						</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->

@endsection                                    