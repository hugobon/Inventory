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
                    <li class="<?php echo in_array(request()->path(), array("home")) ? "active bg-green" : "" ; ?>">
                        <a href="{{ url('home') }}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
                    </li>                    
                    <li class="xn-openable <?php echo in_array(request()->path(), array("product/listing","product/form","product")) ? "active bg-green" : "" ; ?>">
                        <a href="javascript:;"><span class="fa fa-truck"></span> <span class="xn-text">Inventory </span></a>
                        <ul>
                            <li class="xn-openable <?php echo in_array(request()->path(), array("product/listing","product/form","product")) ? "active bg-green" : "" ; ?>">
                                <a href="javascript:;"><span class="fa fa-puzzle-piece"></span> Product </a>
                                <ul>
                                    <li class="<?php echo in_array(request()->path(), array("product/listing")) ? "active bg-green" : "" ; ?>">
										<a href="{{ url('product/listing') }}"><span class="fa fa-list-alt"></span> Product List </a>
									</li>
                                    <li class="<?php echo in_array(request()->path(), array("product/form")) ? "active bg-green" : "" ; ?>">
										<a href="{{ url('product/form') }}"><span class="fa fa-plus"></span> New Product </a>
									</li>
                                </ul>
                            </li>
                            <li class="xn-openable">
                                <a href="javascript:;"><span class="glyphicon glyphicon-shopping-cart"></span> Stock </a>
                                <ul>
                                    <li><a href="javascript:;"><span class="glyphicon glyphicon-list-alt"></span> Current Stock </a></li>
                                    <li><a href="javascript:;"><span class="fa fa-search"></span> Stock Balance Report </a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><span class="fa fa-book"></span> Audit Trail </a></li>
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
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="javascript:;" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->  

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
                            <a href="{{ url('logout') }}" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
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
        
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{!! asset('joli/js/plugins/jquery/jquery.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/plugins/jquery/jquery-ui.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/plugins/bootstrap/bootstrap.min.js') !!}"></script>        
        <!-- END PLUGINS -->

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
        <script type='text/javascript' src="{!! asset('joli/js/plugins/bootstrap/bootstrap-datepicker.js') !!}"></script>                
        <script type="text/javascript" src="{!! asset('joli/js/plugins/owl/owl.carousel.min.js') !!}"></script>                 
        
        <script type="text/javascript" src="{!! asset('joli/js/plugins/moment.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/plugins/daterangepicker/daterangepicker.js') !!}"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="{!! asset('joli/js/settings.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/plugins.js') !!}"></script>        
        <script type="text/javascript" src="{!! asset('joli/js/actions.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('joli/js/demo_dashboard.js') !!}"></script>    
        <!-- END TEMPLATE -->
    </body>
</html>