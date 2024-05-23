<?php
include "config.php";
$dbObj = new DBUtility();
$date_tread=base64_decode($_GET["id"]);
//All Buy Query everday
$total_buy="SELECT date_tread,branch_id, SUM(total_amount) as total_buy_amt, SUM(broker_commission) as total_buy_bcharges, SUM(agency_comm) as total_buy_agency_commi, SUM(commission) as total_buy_commission FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='B' Group By type";
$result_total_buy= $dbObj->select($total_buy);

 $tread_date=@$result_total_buy[0]['date_tread'];
 $tread_date = date('m-d-Y', strtotime($tread_date));
 $total_buy_amt=@$result_total_buy[0]['total_buy_amt'];
 $branch_id=@$result_total_buy[0]['branch_id'];
 $total_buy_bcharges=@$result_total_buy[0]['total_buy_bcharges'];
 $broker_payable=$total_buy_amt+$total_buy_bcharges;
 $total_buy_agency_commi=@$result_total_buy[0]['total_buy_agency_commi'];
 $total_buy_commission=@$result_total_buy[0]['total_buy_commission'];
 
 //$grand_total_buy_commi=$total_buy_bcharges+$total_buy_commission+$total_buy_agency_commi;
 
 //All sell Query for everday
 $total_sell="SELECT date_tread,branch_id, SUM(total_amount) as total_sell_amt, SUM(broker_commission) as total_sell_bcharges, SUM(agency_comm) as total_sell_agency_commi, SUM(commission) as total_sell_commission FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='S' Group By type";
 $result_total_sell= $dbObj->select($total_sell);
 $total_sell_amt=@$result_total_sell[0]['total_sell_amt'];
 $total_turn_over=$total_buy_amt+$total_sell_amt;
 $total_sell_bcharges=@$result_total_sell[0]['total_sell_bcharges'];
 $broker_receivable=$total_sell_amt-$total_sell_bcharges;
 $total_sell_agency_commi=@$result_total_sell[0]['total_sell_agency_commi'];
 $total_sell_commission=@$result_total_sell[0]['total_sell_commission'];

 //$grand_total_sell_commi=$total_sell_bcharges+$total_sell_commission+$total_sell_agency_commi;
  $total_commission=$total_buy_commission+$total_sell_commission;
  
  /*Start Payable Receivable Broker House*/
  $sql_pay_rec="SELECT * FROM tbl_broker_pay_recei";
  $result_pay_rec= $dbObj->select($sql_pay_rec);
  $payable_bal=@$result_pay_rec[0]['payable_bal'];
  $receiable_bal=@$result_pay_rec[0]['receiable_bal'];
   
  if($broker_payable > $broker_receivable){
	$payable=$broker_payable-$broker_receivable;
	$pay=$payable+$payable_bal;
	$rece=$receiable_bal;
  }else{
	 $receiable=$broker_receivable-$broker_payable;
	 $rece=$receiable+$receiable_bal;
	 $pay=$payable_bal;
  }
    $sqlpr = "update tbl_broker_pay_recei set payable_bal='$pay',receiable_bal='$rece' where broker_code='215'";
    $dbObj->update($sqlpr);
	/*End Payable Receivable Broker House*/
  
  $sqlbs = "insert into tbl_buy_sell_info(trade_date,branch_id,total_buy,total_sell,total_turn_over,broker_buy_commi,broker_sell_commi,total_commission,broker_payable,broker_receivable)
		values('$tread_date','$branch_id','$total_buy_amt','$total_sell_amt','$total_turn_over','$total_buy_bcharges','$total_sell_bcharges','$total_commission','$broker_payable','$broker_receivable')";
		$res = $dbObj->insert($sqlbs);
/*  echo '<pre>';
   print_r($result_total_buy);
   echo '</pre>';
    echo '<pre>';
   print_r($result_total_sell);
   echo '</pre>';
   die(); */
   
