<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Activate Modal with JavaScript</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" id="myBtn">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});
</script>

</body>
</html>


<div class="page-content-wrap">
     <!-- START RESPONSIVE TABLES -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- The Modal -->
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                          <span class="close">&times;</span>
                          <h3>Modal Header</h3>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <p><span id="form-title"> </span> </p>
                                </div>
                                <div class="form-group" hidden="">
                                    <label class="col-md-3 control-label"> Agent ID </label>
                                    <div class="col-md-9" id="" hidden>        
                                        <input type="text" class="form-control agent-id" name="agent_id" id="agent_id" value=""/>
                                    </div>
                                    <div class="col-md-9" id="">
                                        <p class="control-label text-left" id="agent_id_disp">
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Delivery Type </label>
                                    <div class="col-md-9" id="">        
                                        <select type="text" class="form-control delivery-type" name="delivery_type" id="delivery_type" onclick="fn_change_field()" value="">
                                            <option value="" selected disabled hidden>Chose Value</option>
                                            <option value="01">Same Address</option>
                                            <option value="02">Different Address</option>
                                            <option value="03">Self Collect</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" id="address_label"> Stree1 </label>
                                    <div class="col-md-9" id="" >        
                                        <input type="text" class="form-control address" name="address" id="address" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" id="address_label"> Stree2 </label>
                                    <div class="col-md-9" id="" >        
                                        <input type="text" class="form-control address" name="address" id="address" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" id="poscode_label"> Poscode </label>
                                    <div class="col-md-9" id="">        
                                        <input type="text" class="form-control poscode" name="poscode" id="poscode" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" id="city_label"> City </label>
                                    <div class="col-md-9" id="">        
                                        <input type="text" class="form-control city" name="city" id="city" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" id="state_label"> State </label>
                                    <div class="col-md-9" id="">        
                                        <input type="text" class="form-control state" name="state" id="state" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Country </label>
                                    <div class="col-md-9" id="">        
                                        <input type="text" type="text" class="form-control country" name="country" id="country" value=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding:10px;">
                              <div>
                                <button class="btn btn-success">OK</button>
                                <button class="btn btn-danger">Cancel</button>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
    border:1px solid green;
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    /*background-color: #5cb85c;
    color: white;*/
}

.modal-body {
    padding: 2px 16px;
    margin: 20px;
}

.modal-footer {
    padding: 2px 16px;
    /*background-color: #5cb85c;
    color: white;*/
}
</style>
