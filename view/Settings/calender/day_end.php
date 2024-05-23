<?php
if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
 $end_date=base64_decode($_GET["id"]);
 if(@$end_date){
	 $ed_date = date('d-m-Y', strtotime($end_date));
	 $sed_date = date('Y-m-d', strtotime($end_date));
	 $cdbl_date = date('d-m-y', strtotime($end_date));
    $db_obj->select('sale_share','*',"trade_date='".$sed_date."'");
	$res_sel=$db_obj->numRows();
	$db_obj->select('tbl_buy_info','*',"trade_date='".$ed_date."'");
	$res_buy=$db_obj->numRows();
	$trade_no=$res_sel+$res_buy;
	$db_obj->select('tbl_CDBL','*',"date='".$cdbl_date."'");
	$result=$db_obj->numRows();
	
    if($result==0){
    echo $_SESSION['in_result_data']= "<h3 align='center'>Already Pandding CDBL File!<h3>";
     $db_obj->disconnect();
	  exit(); 
	}elseif($trade_no==0){
	echo $_SESSION['in_result_data']= "<h3 align='center'>Already Pandding Trade Process!<h3>";
     $db_obj->disconnect();
	  exit(); 
	}else{
		
	$db_obj->sql("SELECT tbl_ipo.account_no,tbl_ipo.BO_ID,tbl_ipo.instrument,tbl_ipo.ISIN,tbl_ipo.Current_Bal,tbl_ipo.qty,tbl_ipo.avg_rate,tbl_ipo.bonus_share,tbl_ipo.realize_gain,instrument.market_price FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin");
    $resultp=$db_obj->getResult();
	$d=date("Y-m-d");
	for($i=0; $i<count($resultp); $i++){
	$account_no=@$resultp[$i]['account_no'];
	$BO_ID=@$resultp[$i]['BO_ID'];
	$ISIN=@$resultp[$i]['ISIN'];
	$instrument=@$resultp[$i]['instrument'];
	$market_price=@$resultp[$i]['market_price'];
	$current_bal=@$resultp[$i]['Current_Bal'];
	$qty=@$resultp[$i]['qty'];
	$avg_rate=@$resultp[$i]['avg_rate'];
	$bonus_share=@$resultp[$i]['bonus_share'];
	$realize_gain=@$resultp[$i]['realize_gain'];
	$total_qty=@$current_bal+$qty+$bonus_share;
	$market_value=@$total_qty*$market_price;	
	
	
	$sqlmp="UPDATE tbl_ipo SET `market_val`='$market_value' WHERE `account_no`='$account_no' AND `ISIN`='$ISIN'";
    $market_price=@mysql_query($sqlmp);
	if($total_qty > 0){
	 $sqlsh = "insert into stock_history
			(account_no,ISIN,BO_ID,instrument,Current_Bal,qty,bonus_share,avg_rate,market_val,realize_gain,date)
		     values('$account_no','$ISIN','$BO_ID','$instrument','$current_bal','$qty','$bonus_share','$avg_rate','$market_value','$realize_gain','$d')";
			 $res = $dbObj->insert($sqlsh);
		}
	
	}
	// Balance Forward 
	
	$sql="SELECT dp_internal_ref_number,total_balance FROM investor Where status=0";
	$db_obj->sql($sql);
	$investor=$db_obj->getResult();

	
	$date=date("Y-m-d");
	$startsql="SELECT * FROM tbl_calendar WHERE status=2";
    $start_res = $dbObj->select($startsql);
    $fid=$start_res[0]['id'];
    $sql="SELECT * FROM tbl_calendar WHERE status=0";				
    $res = $dbObj->select($sql);
    $lid=$res[0]['id']-1;
    $csql="SELECT * FROM tbl_calendar WHERE id BETWEEN '$fid' AND '$lid'";
   $result_date = $dbObj->select($csql);
	//print_r($result_date);
	//echo count($result_date);
	//die();
	// investor balace_forward
	for($i=0; $i<count($investor); $i++){
	
	$account_no=@$investor[$i]['dp_internal_ref_number'];
	/* Accrude fee and charge */

 $acmf_sql="SELECT SUM(acmf_interest_amt) as acmf,SUM(daily_interest) as CashEDF FROM tbl_interest_on_credit_bal WHERE ac_no='$account_no' AND status=0";
 $acmf_fee=$dbObj->select($acmf_sql);
 if($acmf_fee){
	$Excess_Cash_management_Fee=@$acmf_fee[0]['acmf'];
    $Exce_Cash_manage=@$acmf_fee[0]['CashEDF'];	
 }else{
	$Excess_Cash_management_Fee=0;
	$Exce_Cash_manage=0;
  }
 $pm_sql="SELECT SUM(daily_interest)as total_fee_amt FROM tbl_interest WHERE ac_no='$account_no' AND status=0 AND code='mf'";
 $pm_fee=$dbObj->select($pm_sql);
 if($pm_fee){
	$Portfolio_Management_fee=@$pm_fee[0]['total_fee_amt'];
 }else{
	$Portfolio_Management_fee=0;
  }
 
 $li_sql="SELECT SUM(daily_interest)as total_fee_amt FROM tbl_interest WHERE ac_no='$account_no' AND status=0 AND code='mi'";
 $loan_fee=$dbObj->select($li_sql);
 if($loan_fee){
	$interest_on_loan=@$loan_fee[0]['total_fee_amt'];
 }else{
	$interest_on_loan=0;
  }
 
 $accrue_charge=$Excess_Cash_management_Fee+$Portfolio_Management_fee+$interest_on_loan-$Exce_Cash_manage;
 
 /* End Accrude fee and charge */
  $sqlm="SELECT SUM(market_val) as market_val FROM tbl_ipo WHERE account_no='$account_no' GROUP BY account_no";
		  $market_res= $dbObj->select($sqlm);
		  $market_val=@$market_res[0]['market_val'];
 
	$sql_imp="SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$account_no' AND status=0 Group By account_no";
	$res_immature=@$dbObj->select($sql_imp);
	if($res_immature){
    $immatured_bal=@$res_immature[0]['im_bal'];
	$ava_balance=@$investor[$i]['total_balance'];
	$total_balance=@$ava_balance+$immatured_bal;
	}else{
		$total_balance=@$investor[$i]['total_balance'];
		$ava_balance=$total_balance;
	}
	$total_equity=@$total_balance+$market_val-$accrue_charge;
	
	for($j=0; $j<count($result_date); $j++){
	$sdate=$result_date[$j]['date'];
	$fb_date = date('Y-m-d', strtotime($sdate));
	$ins=$db_obj->insert('tbl_balance_forward',array('ac_no'=>$account_no,
          'balace_forward'=>$total_balance,
		  'ava_balance'=>$ava_balance,
		  'market_value'=>$market_val,
		  'equity'=>$total_equity,
          'date'=>$fb_date));
	}
	
	} 
	
	//Bank Forward Balance
	$sqlbf="SELECT * FROM bank_ac";
	$bank_forward_bal=$dbObj->select($sqlbf);
	//bank forward balance
	//print_r($bank_forward_bal);
	
	for($i=0; $i<count($bank_forward_bal); $i++){
	$bankid=@$bank_forward_bal[$i]['id'];
	$account_number=@$bank_forward_bal[$i]['account_number'];
	$balance=@$bank_forward_bal[$i]['balance'];
	
	
	for($j=0; $j<count($result_date); $j++){
	$sdate=$result_date[$j]['date'];
	$fb_date = date('Y-m-d', strtotime($sdate));
     $sqlins= "insert into bank_forward_balance(bankid,account_number,balance,date)
	 values('$bankid','$account_number','$balance','$fb_date')";
     $res = $dbObj->insert($sqlins);
	}
	
	} 
	
	
 
	 $sql="SELECT * FROM sale_share WHERE status=0";
	 $non_matured = $dbObj->select($sql);
     for($i=0; $i<count($non_matured); $i++){	 
	$day_count=@$non_matured[$i]['day_count'];
	$id=@$non_matured[$i]['id'];
	 if($day_count > 0){
	 $total_day=$day_count-1;
	 //echo $total_day.'<br>';
	 }else{
		$total_day=0;
	}
		$sql2="UPDATE sale_share SET `day_count`='$total_day' WHERE `id`='$id'";
        $res2=@mysql_query($sql2);
    }
	 $sql1="SELECT * FROM tbl_buy_info WHERE status=0";				
	 $non_matured_share = $dbObj->select($sql1);
     for($i=0; $i<count($non_matured_share); $i++){	 

	 //print_r($non_matured_share);
	 $day_count_share=$non_matured_share[$i]['day_count'];
	 $s_id=$non_matured_share[$i]['id'];
	 if($day_count_share > 0){
	 $total_day_share=@$day_count_share-1;
	 }else{
		$total_day_share=0;
	 }
	 $sql3="UPDATE tbl_buy_info SET `day_count`='$total_day_share' WHERE `id`='$s_id'";
     $res3=@mysql_query($sql3);
	 }	//print_r($non_matured);
		

	 
	 
	 $sql4="UPDATE tbl_calendar SET `status`='3',note='Close By' WHERE `date`='$end_date'";
     $result=@mysql_query($sql4);
	 //print_r($result);
	//die();		 
	 echo "<h2 style='text-align:center; color:green'>Day End Successfully</h2>";
                     
        $db_obj->disconnect();
	 echo "<meta http-equiv='refresh' content='1;URL=calendar.php?working_calendar' />";
     exit();
	}	 
}


?>