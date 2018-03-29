@extends('header')
@section('title','Stock Adjustment')
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
	<li><a href="{{ url('stock/adjustment') }}">Stock In</a></li>
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
                    <form id="submit_form" class="form-horizontal" method="POST" action="{{ url('stock/submit_adjustment') }}" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                   <h3 class="panel-title">Stock Adjustment</h3>
                            </div>
                            <div class="panel-body"> 
									<div class="form-group">
											<label class="col-md-3 col-xs-12 control-label"> Adjustment <span class="required">*</span></label>
											<div class="col-md-6 col-xs-12">
													<select class="form-control form-adjustment_id" name="adjustment_id" id="adjustment_select">
															<option value=""> </option>
															@if(count($adjustmentArr) > 0)
																@foreach($adjustmentArr as $adjustmentid => $adjustmentname)
																	<option value="{{ $adjustmentid }}" {{ isset($search_adjustment) && $search_adjustment == $adjustmentid ? "selected" : "" }}>
																	{{ $adjustmentname }}</option>
																@endforeach
															@endif
													</select>
												</div>
									</div>  
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label"> Product <span class="required">*</span></label>
                                                <div class="col-md-6 col-xs-12">
														<select class="form-control form-product_id" name="product_id" id="product_input" >
																<option value=""> </option>
																@if(count($productArr) > 0)
																	@foreach($productArr as $productid => $productname)
																		<option value="{{ $productid }}" {{ isset($search_product) && $search_product == $productid ? "selected" : "" }}>
																		{{ $productname }}</option>
																	@endforeach
																@endif
														</select>
                                                </div>
                                        </div>

                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label"> Quantity <span class="required">*</span></label>
                                                <div class="col-md-6 col-xs-12">
														<input type="number" class="form-control mask_number form-quantity" name="quantity" value="0" id="quantity_input"/>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Remarks</label>
                                                <div class="col-md-6 col-xs-12">
														<input type="text" class="form-control form-remarks" name="remarks" value="" id="remarks_input"/>
                                                </div>
										</div>
										<div class="form-group">
												<div class="col-md-6 col-xs-12 col-lg-9">
												<a href="#" class="btn btn-success pull-right" id="adjust_btn">Adjust</a>
												</div>
                                        </div>
										
                                        <input type="text" name="barcode_scan_json" id="barcode_scan_hidden" hidden>

                                    </form>
                            </div>
                    </div>
            </div>
    </div>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Adjustment View</h3>
                            <div class="actions pull-right hide">
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
                                            <th></th>
											<th>Product Status</th>
											<th>Quantity</th>                                      
                                                                                        
                                        </tr>
                                    </thead>
                                    <tbody>
										<tr>
                                            <td></td>
											<td>In Store</td>
											<td>0</td>
										</tr>
										<tr>
                                            <td class="detail-control"></td>
											<td>Adjusting</td>
											<td>0</td>
										</tr>
											<tr>
                                                    <td></td>
													<td><strong>Balance</strong></td>
													<td><strong>0</strong></td>
											</tr>
									</tbody>
										
                                    
                                </table>
                            </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                                <input type="button" id="clearBtn" class="btn btn-default" value="Clear Form">
                                <input type="button" id="submitBtn"class="btn btn-primary pull-right" value="Save">
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
@endsection

@section('script')
      <script type='text/javascript' src="{!! asset('joli/js/plugins/validationengine/jquery.validationEngine.js') !!}"></script>   
      <script>
            $(document).ready(function() {
				
            var t = $('.datatable').DataTable({
                    "order": [[1, 'asc']],
                    "searching": false, 
                    "paging": false,
			        "ordering": false,			
		            });
		$( t.table().footer() ).addClass( 'highlight' );

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

	$('.datatable tbody').on( 'click', 'td', function () {
    console.log( );
		} );

           // Add event listener for opening and closing details
   $('.datatable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

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
		var quantity_input = $('#quantity_input').val();
        var remarks_input = $('#remarks_input').val();
        var product_input = $('#product_input').val();
        var adjustment_select = $('#adjustment_select').val();
        // var quantity = $('#quantity').val();
        // var description = $('#stockNo').val();
        var serial = $('#barcode_scan_hidden').val();
        
        if(quantity_input != '' && remarks_input != '' &&product_input != '' &&adjustment_select != '' ){
            $('#submit_form').submit();
        }else{
            alert('Please fill the fields')
        }   
	})

	$('#adjust_btn').click(function(){
		var t = $('.datatable').DataTable();
		var quantity_input = $('#quantity_input').val();
        var remarks_input = $('#remarks_input').val();
        var product_input = $('#product_input').val();
		var adjustment_select = $('#adjustment_select').val();
		
		var data = {
			_token: "{{ csrf_token() }}",
			quantity: quantity_input,
			remarks : remarks_input,
			product : product_input,
			adjustment : adjustment_select
		};
		$.ajax({
		method:"POST",
		data:data,	
		url: "load_stock_adjust",
		success: function(result){
			var ProdStockCount = result.stocks.stocksCount;
			var AdjustmentOperator = result.adjustmentConfig.operation;

			var cell1 = t.cell({row: 0, column: 2});
			cell1.data(ProdStockCount).draw();
			
			var cell2 = t.cell({row: 1, column: 2});
			cell2.data(quantity_input).draw() 

			var cell3 = t.cell({row: 2, column: 2});
			cell3.data(calcBalance(ProdStockCount,quantity_input,AdjustmentOperator)).draw() 
   		
		},
		error: function (textStatus, errorThrown) {
		}
		}).done(function(){
		});
	});

	function calcBalance(ProdStockCount,quantity_input,AdjustmentOperator){
		if(AdjustmentOperator == '-'){
			return ProdStockCount - quantity_input;
		}else{
			return ProdStockCount + quantity_input;
		}
	}

    /* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
    '</table>';
}


    

        
        </script>
@endsection
