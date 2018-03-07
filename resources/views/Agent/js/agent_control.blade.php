<script type="text/javascript">


	function fn_get_page(){
		$(document).ready(function () {
			fn_display_mode("display");
		});
	}

	function fn_display_mode(mode){

		console.log(mode);
		if(mode == "display"){
			$("input").prop('disabled', true);
			$("select").prop('disabled', true);
		}
	}

	function fn_change_field(){

		var item = $("#delivery_type").val();
		if(item == "same_adds"){
			$("#agent_option").hide();
		}
		else{
			$("#agent_option").show();
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