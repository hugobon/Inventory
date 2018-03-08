<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>@yield('title')</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{!! asset('joli/css/theme-default.css') !!}"/>
		<link rel="stylesheet" type="text/css" id="theme" href="{!! asset('joli/css/bootstrap/bootstrap-datepicker.css') !!}"/>
        <link rel="stylesheet" type="text/css" id="theme" href="{!! asset('joli/css/bootstrap/bootstrap-datepicker.css.map') !!}"/>
		<!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
		<div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="javascript:;"> SKG WORLD </a>
                        <a href="javascript:;" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-title">Navigation</li>
                    <li class="<?php echo in_array(request()->path(), array("home")) ? "active" : "" ; ?>">
                        <a href="{{ url('home') }}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
                    </li>                    
                    <li class="xn-openable <?php echo in_array(Request::segment(1), array("product","stock")) ? "active" : "" ; ?>">
                        <a href="javascript:;"><span class="fa fa-truck"></span> <span class="xn-text">Inventory </span></a>
                        <ul>
                            <li class="xn-openable <?php echo in_array(Request::segment(1), array("product")) ? "active" : "" ; ?>">
                                <a href="javascript:;"><span class="fa fa-puzzle-piece"></span> Product </a>
                                <ul>
                                    <li class="<?php echo in_array(Request::segment(1) . '/' . Request::segment(2), array("product/listing","product/search")) ? "active" : "" ; ?>">
										<a href="{{ url('product/listing') }}"><span class="fa fa-list-alt"></span> Product List </a>
									</li>
                                    <li class="<?php echo in_array(Request::segment(1) . '/' . Request::segment(2), array("product/form","product/edit","product/view")) ? "active" : "" ; ?>">
										<a href="{{ url('product/form') }}"><span class="fa fa-plus"></span> Product </a>
									</li>
									<li class="<?php echo in_array(Request::segment(1) . '/' . Request::segment(2), array("product/package_form","product/package_edit","product/package_view")) ? "active" : "" ; ?>">
										<a href="{{ url('product/package_form') }}"><span class="fa fa-plus"></span> Product Package </a>
									</li>
									<li class="<?php echo in_array(Request::segment(1) . '/' . Request::segment(2), array("product/promotion")) ? "active" : "" ; ?>">
										<a href="{{ url('product/promotion/listing') }}"><span class="fa fa-list"></span> Product Promotion </a>
									</li>
                                </ul>
                            </li>
                            <li class="xn-openable <?php echo in_array(Request::segment(1), array("stock")) ? "active" : "" ; ?>"" >
                                <a href="javascript:;"><span class="glyphicon glyphicon-shopping-cart"></span> Stock </a>
                                <ul>
                                <li class="<?php echo in_array(Request::segment(1).'/'.Request::segment(2), array("stock/in")) ? "active" : "" ; ?>">
								    <a href="{{ url('stock/in') }}"><span class="fa fa-puzzle-piece"></span>Stock In</a>
							    </li>
								<li class="<?php echo in_array(Request::segment(1) . '/' . Request::segment(2), array("stock/adjustment")) ? "active" : "" ; ?>">
										<a href="{{ url('stock/adjustment/listing') }}"><span class="glyphicon glyphicon-list-alt"></span> Stock Adjustment </a>
								</li>
                                <li class="<?php echo in_array(Request::segment(1) . '/' . Request::segment(2), array("stock/current")) ? "active" : "" ; ?>">
                                    <a href="{{ url('stock/current') }}"><span class="glyphicon glyphicon-list-alt"></span> Current Stock </a></li>
                                 <li><a href="javascript:;"><span class="fa fa-search"></span> Stock Balance Report </a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><span class="fa fa-book"></span> Audit Trail </a></li>
                        </ul>
                    </li>
                    <li class="xn-openable <?php echo in_array(request()->path(), array()) ? "active" : "" ; ?>">
                        <a href="javascript:;"><span class="fa fa-truck"></span> <span class="xn-text">Agent </span></a>
                        <ul>
                            <li>
                                <a href="{{ url('agent/register') }}"><span class="fa fa-puzzle-piece"></span> Register Agent </a>
                            </li>
                            <li class="xn-openable">
                                <a href="javascript:;"><span class="glyphicon glyphicon-shopping-cart"></span>Agent Option </a>
                                <ul>
                                    <li>
                                        <a href="{{ url('agent/order_stock/12221112') }}"><span class="glyphicon glyphicon-list-alt"></span> Configure </a>
                                        <a href="javascript:;"><span class="glyphicon glyphicon-list-alt"></span> Select Product </a>
                                        <a href="javascript:;"><span class="glyphicon glyphicon-list-alt"></span> Purchase Report </a>
                                    </li>
                                    <li><a href="javascript:;"><span class="fa fa-search"></span> Stock Balance Report </a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><span class="fa fa-book"></span> Audit Trail </a></li>
                        </ul>
                    </li>
                    <li class="xn-openable <?php echo in_array(Request::segment(1), array("supplier")) ? "active" : "" ; ?>">
                        <a href="{{ url('supplier/supplierDetail') }}"><span class="fa fa-truck"></span> <span class="xn-text">Supplier</span></a>
                        <ul>
                            <li class="<?php echo in_array(Request::segment(1).'/'.Request::segment(2), array("supplier/supplierDetail")) ? "active" : "" ; ?>">
								<a href="{{ url('supplier/supplierDetail') }}"><span class="fa fa-puzzle-piece"></span>Supplier Detail</a>
							</li>
                            
                            <li class="<?php echo in_array(Request::segment(1).'/'.Request::segment(2), array("supplier/supplierDO")) ? "active" : "" ; ?>">
								<a href="{{ url('supplier/supplierDO') }}"><span class="fa fa-puzzle-piece"></span>Delivery Order</a>
							</li>
						</ul>
					</li>
					<li class="xn-openable <?php echo in_array(Request::segment(1), array("configuration")) ? "active" : "" ; ?>">
                        <a href="javascript:;"><span class="fa fa-cogs"></span> <span class="xn-text"> configuration </span></a>
                        <ul>
                            <li class="<?php echo in_array(Request::segment(1).'/'.Request::segment(2), array("configuration/gst")) ? "active" : "" ; ?>">
								<a href="{{ url('configuration/gst') }}"><span class="fa fa-book"></span> Tax GST </a>
							</li>
                        </ul>
						<ul >
                            <li class="<?php echo in_array(Request::segment(1).'/'.Request::segment(2), array("configuration/stockadjustment")) ? "active" : "" ; ?>">
								<a href="{{ url('configuration/stockadjustment') }}"><span class="fa fa-book"></span> Stock Adjustment </a>
							</li>
                        </ul>
                    </li>
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">  
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="javascript:;" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="javascript:;" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->  
				 <!-- START PLUGINS -->
					<script type="text/javascript" src="{!! asset('joli/js/plugins/jquery/jquery.min.js') !!}"></script>
					<script type="text/javascript" src="{!! asset('joli/js/plugins/jquery/jquery-ui.min.js') !!}"></script>
					<script type="text/javascript" src="{!! asset('joli/js/plugins/bootstrap/bootstrap.min.js') !!}"></script>        
					<!-- END PLUGINS -->
				@yield('content')                      
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{!! asset('joli/audio/alert.mp3') !!}" preload="auto"></audio>
        <audio id="audio-fail" src="{!! asset('joli/audio/fail.mp3') !!}" preload="auto"></audio>
        <!-- END PRELOADS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src="{!! asset('joli/js/plugins/icheck/icheck.min.js') !!}"></script>        
        <script type="text/javascript" src="{!! asset('joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/plugins/scrolltotop/scrolltopcontrol.js') !!}"></script>
        
        <script type="text/javascript" src="{!! asset('joli/js/plugins/morris/raphael-min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/plugins/morris/morris.min.js') !!}"></script>       
        <script type="text/javascript" src="{!! asset('joli/js/plugins/rickshaw/d3.v3.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/plugins/rickshaw/rickshaw.min.js') !!}"></script>
        <script type='text/javascript' src="{!! asset('joli/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') !!}"></script>
        <script type='text/javascript' src="{!! asset('joli/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') !!}"></script>                
   
		<script type='text/javascript' src="{!! asset('joli/js/plugins/datepicker/bootstrap-datepicker.min.js') !!}"></script>		
        <script type="text/javascript" src="{!! asset('joli/js/plugins/owl/owl.carousel.min.js') !!}"></script>                 
        
        <script type="text/javascript" src="{!! asset('joli/js/plugins/moment.min.js') !!}"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="{!! asset('joli/js/plugins.js') !!}"></script>        
        <script type="text/javascript" src="{!! asset('joli/js/actions.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/demo_dashboard.js') !!}"></script>    
        <!-- END TEMPLATE -->
    </body>
</html>