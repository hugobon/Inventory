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
	<li><a href="{{ url('stock/report/balance') }}">Stock Report</a></li>
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
                <h2>Stock Summary</h2>
                <form action="" id="changeMonthForm" name="changeMonthForm">
                    <div class="form-group">
                    <select name="month" id="monthSelect" class="col-md-5">
                    <option value="">Select Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                    </div>
                </form>
                </div>
</div>
 <div class="row">
  <div class="col-md-12">
              {{--  <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                           <td>Doc Date</td>                            
                           <td>Doc No</td>
                           <td>Description</td>
                           <td>Amount</td>
                        </tr>
                    </thead>
                        <tbody>
                           
                        </tbody>

                </table>
            </div>    --}}
                <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <td>Product Name</td>
                            @php  

                                $startdate = date('Y-m-01');
                                $enddate = date("Y-m-t");
                                $start = strtotime($startdate);
                                $end = strtotime($enddate);
                                
                                $currentdate = $start;
                                while($currentdate < $end)
                                {
                                        $cur_date = date('d', $currentdate);                                
                                        echo "<td>".$cur_date . "</td>";
                                        $currentdate = strtotime('+1 day', $currentdate);
                                }
                                
                                @endphp
                           <td>Stock In Month</td>
                           <td>Total Adjustment In Month (-)</td>
                           <td>Total Adjustment In Month (+)</td>
                           <td>Stock Balance In Month</td>
                        </tr>
                    </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td>{{$report->name}}</td>
                                @foreach($report->stockAdjustmentValue as $stockAdjust)
                                <td>{{$stockAdjust['day']}}</td>
                                @endforeach
                            <td>{{$report->stockInMonth}}</td>
                            <td>{{$report->totalAdjustment}}</td>
                            <td></td>
                            <td>{{$report->stockBalance}}</td>
                            </tr>
                            @endforeach
                        </tbody>


                </table>
            </div>

                </div>

           
     </div>
</div>

 
@endsection
@section('script')
<script>
        $(document).ready(function() {
            var t = $('.datatable').DataTable();

              $('#monthSelect').on('change', function() {
                document.forms["changeMonthForm"].submit();
            });
        });
</script>
@endsection