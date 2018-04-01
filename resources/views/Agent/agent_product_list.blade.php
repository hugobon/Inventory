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
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="horizontal">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>Shopping Cart</strong></h3>
						<ul class="panel-controls pull-right">
							<a href="{{ url('agent/get_checkout_items') }}/{{ Auth::user()->id }}" style="font-size: 30px;">
								<i class="glyphicon glyphicon-shopping-cart cart"></i>
							</a>
							<span class="informer informer-danger" id="itemCount"></span>
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
						<!-- <div class="col-md-1 ">
							<a href="{{ url('agent/get_checkout_items') }}" style="font-size: 50px;">
								<i class="glyphicon glyphicon-shopping-cart shopping-cart"></i>
							</a>
							<span id="itemCount"></span>
						</div> -->
						<div class="alert alert-danger" role="alert">
						    <button type="button" class="close" data-dismiss="alert">
						    	<span aria-hidden="true">×</span><span class="sr-only">Close</span>
						    </button>
						    <strong></strong>
						</div>
						<div class="container" style="margin-top:50px; width: 100%;">
							<div class='row'>
								@foreach($data['productArr']['Product'] as $key => $value)
								<div class="col-md-3 item-detail">
									<div class="panel panel-default item-content">
								        <div class="panel-heading">
								            <div class="media clearfix" style="height: 20px; word-wrap: break-word;">
								                <h3 class="font-bold" style="font-size: 15px;">{{ $value['name'] }}</h3>
								            </div>
								        </div>
								        <div class="panel-image">
								            <img class="img-responsive" src="{{ isset($value['image_path']) ? asset('storage/'.$value['image_path']) : asset('invalid-image.png') }}" style="width:100%; height: 180px;" alt="">
								        </div>
								        <div class="panel-body">
								       		<table>
								       			<tr>
								       				<td><h4 class="font-bold price-text-color">WM </h4></td>
								    				<td><h4 class="font-bold price-text-color">: RM{{ $value['wm_aftergst'] }}</h4></td>
								       			</tr>
								       			<tr>
							       					<td><h4 class="font-bold price-text-color">EM</h4></td>
							       					<td><h4 class="font-bold price-text-color">: RM{{ $value['em_aftergst'] }}</h4></td>
								       			</tr>
								       		</table>
										</div>			
								        <div class="panel-footer">
							                <form action="javascript:;" class="save-item">
												<input type="hidden" name="itemType" value="product">
												<input type="hidden" id="agent_id" value="{{ Auth::user()->id }}">
												<input type="hidden" name="id" id="id" value="{{ $value['id'] }}">
												<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
												<div class="col-md-3 info" style="margin: 5px;">
													<div class="form-group info-detail">
										                <label class="control-label">Quantity</label>
										                <input type="text" class="form-control quantity" name="quantity" id="quantity" min="1" max="5" step="1">
									                </div>
												</div>
												<button type="submit" class="btn btn-block btn-danger add-to-cart">Add to cart</button>
											</form>
								        </div>
								    </div>
							    </div>
							    @endforeach
							    <div class="pagination-body">
									
								</div>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>

<button type="button" class="btn btn-default mb-control" data-box="#message-box-default">Default</button>


<div class="message-box animated fadeIn open promo-advs" id="message-box-default">
    <div class="mb-container">
    	<div class="mb-header"><i class="fa fa-times-circle-o pull-right mb-control-close" style="font-size: 30px;"></i></div>
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-globe"></span> Some <strong>Title</strong></div>
            <div class="mb-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tellus sed mauris mollis pellentesque nec a ligula. Quisque ultricies eleifend lacinia. Nunc luctus quam pretium massa semper tincidunt. Praesent vel mollis eros. Fusce erat arcu, feugiat ac dignissim ac, aliquam sed urna. Maecenas scelerisque molestie justo, ut tempor nunc.</p>                    
            </div>
            <div class="mb-footer">
            </div>
        </div>
    </div>
</div>

