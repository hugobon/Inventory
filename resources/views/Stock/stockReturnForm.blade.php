@extends('header')
@section('title','Stock Return')

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
				@if(count($errors) > 0)
					@foreach($errors->all() as $row_error)
						<div class="col-md-12  alert alert-danger">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							{{ $row_error }}
						</div>
					@endforeach
				@endif
				@if(session()->has('message'))
					<div class="row"><div class="col-sm-12">
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							{{ session()->get('message') }}
						</div>
					</div></div>
				@endif
			</div>
    <div class="row">
        <div class="col-md-12">
            <form id="submit_form" class="form-horizontal" method="POST" action="{{ url('stock/stockin_insert') }}" enctype="multipart/form-data" >
				{{ csrf_field() }}
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Stock In</h3>
                    </div>
                    <div class="panel-body">
							<div class="alert alert-danger alert-dismissable alert_modal" hidden>
									already exists
								</div>
                        <div class="row">
                        	<div class="col-md-12">
								<div class="form-group">
                        			<label class="col-md-3 control-label">Stock Received No.</label>
                        			<div class="col-md-9">
                        				<input required type="text" name="stock_receive" class="form-control">
                        			</div>
                        		</div>
								<div class="form-group">
                        			<label class="col-md-3 control-label">In Stock Date</label>
                        			<div class="col-md-9">
                        				<div class="input-group">
                        					<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
	                        				<input required type="text" name="instock_date" class="form-control datepicker">
                        				</div>
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Supplier</label>
                        			<div class="col-md-9">
                        				<select class="form-control" name="supplier_code">
											<option value=""></option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                            <option value="3">Option 3</option>
                                            <option value="4">Option 4</option>
                                            <option value="5">Option 5</option>
                                        </select>
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Product</label>
                        			<div class="col-md-9">
                        				<select class="form-control " name="product_code">
												<option value=""></option>
												@foreach($product as $prod)
													<option value="{{ $prod->id }}">{{$prod->description}}</option>
												@endforeach
                                        </select>
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Quantity</label>
                        			<div class="col-md-9">
                        				<input required type="text" name="quantity" class="form-control">
                        			</div>
                        		</div>
                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Barcode List</label>
                        			<div class="col-md-9">
                        				<input type="file" name="barcode" class="form-control"></input>
                        			</div>
                        		</div>


                        		<div class="form-group">
                        			<label class="col-md-3 control-label">Description</label>
                        			<div class="col-md-9">
										{{--  <input type="textarea" name="description" class="form-control">  --}}
										<textarea name="description" id="" cols="30" class="form-control"></textarea>
                        			</div>
                        		</div>
                        	</div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="button" id="clearBtn" class="btn btn-default" value="Clear Form">
						<input type="button" id="submitBtn"class="btn btn-primary pull-right" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#submitBtn').click(function(){
	$('#submit_form').submit();
	// var form,data;
		
	// 	$.ajax({
	// 		url: baseurl + '/',
	// 		method: "POST",
	// 		data: data,
	// 		success: function(result){
				
	// 		}
	// 	});
})
</script>

@endsection