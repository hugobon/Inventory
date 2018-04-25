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
						<div class="col-md-12">
							<div class="col-md-2">
								<p><span id="form-title"></span></p>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<!-- <div class="col-md-12 item-photo" style="border: 1px solid black;">
					                    <img style="max-width:100%;" src="https://ak1.ostkcdn.com/images/products/8818677/Samsung-Galaxy-S4-I337-16GB-AT-T-Unlocked-GSM-Android-Cell-Phone-85e3430e-6981-4252-a984-245862302c78_600.jpg" />
					                </div> -->
					                <div class="col-md-12 item-photo" style="border: 1px solid black;">
					                	@foreach($data['imageArr'] as $key => $value)
					                    <img style="max-width:100%; height: 420px; min-height: 420; max-height: 420px;" src="{{ isset($value['path']) ? asset('storage/'.$value['path']) : asset('invalid-image.png') }}" />
					                    @endforeach
					                </div>
				            	</div>
				            	<div class="col-md-6">

					                <div class="col-md-12" style="border:0px solid gray">
					                    <!-- Datos del vendedor y titulo del producto -->
					                    <h3>{{ $data['data']->name}}</h3>
					                    <!-- Precios -->
					                    <h6 class="title-price"><small>PRICE</small></h6>
					                    <h3 style="margin-top:0px;">WM RM{{ $data['wm_aftergst'] }}</h3>
					                    <h3 style="margin-top:0px;">EM RM{{ $data['em_aftergst'] }}</h3>
					        
					                    <!-- Detalles especificos del producto -->
					                    <!-- <div class="section">
					                        <h6 class="title-attr" style="margin-top:15px;" ><small>COLOR</small></h6>                    
					                        <div>
					                            <div class="attr" style="width:25px;background:#5a5a5a;"></div>
					                            <div class="attr" style="width:25px;background:white;"></div>
					                        </div>
					                    </div>
					                    <div class="section" style="padding-bottom:5px;">
					                        <h6 class="title-attr"><small>CAPACIDAD</small></h6>                    
					                        <div>
					                            <div class="attr2">16 GB</div>
					                            <div class="attr2">32 GB</div>
					                        </div>
					                    </div>  -->
					                    <div class="section" style="padding-bottom:20px;">
					                        <h6 class="title-attr"><small>QUANTITY</small></h6>                    
					                        <div>
					                            <div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
					                            <input value="1" />
					                            <div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
					                        </div>
					                    </div>                
					        
					                    <!-- Botones de compra -->
					                    <div class="section" style="padding-bottom:20px;">
					                        <button class="btn btn-success"><span style="margin-right:20px" class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to Cart</button>
					                        <h6><a href="#"></a></h6>
					                    </div>                                   
					                </div>
				                </div>                         
			        		</div>

			                <div class="col-xs-9 col-md-12">
			                    <ul class="menu-items">
			                        <li class="active">Description</li>
			                        <li>Package Item</li>
			                        <li>Vendedor</li>
			                        <li>Envío</li>
			                    </ul>
			                    <div style="width:100%;border-top:1px solid silver">
			                        <p style="padding:15px;">
			                            <small>
			                            	{{ $data['data']->description}}
			                            </small>
			                        </p>
			                    </div>
			                </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection