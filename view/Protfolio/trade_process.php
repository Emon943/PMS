<?php
include "config.php";
$dbObj = new DBUtility();
$date_tread=base64_decode($_GET["id"]);

       $startsql="SELECT * FROM tbl_calendar WHERE status=2";
	   $start_res = $dbObj->select($startsql);
	   $fid=$start_res[0]['id'];
	   $sql="SELECT * FROM tbl_calendar WHERE status=0";				
	   $res = $dbObj->select($sql);
	   $id=$res[0]['id'];
	   $lid=$res[0]['id']-1;
	   $csql="SELECT count(id) as m_id FROM tbl_calendar WHERE status='1' AND id BETWEEN '$fid' AND '$lid'";
	   $result_date = $dbObj->select($csql);
	   $mcid=$result_date[0]['m_id'];
	   //die();
	   
$treading_date = date("Y-m-d", strtotime($date_tread));
$brokersql1="SELECT bokersoftcode FROM tread_data_list WHERE date_tread='$date_tread' AND status='0'";
$result_broker= $dbObj->select($brokersql1);
$broker_id=@$result_broker[0]['bokersoftcode'];
//die();
//All Buy Query Y everday
$sp_total_buy="SELECT date_tread,branch_id, SUM(total_amount) as total_buy_amt, SUM(broker_commission) as total_buy_bcharges, SUM(agency_comm) as total_buy_agency_commi, SUM(commission) as total_buy_commission FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='B' AND CompulsorySpot='Y' Group By type";
$sport_total_buy= $dbObj->select($sp_total_buy);
if($sport_total_buy){
 $sp_date=@$sport_total_buy[0]['date_tread'];
 $tread_date = date('Y-m-d', strtotime($sp_date));
 $sp_buy_amt=@$sport_total_buy[0]['total_buy_amt'];
 $branch_id=@$sport_total_buy[0]['branch_id'];
 $sp_buy_bcharges=@$sport_total_buy[0]['total_buy_bcharges'];
 $sp_broker_payable=$sp_buy_amt+$sp_buy_bcharges;
 $sp_buy_agency_commi=@$sport_total_buy[0]['total_buy_agency_commi'];
 $sp_buy_commission=@$sport_total_buy[0]['total_buy_commission'];
}
 
 //All sell Query Y for everday
 $sp_total_sell="SELECT date_tread,branch_id,SUM(total_amount) as total_sell_amt, SUM(broker_commission) as total_sell_bcharges, SUM(agency_comm) as total_sell_agency_commi, SUM(commission) as total_sell_commission FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='S' AND CompulsorySpot='Y' Group By type";
 $sport_total_sell= $dbObj->select($sp_total_sell);
 if($sport_total_sell){
 $sp_sell_amt=@$sport_total_sell[0]['total_sell_amt'];
 $sp_turn_over=$sp_buy_amt+$sp_sell_amt;
 $sp_sell_bcharges=@$sport_total_sell[0]['total_sell_bcharges'];
 $sp_broker_receivable=$sp_sell_amt-$sp_sell_bcharges;
 $sp_sell_agency_commi=@$sport_total_sell[0]['total_sell_agency_commi'];
 $sp_sell_commission=@$sport_total_sell[0]['total_sell_commission'];
 $sp_total_commission=$sp_buy_commission+$sp_sell_commission;
 }
 
  /*Start Payable Receivable Broker House*/
  if(@$sp_broker_payable || @$sp_broker_receivable){
  $sql_pay_rec="SELECT * FROM tbl_broker_hous where trace_id='$broker_id'";
  $result_pay_rec= $dbObj->select($sql_pay_rec);
  $payable_bal=@$result_pay_rec[0]['payable'];
  $receiable_bal=@$result_pay_rec[0]['receivable'];
   
  if($sp_broker_payable > $sp_broker_receivable){
	$payable=$sp_broker_payable-$sp_broker_receivable;
	$pay=$payable+$payable_bal;
	$rece=$receiable_bal;
  }else{
	 $receiable=$sp_broker_receivable-$sp_broker_payable;
	 $rece=$receiable+$receiable_bal;
	 $pay=$payable_bal;
  }
    $sqlpr = "update tbl_broker_hous set payable='$pay',receivable='$rece' where trace_id='$broker_id'";
    $dbObj->update($sqlpr);
	/*End Payable Receivable Broker House*/
  
   $sqlbs = "insert into tbl_buy_sell_info(trade_date,branch_id,broker_code,total_buy,total_buy_commi,total_sell,total_sell_commi,total_turn_over,broker_buy_commi,broker_sell_commi,total_commission,broker_payable,broker_receivable)
   values('$tread_date','$branch_id','$broker_id','$sp_buy_amt','$sp_buy_commission','$sp_sell_amt','$sp_sell_commission','$sp_turn_over','$sp_buy_bcharges','$sp_sell_bcharges','$sp_total_commission','$sp_broker_payable','$sp_broker_receivable')";
   $res = $dbObj->insert($sqlbs);
   
  }
  
  

//All Buy Query N everday
$total_buy="SELECT date_tread,branch_id, SUM(total_amount) as total_buy_amt, SUM(broker_commission) as total_buy_bcharges, SUM(agency_comm) as total_buy_agency_commi, SUM(commission) as total_buy_commission FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='B' AND CompulsorySpot='N' Group By type";
$result_total_buy= $dbObj->select($total_buy);

 $tread_date=@$result_total_buy[0]['date_tread'];
 $tread_date = date('Y-m-d', strtotime($tread_date));
 $total_buy_amt=@$result_total_buy[0]['total_buy_amt'];
 $branch_id=@$result_total_buy[0]['branch_id'];
 $total_buy_bcharges=@$result_total_buy[0]['total_buy_bcharges'];
 $broker_payable=$total_buy_amt+$total_buy_bcharges;
 $total_buy_agency_commi=@$result_total_buy[0]['total_buy_agency_commi'];
 $total_buy_commission=@$result_total_buy[0]['total_buy_commission'];
 
 //$grand_total_buy_commi=$total_buy_bcharges+$total_buy_commission+$total_buy_agency_commi;
 
 //All sell Query N for everday
 $total_sell="SELECT date_tread,branch_id,SUM(total_amount) as total_sell_amt, SUM(broker_commission) as total_sell_bcharges, SUM(agency_comm) as total_sell_agency_commi, SUM(commission) as total_sell_commission FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='S' AND CompulsorySpot='N' Group By type";
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
  $sql_pay_rec="SELECT * FROM tbl_broker_hous where trace_id='$broker_id'";
  $result_pay_rec= $dbObj->select($sql_pay_rec);
  $payable_bal=@$result_pay_rec[0]['payable'];
  $receiable_bal=@$result_pay_rec[0]['receivable'];
   
  if($broker_payable > $broker_receivable){
	$payable=$broker_payable-$broker_receivable;
	$pay=$payable+$payable_bal;
	$rece=$receiable_bal;
  }else{
	 $receiable=$broker_receivable-$broker_payable;
	 $rece=$receiable+$receiable_bal;
	 $pay=$payable_bal;
  }
    $sqlpr = "update tbl_broker_hous set payable='$pay',receivable='$rece' where trace_id='$broker_id'";
    $dbObj->update($sqlpr);
	/*End Payable Receivable Broker House*/
  
   $sqlbs = "insert into tbl_buy_sell_info(trade_date,branch_id,broker_code,total_buy,total_buy_commi,total_sell,total_sell_commi,total_turn_over,broker_buy_commi,broker_sell_commi,total_commission,broker_payable,broker_receivable)
   values('$tread_date','$branch_id','$broker_id','$total_buy_amt','$total_buy_commission','$total_sell_amt','$total_sell_commission','$total_turn_over','$total_buy_bcharges','$total_sell_bcharges','$total_commission','$broker_payable','$broker_receivable')";
   $res = $dbObj->insert($sqlbs);
/*  echo '<pre>';
   print_r($result_total_buy);
   echo '</pre>';
    echo '<pre>';
   print_r($result_total_sell);
   echo '</pre>';
   die(); */
   
   
   
   /*Sell Share Process*/
$sqls="SELECT account_no,bo_id,category,bokersoftcode,stock_id,CompulsorySpot,date_tread,instrument,isin,SUM(rate)as avg, SUM(quantity) as qty, SUM(total_amount)as tm, SUM(net_amount)as gt, SUM(commission)as commi FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='S' Group By account_no,isin";
$ress= $dbObj->select($sqls);
//print_r($ress);
//die();

for ($i = 0; $i < count($ress); $i++) {
	$CompuSpot=$ress[$i]["CompulsorySpot"];
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
	$total_bal=$gt+$commission;
    $immatured_bal=$gt;
	$avg_rate=$total_amount/$quantity;
	$av_rate=$gt/$quantity;
	 
	
	$sqlics="SELECT * FROM instrumentcategory WHERE code='$category'";
    $sell_share_cate= $dbObj->select($sqlics);
    $settlement_day =$sell_share_cate[0]["sttelment_day_dse"];
	$sett_day =$mcid+$sell_share_cate[0]["sttelment_day_dse"];
	$mature_date=date('Y-m-d', strtotime($sett_day.' day', strtotime($treading_date)));
	 
	 if($CompuSpot=="N"){
	 $settlements_days=$settlement_day;
	 $status=0;	
	}else{
     $settlements_days='matured';
     $status=1;
    $sql_acb="SELECT * FROM investor WHERE dp_internal_ref_number='$ac_no'";
    $res_avai_bal= $dbObj->select($sql_acb);
	$total_bals =@$res_avai_bal[0]["total_balance"];
	$sell_bal_update =$total_bals+$immatured_bal;
    $sql_usb = "update investor set total_balance='$sell_bal_update' where dp_internal_ref_number ='$ac_no'";
    $dbObj->update($sql_usb);	
	}
	
	
   if($bo_id && $isin){
    $sqli="SELECT * FROM tbl_ipo WHERE BO_ID='$bo_id' AND ISIN='$isin'";
    $resi= $dbObj->select($sqli);
      $total =@$resi[0]["Current_Bal"]-$quantity;
	if($total >= 0){
         $total =@$resi[0]["Current_Bal"]-$quantity;
	     $avgRate =@$resi[0]["avg_rate"];
		 $gain =@$resi[0]["realize_gain"];
	     $total_costing=$quantity*$avgRate;
		 $realize_gain=$gt-$total_costing;
		 $total_realize_gain=$gain+$realize_gain;
		 
		 $sql14 = "update tbl_ipo set Current_Bal='$total', BO_Ac_Status='NULL',realize_gain='$total_realize_gain' where BO_ID ='$bo_id' AND ISIN='$isin'";
         $dbObj->update($sql14);
		}else{
		 echo "<h1> Your Sell Stock Not Exist in System. BO </h1>".$bo_id. ' ISIN ' .$isin;
         die();		 
		}
    }
		 $sdate=date("Y-m-d");
       	 
        $sqlss = "insert into sale_share
				(account_no,bo_id,broker_id,stock_id,instrument,isin,qty,avg_rate,comission,total_bal,immatured_bal,cate,trade_date,mature_date,day_count,status) 
				values(
				'$ac_no','$bo_id','$bokersoftcode','$dsc_clear_bo','$instrument','$isin','$quantity','$av_rate','$commission','$total_bal','$immatured_bal','$category','$treading_date','$mature_date','$settlements_days','$status')";
				//die();
               $res = $dbObj->insert($sqlss);
			   
		$sql_s_charge="INSERT INTO `tbl_charge_info`(code,ac_no,type,description,company_name,short_name,qty,rate,total_amt,commi,total_balance,date)
         VALUES('S','$ac_no','Sale','$instrument','$instrument','NULL','$quantity','$avg_rate','$immatured_bal','$commission','0.00','$sdate')";
		 $ledger = $dbObj->insert($sql_s_charge);
			   
	$sql23 = "update tread_data_list set status='1' where account_no ='$ac_no' AND type='S'";
    $dbObj->update($sql23);
	
   }

/*Buy Share Process*/

