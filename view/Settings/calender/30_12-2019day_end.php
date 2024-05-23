<?php
if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
 $end_date=base64_decode($_GET["id"]);
 if(@$end_date){
	 $ed_date = date('d-m-Y', strtotime($end_date));
	 $cdbl_date = date('d-m-y', strtotime($end_date));
    $db_obj->select('sale_share','*',"trade_date='".$ed_date."'");
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
		
	 $db_obj->sql("SELECT tbl_ipo.account_no,tbl_ipo.ISIN,tbl_ipo.Current_Bal,tbl_ipo.qty,tbl_ipo.bonus_share,instrument.market_price FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin");
    $resultp=$db_obj->getResult();
	for($i=0; $i<count($resultp); $i++){
	$account_no=@$resultp[$i]['account_no'];
	$ISIN=@$resultp[$i]['ISIN'];
	$market_price=@$resultp[$i]['market_price'];
	$current_bal=@$resultp[$i]['Current_Bal'];
	$qty=@$resultp[$i]['qty'];
	$bonus_share=@$resultp[$i]['bonus_share'];
	$total_qty=@$current_bal+$qty+$bonus_share;
	$market_value=$total_qty*$market_price;	
	
	
	$sqlmp="UPDATE tbl_ipo SET `market_val`='$market_value' WHERE `account_no`='$account_no' AND `ISIN`='$ISIN'";
    $market_price=@mysql_query($sqlmp);
	
	}
	// Balance Forward 
	
	$sql="SELECT dp_internal_ref_number,total_balance FROM investor Where status=0";
	$db_obj->sql($sql);
	$investor=$db_obj->getResult();
	$date=date("Y-m-d");
	for($i=0; $i<count($investor); $i++){
	
	$account_no=@$investor[$i]['dp_internal_ref_number'];
	$sql_imp="SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$account_no' AND status=0 Group By account_no";
	$res_immature=$dbObj->select($sql_imp);
	if($res_immature){
    $immatured_bal=@$res_immature[0]['im_bal'];
	$total_balance=@$investor[$i]['total_balance']+$immatured_bal;
	}else{
		$total_balance=@$investor[$i]['total_balance'];
	}
	$ins=$db_obj->insert('tbl_balance_forward',array('ac_no'=>$account_no,
          'balace_forward'=>$total_balance,
          'date'=>$date));
	
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