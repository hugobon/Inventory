@extends('header')
@section('title','Stock In')
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
            <div class="col-md-12">

                    <div class="panel panel-default">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Current Stock Listing</h3>
                                    <div class="actions pull-right">
                                            <a href="{{ url('stock/in') }}" class="btn btn-default  btn-sm btn-circle" title="Stock In" >
                                                <i class="fa fa-plus"></i> Stock In </a>
                                    </div>
                                    <div class="actions pull-right">
                                        <a href="{{ url('stock/adjustment') }}" class="btn btn-default  btn-sm btn-circle" title="Adjust Stock" >
                                            <i class="fa fa-plus"></i> Stock Adjustment </a>
                                    </div>
                            </div>
                            <div class="panel-body">  
                                    <div class="col-md-3">
                                            <div class="widget widget-default widget-item-icon">
                                                    <div class="widget-item-left">
                                                        <span class="fa fa-truck"></span>
                                                    </div>                             
                                                    <div class="widget-data">
                                                        <div class="widget-int num-count">{{'48'}}</div>
                                                        <div class="widget-title">Total Products</div>
                                                        {{--  <div class="widget-subtitle">In your mailbox</div>  --}}
                                                    </div>      
                                                    {{--  <div class="widget-controls">                                
                                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                                    </div>  --}}
                                                </div>   
                                    </div>
                                    <div class="col-md-3">
                                            <div class="widget widget-default widget-item-icon">
                                                    <div class="widget-item-left">
                                                        <span class="glyphicon glyphicon-warning-sign"></span>
                                                    </div>                             
                                                    <div class="widget-data">
                                                        <div class="widget-int num-count">{{'48'}}</div>
                                                        <div class="widget-title">Low in stocks</div>
                                                        <div class="widget-subtitle"></div>
                                                    </div>      
                                                    {{--  <div class="widget-controls">                                
                                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                                    </div>  --}}
                                                </div>   
                                    </div>
                                    <div class="col-md-3">
                                            <div class="widget widget-default widget-item-icon">
                                                    <div class="widget-item-left">
                                                        <span class="fa fa-truck"></span>
                                                    </div>                             
                                                    <div class="widget-data">
                                                        <div class="widget-int num-count">{{date("Y-m-d", strtotime( '-1 days' ) )}}</div>
                                                        <div class="widget-title">Last Adjustment</div>
                                                        <div class="widget-subtitle"></div>
                                                    </div>      
                                                    {{--  <div class="widget-controls">                                
                                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                                    </div>  --}}
                                                </div>   
                                    </div>
                                    <div class="col-md-3">
                                            <div class="widget widget-default widget-item-icon">
                                                    <div class="widget-item-left">
                                                        <span class="fa fa-truck"></span>
                                                    </div>                             
                                                    <div class="widget-data">
                                                        <div class="widget-int num-count">{{'48'}}</div>
                                                        <div class="widget-title">Total Products</div>
                                                        <div class="widget-subtitle">In your mailbox</div>
                                                    </div>      
                                                    {{--  <div class="widget-controls">                                
                                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                                    </div>  --}}
                                                </div>   
                                    </div>
                            </div>
                            <div class="panel-body">              
                                            <p>Total listing: <b>{{ count($data) }}</b></p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-actions" id="table_listing">
                                                <thead>
                                                    <tr>
                                                        <th width="5px"></th>
                                                        <th>Code</th>
                                                        <th>Product Name</th>
                                                        <th>Stock left</th>                                           
                                                        <th width="5px"></th>                                            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($data) > 0)
                                                    <?php $i = 1; ?>
                                                    @foreach($data as $stock)       
                                                                              
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td>{{ $stock['product_code'] }} </td>
                                                            <td>{{ $stock['product_description'] }} </td>
                                                            <td>{{ $stock['stocksCount']}} </td>
                                                            <td>
                                                                <a href="#" class="btn btn-info btn-rounded "><span class="fa fa-eye"></span></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="9" class="text-center"> No Data Found <br />
                                                    <a href="{{ url('stock/in') }}"><span class="fa fa-plus"></span> Add new stock</a></td>
                                                </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                            </div>
                    </div>
            </div>
    </div>



</div>

<!-- Modal -->
<div id="scannerModal" class="modal fade" role="dialog">
        <div class="modal-dialog">      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Scan</h4>
            </div>
            <div class="modal-body">
            <form action="" id="barcode_list">
                  <input type="text" class="input_barcode form-control">
                  
                    <img src="{{ asset('images/barcodescan.gif') }}" alt="scanner">
                  
                  
            </form>
          
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal" id="barcodeDoneBtn">Done</button>
            </div>
          </div>
      
        </div>
      </div>
      <script type='text/javascript' src="{!! asset('joli/js/plugins/validationengine/jquery.validationEngine.js') !!}"></script>   
      <script>
            $(document).ready(function() {
                $('.datepicker').datepicker('setDate', 'today');
                var t = $('.datatable').DataTable();
                var counter = 1;
                var arrayCol;
           
        
                $(".input_barcode").keyup(function(event) {
                    if (event.keyCode === 13 || event.keyCode === 116) {
                        var input = $('.input_barcode').val();
                        if(input!=''){
                            if(checkIfArrayIsUnique(input) == true){
                                t.row.add( [
                                    counter,
                                    input,
                                ] ).draw( false );
                                counter++;
                                arrayCol = getSerialNumber()
                                $('#quantity').val(arrayCol.length)
                            }else{
                                alert('Duplicate Serial Number')
                            }
                        }else{
                            alert('Input cannot be empty')
                        }
                        $('.input_barcode').val('');                       
                       
                    } 
                    
                });



            })

    $('#barcode_list').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
        e.preventDefault();
        return false;
    }
    });

    function getSerialNumber(){
        var t = $('.datatable').DataTable();
        var data = t
                        .columns( 1 )
                        .data()
                        .eq( 0 )      // Reduce the 2D array into a 1D array of data
                        .sort()       // Sort data alphabetically
                        // .unique()     // Reduce to unique values
                        .join( '\n' )
        var barcode_arr = data.split("\n")        
		// var temp = [];

		// for(let i of barcode_arr)
		// 	i && temp.push(i); // copy each non-empty value to the 'temp' array

		// barcode_arr = temp;
		// delete temp; 
		$('#barcode_scan_hidden').val(JSON.stringify(barcode_arr));		
		return barcode_arr;
    }

    function checkIfArrayIsUnique(input) {        
        var myArray = getSerialNumber();
        myArray.push(input)        
    return myArray.length === new Set(myArray).size;
    }

    $('#submitBtn').click(function(){
        //Validate
        var stockNo = $('#stockNo').val();
        var stockDate = $('#stockDate').val();
        var supplier = $('#supplier').val();
        var product = $('#product').val();
        var quantity = $('#quantity').val();
        var description = $('#stockNo').val();
        var serial = $('#barcode_scan_hidden').val();
        
        if(stockNo != '' && stockDate != '' &&supplier != '' &&product != '' && quantity != '' && description != '' && serial != ''){
            $('#submit_form').submit();
        }else{
            alert('Please fill the fields')
        }

    
})

    

        
        </script>
@endsection
