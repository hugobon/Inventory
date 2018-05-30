@extends('header')
@section('title','Barcode Listing')
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
	<li><a href="{{ url('stock/listing') }}">Barcode Listing</a></li>
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
                            <h3 class="panel-title">Barcode Listing for <strong>{{$product_name['name']}}</strong></h3>
                            </div>
                            
                            <div class="panel-body">              
                                            <p>Total listing: <b>{{ count($data) }}</b></p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-actions" id="table_listing">
                                                <thead>
                                                    <tr>
                                                        <th width="5px"></th>
                                                        <th>Barcode</th>
                                                        <th>Stock In Serial Number</th>
                                                        <th>Stock In Date</th>                                              
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($data) > 0)
                                                    <?php $i = 1; ?>
                                                    @foreach($data as $stock)       
                                                                              
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td>{{ $stock['serial_number'] }} </td>
                                                            <td>{{ $stock['stock_received_number'] }} </td>
                                                            <td>{{ Carbon\Carbon::parse($stock['in_stock_date'])->format('d/m/Y')}} </td>
                                                           
                                                            
                                                        </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="9" class="text-center"> No Data Found <br />
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
