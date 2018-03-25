@extends('header')
@section('title','Stock Report')
<style>
#table_listing{
    font-size: 1.2rem;
}
textarea {
   resize: none;
}
</style>
@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('stock/report') }}">Stock Report</a></li>
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
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Product Name</td>
                                <?php

                                $startdate = date('Y-m-01');
                                $enddate = date("Y-m-t");
                                $start = strtotime($startdate);
                                $end = strtotime($enddate);
                                
                                $currentdate = $start;
                                while($currentdate < $end)
                                {
                                        $cur_date = date('d', $currentdate);
                                
                                        $currentdate = strtotime('+1 day', $currentdate);
                                
                                        echo "<td>".$cur_date . "</td>";
                                }
                                
                                ?>
                           <td>Stock In Month</td>
                           <td>Total Adjustment In Month (-)</td>
                           <td>Total Adjustment In Month (+)</td>
                           <td>Stock Balance In Month</td>
                        </tr>
                    </thead>
                        <tbody>
                            @foreach($productDetail as $prodDetail)
                            <tr>
                                <td>{{$prodDetail->description}}</td>
                                @foreach($stockAdjustmentValue as $stockAdjust)
                                <td>{{$stockAdjust['day']}}</td>
                                @endforeach
                            <td>{{$prodDetail->stockInMonth}}</td>
                            <td>{{$prodDetail->totalAdjustment}}</td>
                            <td></td>
                            <td>{{$prodDetail->stockBalance}}</td>
                            </tr>
                            @endforeach
                        </tbody>


                </table>
                        

                </div>

           
     </div>
</div>

 
@endsection
