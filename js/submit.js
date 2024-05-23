function SubmitFormData() {
	var ac_no = $("#ac_no").val();
	var company_id = $("#company_id").val();
	if( ac_no ==='' || company_id ===''){
    alert("Please Select Company Name And Account No");
	}else{
	//var phone = $("#phone").val();
	//var gender = $("input[type=radio]:checked").val();
	$.post("submit.php", { ac_no: ac_no, company_id: company_id },
	   function(data) {
		 $('#results').html(data);
		 //$('#myForm')[0].reset();
	   });
	}
}



function SaveFormData() {
	var ac_no = $("#ac_no").val();
	var company_id = $("#company_id").val();
	var name = $("#name").val();
	var bo_id = $("#bo_id").val();
	var ac_bal = $("#ac_bal").val();
	var ac_type = $("#ac_type").val();
	var applicant_type = $("#applicant_type").val();
	var currency = $("#currency").val();
	var market_lot = $("#market_lot").val();
	var ipo_rate = $("#ipo_rate").val();
	var min_investment = $("#min_investment").val();
	var market_value = $("#market_value").val();
	var total_amt = $("#total_amt").val();
	var phone = $("#phone").val();
	var routing_number = $("#routing_number").val();
	var bank_name = $("#bank_name").val();
	var bank_ac_no = $("#bank_ac_no").val();
	var account_status = $("#account_status").val();
	var serial = $("#serial").val();
	var advisory_no = $("#advisory_no").val();
	var dec_date = $("#dec_date").val();
	var short_name = $("#short_name").val();
	var date = $("#date").val();
	
	alert(market_lot);
	
	if(Number(ac_bal) > Number(total_amt) && Number(market_value) > Number(min_investment)){
		//var phone = $("#phone").val();
	//var gender = $("input[type=radio]:checked").val();
	$.post("ipo_save.php", { ac_no: ac_no, company_id: company_id, short_name: short_name, name: name, bo_id: bo_id, ac_bal: ac_bal, ac_type: ac_type, applicant_type: applicant_type, currency: currency, market_lot: market_lot, ipo_rate: ipo_rate, total_amt: total_amt, phone: phone, routing_number: routing_number, bank_name: bank_name, bank_ac_no: bank_ac_no, account_status: account_status, serial: serial, advisory_no: advisory_no, dec_date: dec_date, date: date },
	   function(data) {
		 $('#res').html(data);
		 $('#myForm')[0].reset();
	   });
	 
	}else{
	  alert("Balance Not Enough for IPO Apply");
  }
}

