<script type="text/javascript">

	function fn_sumbit_agent_detail(){

		var lv_agent_type = document.getElementById('agent_type').value;
		var lv_agent_name = document.getElementById('agent_name').value;
		var lv_agent_username = document.getElementById('agent_username').value;
		var lv_agent_dateofbirth = document.getElementById('agent_dateofbirth').value;
		var lv_agent_gender = document.getElementById('agent_gender').value;
		var lv_agent_marital_status = document.getElementById('agent_marital_status').value;
		var lv_agent_race = document.getElementById('agent_race').value;
		var lv_agent_id_type = document.getElementById('agent_id_type').value;
		var lv_agent_id = document.getElementById('agent_id').value;
		var lv_agent_photo = document.getElementById('agent_photo').value;
		var lv_agent_number = document.getElementById('agent_number').value;
		var lv_agent_email = document.getElementById('agent_email').value;
		var lv_agent_address_street = document.getElementById('agent_address_street').value;
		var lv_agent_address_poscode = document.getElementById('agent_address_poscode').value;
		var lv_agent_address_city = document.getElementById('agent_address_city').value;
		var lv_agent_address_country = document.getElementById('agent_address_country').value;
		var lv_agent_bank_acc = document.getElementById('agent_bank_acc').value;
		var lv_agent_bank_acc_name = document.getElementById('agent_bank_acc_name').value;
		var lv_agent_bank_acc_type = document.getElementById('agent_bank_acc_type').value;
		var lv_agent_call_name = document.getElementById('agent_call_name').value;
		var lv_agent_del_type = document.getElementById('agent_del_type').value;
		var lv_agent_pymt_type = document.getElementById('agent_pymt_type').value;
		var lv_agent_secqurity_pass = document.getElementById('agent_secqurity_pass').value;
		var lv_agent_pymt_type = document.getElementById('agent_pymt_type').value;

		var lv_agent_detail = {};

			lv_agent_detail = {

				agent_type 				: lv_agent_type,
				agent_name 				: lv_agent_name,
				agent_username 			: lv_agent_username,
				agent_dateofbirth 		: lv_agent_dateofbirth,
				agent_gender 			: lv_agent_gender,
				agent_marital_status 	: lv_agent_marital_status,
				agent_race 				: lv_agent_race,
				agent_id_type 			: lv_agent_id_type,
				agent_id 				: lv_agent_id,
				agent_photo 			: lv_agent_photo,
				agent_number 			: lv_agent_number,
				agent_email 			: lv_agent_email,
				agent_address_street 	: lv_agent_address_street,
				agent_address_poscode 	: lv_agent_address_poscode,
				agent_address_city 		: lv_agent_address_city,
				agent_address_country 	: lv_agent_address_country,
				agent_bank_acc 			: lv_agent_bank_acc,
				agent_bank_acc_name 	: lv_agent_bank_acc_name,
				agent_call_name 		: lv_agent_call_name,
				agent_del_type 			: lv_agent_del_type,
				agent_pymt_type 		: lv_agent_pymt_type,
				agent_secqurity_pass 	: lv_agent_secqurity_pass,
				agent_pymt_type 		: lv_agent_pymt_type
			}

			console.log(lv_agent_detail)
	}
</script>