<script type="text/javascript">


	function fn_get_page(){
		$(document).ready(function () {
			fn_display_mode("display");
		});
	}

	function fn_display_mode(mode){

		console.log(mode);
		if(mode == "display"){

			$("#agent_id_disp").show();
			$("#country_disp").show();
			$("#delivery_type_disp").show();
			$("#address_disp").show();
			$("#poscode_disp").show();
			$("#city_disp").show();
			$("#state_disp").show();

			$("#agent_id").hide();
			$("#country").hide();
			$("#delivery_type").hide();
			$("#address").hide();
			$("#poscode").hide();
			$("#city").hide();
			$("#state").hide();

			$("#display_button").hide();
			$("#edit_button").show();
			$("#clear_button").hide();
			$("#submit_button").hide();

		}
		else if(mode == "edit"){

			$("#agent_id").show();
			$("#country").show();
			$("#delivery_type").show();
			$("#address").show();
			$("#poscode").show();
			$("#city").show();
			$("#state").show();

			$("#agent_id_disp").hide();
			$("#country_disp").hide();
			$("#delivery_type_disp").hide();
			$("#address_disp").hide();
			$("#poscode_disp").hide();
			$("#city_disp").hide();
			$("#state_disp").hide();

			$("#display_button").show();
			$("#edit_button").hide();
			$("#clear_button").show();
			$("#sumbit_button").show();
			
		}
	}

	function fn_change_field(){

		var item = $("#delivery_type").val();
		
		if(item == "01" || item == "02"){
			$("#address").show();
			$("#poscode").show();
			$("#city").show();
			$("#state").show();
			$("#address_label").show();
			$("#poscode_label").show();
			$("#city_label").show();
			$("#state_label").show();
		}
		else{
			$("#address").hide();
			$("#poscode").hide();
			$("#city").hide();
			$("#state").hide();
			$("#address_label").hide();
			$("#poscode_label").hide();
			$("#city_label").hide();
			$("#state_label").hide();
		}
	}

	function readURL(input){

			console.log(input.files)
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-photo')
                    .attr('src', e.target.result)
                    .width(170)
                    .height(150);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>