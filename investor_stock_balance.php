<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $cdate=@$_POST["cdate"];
 $inst=@$_POST["inst"];
 
  if($inst){
  $sql="SELECT isin,short_name FROM `instrument` WHERE `isin`='$inst' AND status='Active'";
  $inst_info= $dbObj->select($sql);
  }else{
  $sql="SELECT isin,short_name FROM `instrument` WHERE status='Active'";
  $inst_info= $dbObj->select($sql);
  }
  //Print_r($marketprice);
  //die();
  
   
 
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Investor Stock Balance(Instrumentwise)',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');

		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(0,10, "Date: ".date("d-M-Y", strtotime($cdate)),0,0,'R');
		$pdf->Ln(10);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(30,40,40,40,30);
		$pdf->SetFillColor(255,255,255);
		
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Client Code',B,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[1],10,'Client Name',B,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Total Balance',B,0,'C',true); // Fourth header
		$pdf->Cell($width_cell[3],10,'Saleable Balance',B,0,'C',true); // Fourth header column
		$pdf->Ln(10);
		
        if($inst_info){
		for($i=0; $i< count($inst_info); $i++){
		  $short_name=$inst_info[$i]['short_name'];
		  $isin=$inst_info[$i]['isin'];
		 
		 // Fourth header column
		$ssql="SELECT account_no,Current_Bal,qty,bonus_share,Lockin_Balance FROM `tbl_ipo` WHERE `ISIN`='$isin'";
        $result= $dbObj->select($ssql);
		if($result){
		 $pdf->SetFont('Helvetica','B',9);
		 $pdf->Write(8,''.$short_name."");
		 $pdf->Ln(3);
		 $pdf->Write(6, '-----------------------------------------------------');
		 $pdf->Ln(1);
		 
		$tsum=0.00;
		$sum=0.00;
        foreach($result as $res){
		$account_no=$res['account_no'];
		$sssql="SELECT investor_name FROM `investor` WHERE `dp_internal_ref_number`='$account_no'";
        $investor_res= $dbObj->select($sssql);
		$investor_name=@$investor_res[0]["investor_name"];
		$free_bal=$res['Current_Bal'];
		$sum=$sum+$free_bal;
		$qty=$res['qty'];
		$bonus_share=$res['bonus_share'];
		$Lockin_Balance=$res['Lockin_Balance'];
		$total_bal=$bonus_share+$Lockin_Balance+$qty+$free_bal;
		$tsum=$tsum+$total_bal;
	    if($total_bal!=0){
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$account_no,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$investor_name,0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[2],10,@$total_bal,0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[3],10,@$free_bal,0,0,'C',false); // Fourth column of row 1 
		$pdf->Ln(2);
        $pdf->Write(8, '');
        $pdf->Ln(3);
		} 
   }
        $pdf->SetFont('Helvetica','B',9);
        $pdf->Write(6, '--------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(1);
        $pdf->SetFont('Helvetica','B',10);
        $pdf->Cell($width_cell[0],10,'',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,$tsum,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,$sum,0,0,'C',false); // Fourth column of row 1

	    
	    $pdf->Ln(5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                      ___________                             ___________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                      ___________                             ___________');

	    $pdf->Ln(5);
		
	  }
	  
	  }
		}

 $fileName ='Investor Stock Balance'.$cdate.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>