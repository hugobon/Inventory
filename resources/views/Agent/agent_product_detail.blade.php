@extends('header')
@include('Agent.js.agent_control')
@include('Agent.css.agent_css')
@section('title','Product Listing')
@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="javascript:;">Home</a></li>                    
	<li class="{{ url('agent') }}">Agent</li>
	<li class="{{ url('agent') }}">Select Product</li>
</ul>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="horizontal">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>Shopping Cart</strong> </h3>
						<ul class="panel-controls">
							<!-- <a href="{{ url('agent/get_checkout_items') }}/{{ Auth::user()->id }}" style="font-size: 30px;">
								<i class="glyphicon glyphicon-shopping-cart cart"></i>
							</a> -->
							<span id="itemCount"></span>
						</ul>
					</div>
				</div>
				<div class="panel-body form-horizontal">
					<div class="row">
						<div class="col-md-11">
							<div class="col-md-2 col-md-offset-5">
								<p><span id="form-title"> </span></p>
							</div>
						</div>
					</div>
					<div class="row">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection