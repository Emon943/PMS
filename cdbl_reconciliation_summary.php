<?php
 include("fpdf/fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
 $db_obj=new PMS;
 $as_no=@$_POST["as_no"];


if($as_no){
  
  $sql="SELECT * FROM tbl_buy_info WHERE mature_date='$as_no'";
  $result= $dbObj->select($sql);
  // print_r( $result);
   //die();
  
  }
		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'CDBL Reconciliation Summary',0,0,'C');
		$pdf->Ln(10);

		$width_cells=array(190);
		$width_cellss=array(90);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,'C',true); // First header column 
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Payout difference');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'                                                                                                                                                '." Date: " .date("d-M-Y", strtotime($as_no))."");
		$pdf->Ln(8);
	  
		$width_cell=array(40,50,50,50);
		$pdf->SetFillColor(255,255,255);
		
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'Client Code',BTL,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Client Name',BT,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Instrument',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Difference',BTR,1,'C',true); // Fourth header column
		$pdf->Ln(3);
		
		foreach($result as $r){
			$account_no=$r['account_no'];
			$instrument=$r['instrument'];
			$Current_Bal=$r['Current_Bal'];
			$qty=$r['qty'];
			$diff=$Current_Bal+$qty;
			
			$sqlin="SELECT investor_name FROM investor WHERE dp_internal_ref_number='$account_no'";
            $investor_bo= $dbObj->select($sqlin);
			$investor_name=$investor_bo[0]['investor_name'];
		
			
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,$account_no,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10,$investor_name,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$instrument,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$diff,0,0,'C',true); // Fourth column of row 1 
		$pdf->Ln(4);
        $pdf->Write(5, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		 } 		 
		
       

	
$fileName ='cdbl_reconciliation_summary_'.$as_no.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>