<?php
include("fpdf.php");
include("config.php");
$dbObj = new DBUtility();
$ac_codes=base64_decode($_GET["id"]);
$ac_code=strtoupper($ac_codes);
$currDate = date("Y-m-d");
//die();
session_start();


$sql="SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where investor.dp_internal_ref_number='$ac_code' AND investor_personal.dp_internal_ref_number='$ac_code'";
$res= $dbObj->select($sql);
//print_r($res);
//die();
 $bo_id=@$res[0]['investor_ac_number'];
 
 //Total Capital Gain
 $sqlrg="SELECT SUM(realize_gain) as realize_gain FROM tbl_ipo WHERE account_no='$ac_code'";
 $r_gain=$dbObj->select($sqlrg);
// print_r($r_gain);
 $total_realize_gain=$r_gain[0]["realize_gain"];
 
 
 //Nonmargiable stock share
 $sql1="SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='$bo_id' AND non_marginable='TRUE' AND market_val!=0";
 $result=$dbObj->select($sql1);
 //print_r($result);
 //die();
 
 //Marginable stock share
 $m_sql="SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='$bo_id' AND non_marginable='FALSE' AND market_val!=0";
 $marginable=$dbObj->select($m_sql);
 //print_r($result);
 //die();
   //print_r($non_margin);
  /*  if($marginable){
	$m_sum=0;
   for($i=0; $i<count($marginable);$i++){
	$total_nonmargin_share=@$marginable[$i]['Current_Bal']+@$marginable[$i]['qty']+@$marginable[$i]['bonus_share']+@$marginable[$i]['Lockin_Balance'];
	$marginable_market_value=@$marginable[$i]['market_price']*$total_nonmargin_share;
	$m_sum=$m_sum+$marginable_market_value;
	 }
    }else{
	$m_sum=0;
	}  */
  
  //Cash Dividend Query
 $csql="SELECT * FROM tbl_cash_dividend WHERE bo_id='$bo_id' AND payment_date > '$currDate'";
 $cash_dividend=$dbObj->select($csql);
 
 //Bonus Dividend Query
 $bsql="SELECT * FROM tbl_bonus_share INNER JOIN instrument ON tbl_bonus_share.isin=instrument.isin WHERE bo_id='$bo_id' AND effective_date > '$currDate'";
 $bonus_share=$dbObj->select($bsql);
 
//print_r($bonus_share);
//die();

 $sqlcl="SELECT SUM(total_amt) as total_amt FROM tbl_charge_info WHERE ac_no='$ac_code' AND code!='RF' AND code!='ISC' AND code!='Dp' AND code!='WD'";
 $total_charge=$dbObj->select($sqlcl);
 $total_charge_amt=@$total_charge[0]['total_amt'];


//Accrude fee and charge
 $acmf_sql="SELECT SUM(acmf_interest_amt) as acmf,SUM(daily_interest) as CashEDF FROM tbl_interest_on_credit_bal WHERE ac_no='$ac_code' AND status=0";
 $acmf_fee=$dbObj->select($acmf_sql);
 if($acmf_fee){
	$Excess_Cash_management_Fee=@$acmf_fee[0]['acmf'];
    $Exce_Cash_manage=@$acmf_fee[0]['CashEDF'];	
 }else{
	$Excess_Cash_management_Fee=0;
	$Exce_Cash_manage=0;
  }
  $pm_sql="SELECT SUM(daily_interest)as total_fee_amt FROM tbl_interest WHERE ac_no='$ac_code' AND status=0 AND code='mf'";
  $pm_fee=$dbObj->select($pm_sql);
 if($pm_fee){
	$Portfolio_Management_fee=@$pm_fee[0]['total_fee_amt'];
 }else{
	$Portfolio_Management_fee=0;
  }
 
 $li_sql="SELECT SUM(daily_interest)as total_fee_amt FROM tbl_interest WHERE ac_no='$ac_code' AND status=0 AND code='mi'";
 $loan_fee=$dbObj->select($li_sql);
 if($loan_fee){
	$interest_on_loan=@$loan_fee[0]['total_fee_amt'];
 }else{
	$interest_on_loan=0;
  }
 
 $accrue_charge=$Excess_Cash_management_Fee+$Portfolio_Management_fee+$interest_on_loan-$Exce_Cash_manage;
 
 
 $p_date=date("d-M-Y");

 $investor_name=@$res[0]['investor_name'];
 $AC_Number=@$res[0]['dp_internal_ref_number'];
 $investor_group_id=@$res[0]['investor_group_id'];
 $s="SELECT `group_name`,`loan_cat` FROM `investor_group` WHERE `investor_group_id`='$investor_group_id'";
 $rs= $dbObj->select($s);
 $group_name=@$rs[0]['group_name'];
 $loan_cat=@$rs[0]['loan_cat'];
 
