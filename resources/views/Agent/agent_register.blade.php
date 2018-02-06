<!DOCTYPE html>
<html>
<head>
	@include('Agent.js.agent_control')
	<title>
		Register Agent
	</title>
	<style type="text/css">
	</style>
</head>
<body>
	<div>
		<form name="submit_agent_detail" id="submit_agent_detail">
			<h1>Register</h1><br>
			<h2>Personal Infomation</h2><br>
			Type :<input type="text" name="agent_type" id="agent_type"><br><br>
			Name :<input type="text" name="agent_name" id="agent_name"><br><br>
			Username :<input type="text" name="agent_username" id="agent_username"><br><br>
			Date of Brith :<input type="text" name="agent_dateofbirth" id="agent_dateofbirth"><br><br>
			Gender :<input type="text" name="agent_gender" id="agent_gender"><br><br>
			Marital Status :<input type="text" name="agent_marital_status" id="agent_marital_status"><br><br>
			Race :<input type="text" name="agent_race" id="agent_race"><br><br>
			ID Type :<input type="text" name="agent_id_type" id="agent_id_type"><br><br>
			<input type="text" name="agent_id" id="agent_id"><br><br>
			<input type="text" name="agent_photo" id="agent_photo"><br><br>
			<h2>Contact Info</h2><br>
			Phone Number :<input type="number" name="agent_number" id="agent_number"><br><br>
			Email :<input type="email" name="agent_email" id="agent_email"><br><br>
			<h2>Address</h2><br>
			Street :<input type="text" name="agent_address_street" id="agent_address_street"><br><br>
			Poscode :<input type="text" name="agent_address_poscode" id="agent_address_poscode"><br><br>
			City :<input type="text" name="agent_address_city" id="agent_address_city"><br><br>
			Country :<input type="text" name="agent_address_country" id="agent_address_country"><br><br>
			<h2>Bank Account Info</h2><br>
			Bank Name :<input type="text" name="agent_bank_name" id="agent_bank_name"><br><br>
			Account Bank :<input type="text" name="agent_bank_acc" id="agent_bank_acc"><br><br>
			Account Name :<input type="text" name="agent_bank_acc_name" id="agent_bank_acc_name"><br><br>
			Account Type<input type="text" name="agent_bank_acc_type" id="agent_bank_acc_type"><br><br>
			<h2>Other Info</h2><br>
			Benifical Name :<input type="text" name="agent_call_name" id="agent_call_name"><br><br>
			<h2>Delivery Info :</h2><br>
			Delivery Type :<input type="text" name="agent_del_type" id="agent_del_type"><br><br>
			Payment Type :<input type="text" name="agent_pymt_type" id="agent_pymt_type"><br><br>
			Security Password :<input type="text" name="agent_secqurity_pass" id="agent_secqurity_pass"><br><br>
			<h2>Payment Detail :</h2><br>
			Payment Type :<input type="text" name="agent_pymt_type" id="agent_pymt_type"><br><br>
			<input type="button" value="submit" name="submit" id="submit" onClick="fn_sumbit_agent_detail()">
		</form>
	</div>
</body>
</html>