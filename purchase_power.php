<?php
 include("fpdf/mpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $as_on=@$_POST["as_on"];


if($as_on){
 $sql="SELECT investor_name,dp_internal_ref_number,investor_ac_number,total_balance FROM investor where status=0 ORDER BY dp_internal_ref_number ASC";
 $result= $dbObj->select($sql);
  

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Purchase Power',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(4, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');

		$pdf->Ln(3);

		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(0,10, "Trading Date: ".date("d-M-Y", strtotime($as_on)),0,0,'R');
		$pdf->Ln(7);
		
		$width_cell=array(20,40,26,26,26,25,25);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'Client Code',B,0,'L',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Client Name',B,0,'L',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Ledger Balance',B,0,'L',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Ava. Balance',B,0,'L',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Total Equity',B,0,'L',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Margiable Equity',B,0,'L',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Purchase power',B,0,'L',true); // Fourth header column
		$pdf->Ln(10);
		
	if($result){
		
		for($i=0; $i< count($result); $i++){
		$investor_name=$result[$i]['investor_name'];
		$ac_no=$result[$i]['dp_internal_ref_number'];
		$total_balance=$result[$i]['total_balance'];
		$bo_id=$result[$i]['investor_ac_number'];
		//Nonmargiable stock share
     $sql1="SELECT SUM(market_val)as nonmmarket_val FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='$bo_id' AND non_marginable='TRUE' AND market_val!=0";
     $mres=$dbObj->select($sql1);
     $nonmargin_market_val=@$mres[0]['nonmmarket_val'];
 
    //Marginable stock share
    $m_sql="SELECT SUM(market_val)as mmarket_val FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='$bo_id' AND non_marginable='FALSE' AND market_val!=0";
    $marginable=$dbObj->select($m_sql);
	$marginable_market_val=@$marginable[0]['mmarket_val'];
	$total_market_value=$nonmargin_market_val+$marginable_market_val;
	//Accrude fee and charge
 $acmf_sql="SELECT SUM(acmf_interest_amt) as acmf,SUM(daily_interest) as CashEDF FROM tbl_interest_on_credit_bal WHERE ac_no='$ac_no' AND status=0";
 $acmf_fee=$dbObj->select($acmf_sql);
 if($acmf_fee){
	$Excess_Cash_management_Fee=@$acmf_fee[0]['acmf'];
    $Exce_Cash_manage=@$acmf_fee[0]['CashEDF'];	
 }else{
	$Excess_Cash_management_Fee=0;
	$Exce_Cash_manage=0;
  }
 $pm_sql="SELECT SUM(daily_interest)as total_fee_amt FROM tbl_interest WHERE ac_no='$ac_no' AND status=0 AND code='mf'";
 $pm_fee=$dbObj->select($pm_sql);
 if($pm_fee){
	$Portfolio_Management_fee=@$pm_fee[0]['total_fee_amt'];
 }else{
	$Portfolio_Management_fee=0;
  }
 
 $li_sql="SELECT SUM(daily_interest)as total_fee_amt FROM tbl_interest WHERE ac_no='$ac_no' AND status=0 AND code='mi'";
 $loan_fee=$dbObj->select($li_sql);
 if($loan_fee){
	$interest_on_loan=@$loan_fee[0]['total_fee_amt'];
 }else{
	$interest_on_loan=0;
  }
 
    $accrue_charge=@$Excess_Cash_management_Fee+@$Portfolio_Management_fee+@$interest_on_loan-@$Exce_Cash_manage;
	
		
	 $sqlb="SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_no' AND status=0 Group By account_ref";
     $res_bal= $dbObj->select($sqlb);
     $unclear_cheque=@$res_bal[0]['deposit_amt'];
	 
	  $sqls="SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$ac_no' AND status=0 Group By account_no";
	  $ress=$dbObj->select($sqls);
      $immatured_bal=@$ress[0]['im_bal'];
	  
	  $ledger_bal=($total_balance+$unclear_cheque+$immatured_bal);
	  $total_equity=$ledger_bal+@$total_market_value-$unclear_cheque-$accrue_charge;
	  $marginable_total_equity=$ledger_bal+@$marginable_market_val-$unclear_cheque-$accrue_charge;
	
		 
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell($width_cell[0],10, $ac_no,0,0,'L',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $investor_name,0,0,'L',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,number_format((float)$ledger_bal, 2),0,0,'L',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,number_format((float)$total_balance, 2),0,0,'L',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,number_format((float)$total_equity, 2),0,0,'L',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,number_format((float)$marginable_total_equity, 2),0,0,'L',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,number_format((float)$total_balance, 2),0,0,'L',true); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(6, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);  	

		}
		
	}
}
	
$fileName ='purchase_power_'.$as_on.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>