$pdf = new FPDF('p','mm','A4');
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->Image('logo.jpg',12,5,50,20,'jpg');
		$pdf->Ln(6);
		

		$pdf->SetFont('Helvetica','',10);
		$pdf->Write(5, '                                                                                                           Please Contact Our number for trading service');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(5, '                                                                                                                                   01865072871 & 01865072872');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Ln();
		
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		
	    $pdf->SetFont('Helvetica','B',9);
		$pdf->Write(6, '                                                                             '."Investor Portfolio Statement"." ");
		$pdf->Ln();
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                  A/C Status :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,' '.$group_name.'                              Date:  '.$p_date."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Client Code   :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$AC_Number."");
		$pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'BO Number   :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$bo_id."");
		$pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Name   :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor_name."");
		$pdf->Ln(5);
		$pdf->Write(1, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','B',8);
		$width_cell=array(5,25,15,20,15,25,20,25,25,15);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'SL',1,0,'C',true); // First header column
		
		$pdf->Cell($width_cell[1],10,'Company Name',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Total',1,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[3],10,'Saleable',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Avg Cost',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Total Cost',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Market Rate',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Market Value',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[8],10,'u_gain',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[9],10,'gain%',1,1,'C',true); // Fourth header column
		

	
		$sum=0;
		$no_of_share=0;
	    $sql_ipo="SELECT * FROM ipo_application WHERE ac_no='$ac_code' AND status=1 AND process_status IN(0, 3)";
        $res_ipo= $dbObj->select($sql_ipo);
        //print_r($res_ipo);
	 
	 /* marginable Share */
	 if($marginable){
	   $m_sum=0;
	   $m_sums=0;
       $mt_sum=0;
	   $realize_gain=0;
	   $pdf->SetFont('Helvetica','B',9);
	   $pdf->Write(4,'#Marginable:');
	   $pdf->Ln(4);
	   $pdf->Write(1, '-------------------');
	   $pdf->Ln(1);
	   
	  for($i=0; $i<count($marginable);$i++){
		$serial=$i+1;
		$zero=0;		   
		$total_share=@$marginable[$i]['Current_Bal']+@$marginable[$i]['qty']+@$marginable[$i]['bonus_share']+@$marginable[$i]['Lockin_Balance'];
		$avg_rate=str_pad($marginable[$i]['avg_rate'],10," ",STR_PAD_LEFT);
		$avg_rate_v=number_format((float)$avg_rate, 2);
		$cost_per_share=$marginable[$i]['cost_per_share'];
		$BO_Ac_Status=$marginable[$i]['BO_Ac_Status'];
			if($BO_Ac_Status=='ACTIVE' AND $avg_rate==0){
			$avgs_rate=$cost_per_share;
			}else{
			$avgs_rate=$avg_rate;
			}
			if($BO_Ac_Status=='ACTIVE' AND $avg_rate==0){
			$total_cost=$total_share*$cost_per_share;
			}else{
			$total_cost=$total_share*$avg_rate;
			}
		
		if($total_share!=0){
		$m_sum=$m_sum+$total_cost;
		$total_cost=str_pad($total_cost,13," ",STR_PAD_LEFT);
		$total_cost_v=number_format((float)$total_cost, 2);
		$market_value=@$marginable[$i]['market_price']*$total_share;
		$m_sums=@$m_sums+$market_value;
        $unserialize_gain=$market_value-$total_cost;
		$unserialize_gain_v=number_format((float)$unserialize_gain, 2);
		@$gain_percents= $unserialize_gain*100;
		$gain_percent= @$gain_percents/@$total_cost;
		$gain_percent=number_format((float)$gain_percent, 2);
		 $mt_sum=$m_sums-$m_sum;
		 //$realize_gain=$realize_gain+$marginable[$i]['realize_gain'];
		$pdf->SetFont('Helvetica','',8); 
	
// First row of data 
$pdf->Cell($width_cell[0],10,$serial,0,0,'C',false); // First column of row 1 
$pdf->Cell($width_cell[1],10,@$marginable[$i]['instrument'],0,0,'C',false); // Second column of row 1 
$pdf->Cell($width_cell[2],10,$total_share,0,0,'C',false); // Third column of row 1 
$pdf->Cell($width_cell[3],10,@$marginable[$i]['Current_Bal'],0,0,'C',false); // Fourth column of row 1
$pdf->Cell($width_cell[4],10,$avgs_rate,0,0,'C',false); // Fourth column of row 1 
$pdf->Cell($width_cell[5],10,$total_cost_v,0,0,'C',false); // Fourth column of row 1 
$pdf->Cell($width_cell[6],10,$marginable[$i]['market_price'],0,0,'C',false); // Fourth column of row 1 
$pdf->Cell($width_cell[7],10,$market_value,0,0,'C',false); // Fourth column of row 1 
$pdf->Cell($width_cell[8],10,$unserialize_gain_v,0,0,'C',false); // Fourth column of row 1 
$pdf->Cell($width_cell[9],10,$gain_percent,0,1,'C',false); // Fourth column of row 1  
$pdf->Write(1, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
$pdf->Ln(1);
	}else{
		
	}
	  }
	  
	 }
	 
	 /*Non margiable Share*/
	 if($result){
       $sum=0;
	   $sums=0;
       $t_sum=0;
	   //$realize_gain=0;
	 $pdf->SetFont('Helvetica','B',9);
	 $pdf->Write(4,'#Non Marginable:');
	 $pdf->Ln(4);
	 $pdf->Write(1, '------------------------');
	 $pdf->Ln(3);
      for($i=0; $i<count($result);$i++){
		$serial=$i+1;
		$zero=0;		   
		$total_share=@$result[$i]['Current_Bal']+@$result[$i]['qty']+@$result[$i]['bonus_share']+@$result[$i]['Lockin_Balance'];
		$avg_rate=str_pad($result[$i]['avg_rate'],10," ",STR_PAD_LEFT);
		$avg_rate_v=number_format((float)$avg_rate, 2);
		$cost_per_share=$result[$i]['cost_per_share'];
			if($avg_rate==0){
			$avgs_rate=$cost_per_share;
			}else{
			$avgs_rate=$avg_rate;
			}
			if($avg_rate==0){
			$total_cost=$total_share*$cost_per_share;
			}else{
			$total_cost=$total_share*$avg_rate;
			}
		
		if($total_share!=0){
		$sum=$sum+$total_cost;
		$total_cost=str_pad($total_cost,13," ",STR_PAD_LEFT);
		$total_cost_v=number_format((float)$total_cost, 2);
		$market_value=@$result[$i]['market_price']*$total_share;
		$sums=$sums+$market_value;
        $unserialize_gain=$market_value-$total_cost;
		$unserialize_gain_v=number_format((float)$unserialize_gain, 2);
		$gain_percents= $unserialize_gain*100;
		$gain_percent= $gain_percents/$total_cost;
		
		$gain_percent=number_format((float)$gain_percent, 2);
		 $t_sum=$sums-$sum;
		 //$realize_gain=$realize_gain+$result[$i]['realize_gain'];
		
		 
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,$serial,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$result[$i]['instrument'],0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,$total_share,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$result[$i]['Current_Bal'],0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$avgs_rate,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$total_cost_v,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$result[$i]['market_price'],0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[7],10,$market_value,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[8],10,$unserialize_gain_v,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[9],10,$gain_percent,0,0,'C',false); // Fourth column of row 1  
		$pdf->Write(1, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(10);
		
	}else{
		
	  }
	 }
	} 
	 $total_cost_val =@$sum+@$m_sum;
	 $total_cost_val=number_format((float)$total_cost_val, 2);
	 $total_market_val =@$sums+@$m_sums;
	 $total_market_val=number_format((float)$total_market_val, 2);
	 $total_unrealize_gain =@$t_sum+@$mt_sum;
	 $total_unrealize_gain=number_format((float)$total_unrealize_gain, 2);
	
	 
	  
	  $sqls="SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$ac_code' AND status=0 Group By account_no";
	  $ress=$dbObj->select($sqls);
      $immatured_bal=@$ress[0]['im_bal'];
	  $immatured_bal_v=number_format((float)$immatured_bal, 2);
    
  
     $sqlb="SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_code' AND status=0 Group By account_ref";
     $res_bal= $dbObj->select($sqlb);
     $unclear_cheque=@$res_bal[0]['deposit_amt'];
	 $unclear_cheque_v=number_format((float)$unclear_cheque, 2);
	 
	 
	 $sqld="SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_code' AND status=2 Group By account_ref";
     $depo_bal= $dbObj->select($sqld);
     $deposits_amt=@$depo_bal[0]['deposit_amt'];
	 $deposit_amt=number_format((float)$deposits_amt, 2);

	 $sqlw="SELECT SUM(withdraw_amt) as withdraw_amt FROM tbl_withdraw_balance WHERE account_ref='$ac_code' AND status=2 Group By account_ref";
     $withdraw_bal= $dbObj->select($sqlw);
     $withdraws_amt=@$withdraw_bal[0]['withdraw_amt'];
	 $withdraw_amt=number_format((float)$withdraws_amt, 2);
	 
	 $net_deposite=$deposits_amt-$withdraws_amt-$total_charge_amt;
	 $net_deposite=number_format((float)$net_deposite, 2);
	 
  
  //echo $unclear_cheque;
     $ledger_bal=@$res[0]['total_balance']+$unclear_cheque+$immatured_bal;
	 $ledger_bal_v=number_format((float)$ledger_bal, 2);
     $total_balance=@$res[0]['total_balance'];
	 $total_balance_v=number_format((float)$total_balance, 2);
	 
     $total_equity=$ledger_bal+@$sums+@$m_sums-$unclear_cheque-$accrue_charge;
	 $total_equity=number_format((float)$total_equity, 2);
	 $marginable_total_equity=$ledger_bal+@$m_sums-$unclear_cheque-$accrue_charge;
	 $marginable_total_equity=number_format((float)$marginable_total_equity, 2);
	 if($ledger_bal < 0){
	    $debit_ratio=($total_equity/$ledger_bal)*100;
		$debit_ratio=(abs($debit_ratio));
		$debit_ratio=round($debit_ratio, 2);
	 }else{
		  $debit_ratio="0.00";
	 }
	 
	 
	 //margin Utility  another system
 /*  $sql_m="SELECT * FROM tbl_margin_loan INNER JOIN investor ON investor.dp_internal_ref_number = tbl_margin_loan.ac_no where tbl_margin_loan.ac_no='$ac_code' AND tbl_margin_loan.status='1'";
  $margin_loan=$dbObj->select($sql_m);
 $margin_ratio=@$margin_loan[0]['margin_ratio']; 
 //print_r($margin_loan);
 //echo $margin_ratio;
 
		
 if($margin_ratio){
	$purchase_power=$total_balance+$immatured_bal*$margin_ratio;
 }else{
	$purchase_power=$total_balance;
 }*/
if($loan_cat){
$sql2l="SELECT * FROM `loan_catagory_margin` WHERE id='$loan_cat'";
		 $margin_cat= $dbObj->select($sql2l);
		 $margin_ratio=@$margin_cat[0]['margin_ratio'];
		
	 $purchase_power=@$m_sums*$margin_ratio+$ledger_bal-$unclear_cheque;
	 //$loan_ratio=$ledger_bal/$sums;
	 //$loan_ratio=round($loan_ratio, 2);
    }else{
	  $margin_ratio="N/A";
	  $purchase_power=$total_balance;
     }
	 $pdf->Write(1, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
	 $pdf->Ln(1);
	 $pdf->SetFont('Helvetica','',10);
	 $pdf->Write(5, "Total :                                                                        $total_cost_val                          $total_market_val         $total_unrealize_gain" );
	 $pdf->Ln(10);
		
		$pdf->SetFont('Helvetica','',10);
		$pdf->Write(8, 'Account Status Till Today');
		$pdf->Ln(10);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Available Balance  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$total_balance_v."");
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                         Market Value of Securities :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,' '.$total_market_val."");
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Immatured Balance  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$immatured_bal_v."");
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                         Equity(All Instrument) :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,' '.$total_equity."");
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Unclear Cheque  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$unclear_cheque_v."");
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                         Equity(Marginable Instrument) :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,' '.$marginable_total_equity."");
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Ledger Balance  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$ledger_bal_v."");
		$pdf->Ln(8);
		
		$pdf->SetFont('Helvetica','',10);
		$pdf->Write(8, 'Deposit Withdraw Status');
		$pdf->Ln(10);
		
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Total Deposit  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$deposit_amt."");
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                         Purchase Power :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,' '.$purchase_power."");
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Total Withdraw  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$withdraw_amt."");
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                         Equity to Debt. Ratio :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,' '.$debit_ratio."");
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Net Deposit  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$net_deposite."");
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                         Loan Ratio :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,' '.$margin_ratio."");
		$pdf->Ln(8);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4, 'Accrude Fees and Charge  : ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$accrue_charge."");
		$pdf->Ln(6);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Realized Capital Gain  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.@$total_realize_gain."");
		$pdf->Ln(6);
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Unrealized Capital Gain  :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.@$total_unrealize_gain."");
		$pdf->Ln(12);
		
		
		if($bonus_share OR $res_ipo){
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(5, 'Discrepancy in Statement  must be notified  in written within 7 days from statement date.Otherwise this statement is considered correct');
		$pdf->Ln(5);
		}
		
		if($bonus_share){
	    $width_cell=array(30,30,30,30,30,20,20);
		$pdf->SetFillColor(255,255,255);
	    $pdf->SetFont('Helvetica','B',9);
		$pdf->Write(5, 'BONUS RECEIVABLES');
		$pdf->Ln();
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(1, '----------------------------------------------');
		$pdf->Ln(3);
		$pdf->Cell($width_cell[0],10,'Instrument Name',0,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Effective/Applied',0,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Declare On',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Holding',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Quantity',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Rate',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Total Amount',0,0,'C',true); // Fourth header column
		$pdf->Ln(6);
		  $d_sum=0;
		for($i=0; $i<count($bonus_share);$i++){
        $effective_date = date('d-M-Y', strtotime($bonus_share[$i]['effective_date']));
		$pdf->SetFont('Helvetica','',8); 
        $pdf->Cell($width_cell[0],10,$bonus_share[$i]['isin_short_name'],0,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,$effective_date,0,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,$bonus_share[$i]['record_date'],0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,$bonus_share[$i]['bo_holding'],0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,$bonus_share[$i]['qty'],0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,$bonus_share[$i]['market_price'],0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,$bonus_share[$i]['qty']*$bonus_share[$i]['market_price'],0,0,'C',true); // Fourth header column		
		$pdf->Ln(5);
	}
	
   }
   
       $pdf->Ln(6);
		if($res_ipo){
		$width_cell=array(30,30,30,30,30,40);
		$pdf->SetFillColor(255,255,255);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(5, 'IPO Application');
		$pdf->Ln();
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(1, '----------------------------------------------');
		$pdf->Ln(3);
		$pdf->Cell($width_cell[0],10,'Instrument Name',0,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Effective/Applied',0,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Declare On',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Holding',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Quantity',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Total Amount',0,0,'C',true); // Fourth header column
		$pdf->Ln(6);
		
		 for($i=0; $i<count($res_ipo);$i++){
		$ipo_date=$res_ipo[$i]['date'];
		$dec_date=$res_ipo[$i]['dec_date'];
		$process_status=$res_ipo[$i]['process_status'];
		if($process_status==3){
		$total_amt=$res_ipo[$i]['total_amt']-$res_ipo[$i]['refund_amt'];	
		}else{
		$total_amt=$res_ipo[$i]['total_amt'];
		}
		
		$applied_date = date('d-M-Y', strtotime($ipo_date));
		$declaration_date = date('d-M-Y', strtotime($dec_date));
		$pdf->SetFont('Helvetica','',8); 
        $pdf->Cell($width_cell[0],10,$res_ipo[$i]['short_name'],0,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,$applied_date,0,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,$declaration_date,0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'0',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,$res_ipo[$i]['market_lot'],0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,$total_amt,0,0,'C',true); // Fourth header column		
		$pdf->Ln(6);
		}
	}
	
	
	$pdf->Ln(6);
	if($cash_dividend){
		$width_cell=array(40,40,40,30,30,40);
		$pdf->SetFillColor(255,255,255);
	
	    $pdf->SetFont('Helvetica','B',9);
		$pdf->Write(5, 'DIVIDENDS RECEIVABLES');
		$pdf->Ln();
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(1, '----------------------------------------------');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell($width_cell[1],10,'Instrument Name',0,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Cash Payment Date',0,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[3],10,'Record Date',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Holding',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Net Cash Amount',0,0,'C',true); // Fourth header column
		$pdf->Ln(6);
		  $total_cash=0;
		 for($i=0; $i<count($cash_dividend);$i++){
			 $payment_date = date('d-M-Y', strtotime($cash_dividend[$i]['payment_date']));
			 $t_sum=$cash_dividend[$i]['net_cash'];
			 $total_cash=$total_cash+$t_sum;
		$pdf->SetFont('Helvetica','',9);
        $pdf->Cell($width_cell[1],10,@$cash_dividend[$i]['short_name'],0,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,$payment_date,0,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[3],10,$cash_dividend[$i]['record_date'],0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,$cash_dividend[$i]['bo_holding'],0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,$cash_dividend[$i]['net_cash'],0,0,'C',true); // Fourth header column	
		$pdf->Ln(6);
	  }
	    $pdf->SetFont('Helvetica','B',9);
	  	$pdf->Write(4, '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       ---------------------------------------------------------');
        $pdf->Ln();
	    $pdf->SetFont('Helvetica','',9);
        $pdf->Cell($width_cell[1],10,'',0,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'',0,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[3],10,'',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Total: ',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,$total_cash,0,0,'C',true); // Fourth header column	
		$pdf->Ln(6);
		
    }
        $pdf->Ln(6);
        $pdf->SetFont('Arial','',8);
		$pdf->Write(4, 'Disclaimer: This report is for CAPM Advisory Limited internal use only.This documentmust not be shared other than the person it is intended for');
		$pdf->Ln(5);
        $pdf->SetFont('Arial','B',12);
		$pdf->Write(4, 'CAPM Advisory Limited');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'Tower Hamlet (9th Floor), Kemal Ataturk Avenue, Banani C/A, Dhaka-1213,Bangladesh 
		Contact Us|Tel: +88-02-9822391-2|Fax:+88-02-9822393|Email:  |Web: www.capmadvisorybd.com');
//$fileName = 'homework-' . $_POST['teacher_name'] . '.pdf';
//$pdf->Output( './pms_doc_upload/'.$fileName,'F');
$fileName ='investor_protfolio_'.$ac_code.'.pdf';
$pdf->Output($fileName, 'I');
$pdf->Output();
 exit;

		
?>