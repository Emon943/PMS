<?php
ob_start();
require('fpdf/mpdf.php');
include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
$db_obj=new PMS;
 $print_date=date("d-M-Y");
 $as_on=@$_POST["as_on"];
class h4PDF extends FPDF{
    function Header(){
		$as_on=@$_POST["as_on"];
		$Date = date("d-M-Y", strtotime($as_on));
		
		$this->SetY(3);
	$this->SetFont('Arial','',6);
	$this->Cell(0,10,'Contact Us | Tel: +88-02-9822391-2 | Mob: 01865072871-72',0,0,'R');
	$this->Ln(2.5);
	$this->SetFont('Arial','',6);
	$this->Cell(240,10,'Email:',0,0,'R');
	$this->SetX(248.75);
	$this->SetFont('Arial','U',6);
	$this->SetTextColor(26,13,171);
	$this->Cell(0,10,'contact@capmadvisorybd.com',0,0);
	$this->Ln(7);
	$this->SetFont('Arial','B',16);
	$this->SetTextColor(0);
	$this->Cell(0,10,'CAPM Advisory Limited',0,0,'C');
	$this->Ln(8);

		$this->AddFont('ArialNarrow','','Arialn.php');
    	$this->SetFont('ArialNarrow','',12);
		$this->Cell(0,10,'Current Investment Position',0,0,'C');
		$this->Ln(13);
		$this->SetFont('Helvetica','B',10);
		$this->Cell($width_cells[0],0,'',1,0,C,true); // First header column 
		$this->Ln(3);
		$this->SetFont('Helvetica','B',9);
		 $this->Write(6,'                                                                                                                                                                                                                                                                                Date: ');
		 $this->SetFont('Helvetica','',9);
		 $this->Write(6,''.$Date."");
		 $this->Ln(5);
		
$width_cells=array(100,100,40);
$width_cell=array(15,15,15,15,15,20,15,15,15,15,15,15,15,15,15,15,15,20);
$this->SetFillColor(255,255,255); // Background color of header 
// Header starts ///


$this->SetFont('Arial','B',6);
$this->Cell($width_cell[0],10,'Client Code',B,0,'C',true); // Third header column 
$this->Cell($width_cell[1],10,'Client Name',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[2],10,'Account',B,0,'C',true); // Third header column 
$this->Cell($width_cell[3],10,'Margin',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[4],10,'Ledger Bal',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[5],10,'Unclear Cheque',B,0,'C',true); // Third header column 
$this->Cell($width_cell[6],10,'Total Market',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[7],10,'M Market',B,0,'C',true); // Third header column 
$this->Cell($width_cell[8],10,'TotalCost Val',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[9],10,'MCost Value',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[10],10,'Total Equity',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[11],10,'M Equity',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[12],10,'Total Deposit',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[13],10,'Fund Trans',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[14],10,'Total Withdraw',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[15],10,'Accrued',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[16],10,'Fund Trans',B,0,'C',true); // Fourth header column
$this->Cell($width_cell[17],10,'Purchase Power',B,0,'C',true); // Fourth header column
$this->Ln(10);
}

function Footer(){
	$this->SetY( -15 ); 
    $this->Cell(270,0,' ',1,4,true);
    $this->SetFont( 'Arial', '', 6 ); 
    $this->SetX($this->lMargin);
    $this->Cell(0,9,'Tower Hamlet (9th Floor) ',0,0,'C');
	$this->Ln(2.75);
	$this->Cell(0,10,'16, Kemal Ataturk Avenue, Banani, Dhaka-1213',0,0,'C');
    $this->SetX($this->lMargin);
    $this->Cell( 0, 10, "Printed On- ".date('d-M-Y h:i:s'), 0, 0, 'L' );
    $this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'R');
}

}

