@extends('header')
@section('title','Supplier')

@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="{{ url('home') }}">Home</a></li>
    <li><a href="#">Supplier</a></li>
    <li class="active">Stock In</li>
</ul>
<!-- END BREADCRUMB -->     

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Stock In</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                        	<div class="col-md-12">
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Supplier Code</label>
                        			<div class="col-md-9">
                        				<select class="form-control select">
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                            <option>Option 4</option>
                                            <option>Option 5</option>
                                        </select>
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Product Code</label>
                        			<div class="col-md-9">
                        				<select class="form-control select">
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                            <option>Option 4</option>
                                            <option>Option 5</option>
                                        </select>
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Quantity</label>
                        			<div class="col-md-9">
                        				<input type="text" name="qty" class="form-control">
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Barcode List</label>
                        			<div class="col-md-9">
                        				<select class="form-control select">
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                            <option>Option 4</option>
                                            <option>Option 5</option>
                                        </select>
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">In Stock Date</label>
                        			<div class="col-md-9">
                        				<div class="input-group date">
                        					<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
	                        				<input type="text" name="qty" class="form-control datepicker">
                        				</div>
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Stock Received No.</label>
                        			<div class="col-md-9">
                        				<input type="text" name="qty" class="form-control">
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Description</label>
                        			<div class="col-md-9">
                        				<input type="text" name="qty" class="form-control">
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

@endsection