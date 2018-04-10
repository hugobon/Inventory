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
            <div class="col-md-6">
                    <form id="submit_form" class="form-horizontal" method="POST" action="store_stock_in" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                       
                    <div class="panel panel-default">
                            <div class="panel-heading">
                            <h3 class="panel-title">Stock In No: {{$DocNo}}</h3>
                            </div>
                            <div class="panel-body">   
                                        <div class="form-group">
                                               <input required type="text" name="stock_receive" class="form-control hide" id="stockNo" value="{{$DocNo}}">
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">In Stock Date</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="date" class="form-control" name="in_stock_date" id="stockDate" value="{{$inStockDate}}">                                            
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Supplier</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <select class="form-control" name="supplier_code" id="supplier">
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
                                                        <select class="form-control" name="product_code" id="product">
                                                                <option value=""></option>
                                                                @foreach($product as $prod)
                                                                    <option value="{{ $prod->id }}">{{$prod->code}}({{$prod->name}})</option>
                                                                @endforeach
                                                        </select>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Quantity</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <input required type="text" id="quantity" name="quantity" class="form-control" value="0">
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Description</label>
                                                <div class="col-md-6 col-xs-12">
                                                        <textarea id="textarea_barcode" cols="30" rows="10" class="form-control" name="description"></textarea>
                                                </div>                                                
                                        </div>
                                        <input type="text" name="serial_number_scan_json" id="serial_number_scan_json" hidden>
                                        <input type="text" name="stock_in_id" id="stock_in_id" hidden value="{{$stockInId}}">
                                        <input type="text" name="stock_in_serial_check" id="stock_in_serial_check" hidden value="false">
                            </div>
                            <div class="panel-footer">
                                    <input type="button" id="clearBtn" class="btn btn-default" value="Clear Form">
                                    <input type="button" id="saveDialogBtn"class="btn btn-primary pull-right" value="Save">
                            </div>
                        </div>

                    </form>                           
                            </div>
                 

        <div class="col-md-6">
               
                <div class="panel panel-default disable">
                        <div class="panel-heading">
                                <div class="actions pull-right">                         
                                    <label class="switch">
                                        <input type="checkbox" value="false" id="serial_no_checkbox" name="serial_no_checkbox"/>
                                    <span></span>
                                    </label>
                                
                            </div>
                            <h3 class="panel-title">Serial Number List</h3>
                            <div class="actions pull-right">                                  
                                    
                            </div>
                        </div>
                        <div class="panel-body serialNo">
                                <button type="button" class="btn btn-md  btn-default"  data-toggle="modal" data-target="#uploadModal"><i class="fa fa-upload"></i>Upload CSV</button>
                                <button type="button"  class="btn btn-md  btn-default"  data-toggle="modal" data-target="#scannerModal"><i class="fa fa-barcode"></i>Scanner</button> 
                            </div>   
                        <div class="panel-body panel-body-table serialNo">  
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
                        </div>

                    </div>   
        </div>
    </div><!--ROW-->
    


</div>

<!-- Modal -->
<div id="scannerModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Scan</h4>
            </div>
            <div class="modal-body">
                  <input type="text" class="input_barcode form-control">                  
                  <img src="{{ asset('images/barcodescan.gif') }}" alt="scanner">             
          
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal" id="barcodeDoneBtn">Done</button>
            </div>
          </div>
      
        </div>
      </div>
<!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
        <form action="" id="#" role="form" class="form-horizontal">
    <div class="modal-dialog modal-sm">      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Scan</h4>
        </div>
        <div class="modal-body">
        
            <div class="form-group">
                <label class="col-md-2 control-label">Upload CSV here</label>
                <div class="col-md-5">
                    <input type="file" class="fileinput btn-danger" name="csv" id="inputCsv" data-filename-placement="inside" title="File name goes inside" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                    
                </div>
            </div>
            <div class="form-group">
                            <div class="col-md-12">
                    <div class="progress">
                            <div class="progress-bar progress_upload" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                           
                        </div>
                </div>
            </div>
      
      
        </div>
        <div class="modal-footer">
          <button id="csv-upload" type="button" class="btn btn-primary"  >Upload</button>
        </div>
      </div>
  
    </div>
</form>
  </div>

  <!--Save Dialog-->
  <div id="saveDialog" class="modal fade" role="dialog">
        <div class="modal-dialog ">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Save Option</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-md-6">
               <button type="button" id="saveAddProduct" class="btn btn-danger btn-lg btn-block" >Save and add another product</button>
                </div>
                <div class="col-md-6">
               <button type="button" id="saveClose" class="btn btn-primary btn-lg btn-block">Save and close</button>
            </div>
        </div>
        </div>
            </div>

          </div>
      
        </div>
@endsection

@section('script')
      <script type='text/javascript' src="{!! asset('joli/js/plugins/validationengine/jquery.validationEngine.js') !!}"></script>   
      <script type='text/javascript' src="{!! asset('joli/js/plugins/bootstrap/bootstrap-file-input.js') !!}"></script> 
      <script type='text/javascript' src="{!! asset('js/papaparse.min.js') !!}"></script> 
      <script>
            $(document).ready(function() {
                //Declare now
               var now = new Date();
                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);
                var today = now.getFullYear()+"-"+(month)+"-"+(day);
                //Init datatable
                window.t = $('.datatable').DataTable();
                //init counter
                window.counter = 1;

                 $('.serialNo').hide()
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

            $('#csv-upload').on("click",function(e){
                    e.preventDefault();
                    $('#inputCsv').parse({
                        config: {
                            delimiter: "auto",
                            complete: displayHTMLTable,
                        },
                        before: function(file, inputElem)
                        {
                            console.log("Parsing file...", file);
                        },
                        error: function(err, file)
                        {
                            console.log("ERROR:", err, file);
                        },
                        complete: function()
                        {
                            console.log("Done with all files");
                        }
                    });
                });

            //CHg serial
            $('#serial_no_checkbox').click(function(){
                if($('#serial_no_checkbox').is(':checked')) { 
                    $('.serialNo').show(); 
                    $('#stock_in_serial_check').val(true)
                    $("#quantity").prop('disabled', true)
                }else{
                    $('.serialNo').hide()
                    $('#stock_in_serial_check').val(false)
                    $("#quantity").prop('disabled', false)
                }               
            })

            })//ENDready


        function displayHTMLTable(results){
        var table = "";
        var data = results.data;
        
        for(i=0;i<data.length;i++){
            if(checkIfArrayIsUnique(data[i]) == true){
                                t.row.add( [
                                    counter,
                                    data[i],
                                ] ).draw( false );
                                counter++;
                                arrayCol = getSerialNumber()
                                $('#quantity').val(arrayCol.length)
            }
        // table+= "<tr>";
        // var row = data[i];
        // var cells = row.join(",").split(",");
        
        // for(j=0;j<cells.length;j++){
        // table+= "<td>";
        // table+= cells[j];
        // table+= "</th>";
        // }
        // table+= "</tr>";
        }
        table+= "";
        // $("#table_listing").html(table);
        }



    function getSerialNumber(){
        // var t = $('.datatable').DataTable();
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

    $('#saveDialogBtn').click(function(){
        //Validate
        let stockNo = $('#stockNo').val();
        let stockDate = $('#stockDate').val();
        let supplier = $('#supplier').val();
        let product = $('#product').val();
        let quantity = $('#quantity').val();
        let description = $('#textarea_barcode').val();
        let serial = $('#serial_number_scan_json').val();
        if($('#stock_in_serial_check').val() == "true" && serial == ''){
           alert('No serial Number were inserted');
        }else if(stockNo != '' && stockDate != '' &&supplier != '' &&product != '' && quantity != '' && description != ''){
            // open save dialog
            $("#saveDialog").modal("show");
            //$('#submit_form').submit();
            
        }else{
            alert('Please fill the fields')
        }
    })

    $(document).on('click','#saveAddProduct',function(){
        $('#submit_form').submit();
        
    })

    $(document).on('click','#saveClose',function(){
        $('#submit_form').append("<input type='hidden' name='link_redirect' value='{{url('stock/report/receive')}}'>");  // This is added to the end of the form and triggers the redirect after the saving is done
            
        $('#submit_form').submit();      
    })
    
        </script>
@endsection
