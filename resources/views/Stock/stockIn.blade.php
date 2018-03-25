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
	<li><a href="{{ url('stock/in') }}">Stock In</a></li>
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
                    <form id="submit_form" class="form-horizontal" method="POST" action="{{ url('stock/submit_stock-in') }}" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                   <h3 class="panel-title">Stock In Form</h3>
                            </div>
                            <div class="panel-body">   
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Stock Received No.</label>
                                                <div class="col-md-6 col-xs-12">
                                                    <input required type="text" name="stock_receive" class="form-control" id="stockNo">
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">In Stock Date</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="date" class="form-control datepicker" name="instock_date" id="stockDate">                                            
                                                        </div>
                                                        
                                                    </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Supplier</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <select class="form-control select" name="supplier_code" id="supplier">
                                                                <option value=""></option>
                                                                @foreach($supplier as $supp)
                                                                        <option value="{{ $supp->id }}">{{$supp->supplier_code}}</option>
                                                                    @endforeach
                                                            </select>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Product</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <select class="form-control select " name="product_code" id="product">
                                                                <option value=""></option>
                                                                @foreach($product as $prod)
                                                                    <option value="{{ $prod->id }}">{{$prod->description}}</option>
                                                                @endforeach
                                                        </select>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Quantity</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <input required type="text" id="quantity" name="quantity" disabled class="form-control" value="0">
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Description</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <textarea id="textarea_barcode" cols="30" rows="10" class="form-control" name="description"></textarea>
                                                </div>
                                                
                                        </div>
                                        <input type="text" name="serial_number_scan_json" id="serial_number_scan_json" hidden>

                                    </form>
                            </div>
                    </div>
            </div>
    </div>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Serial Number List</h3>
                            <div class="actions pull-right">
                                    <button type="button" class="btn btn-md  btn-default"  data-toggle="modal" data-target="#uploadModal"><i class="fa fa-upload"></i>Upload CSV</button>
                                   <button type="button"  class="btn btn-md  btn-default"  data-toggle="modal" data-target="#scannerModal"><i class="fa fa-barcode"></i>Scanner</button>
                                </div>
                        </div>
                        <div class="panel-body panel-body-table">
                             <div class="panel-body">                              
                            <div class="table-responsive">
                                <table class="table  datatable" id="table_listing">
                                    <thead>
                                        <tr>
                                            <th width="5px"></th>
                                            <th>Serial Number</th>                                      
                                                                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                                <input type="button" id="clearBtn" class="btn btn-default" value="Clear Form">
                                <input type="button" id="submitBtn"class="btn btn-primary pull-right" value="Submit">
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
               // $('.datepicker').datepicker('setDate', 'today');

               var now = new Date();

                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);

                var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

                $('.datepicker').val(today);
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
		$('#serial_number_scan_json').val(JSON.stringify(barcode_arr));		
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
        var serial = $('#serial_number_scan_json').val();
        
        if(stockNo != '' && stockDate != '' &&supplier != '' &&product != '' && quantity != '' && description != '' && serial != ''){
            $('#submit_form').submit();
        }else{
            alert('Please fill the fields')
        }

    
})

    

        
        </script>
@endsection