/*Buy Share Process*/
$sql="SELECT account_no,bo_id,date_tread,category,COUNT(id) as num, instrument, isin, SUM(quantity) as qty, SUM(net_amount)as gt, SUM(rate)as avg FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='B' Group By account_no,isin";
$result= $dbObj->select($sql);
//print_r($result);
//die();
 for ($i = 0; $i < count($result); $i++) {
	$ac_no=$result[$i]["account_no"];
	$bo_id=$result[$i]["bo_id"];
	$category=$result[$i]["category"];
	$date_tread=$result[$i]["date_tread"];
	$gt=$result[$i]["gt"];
	$num=$result[$i]["num"];
	$instrument=$result[$i]["instrument"];
	$isin=$result[$i]["isin"];
	$quantity=$result[$i]["qty"];
	$rate=$result[$i]["avg"];
    $avg_rate=$rate/$num;
	$curr_bal=0;
	$sql="SELECT * FROM instrumentcategory WHERE code='$category'";
    $share_cate= $dbObj->select($sql);
	//print_r($share_cate);
   $settlement_day =$share_cate[0]["sttelment_day_dse"]+1;
	//die();
	
	$sql="SELECT * FROM investor WHERE dp_internal_ref_number='$ac_no'";
    $res= $dbObj->select($sql);
	$total =@$res[0]["total_balance"]-$gt;
       	 
  $sql = "insert into tbl_ipo
				(account_no,ISIN,trade_date,BO_ID,instrument,Current_Bal,qty,avg_rate,trans_type,day_count) 
				values('$ac_no','$isin','$date_tread','$bo_id','$instrument','$curr_bal','$quantity','$avg_rate','B','$settlement_day')";
				
               $res = $dbObj->insert($sql);
		   
    $sql2 = "update tread_data_list set status='1' where account_no ='$ac_no' AND type='B'";
    $dbObj->update($sql2);
	//die();	
	$sql1 = "update investor set total_balance='$total' where dp_internal_ref_number ='$ac_no'";
    $dbObj->update($sql1);
	
	
	
 }
/*Sell Share Process*/
$sqls="SELECT account_no,bo_id,category,bokersoftcode,stock_id,COUNT(id) as num,date_tread,instrument,isin,SUM(rate)as avg, SUM(quantity) as qty, SUM(total_amount)as tm, SUM(net_amount)as gt, SUM(commission)as commi FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='S' Group By account_no,isin";
$ress= $dbObj->select($sqls);
//print_r($ress);
//die();
for ($i = 0; $i < count($ress); $i++) {
	$num=$ress[$i]["num"];
	$rate=$ress[$i]["avg"];
	$ac_no=$ress[$i]["account_no"];
	$bo_id=$ress[$i]["bo_id"];
	$bokersoftcode=$ress[$i]["bokersoftcode"];
	$category=$ress[$i]["category"];
	$dsc_clear_bo=$ress[$i]["stock_id"];
	$date_tread=$ress[$i]["date_tread"];
	$total_amount=$ress[$i]["tm"];
	$instrument=$ress[$i]["instrument"];
	$isin=$ress[$i]["isin"];
	$quantity=$ress[$i]["qty"];
	$gt=$ress[$i]["gt"];
	$commission=$ress[$i]["commi"];
    $immatured_bal=$gt;
	 $avg_rate=$rate/$num;
	
	$sql="SELECT * FROM instrumentcategory WHERE code='$category'";
    $share_cate= $dbObj->select($sql);
	//print_r($share_cate);
   $settlement_day =$share_cate[0]["sttelment_day_dse"]+1;
   
   $sqli="SELECT * FROM tbl_ipo WHERE BO_ID='$bo_id' AND ISIN='$isin'";
    $resi= $dbObj->select($sqli);
       $total =@$resi[0]["Current_Bal"]-$quantity;
	     $avg_rate =@$resi[0]["avg_rate"];
	     $total_cost=$quantity*$avg_rate;
		 $realize_gain=$gt-$total_cost;
		 
       	 
  $sqlss = "insert into sale_share
				(account_no,bo_id,broker_id,stock_id,instrument,isin,qty,avg_rate,comission,immatured_bal,trade_date,day_count) 
				values(
				'$ac_no','$bo_id','$bokersoftcode','$dsc_clear_bo','$instrument','$isin','$quantity','$avg_rate','$commission','$immatured_bal','$date_tread','$settlement_day')";
				//die();
               $res = $dbObj->insert($sqlss);
			   
	$sql23 = "update tread_data_list set status='1' where account_no ='$ac_no' AND type='S'";
    $dbObj->update($sql23);
	$sql14 = "update tbl_ipo set Current_Bal='$total',BO_Ac_Status='NULL',realize_gain='$realize_gain' where BO_ID ='$bo_id' AND ISIN='$isin'";
    $dbObj->update($sql14);
   }
     echo "<h2 align='center' style='color:#000000'>Successfully Trade Process</h2>";
       echo "<meta http-equiv='refresh' content='1 URL=Protfolio.php?tradeHistory'>";
       exit;
?>