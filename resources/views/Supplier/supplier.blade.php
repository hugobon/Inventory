@extends('header')
@section('title','Supplier')

@section('content')

<!-- START PAGE CONTAINER -->
<div class="page-container">
	
	<!-- START PAGE SIDEBAR -->
	<div class="page-sidebar">

		<!-- START X-NAVIGATION -->
		<ul class="x-navigation">
			<li class="xn-logo">
                <a href="index.html">Zul Admin</a>
                <a href="#" class="x-navigation-control"></a>
            </li>
			<li class="xn-title">Navigation</li>
			<li><a href="#"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a></li>
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
        </ul>
        <!-- END X-NAVIGATION VERTICAL -->                     
        
        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="#">Link</a></li>                    
            <li class="active">Active</li>
        </ul>
        <!-- END BREADCRUMB -->                
        
        <div class="page-title">                    
            <h2><span class="fa fa-arrow-circle-o-left"></span> Page Title</h2>
        </div>                   
        
        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
        
            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Panel Title</h3>
                        </div>
                        <div class="panel-body">
                            Panel body
                        </div>
                    </div>

                </div>
            </div>
        
        </div>
        <!-- END PAGE CONTENT WRAPPER -->                
    </div>            
    <!-- END PAGE CONTENT -->

</div>
<!-- END PAGE CONTAINER -->

@endsection