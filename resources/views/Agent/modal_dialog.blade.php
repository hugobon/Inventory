<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

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

<content>
<div class="page-content-wrap">
     <!-- START RESPONSIVE TABLES -->
    <div class="row">
        <div class="col-md-12">
            <!-- Modal -->
            <div class="modal fade" id="CreateAddress" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">New Address</h4>
                        </div>
                        <div class="modal-body">
                            <div class="panel-body"> 
                                <div class="row" id="form-field">
                                    <div class="col-md-12">
                                        <div class="form-group address-group" hidden="">
                                            <label class="col-md-3 control-label"> Address Code </label>
                                            <div class="col-md-9" id="" hidden>
                                                <input type="hidden" class="form-control id" id="id" name="id" value=""/>
                                                <input type="hidden" class="form-control address-code" name="address-code" id="address-code" value=""/>
                                            </div>
                                            <div class="col-md-9" id="">
                                                <p class="control-label text-left" id="agent_id_disp">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group address-group">
                                            <label class="col-md-3 control-label" id="address_label"> Name </label>
                                            <div class="col-md-9" id="" >        
                                                <input type="text" class="form-control name" name="name" id="name" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group address-group">
                                            <label class="col-md-3 control-label" id="address_label"> Street 1 </label>
                                            <div class="col-md-9" id="" >        
                                                <input type="text" class="form-control street1" name="street1" id="street1" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group address-group">
                                            <label class="col-md-3 control-label" id="address_label"> Street 2 </label>
                                            <div class="col-md-9" id="" >        
                                                <input type="text" class="form-control street2" name="street2" id="street2" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group address-group">
                                            <label class="col-md-3 control-label" id="poscode_label"> Poscode </label>
                                            <div class="col-md-9" id="">        
                                                <input type="text" class="form-control poscode" name="poscode" id="poscode" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group address-group">
                                            <label class="col-md-3 control-label" id="city_label"> City </label>
                                            <div class="col-md-9" id="">        
                                                <input type="text" class="form-control city" name="city" id="city" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group address-group">
                                            <label class="col-md-3 control-label" id="state_label"> State </label>
                                            <div class="col-md-9" id="">        
                                                <input type="text" class="form-control state" name="state" id="state" value=""/>
                                            </div>
                                        </div>
                                        <div class="form-group address-group">
                                            <label class="col-md-3 control-label"> Country </label>
                                            <div class="col-md-9" id="">        
                                                <input type="text" class="form-control country" name="country" id="country" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="position: relative;">
                            <button type="button" class="btn btn-success save-address">OK</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</content>

<script type="text/javascript">

</script>
