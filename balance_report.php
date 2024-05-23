<?php
require('fpdf.php');
include "config.php";
$dbObj = new DBUtility();
$ac_code="Check";
$date=date("d-m-Y");

/* Start Avaiable Balance Query */

$sql="SELECT SUM(total_balance) as total_balance FROM investor where investor.status='0' AND investor.total_balance>=0";
$res= $dbObj->select($sql);
$total_investor_bal=$res[0]['total_balance'];

$sql1="SELECT SUM(total_balance) as total_balance FROM investor where investor.status='0' AND investor.total_balance<=0";
$ress= $dbObj->select($sql1);
$total_investor_loan_bal=$ress[0]['total_balance'];
$total_avi_bal=($total_investor_bal)+($total_investor_loan_bal);

/*End Avaiable Balance Query */


/* Start Bank Balance Query */

$sql4="SELECT SUM(balance) as balance FROM bank_ac where bank_ac.account_use='1'";
$result= $dbObj->select($sql4);
$balance=$result[0]['balance'];
$sqlpr="SELECT * FROM tbl_broker_pay_recei";
$broker_pay_rec = $dbObj->select($sqlpr);
$payable_bal=$broker_pay_rec[0]['payable_bal'];
$receiable_bal=$broker_pay_rec[0]['receiable_bal'];


/* End Bank Balance Query */




$pdf=new FPDF();
		$pdf->AddPage();
		$pdf->Ln(8);
		$pdf->SetFont('Helvetica','B',18);
		$pdf->Write(4, 'CAPM Advisory Ltd');
		$pdf->Ln(6);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(8, 'A New Generation Merchant Bank');
		$pdf->Ln(6);
		
		
		$pdf->SetFont('Helvetica','',10);
		$pdf->Write(5, '                                                                                                           Please Contact Our new number for trading service');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(5, '                                                                                                                           01865072871 & 01865072872');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Ln();
		
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(5, 'Portfolio Balance');
		$pdf->Ln();
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------');
		$pdf->Ln(3);
		
		$pdf->Write(6, '');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Portfolio Total Avaiable Balance   :                                       ');
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,''.$total_investor_bal." /=");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Portfolio Total Loan Balance   :                                        ');
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,''.$total_investor_loan_bal." /=");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '--------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Total Avaiable Balance     :                                  ');
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,''.$total_avi_bal." /=");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '');
		$pdf->Ln(8);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(5, 'Portfolio Bank Balance');
		$pdf->Ln();
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Total Bank Balance   :                                       ');
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,''.$balance." /=");
		$pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Broker Payable   :                                       ');
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,''.$payable_bal." /=");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Broker Receiable  :                                       ');
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,''.$receiable_bal." /=");
		$pdf->Ln(5);
		
		$fileName ='protfolio_balance_'.$ac_code.'.pdf';
		$pdf->Output($fileName, 'D');
	    $pdf->Output();
         exit();
	   
	   
	   ?>