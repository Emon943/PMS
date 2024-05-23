<?php
include("fpdf.php");
include("config.php");
$dbObj = new DBUtility();
$id=base64_decode($_GET["id"]);
session_start();
$p_date=date("d-M-Y");
$company="CAPM Advisory Ltd";


$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->Ln(8);
		$pdf->SetFont('Helvetica','B',18);

		$pdf->Write(4, 'CAPM Advisory Ltd');
		$pdf->Ln(6);
		

		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(5, '                                                                                                                                 Summary of the Applicationss');
		$pdf->SetFont('Helvetica','',7);
		$pdf->Ln();
		$pdf->Write(6, ''.$p_date." ");
		$pdf->Ln();
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '--------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(5);
		
	
	 $pdf->Cell(0, 10, "Name of the Stock Broker/Merchant Bank: CAPM Advisory Ltd", 1, 1);
	 $pdf->Cell(0, 10, "Name of the Company/Fund: $id", 1, 1);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(70,5,'Category',1);
		$pdf->Cell(30,5,'No. of Applicant',1);
		$pdf->Cell(30,5,'No. of shares',1);
		$pdf->Cell(15,5,'BDT',1);
		$pdf->Cell(15,5,'USD',1);
		$pdf->Cell(15,5,'GBP',1);
		$pdf->Cell(15,5,'EURO',1);

		
		$pdf->Ln(5);
		
		  
	     $sql="SELECT applicant_type, count(ac_no) as no_of_app,sum(total_amt) as total_amt, sum(market_lot)as no_of_share,	currency FROM ipo_application WHERE status=1 AND company_id='$id' group by applicant_type";
         $res= $dbObj->select($sql);
		 
		 

 
       // print_r($res);
		 //die();
      
		
       for($i=0; $i<count($res);$i++){
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(70,5,@$res[$i]['applicant_type'],1);
		$pdf->Cell(30,5,@$res[$i]['no_of_app'],1);
		$pdf->Cell(30,5,@$res[$i]['no_of_share'],1);
		if(@$res[$i]['currency']=='BDT'){
		$pdf->Cell(15,5,@$res[$i]['total_amt'],1);
		}else{
		$pdf->Cell(15,5,'0',1);
		}
		if(@$res[$i]['currency']=='USD'){
		$pdf->Cell(15,5,@$res[$i]['total_amt'],1);
		}else{
		$pdf->Cell(15,5,'0',1);
		}
		if(@$res[$i]['currency']=='GBP'){
		$pdf->Cell(15,5,@$res[$i]['total_amt'],1);
		}else{
		$pdf->Cell(15,5,'0',1);
		}
		if(@$res[$i]['currency']=='EURO'){
		$pdf->Cell(15,5,@$res[$i]['total_amt'],1);
		}else{
		$pdf->Cell(15,5,'0',1);
		}
		
		$pdf->Ln(5);
	}
		
		
$pdf->Output();
 exit;

		
?>