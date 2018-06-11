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
                <form name="filter" class="navbar-form navbar-left" method="POST" action="{{url('stock/report/balance')}}" >
                    {{ csrf_field() }}
                    {{-- <input type="text" class="form-control datepromotion" name="daterange" 
					value="{{ isset($start) && isset($end) ? date('d/m/Y h:i A', strtotime($start)) . ' - '. date('d/m/Y h:i A', strtotime($end)) : '' }}"/> --}}
                    
                    <select name="year" id="year" size="1" class="form-control" >
                        @php
                        $firstYear = (int)date('Y') - 5;
                        $lastYear = (int)date('Y') + 5;
                        @endphp

                        @for($i=$firstYear;$i<=$lastYear;$i++)
                        <option value="{{$i}}" @if(date('Y') == $i ) selected @endif> {{$i}} </option>
                        @endfor
                    </select>
                    <select name="month" id="month" size="1" class="form-control" >
                        <option value="01" >January</option>
                        <option value="02"  >February</option>
                        <option value="03"  >March</option>
                        <option value="04" >April</option>
                        <option value="05"  >May</option>
                        <option value="06"  >June</option>
                        <option value="07"  >July</option>
                        <option value="08"  >August</option>
                        <option value="09"  >September</option>
                        <option value="10"  >October</option>
                        <option value="11"  >November</option>
                        <option value="12"  >December</option>
                    </select>

                    <select name="sday" id="sday" size="1" class="form-control" >
                        @php
                                $startdate = date('Y-m-01');
                                $enddate = date("Y-m-t");
                                $start = strtotime($startdate);
                                $end = strtotime($enddate);
                                
                                $currentdate = $start;
                                while($currentdate <= $end)
                                {
                                        $cur_date = date('d', $currentdate);                                
                                        echo '<option value="'.$cur_date.'">'.$cur_date.'</option>';
                                        $currentdate = strtotime('+1 day', $currentdate);
                                }
                        @endphp             

                    </select>
                     - 
                    <select name="eday" id="eday" size="1" class="form-control" >
                        @php
                                $startdate = date('Y-m-01');
                                $enddate = date("Y-m-t");
                                $start = strtotime($startdate);
                                $end = strtotime($enddate);
                                
                                $currentdate = $start;
                                while($currentdate <= $end)
                                {
                                        $cur_date = date('d', $currentdate);                                
                                        echo '<option value="'.$cur_date.'">'.$cur_date.'</option>';
                                        $currentdate = strtotime('+1 day', $currentdate);
                                }
                        @endphp                       

                    </select>
                    <button type="submit" class="btn btn-success">Apply Filter</button>                    
                    
                    </form>
                </div>
</div>
 <div class="row">
  <div class="col-md-12">
        <div class="panel panel-default">
                <div class="panel-body panel-body-table">
                <div class="table-responsive">
                <table class="table table-hover table-bordered text-center datatable"  style="/*height: 80vh*/">
                    <thead>
                        <tr>
                            <td>Product Name</td>
                            @php  

                                $startdate = $sdate;
                                $enddate = $edate;
                                $start = strtotime($startdate);
                                $end = strtotime($enddate);
                                
                                $currentdate = $start;
                                while($currentdate <= $end)
                                {
                                        $cur_date = date('d', $currentdate);                                
                                        echo "<td width='50px'>".$cur_date . "</td>";
                                        $currentdate = strtotime('+1 day', $currentdate);
                                }
                                
                                @endphp
                           <td class="bg-primary">Stocks Available</td>
                           <td class="bg-success">Total Adjustment In Month (-)</td>
                           <td class="bg-danger">Total Adjustment In Month (+)</td>
                           <td class="bg-warning">Stock Balance</td>
                        </tr>
                    </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td>{{$report->name}}</td>
                                @foreach($report->stock_adjustment_value as $stockAdjust)
                            <td><span class="text-success">{{ $stockAdjust['day_add']!="0" ? $stockAdjust['day_add'] : "" }}</span><br><span data-toggle="tooltip" title="{{$stockAdjust['adjustment_tooltip']}}" data-html="true" class="text-danger">{{ $stockAdjust['day_minus'] !="0" ? $stockAdjust['day_minus'] : "" }}<span></td>
                                @endforeach
                            <td >{{$report->stock_in_month}}</td>
                            <td  >{{$report->total_adjustment_minus}}</td>
                            <td >{{$report->total_adjustment_add}}</td>
                            <td >{{$report->stock_balance}}</td>
                            </tr>
                            @endforeach
                        {{-- </tbody>
                        <tfoot>
                            <tr>
                                <td>Product Name</td>
                                @php  
    
                                    $startdate = date('Y-m-01');
                                    $enddate = date("Y-m-t");
                                    $start = strtotime($startdate);
                                    $end = strtotime($enddate);
                                    
                                    $currentdate = $start;
                                    while($currentdate <= $end)
                                    {
                                            $cur_date = date('d', $currentdate);                                
                                            echo "<td>".$cur_date . "</td>";
                                            $currentdate = strtotime('+1 day', $currentdate);
                                    }
                                    
                                @endphp
                               <td class="bg-primary">Stock In Month</td>
                               <td class="bg-success">Total Adjustment In Month (-)</td>
                               <td class="bg-danger">Total Adjustment In Month (+)</td>
                               <td class="bg-warning">Stock Balance In Month</td>
                                </tr>
                        </tfoot> --}}


                </table>
            </div>
        </div>
                </div>

           
     </div>
</div>

 
@endsection
@section('script')
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="{!! asset('joli/js/daterangepicker/moment.min.js') !!}" ></script> 
<script type="text/javascript" src="{!! asset('joli/js/daterangepicker/daterangepicker.js') !!}" ></script>
<script>
        $(document).ready(function() {
            $('input[name="daterange"]').daterangepicker({
                timePicker: true,
                timePickerIncrement: 1,
                locale: {
                    format: 'DD/MM/YYYY h:mm A'
                }
            });
            var staff =0;
            $('select[name="month"]').first().val("{{ $month }}");
            $('select[name="sday"]').first().val("{{ $sday }}");
            $('select[name="eday"]').first().val("{{ $eday }}");
     
            
            var t = $('.datatable').DataTable({
                /*
              "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
                var colNumber = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35];

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {        
                        return typeof i === 'string' ?
                            i.replace(/\D/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;                                
                    };

              // Total over all pages
               for (d = 0; d < colNumber.length; d++) {
                  var COLNUMBER = colNumber[d];
                  if (api.column(COLNUMBER).data().length){
                        var total = api                        
                                    .column( COLNUMBER )
                                    .data()
                                    .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                    }) 
                  }
                  else{ total = 0};

              // Total over this page
               
              if (api.column(COLNUMBER).data().length){
                var pageTotal = api
                                .column( COLNUMBER, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }) 
                  }
                  else{ pageTotal = 0};
    
              // Update footer
              $( api.column(COLNUMBER).footer() ).html(
                  "<strong>"+pageTotal+"</strong>"
              ); $( api.column(0).footer() ).html(
                  "<strong>Total</strong>"
              ); 
          }
        }
        */
            });

        });
</script>
@endsection