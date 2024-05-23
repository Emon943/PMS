<?php
include "config.php";
$dbObj = new DBUtility();
$date=date("d-m-Y");
$curr_timestamp = date('d-m-Y:H:i:s');
$newDate = date("d-M-Y", strtotime($date));
$newfilename = date("dmY", strtotime($date));
$file="DSE-Cash-Mika".$newfilename.".txt";
header('Content-Disposition: attachment; filename="'.$file.'"');
header('Content-type: text/plain');

$sql12="SELECT * FROM `tbl_purchase_power`";
$purchase_res= $dbObj->select($sql12);
$purchase_limit=$purchase_res[0]['purchase_limit'];

foreach ($_POST['check'] as $id){

    $sql="SELECT * FROM investor WHERE dp_internal_ref_number='$id'";
	$res= $dbObj->select($sql);
    $investor_group_id=@$res[0]['investor_group_id'];
    $bo_id=@$res[0]['investor_ac_number'];
	$ava_balance=@$res[0]['total_balance'];
	$im_sql="SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$id' AND status=0 Group By account_no";
    $im_res= $dbObj->select($im_sql);
	if($im_res){
	 $im_bal=@$im_res[0]['im_bal'];	
	}else{
	$im_bal=0;	
	}
	$unclear_sql="SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$id' AND status=0 Group By account_ref";
    $unclear_res= $dbObj->select($unclear_sql);
	if($unclear_res){
	 $deposit_amt=@$unclear_res[0]['deposit_amt'];	
	}else{
	$deposit_amt=0;	
	}
	
   
 //Marginable stock share
 $m_sql="SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='$bo_id' AND non_marginable='FALSE'";
 $marginable=$dbObj->select($m_sql);
   //print_r($non_margin);
   if($marginable){
	$m_sum=0;
   for($i=0; $i<count($marginable);$i++){
	$total_margin_share=@$marginable[$i]['Current_Bal']+@$marginable[$i]['qty']+@$marginable[$i]['bonus_share']+@$marginable[$i]['Lockin_Balance'];
	$marginable_market_value=@$marginable[$i]['market_price']*$total_margin_share;
	$m_sum=$m_sum+$marginable_market_value;
	 }
    }else{
	$m_sum=0;
	}
	
 $s="SELECT `group_name`,`loan_cat` FROM `investor_group` WHERE `investor_group_id`='$investor_group_id'";
 $rs= $dbObj->select($s);
 $loan_cat=@$rs[0]['loan_cat'];
 
 
 if($loan_cat){
$sql2l="SELECT * FROM `loan_catagory_margin` WHERE id='$loan_cat'";
		 $margin_cat= $dbObj->select($sql2l);
		 $margin_ratio=@$margin_cat[0]['margin_ratio'];
	     $purchase_power=$m_sum*$margin_ratio+$ava_balance+$im_bal+$deposit_amt;
		 $purchase_power =round($purchase_power, 2);
         $pp=($purchase_limit*$purchase_power)/100;
		 $pp = (int)$pp;
		 $pp = number_format($pp, 2, '.', ',');
		 $pp=(explode(",",$pp));
		 $pp=$pp[0];
         
 }else{
		 $total_bal=$res[0]['total_balance'];
		 $total_balance=$total_bal+$im_bal+$deposit_amt;
		 $total_balance =round($total_balance, 2);
         $pp=($purchase_limit*$total_balance)/100;
		 $pp = (int)$pp;
		$pp = number_format($pp, 2, '.', ',');
		$pp=(explode(",",$pp));
		//print_r($total_balance);
		$pp=$pp[0];
 }
 
	    echo $res[0]['dp_internal_ref_number']."~";
		echo $res[0]['investor_ac_number']."~";
		echo rtrim($res[0]['investor_name'])."~";
		echo "N"."~";
		echo $pp."~";
		echo "Y"."~";
		echo $curr_timestamp.":"."\r\n";
	}
?>