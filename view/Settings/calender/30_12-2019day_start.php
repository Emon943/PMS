<?php

if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
$start_date=base64_decode($_GET["id"]);
//echo $start_date;

	// die();
 if($start_date){
   $s_date = date('Ymd', strtotime($start_date));
   $st_date = date('Y-m-d', strtotime($start_date));
   $sql="SELECT * FROM tbl_calendar WHERE status=0";
					
	$res = $dbObj->select($sql);
	$id=$res[0]['id'];
	 //print_r($res);
	//die();
	 $sql4="UPDATE tbl_calendar SET `status`='1',note='Close By' WHERE `date`='$start_date'";
     $result=@mysql_query($sql4);
	 
	 $sql1="UPDATE tbl_calendar SET `status`='2' WHERE `id`='$id'";
     $result=@mysql_query($sql1);
	 //print_r($result);
	// die();
	 $open_date="SELECT * FROM tbl_calendar WHERE status='2'";
     $res = $dbObj->select($open_date);
	 $end_date=@$res[0]['create_date'];
	 
     $loan_interest="SELECT * FROM tbl_calendar WHERE create_date BETWEEN '$s_date' AND '$end_date'";
     $ress = $dbObj->select($loan_interest);
	 $count_no=count($ress)-1;
	 // print_r($ress);
	 ////die();
	 /*start Interest Creadit on balance */
	 $db_obj->sql("SELECT * FROM investor where interest_on_credit_blance_cata_id!='NULL'");
     $interest_credit=$db_obj->getResult();
	// print_r($interest_credit);
	
	 for($i=0; $i<count($interest_credit); $i++){
	 $ac_num=$interest_credit[$i]['dp_internal_ref_number'];
	 $interest_id=$interest_credit[$i]['interest_on_credit_blance_cata_id'];
	 $interest_total_bal=$interest_credit[$i]['total_balance'];
	 if($interest_total_bal > 0 && $interest_id){
	$db_obj->sql("SELECT * FROM interst_on_credit_blance_catagory where id='$interest_id'");
    $interest_on_fee=$db_obj->getResult();
	//print_r($interest_on_fee);
	  //die();
	if($interest_on_fee){
	$irf=$interest_on_fee[0]['interest_rate'];
	$tax_on=$interest_on_fee[0]['tax_on_return_rate'];
	$code="iocb";
	$codes="acmf";
	$type="Receipt";
	$desc="Interest On Creadit Balance";
	$des=$interest_on_fee[0]['description'];
	$daily_interest_fe=($interest_total_bal*$irf/100);
	$daily_creadit_fee=($daily_interest_fe/360);
	$daily_creadit_interest=@$daily_creadit_fee*$count_no;
	
	
	$daily_MB_interest=($interest_total_bal*$tax_on/100);
	$daily_MB_fee=($daily_MB_interest/360);
	$daily_mbank_interest=@$daily_MB_fee*$count_no;
	
	
	
	$sql="INSERT INTO tbl_interest_on_credit_bal(ac_no,code,type,interest_rate,amount,description,daily_interest,acmf_rate,acmf_interest_amt,date)
    VALUES ('$ac_num','$code','$type','$irf','$interest_total_bal','$desc','$daily_creadit_interest','$tax_on','$daily_mbank_interest','$st_date')";
	$ress= $dbObj->insert($sql);
	
	}
	}
   }
  
	 /*End Interest Creadit on balance */
	 
	 
	/*management_fee start */
	$db_obj->sql("SELECT investor.dp_internal_ref_number,investor.investor_ac_number,investor.managment_fee_id,investor.total_balance,investor.interest_on_credit_blance_cata_id,investor_personal.bo_catagory FROM `investor_personal`  INNER JOIN `investor` 
     ON (`investor_personal`.`investor_id` = `investor`.`investor_id`) WHERE `investor`.managment_fee_id!='NULL'");
     $result_pmda=$db_obj->getResult();
	//print_r($result_pmda);
	foreach($result_pmda as $res_p){
	$investor_ac_number=$res_p['investor_ac_number'];
	$ac_number=$res_p['dp_internal_ref_number'];
	$mid=$res_p['managment_fee_id'];
	$interest_credit_blac_id=$res_p['interest_on_credit_blance_cata_id'];
	$Avi_balance=$res_p['total_balance'];
	$bo_catagory=$res_p['bo_catagory'];
	
    $db_obj->sql("SELECT account_no,SUM(market_val)as market_val FROM tbl_ipo WHERE BO_ID='".$db_obj->EString($investor_ac_number)."'");
    $resultp=$db_obj->getResult();
	
	if($resultp){
	$market_val=@$resultp[0]['market_val'];
	//$mf_bal=$Avi_balance+$market_val;
	}else{
		$market_val=0;
	} 
	
	if($mid){
	$db_obj->sql("SELECT * FROM margin_fee_catagory where id='$mid'");
    $management_fee=$db_obj->getResult();
	//print_r($management_fee);
	if($management_fee){
	$ir=$management_fee[0]['interest_rate'];
	$des=$management_fee[0]['description'];
	$code="mf";
	$type="Payment";
	if($bo_catagory==2){
	$db_obj->sql("SELECT SUM(daily_interest) as icmf, SUM(acmf_interest_amt) as cmf FROM tbl_interest_on_credit_bal where ac_no='$ac_number' AND status=0 GROUP BY ac_no");
    $interest_amt=$db_obj->getResult();
	//print_r($interest_amt);
     $icmf=$interest_amt[0]['icmf'];
	 $cmf=$interest_amt[0]['cmf'];
	
	 $sqls="SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$ac_number' AND status=0 Group By account_no";
	 $ress=$dbObj->select($sqls);
	 if($ress){
		$immatured_bal=@$ress[0]['im_bal']; 
	 }else{
		$immatured_bal=0;
	 }
    
	$PMF=($Avi_balance+$market_val+$immatured_bal+$icmf-$cmf);
	$daily_management_f=($PMF*$ir/100);
	$daily_management_fee=($daily_management_f/360);
	$daily_management_interest=abs($daily_management_fee)*$count_no;	
	}else{
	$daily_management_f=($market_val*$ir/100);
	$daily_management_fee=($daily_management_f/360);
	$daily_management_interest=abs($daily_management_fee)*$count_no;	
	}
   $sql="INSERT INTO tbl_interest(ac_no,code,type,interest_rate,amount,description,daily_interest,date)
   VALUES ('$ac_number','$code','$type','$ir','$PMF','$des','$daily_management_interest','$st_date')";
	
   $res= $dbObj->insert($sql);
	
	}
	
  }
 
}

	/*management_fee End */
	
	/* $db_obj->sql("SELECT * FROM investor INNER JOIN tbl_margin_loan ON tbl_margin_loan.ac_no = investor.dp_internal_ref_number where tbl_margin_loan.status='1'");
    $res=$db_obj->getResult(); */
	
	
	$db_obj->sql("SELECT investor.dp_internal_ref_number,investor.total_balance,loan_catagory_margin.interest_rate,investor_group.loan_applicable
           FROM loan_catagory_margin
           INNER JOIN investor_group ON loan_catagory_margin.id = investor_group.loan_cat
           INNER JOIN investor ON investor.investor_group_id = investor_group.investor_group_id");
		   $interest_margin_ac=$db_obj->getResult();
	
			 //print_r($interest_margin_ac);
	
    for($i=0; $i<count($interest_margin_ac); $i++){
	     $ac_no=$interest_margin_ac[$i]['dp_internal_ref_number'];
		 $total_balance=$interest_margin_ac[$i]['total_balance'];
		 $interest_rate=$interest_margin_ac[$i]['interest_rate'];
		 $description="Margin Interest";
		 $code="mi";
		 $type="Payment";
		 if($total_balance < 0){
		 $daily_interest_f=($total_balance*$interest_rate)/100;
		 $daily_interest_l=($daily_interest_f)/360;
		 $daily_interest=abs($daily_interest_l)*$count_no;
		 
  		 $ins=$db_obj->insert('tbl_interest',array('ac_no'=>$ac_no,
		  'code'=>$code,
		  'type'=>$type,
          'interest_rate'=>$interest_rate,
		  'amount'=>$total_balance,
		  'description'=>$description,
          'daily_interest'=>$daily_interest,
          'date'=>$st_date));
		 }
	}
	 
	 echo "<h2 style='text-align:center; color:green'>Day Start Successfully</h2>";
                     
        $db_obj->disconnect();
	 echo "<meta http-equiv='refresh' content='1;URL=calendar.php?working_calendar' />";
     exit();
			 
	}


?>