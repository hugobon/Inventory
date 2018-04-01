@extends('header')
@section('title','Create Stock In')
@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>                    
        <li><a href="{{ url('stock/listing') }}">Stock Listing</a></li>
    </ul>
    <!-- END BREADCRUMB -->   
    
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <!-- START RESPONSIVE TABLES -->
        <div class="row"><div class="col-sm-12">
     @if(session("message"))        
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {{ session("message") }}
                </div>
            </div>
     @endif
     @if(session("errorid"))
         <div class="col-sm-12">
             <div class="alert alert-danger">
                 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                 {{ session("errorid") }}
             </div>
         </div>
     @endif
        </div>
    
        <div class="row">
                <div class="col-md-3">
                    
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="create" method="POST">
        {{ csrf_field() }}
    <div class="form-group">
        <label for="stock_in_date">Stock Received Date</label>
        <div class="input-group"><input type="date" name="in_stock_date" class="form-control">
            <span class="input-group-btn"><button class="btn btn-default">Create</button>    </span>
        </div>
    </div>
</form>
                </div>
            </div>
@endsection