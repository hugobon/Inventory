<style type="text/css">
	
	#itemCount {
	  position: absolute;
	  display: none;
	  top: -10px;
	  left: -10px;
	  width: 20px;
	  height: 20px;
	  border-radius: 50%;
	  background: red;
	  color: white;
	  text-align: center;
	}
	
	.item-detail{

	    padding: 10px;
	}

	.item-detail:hover{

		box-shadow: 0px 2px 3px -1px #000;
		-moz-box-shadow: 0px 2px 3px -1px #000;
		-webkit-box-shadow: 0px 2px 3px -1px #000;
		/*-webkit-border-radius: 0px;*/
		/*-moz-border-radius: 0px;*/
		/*border-radius: 10px;   */
		-webkit-transition: all 0.3s ease-in-out;
		-moz-transition: all 0.3s ease-in-out;
		-o-transition: all 0.3s ease-in-out;
		-ms-transition: all 0.3s ease-in-out;
		transition: all 0.3s ease-in-out;  

	}

	.price-text-color{

	    color: #219FD1;
	    font-size: 14px;
	    font-style: normal;
	}

	.cart-list{
		/*border: 1px solid black;*/
	}

	.cart-row{
		/*border: 1px solid green;*/
	}

	.img-content{
		margin-right: 10px;
	}

/*********************************************
    			Call Bootstrap
*********************************************/

@import url("bootstrap/bootstrap.min.css");
@import url("bootstrap-override.css");
@import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");

/*********************************************
        		Theme Elements
*********************************************/

.gold{
	color: #FFBF00;
}

/*********************************************
					PRODUCTS
*********************************************/

.product{
	border: 1px solid #dddddd;
	height: 321px;
}

.product>img{
	max-width: 230px;
}

.product-rating{
	font-size: 20px;
	margin-bottom: 25px;
}

.product-title{
	font-size: 20px;
}

.product-desc{
	font-size: 14px;
}

.product-price{
	font-size: 22px;
}

.product-stock{
	color: #74DF00;
	font-size: 20px;
	margin-top: 10px;
}

.product-info{
		margin-top: 50px;
}

/*********************************************
					VIEW
*********************************************/

.content-wrapper {
	max-width: 1140px;
	background: #fff;
	margin: 0 auto;
	margin-top: 25px;
	margin-bottom: 10px;
	border: 0px;
	border-radius: 0px;
}

.container-fluid{
	max-width: 1140px;
	margin: 0 auto;
}

.view-wrapper {
	float: right;
	max-width: 70%;
	margin-top: 25px;
}

.container {
	padding-left: 0px;
	padding-right: 0px;
	max-width: 100%;
}

/*********************************************
				ITEM 
*********************************************/

.service1-items {
	padding: 0px 0 0px 0;
	float: left;
	position: relative;
	overflow: hidden;
	max-width: 100%;
	height: 321px;
	width: 130px;
}

.service1-item {
	height: 107px;
	width: 120px;
	display: block;
	float: left;
	position: relative;
	padding-right: 20px;
	border-right: 1px solid #DDD;
	border-top: 1px solid #DDD;
	border-bottom: 1px solid #DDD;
}

.service1-item > img {
	max-height: 110px;
	max-width: 110px;
	opacity: 0.6;
	transition: all .2s ease-in;
	-o-transition: all .2s ease-in;
	-moz-transition: all .2s ease-in;
	-webkit-transition: all .2s ease-in;
}

.service1-item > img:hover {
	cursor: pointer;
	opacity: 1;
}

.service-image-left {
	padding-right: 50px;
}

.service-image-right {
	padding-left: 50px;
}

.service-image-left > center > img,.service-image-right > center > img{
	max-height: 155px;
}



</style>