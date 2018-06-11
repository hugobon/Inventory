<?php

$breadcrumb = "New Supplier Detail";
$title = "Supplier Form";
$url = url('supplier/supplierDetail/create_comp');

if(isset($outputData)){
	
	$breadcrumb = "Edit Supplier Detail";
	$title = "Supplier Detail";
	$url = url('supplier/supplierDetail/update_comp');
}

?>

@extends('header')
@section('title','Supplier')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="{{ url('supplier/supplierDetail') }}">Supplier</a></li>
    <li class="active">{!! $breadcrumb !!}</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form id="submit_form" class="form-horizontal" method="post" action="{{ $url }}">
				{{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{!! $title !!}</h3>
						<?php if(isset($outputData)){ ?>
							<div class="actions pull-right">
								<a href="{{ url('supplier/supplierDetail/view/' . $outputData->id) }}" class="btn btn-default  btn-sm btn-circle">
								<i class="fa fa-eye"></i> View </a>
							</div>
						<?php } ?>
                    </div>
                    <div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-3 control-label">Supplier Code</label>
									<div class="col-md-9">
										<?php if(isset($outputData)){ ?>
											<input name="supplier_code" type="text" class="form-control" value="{!! $outputData->supplier_code !!}" readonly>
										<?php }else{ ?>
											<input name="supplier_code" type="text" class="form-control" value="">
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Company Name</label>
									<div class="col-md-9">
										<input name="company_name" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->company_name : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Address 1</label>
									<div class="col-md-9">
										<input name="street1" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->street1 : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Address 2</label>
									<div class="col-md-9">
										<input name="street2" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->street2 : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Postal Code</label>
									<div class="col-md-9">
										<input name="poscode" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->poscode : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">City</label>
									<div class="col-md-9">
										<input name="city" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->city : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">State</label>
									<div class="col-md-9">
										<input name="state" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->state : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Country</label>
									<div class="col-md-9">
										<input name="country" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->country : '' !!}">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-3 control-label">Telephone</label>
									<div class="col-md-9">
										<input name="tel" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->tel : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Fax No</label>
									<div class="col-md-9">
										<input name="fax" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->fax : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Attn To</label>
									<div class="col-md-9">
										<input name="attn_no" type="text" class="form-control" value="{!! isset($outputData) ? $outputData->attn_no : '' !!}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Email</label>
									<div class="col-md-9">
										<input name="email" type="email" class="form-control" value="{!! isset($outputData) ? $outputData->email : '' !!}">
										<input name="id" type="hidden" class="form-control" value="{!! isset($outputData) ? $outputData->id : '' !!}">
									</div>
								</div>
								
							</div>
						</div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default">Clear Form</button>
                        <button class="btn btn-primary pull-right">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->

@endsection