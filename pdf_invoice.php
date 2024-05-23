<?php
include("fpdf.php");
include("config.php");
$dbObj = new DBUtility();
$id=base64_decode($_GET["id"]);
session_start();
$sql="SELECT * FROM ipo_application WHERE company_id='$id' and status=1";
$res= $dbObj->select($sql);
$p_date=date("d-M-Y");
$company="CAPM Advisory Ltd";
$inst_name=@$res[0]['company_id'];
$applicant_type=@$res[0]['applicant_type'];

$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->Ln(8);
		$pdf->SetFont('Helvetica','B',18);

		$pdf->Write(4, 'CAPM Advisory Ltd');
		$pdf->Ln(6);
		

		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(5, '                                                                                                                                 Details Information of Applications');
		$pdf->SetFont('Helvetica','',7);
		$pdf->Ln();
		$pdf->Write(6, ''.$p_date." ");
		$pdf->Ln();
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '_______________________________________________________________________________________________');
		$pdf->Ln(3);
		
	
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Name of the Stock Broker/Merchant Bank                         :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'CAPM Advisory Ltd');
		$pdf->Ln(5);
		
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Name of the Company/Fund                       :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$inst_name."");
		$pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Category of applicant            :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$applicant_type."");
		$pdf->Ln(10);
		
		 $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(15,15,20,40,20,30,20,30);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'TREC Code',0,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'DPID',0,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Customer ID',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Name of applicant',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'BO Number',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Cate of Applicant',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Number of sharest',0,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Applied Amount',0,0,'C',true); // Fourth header column 
		
		$pdf->Ln(7);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '_______________________________________________________________________________________________');
		$pdf->Ln(3);
		$sum=0;
		$no_of_share=0;
		//$sql="SELECT * FROM ipo_application WHERE status=1";
        //$res= $dbObj->select($sql);
     //print_r($res);

  
      for($i=0; $i<count($res);$i++){
		$sum=$sum+@$res[$i]['total_amt'];
        $no_of_share=$no_of_share+@$res[$i]['market_lot'];		
		$pdf->SetFont('Helvetica','',8); 
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$res[$i]['serial'],0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$res[$i]['advisory_no'],0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$res[$i]['ac_no'],0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$res[$i]['name'],0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,@$res[$i]['bo_id'],0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@$res[$i]['applicant_type'],0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$res[$i]['market_lot'],0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[7],10,@$res[$i]['total_amt'],0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5);
		$pdf->Write(6, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		
	}
	    
		$pdf->Write(4, "                                                                                                                                                                                             $no_of_share                         $sum" );
		$pdf->Ln();
	
//$fileName = 'homework-' . $_POST['teacher_name'] . '.pdf';
$fileName = $inst_name.'_Detail_DSE_042.pdf';
$pdf->Output($fileName, 'D');		
$pdf->Output();
 exit;

		
?>