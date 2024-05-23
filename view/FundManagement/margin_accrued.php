
 <?php
 if(isset($_POST["submit"])){
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $date=@$_POST["payment_date"];
 $description=@$_POST["des"];
  foreach ($_POST['check'] as $id){
 $sql="SELECT ac_no,date,code,type,SUM(daily_interest)as total_interest_amt,description,status FROM `tbl_interest` where code='mi' AND ac_no='$id' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY ac_no";
  $res= $dbObj->select($sql);
   //print_r($res);
	$ac_no=@$res[0]['ac_no'];
	$code=@$res[0]['code'];
	$type=@$res[0]['type'];
    $total_interest_amt=$res[0]['total_interest_amt'];
	$description=$res[0]['description'];
	
	
	$investor="SELECT total_balance FROM investor WHERE dp_internal_ref_number='$ac_no'";
    $investor_bal= $dbObj->select($investor);
	$total_balance =$investor_bal[0]["total_balance"];
	$total = $total_balance-$total_interest_amt;
	      
	
	$sql1="INSERT INTO tbl_interest_quaterly(ac_no,code,type,total_interest_amt,description,form_date,to_date,date)
    VALUES ('$ac_no','$code','$type','$total_interest_amt','$description','$fromdate','$todate','$date')";
	 $result= $dbObj->insert($sql1);
	 
	 $sql_c="INSERT INTO `tbl_charge_info`(code,ac_no,type,description,company_name,short_name,total_amt,total_balance,date)
     VALUES('$code','$ac_no','$type','$description','NULL','NULL','$total_interest_amt','$total','$date')";
	 $result= $dbObj->insert($sql_c);
	 
	 $sql2 = "update tbl_interest set status='1' where ac_no ='$ac_no' AND code='mi' AND `date` BETWEEN '$fromdate' AND '$todate'";
     $dbObj->update($sql2);
	 
	 $sql3 = "update investor set total_balance='$total' where dp_internal_ref_number ='$ac_no'";
     $dbObj->update($sql3);
	  }
	}
	echo "<h2 align='center' style='color:#000000'>Margin Interest Successfully Deduct</h2>";
    echo "<meta http-equiv='refresh' content='1 URL=fund_management.php?InterestReceivable'>";
       exit;
 
 ?>