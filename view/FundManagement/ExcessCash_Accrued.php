
 <?php
 if(isset($_POST["submit"])){
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $date=@$_POST["payment_date"];
 $description=@$_POST["des"];
  foreach ($_POST['check'] as $id){
  $sql="SELECT ac_no,date,code,amount,interest_rate,type,SUM(daily_interest)as total_interest_amt,acmf_rate,SUM(acmf_interest_amt)as total_acmf_amt,description,status FROM `tbl_interest_on_credit_bal` where code='iocb' AND ac_no='$id' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY ac_no";
  $res= $dbObj->select($sql);
  //print_r($res);
 
    $ac_no=@$res[0]['ac_no'];
	$code=@$res[0]['code'];
	$type=@$res[0]['type'];
	$types="Payment";
    $total_interest_amt=@$res[0]['total_interest_amt'];
	$total_acmf_amt=@$res[0]['total_acmf_amt'];
    $net_interest_bal=$total_interest_amt-$total_acmf_amt;
	//$description=@$res['description'];
	$des="Interest on Creadit balance";
	
	
	$investor="SELECT total_balance FROM investor WHERE dp_internal_ref_number='$ac_no'";
    $investor_bal= $dbObj->select($investor);
	
	if($investor){
	$total_balance =$investor_bal[0]["total_balance"];
	$total = $total_balance+$net_interest_bal;
	      
	
	$sql12="INSERT INTO tbl_interest_quaterly(ac_no,code,type,total_interest_amt,description,form_date,to_date,date)
     VALUES ('$ac_no','$code','$type','$total_interest_amt','$des','$fromdate','$todate','$date')";
	 $result= $dbObj->insert($sql12);
	 
	 if($result){ 
	 $sql_c="INSERT INTO `tbl_charge_info`(code,ac_no,type,description,company_name,short_name,total_amt,total_balance,date)
     VALUES('$code','$ac_no','$type','$des','NULL','NULL','$net_interest_bal','$total','$date')";
	 $re= $dbObj->insert($sql_c); 
	 }
	 
	$sql1="INSERT INTO tbl_interest_quaterly(ac_no,code,type,total_interest_amt,description,form_date,to_date,date)
     VALUES ('$ac_no','$code','$types','$total_acmf_amt','$des','$fromdate','$todate','$date')";
	 $results= $dbObj->insert($sql1);
	 
	
	 $sql2 = "update tbl_interest_on_credit_bal set status='1' where ac_no ='$ac_no' AND code='iocb' AND `date` BETWEEN '$fromdate' AND '$todate'";
     $dbObj->update($sql2);
	 
	 $sql3 = "update investor set total_balance='$total' where dp_internal_ref_number ='$ac_no'";
     $dbObj->update($sql3);
	 } 
	 
	 }
	
 }
	echo "<h2 align='center' style='color:#000000'>Excess Cash Successfully Deduct</h2>";
    echo "<meta http-equiv='refresh' content='1 URL=fund_management.php?ExcessCashManagement'>";
    exit;
 
 ?>