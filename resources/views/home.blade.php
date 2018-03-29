@extends('header')

@section('title', 'Dashboard')
@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Home</a></li>                    
    <li class="active">Dashboard</li>
</ul>
<!-- END BREADCRUMB --> 
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    
    <!-- START WIDGETS -->                    
    <div class="row">
        <div class="col-md-3">
        <!-- START USERS ACTIVITY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h2>Warehouse</h2>
                    <span>Inventory </span>
                </div>                                    
                <!-- <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                        <ul class="dropdown-menu">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                        </ul>                                        
                    </li>                                        
                </ul>                                     -->
            </div>                                
            <div class="panel-body  list-group list-group-contacts">
              <a href="supplier/supplierDetail" class="list-group-item">                
                <i class="fa fa-circle-o pull-left fa-lg"></i>
                <span class="contacts-title">Supplier</span>
            </a>
                          <a href="product/listing" class="list-group-item"> 
                <i class="fa fa-circle-o pull-left fa-lg"></i>
                <span class="contacts-title">Product</span>
            </a>      
                          <a href="stock/listing" class="list-group-item"> 
                <i class="fa fa-circle-o pull-left fa-lg"></i>
                <span class="contacts-title">Stock</span>
            </a>            

            </div>                                    
        </div>
        <!-- END USERS ACTIVITY BLOCK -->
        </div>
        <div class="col-md-3">
        <!-- START AGENT BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h2>Agent</h2>
                    <span>Store </span>
                </div>                                    
                <!-- <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                        <ul class="dropdown-menu">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                        </ul>                                        
                    </li>                                        
                </ul>                                     -->
            </div>                                
            <div class="panel-body  list-group list-group-contacts">
              <a href="agent/get_product_list/all" class="list-group-item">                
                <i class="fa fa-circle pull-left fa-lg"></i>
                <span class="contacts-title">Product List</span>
            </a>
                          <a href="agent/get_delivery_status" class="list-group-item"> 
                <i class="fa fa-circle pull-left fa-lg"></i>
                <span class="contacts-title">Order List</span>
            </a>      
                          <a href="agent/get_address/display" class="list-group-item"> 
                <i class="fa fa-circle pull-left fa-lg"></i>
                <span class="contacts-title">Address Configuration</span>
            </a>            

            </div>                                    
        </div>
        <!-- END USERS ACTIVITY BLOCK -->
        </div>
        <div class="col-md-3">
        <!-- START DELIVER BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h2>Delivery</h2>
                    <span>Management </span>
                </div>                                    
                <!-- <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                        <ul class="dropdown-menu">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                        </ul>                                        
                    </li>                                        
                </ul>                                     -->
            </div>                                
            <div class="panel-body  list-group list-group-contacts">
              <a href="deliver_order/" class="list-group-item">                
                <i class="fa fa-check pull-left fa-lg"></i>
                <span class="contacts-title">Create DO</span>
            </a>
                          <a href="deliver_order/listing" class="list-group-item"> 
                <i class="fa fa-check pull-left fa-lg"></i>
                <span class="contacts-title">Listing</span>
            </a>      
                          <a href="stock/listing" class="list-group-item"> 
                <i class="fa fa-check pull-left fa-lg"></i>
                <span class="contacts-title">Delivery Status</span>
            </a>            

            </div>                                    
        </div>
        <!-- END USERS ACTIVITY BLOCK -->
        </div>
    </div>

</div>
@endsection
