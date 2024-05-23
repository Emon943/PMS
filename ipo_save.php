<?php
require_once("config.php");
$dbObj = new DBUtility();
require("include_file/__class_file.php");
$db_obj=new PMS;
  $ac_no=$_POST['ac_no'];
  $company_id=$_POST['company_id'];
  
  
  	
   $sql="SELECT * FROM `ipo_application` where ac_no='$ac_no' AND company_id='$company_id'";
   $res= $dbObj->select($sql);
 		
   $count=count($res);
 
   if($count!=0){
	echo "<h2 style='text-align:center; color:red'>Investor Already Applied </h2>"; 
	}else{	
  
  $ins=$db_obj->insert('ipo_application',array('ac_no'=>$_POST['ac_no'],
	    'company_id'=>$_POST['company_id'],
		'short_name'=>$_POST['short_name'],
		'name'=>$_POST['name'],
		'bo_id'=>$_POST['bo_id'],
		'ac_bal'=>$_POST['ac_bal'],
		'ac_type'=>$_POST['ac_type'],
		'applicant_type'=>$_POST['applicant_type'],
		'currency'=>$_POST['currency'],
		'market_lot'=>$_POST['market_lot'],
		'total_amt'=>$_POST['total_amt'],
		'ipo_name'=>$_POST['ipo_rate'],
		'phone'=>$_POST['phone'],
		'routing_number'=>$_POST['routing_number'],
		'bank_name'=>$_POST['bank_name'],
		'bank_ac_no'=>$_POST['bank_ac_no'],
		'account_status'=>$_POST['account_status'],
        'serial'=>$_POST['serial'],
        'advisory_no'=>$_POST['advisory_no'],
		'dec_date'=>$_POST['dec_date'],
		'date'=>$_POST['date'])); 

     echo "<h2 style='text-align:center; color:green'>Investor Applied Successfully</h2>";	
	}
	
  ?>