if($as_on){
 $sql="SELECT dp_internal_ref_number FROM investor where status=0 ORDER BY dp_internal_ref_number ASC";
 $result_ac= $dbObj->select($sql);
 
$pdf = new h4PDF('P','mm',array(290,330));
        $pdf->PageNo();
	    $pdf->AddPage();
		$pdf->AliasNbPages();
		$width_cell=array(15,15,15,15,15,20,15,15,15,15,15,15,15,15,15,15,15,20);
		$pdf->SetFillColor(255,255,255);
if($result_ac){
		
for($j=0; $j< count($result_ac); $j++){

	$ac_code=$result_ac[$j]['dp_internal_ref_number'];
	
	 $sqld="SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_code' AND status=2 Group By account_ref";
     $depo_bal= $dbObj->select($sqld);
     $deposits_amt=@$depo_bal[0]['deposit_amt'];
	 $deposit_amt=number_format((float)$deposits_amt, 2);

	 $sqlw="SELECT SUM(withdraw_amt) as withdraw_amt FROM tbl_withdraw_balance WHERE account_ref='$ac_code' AND status=2 Group By account_ref";
     $withdraw_bal= $dbObj->select($sqlw);
     $withdraws_amt=@$withdraw_bal[0]['withdraw_amt'];
	 $withdraw_amt=number_format((float)$withdraws_amt, 2);
	
	
	
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
 
 /* End Accrude fee and charge */
 
$db_obj->sql("SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where investor.dp_internal_ref_number='$ac_code' AND investor_personal.dp_internal_ref_number='$ac_code'");
$res=$db_obj->getResult();
$investor_group_id=@$res[0]['investor_group_id'];
$bo_catagory=$res[0]['bo_catagory'];

 $db_obj->sql("SELECT * FROM tbl_bo_cate WHERE id='".$db_obj->EString($bo_catagory)."'");
 $bo_type=$db_obj->getResult();
 $cate_name=@$bo_type[0]['cate_name'];
//print_r($res);
 $bo_id=@$res[0]['investor_ac_number'];
 $db_obj->sql("SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='".$db_obj->EString($bo_id)."'");
 $result=$db_obj->getResult();
 //print_r($result);

 $sum=0;
 $sums=0;
 for($i=0; $i<count($result); $i++){
	 
		    $total_share=@$result[$i]['Current_Bal']+@$result[$i]['qty']+@$result[$i]['bonus_share']+@$result[$i]['Lockin_Balance'];
			$avg_rate=$result[$i]['avg_rate'];
			$cost_per_share=$result[$i]['cost_per_share'];
			if($avg_rate==0){
			$ipo_total_cost=$total_share*$cost_per_share;
			}else{
			$ipo_total_cost=0;
			}
			$total_cost=$total_share*$avg_rate;
			$sum=@$sum+$total_cost+$ipo_total_cost;
			$market_value=@$result[$i]['market_price']*$total_share;
			$sums=@$sums+$market_value;
			$u_gain=@$sums-$sum;
		    $u_gain=number_format((float)$u_gain, 2);
			
			
	}

 //print_r($result);
 
 //Marginable stock share
 $db_obj->sql("SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='$bo_id' AND non_marginable='FALSE'");
 $marginable= $db_obj->getResult();
   //print_r($non_margin);
   if($marginable){
	$m_sum=0;
   for($i=0; $i<count($marginable);$i++){
	$total_nonmargin_share=@$marginable[$i]['Current_Bal']+@$marginable[$i]['qty']+@$marginable[$i]['bonus_share']+@$marginable[$i]['Lockin_Balance'];
	$marginable_market_value=@$marginable[$i]['market_price']*$total_nonmargin_share;
	$m_sum=$m_sum+$marginable_market_value;
	 }
    }else{
	$m_sum=0;
	}
   
	 
 $sqls=$db_obj->sql("SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$ac_code' AND status=0 Group By account_no");
 $ress= $db_obj->getResult();
 $im_bal=@$ress[0]['im_bal'];
 $immatured_bal=number_format((float)$im_bal, 2);
 // echo $immatured_bal;
  
 $sqlb=$db_obj->sql("SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_code' AND status=0 Group By account_ref");
 $res_bal= $db_obj->getResult();
 $unclear_cheque=@$res_bal[0]['deposit_amt'];
 $unclear_cheque=round($unclear_cheque, 2);
 $unclear_cheque_v=number_format((float)$unclear_cheque, 2);
  //echo $unclear_cheque;
  $ledger_bal=@$res[0]['total_balance']+$unclear_cheque+$im_bal;
  $ledger_bal_v=number_format((float)$ledger_bal, 2);
  
  $total_balance=@$res[0]['total_balance'];
  $avi_bal_v=number_format((float)$total_balance, 2);
  $total_equity=$ledger_bal+$sums-$accrue_charge;
  
  
  /*loan Exproser limit*/
  if(@$total_equity > 0){
  $loans_utilize=round(@$ledger_bal/$total_equity*100,2);
  }
  if(@$loans_utilize < 0){
	$loan_utilize=abs($loans_utilize);
    $db_obj->sql("SELECT * FROM loan_catagory_exposure");
    $loan_exploser=$db_obj->getResult(); 
 //print_r($loan_exploser);
 

	$exposure_from=$loan_exploser[0]['exposure_from'];
	$esposure_to=$loan_exploser[0]['esposure_to'];
	$exposure_from1=$loan_exploser[1]['exposure_from'];
	$esposure_to1=$loan_exploser[1]['esposure_to'];
	$exposure_from2=$loan_exploser[2]['exposure_from'];
	$esposure_to2=$loan_exploser[2]['esposure_to'];
	$exposure_from3=$loan_exploser[3]['exposure_from'];
	$esposure_to3=$loan_exploser[3]['esposure_to'];
	 
 if(@$loan_utilize > $exposure_from && @$loan_utilize < $esposure_to){
		 $code=$loan_exploser[0]['code'];
	 }elseif(@$loan_utilize > @$exposure_from1 && @$loan_utilize < @$esposure_to1){
		  $code=$loan_exploser[1]['code'];
	 }elseif(@$loan_utilize > $exposure_from2 && $loan_utilize < $esposure_to2){
		 $code=$loan_exploser[2]['code'];
	 }elseif(@$loan_utilize >= $exposure_from3 && $loan_utilize <= $esposure_to3){
		$code=$loan_exploser[3]['code'];
	 }
  }else{
	 $loan_utilize="0.00";
	 $code="N/A";
  } 
	  
  /*End loan exproser*/
  
 
  $db_obj->sql("SELECT `group_name`,`loan_cat` FROM `investor_group` WHERE `investor_group_id`='$investor_group_id'");
  $rs=$db_obj->getResult();
  $group_name=@$rs[0]['group_name'];
  $loan_cat=@$rs[0]['loan_cat'];
  
 /*Start Purchase Power*/ 
  if($loan_cat){
     $db_obj->sql("SELECT * FROM `loan_catagory_margin` WHERE id='$loan_cat'");
     $margin_cat=$db_obj->getResult();

	 $margin_ratio=@$margin_cat[0]['margin_ratio'];
		
	 $purchase_power=$m_sum*$margin_ratio+$ledger_bal-$unclear_cheque;
	 //$loan_ratio=$ledger_bal/$sums;
	 //$loan_ratio=round($loan_ratio, 2);
    }else{
	  $margin_ratio="N/A";
	  $purchase_power=$total_balance;
     }
 /*End Purchase Power*/ 

		 
		$pdf->SetFont('Helvetica','',7);
		$pdf->Cell($width_cell[0],10, $res[0]['dp_internal_ref_number'],0,0,'L',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $res[0]['investor_name'],0,0,'L',FALSE); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$cate_name,0,0,'C',FALSE); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$margin_ratio,0,0,'C',FALSE); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$ledger_bal_v,0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$unclear_cheque_v,0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,number_format((float)$sums, 2),0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,number_format((float)$sums, 2),0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,number_format((float)$sum, 2),0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[9],10,number_format((float)$sum, 2),0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[10],10,number_format((float)$total_equity, 2),0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[11],10,number_format((float)$total_equity, 2),0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[12],10,$deposit_amt,0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[13],10,'0.00',0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[14],10,$withdraw_amt,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[15],10,$accrue_charge,0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[16],10,'0.00',0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Cell($width_cell[17],10,$purchase_power,0,0,'C',FALSE); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(6, '-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);  	

		}
		
	}
}

$fileName ='current_position'.$as_on.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();

?>