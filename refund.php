<?php
session_start();
if(@$_SESSION['LOGIN_USER']==false || $_SESSION['SECID']!=session_id()):
session_destroy();
header("Location: ./");
else:

require("include_file/__class_file.php");
$db_obj=new PMS;
include "config.php";
$dbObj = new DBUtility();
$mainLink=basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$enc=new Encryption;
endif;



$id=base64_decode($_GET["id"]);


$sql="SELECT * FROM ipo_application WHERE company_id='$id'and process_status=1";
$res= $dbObj->select($sql);
//print_r($res);
//die();
if($res){
for($i=0; $i<count($res); $i++){
	$dp_ac_no=$res[$i]['ac_no'];
	$refund_amt=$res[$i]['refund_amt'];
	$company_id=$res[$i]['company_id'];
	$short_name=$res[$i]['short_name'];
	$description="IPO Refund";
	$type="Receipt";
	$code="RF";
	$date=date("Y-m-d");
    $user_id=$_SESSION['LOGIN_USER']['id'];
	$inv_sql="SELECT total_balance FROM investor WHERE dp_internal_ref_number='$dp_ac_no'";
    $B_res = $dbObj->select($inv_sql);
    $ac_bal=$B_res[0]['total_balance'];
	$total_amt=$ac_bal+$refund_amt;
	//echo $total_amt; 
 
	
  $sql1="UPDATE `ipo_application` SET `process_status`='3' WHERE `ac_no`='$dp_ac_no' AND `company_id`='$id'";
  $result1=@mysql_query($sql1);
  $sql2="UPDATE `investor` SET `total_balance`='$total_amt' WHERE dp_internal_ref_number='$dp_ac_no'";
  $result2=@mysql_query($sql2);
  
    $sqlRF="INSERT INTO tbl_charge_info(code,ac_no,type,description,company_name,short_name,total_amt,total_balance,date,data_insert_id) 
    VALUES ('$code','$dp_ac_no','$type','$description','$company_id','$short_name','$refund_amt','$total_amt','$date','$user_id')";
   
	 $result=$dbObj->insert($sqlRF);
  
}
}else{
	 echo "<h2 style='text-align:center; color:red'>Unsuccessfully Refund IPO.Please import IPO text file!!</h2>";
	  echo "<meta http-equiv='refresh' content='2; URL=ipo.php?IPOprocess'/>";
	 exit();
}
   echo "<h2 style='text-align:center; color:green'>Successfully Refund IPO</h2>";
                     
   echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOprocess'/>";
   exit();  