$sql="SELECT account_no,bo_id,CompulsorySpot,date_tread,category,instrument,isin,SUM(quantity) as qty,SUM(total_amount)as tm,SUM(net_amount)as gt,SUM(rate)as avg,SUM(commission)as commi FROM tread_data_list WHERE date_tread='$date_tread' AND status=0 AND type='B' Group By account_no,isin";
$result= $dbObj->select($sql);


 for ($i = 0; $i < count($result); $i++) {
	$buy_ac_no=$result[$i]["account_no"];
	$buy_bo_id=$result[$i]["bo_id"];
	$CompulsorySpot=$result[$i]["CompulsorySpot"];
	$category=$result[$i]["category"];
	$date_tread=$result[$i]["date_tread"];
    $btotal_amount=$result[$i]["tm"];
	$buy_gt=$result[$i]["gt"];
	$instrument=$result[$i]["instrument"];
	$bisin=$result[$i]["isin"];
	$buy_quantity=$result[$i]["qty"];
	$rate=$result[$i]["avg"];
	$commi=$result[$i]["commi"];
	$lbuy_avg_rate=$btotal_amount/$buy_quantity;
	$buy_avg_rate=$buy_gt/$buy_quantity;
	
	 
	$sqlbic="SELECT * FROM instrumentcategory WHERE code='$category'";
    $buy_share_cate= $dbObj->select($sqlbic);
	$settlement_day =$buy_share_cate[0]["sttelment_day_dse"];
	$sett_day =$mcid+$buy_share_cate[0]["sttelment_day_dse"];
	$bmature_date=date('Y-m-d', strtotime($sett_day.' day', strtotime($treading_date)));
   
   if($CompulsorySpot=="N"){
	 $curr_bal=0;
	 $buy_quant=$buy_quantity;
	 $settlement_days=$settlement_day;
	 $status=0;	
	}else{
	 $curr_bal=$buy_quantity;
	 $buy_quant=0;
     $settlement_days='matured';
     $status=1;	 
	}
	
	$sql_buy = "SELECT * FROM tbl_ipo WHERE BO_ID='$buy_bo_id' AND ISIN='$bisin'";
    $buy_share_check= $dbObj->select($sql_buy);
	//print_r($buy_share_check);
	
	if($buy_share_check){
		 $Check_qty =@$buy_share_check[0]["qty"];
		 $Check_Current_Bal =@$buy_share_check[0]["Current_Bal"];
		 $total_check_share=$Check_qty+$Check_Current_Bal;
		 $avg_rat =@$buy_share_check[0]["avg_rate"];
		 $total_costs=$avg_rat*$total_check_share;
		 $total_avg_cost=$total_costs+$buy_gt;
		 $total_qty=$total_check_share+$buy_quantity;
		 $update_qty=$Check_qty+$buy_quantity;
		 $update_mature_qty=$Check_Current_Bal+$buy_quantity;
		 $update_avg_rate=$total_avg_cost/$total_qty;
		 
		 if($CompulsorySpot=="N"){
		 $sql_update_share = "update tbl_ipo set qty='$update_qty',avg_rate='$update_avg_rate' where BO_ID ='$buy_bo_id' AND ISIN='$bisin'";
         $dbObj->update($sql_update_share);
		 }else{
		 $sql_update_share = "update tbl_ipo set Current_Bal='$update_mature_qty',avg_rate='$update_avg_rate' where BO_ID ='$buy_bo_id' AND ISIN='$bisin'";
         $dbObj->update($sql_update_share); 
		 }
		 
	}else{
       	 
         $sql = "insert into tbl_ipo
				(account_no,ISIN,trade_date,BO_ID,instrument,Current_Bal,qty,avg_rate,trans_type,day_count,date)
				values('$buy_ac_no','$bisin','$date_tread','$buy_bo_id','$instrument','$curr_bal','$buy_quant','$buy_avg_rate','B','$settlement_days','$treading_date')";
				$res = $dbObj->insert($sql);
				
	}
	
	$sql_buy_in = "insert into tbl_buy_info
				(account_no,ISIN,trade_date,BO_ID,instrument,Current_Bal,qty,avg_rate,total_amt,commission,trans_type,day_count,status,date,mature_date)
				values('$buy_ac_no','$bisin','$date_tread','$buy_bo_id','$instrument','$curr_bal','$buy_quant','$buy_avg_rate','$buy_gt','$commi','B','$settlement_days','$status','$treading_date','$bmature_date')";
                $res = $dbObj->insert($sql_buy_in);
			 
	 $bdate=date("Y-m-d");
	 $sql_b_charge="INSERT INTO `tbl_charge_info`(code,ac_no,type,description,company_name,short_name,qty,rate,total_amt,commi,total_balance,date)
     VALUES('B','$buy_ac_no','Buy','$instrument','$instrument','NULL','$buy_quantity','$lbuy_avg_rate','$buy_gt','$commi','0.00','$bdate')";
	 $ledger_buy = $dbObj->insert($sql_b_charge);
			   
			   	
 }
 
 
 /* settlement process start*/
 
  $sqlbuying="SELECT account_no,SUM(net_amount)as gt FROM tread_data_list WHERE date_tread='$date_tread' AND status='0' AND type='B' Group By account_no";
  $result_buy_info= $dbObj->select($sqlbuying);
  for($i=0; $i<=count($result_buy_info); $i++){
	$acc_no=@$result_buy_info[$i]["account_no"];
	$buy_amount=@$result_buy_info[$i]["gt"];


	
	$sql_a_b="SELECT * FROM investor WHERE dp_internal_ref_number='$acc_no'";
    $res_avi_bal= $dbObj->select($sql_a_b);
	$total_balance =@$res_avi_bal[0]["total_balance"];
	$totals_buy_update =$total_balance-$buy_amount;
	
	$sql_im="SELECT id,SUM(immatured_bal) as immatured_bal,account_no FROM sale_share WHERE account_no='$acc_no' AND status='0' AND trade_date='$bdate' AND cate!='Z' Group By account_no";
    $immatured_bal_check= $dbObj->select($sql_im);
	 //print_r($immatured_bal_check);
	 //die();
	
	if($immatured_bal_check){
		
	$total_imm =@$immatured_bal_check[0]["immatured_bal"];
	$sell_id =@$immatured_bal_check[0]["id"];
	$account_no =@$immatured_bal_check[0]["account_no"];
	
	  if($buy_amount <= $total_imm){
	  $update_im_bal=$total_imm-$buy_amount;
	  $sqlimu = "update sale_share set immatured_bal='$update_im_bal',settlement_status='1' where id='$sell_id'";
      $dbObj->update($sqlimu);
	  
	  $sql_id="SELECT id,immatured_bal FROM sale_share WHERE account_no='$account_no' AND trade_date='$bdate' AND settlement_status='0' AND cate!='Z'";
      $immatured_row_check= $dbObj->select($sql_id);
	  if($immatured_row_check){
	  for($j=0; $j<=count($immatured_row_check); $j++){
	  $immatured_bal_row =@$immatured_row_check[$j]["id"];
	  $sql12234 = "update sale_share set immatured_bal='0' where id='$immatured_bal_row'";
      $dbObj->update($sql12234);
	    }
	  }
	  }else{ 
      $update_balance=$buy_amount-$total_imm;
	  $total_buy_update=$total_balance-$update_balance;
	   $sql1 = "update investor set total_balance='$total_buy_update' where dp_internal_ref_number ='$acc_no'";
       $dbObj->update($sql1);
	   $sql_id="SELECT id,immatured_bal FROM sale_share WHERE account_no='$account_no' AND trade_date='$bdate' AND settlement_status='0' AND cate!='Z'";
       $immatured_row_check= $dbObj->select($sql_id);
	 
	   if($immatured_row_check){
	   for($j=0; $j<= count($immatured_row_check); $j++){
	  $immatured_bal_row =@$immatured_row_check[$j]["id"];
       $sql122 = "update sale_share set immatured_bal='0' where id ='$immatured_bal_row'";
       $dbObj->update($sql122);
	     }	
	  }
	   
	  }
	
   }else{
	  $sql1 = "update investor set total_balance='$totals_buy_update' where dp_internal_ref_number ='$acc_no'";
      $dbObj->update($sql1); 
   }
   
    $sql2 = "update tread_data_list set status='1' where account_no ='$acc_no' AND type='B'";
    $dbObj->update($sql2);
  }

       echo "<h2 align='center' style='color:#000000'>Successfully Trade Process</h2>";
       echo "<meta http-equiv='refresh' content='1 URL=Protfolio.php?tradeHistory'>";
       exit;
?>