<div class="shopee-product-info-body__info-content">
	<div class="shopee-product-info-body__order-quantity">
		<div class="shopee-input-quantity">
			<button class="shopee-button-outline">
				<svg class="shopee-svg-icon " enable-background="new 0 0 10 10" viewBox="0 0 10 10" x="0" y="0">
					<polygon points="4.5 4.5 3.5 4.5 0 4.5 0 5.5 3.5 5.5 4.5 5.5 10 5.5 10 4.5"></polygon>
				</svg>
			</button>
			<input type="text" class="shopee-button-outline shopee-button-outline-mid" value="1">
			<button class="shopee-button-outline">
				<svg class="shopee-svg-icon icon-plus-sign" enable-background="new 0 0 10 10" viewBox="0 0 10 10" x="0" y="0">
					<polygon points="10 4.5 5.5 4.5 5.5 0 4.5 0 4.5 4.5 0 4.5 0 5.5 4.5 5.5 4.5 10 5.5 10 5.5 5.5 10 5.5"></polygon>
				</svg>
			</button>
		</div>
		<span class="shopee-product-info-body__order-quantity__stock-count">1 piece available</span>
	</div>
</div>

<script type="text/javascript">


	$(document).ready(function(){

		var count = '{!! $count !!}';
		console.log(count);
		if(count != 0){
			$('#itemCount').html(count).css('display', 'block' ); 
		}
		else{
			$('#itemCount').html(count).css('display', 'none' ); 
		}

		$('.alert-danger').hide();

		$('.promo-advs').css('display','none')

	});

	// $('div.item-detail').click(function(){

	// 	var product_id = $(this).find('input#id').val();
	// 	// console.log(product_id)
	// 	window.location.href = "agent/get_product_details/"+product_id;
	// });
	
	// var itemCount = 0;

	$('button.add-to-cart').on('click', function () {
		console.log("masuk sini")
		var imgtodrag = $(this).closest(".panel").children(".panel-image").find("img").eq(0);
		var cart = $('.cart');
		// console.log($(this).closest('form.save-item').children('.info').children('.info-detail').find('select#quantity').val())
		var product_id = $(this).closest('form.save-item').find('input#id').val();
		var quantity = $(this).closest('form.save-item').children('.info').children('.info-detail').find('input#quantity').val();
		var agent_id = $(this).closest('form.save-item').find('input#agent_id').val();
		var _token = $(this).closest('form.save-item').find('input#_token').val();
		var item = [];
		console.log(quantity)

		if(quantity > 0 || quantity != ""){
			item ={

				product_id : product_id,
				agent_id : agent_id,
				quantity : quantity
			};

			var data = {

				_token : _token,
				item : item
			};

			$.ajax({

				url 	: "/agent/save_selected_items",
				type 	: "POST",
				data 	: JSON.stringify(data),
				dataType: "json",
				contentType: "application/json",

			}).done(function(respone){

				console.log(respone)
				if(respone.return.status == "01"){

					// fn_get_cart_items(respone.data.product_id,respone.data.agent_id);
			        if (imgtodrag) {
			            var imgclone = imgtodrag.clone().offset({
			               top: imgtodrag.offset().top,
			                left: imgtodrag.offset().left
			            }).css({
			                'opacity': '0.5',
			                'position': 'absolute',
			                'height': '150px',
			                'width': '150px',
			                'z-index': '100'
			            }).appendTo($('body')).animate({
			                'top': cart.offset().top + 10,
			                'left': cart.offset().left + 10,
			                'width': 75,
			                'height': 75
			            }, 1000, 'easeInOutExpo');
			            
			            setTimeout(function () {
			                cart.effect("shake", {
			                    times: 2
			                }, 200);
			      //           itemCount ++;
			  				$('#itemCount').html(respone.count).css('display', 'block'); 
			            }, 1500);

			            imgclone.animate({
			                'width': 0,
			                'height': 0
			            }, function () {
			                $(this).detach()
			            });
			        }

			        setTimeout(function () {
			        }, 1500);
		    	}
		    	else if(respone.return.status == "03"){

		    		$('.alert-danger').show();
		    		$('.alert-danger').children('strong').html(respone.return.message);

		    	}

			}).fail(function(XHR, textStatus, errorThrown){
				var errorText = JSON.parse(XHR.responseText);
			  	console.log(errorText);
			});
		}
		else{

			$(this).closest('form.save-item').find('.quantity').css('border','2px solid red');
		}	
    });

    $('.quantity').change(function(){
    	$(this).closest('form.save-item').find('.quantity').css('border','none');
    })

function fn_get_cart_items(product_id,agent_id){

	var data = {

		_token : "{!! csrf_token() !!}",
		agent_id : agent_id,
		product_id : product_id
	};

	$.ajax({

		url : "/agent/get_cart_items",
		type : "GET",
		dataType : "json",
		data : data

	}).done(function(respone){

		if(respone.return.status == "01"){
	  		$('#itemCount').html(respone.count).css('display', 'block'); 
		}


	}).fail(function(XHR, textStatus, errorThrown){

	});
}
</script>

@endsection