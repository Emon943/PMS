<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $month = date("F", strtotime($todate));
 $year = date("Y", strtotime($todate));
 
 
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Monthwise Performance Growth',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
	
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(0,10, "Period:".date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate)),0,0,'R');
		$pdf->Ln(10);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(20,20,20,20,25,25,20,20,20);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Year',BTL,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[1],10,'Month',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'No Of A/C',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Cash Deposit',BT,0,'C',true); // Fourth header
		$pdf->Cell($width_cell[4],10,'Transferred In',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Turn Over',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Loan',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Net Earning',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[8],10,'Active A/C',BTR,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		 
    if($month){
       $sql="SELECT * FROM `tbl_buy_sell_info` WHERE broker_code='$broker' AND `insert_date` BETWEEN '$fromdate' AND '$todate'";
       $b_trade_summary= $dbObj->select($sql);
	   //print_r($b_trade_summary);
	   
	   $ssql="SELECT COUNT(id) as id, SUM(total_amt) as total_depo FROM `tbl_charge_info` WHERE code='DP' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY code";
       $depo_sum= $dbObj->select($ssql);
	   $no_of_id=count($depo_sum);
	   $total_depo=$depo_sum[0]['total_depo'];
	   $no_of_id=$depo_sum[0]['id'];
	   
	   $sql="SELECT SUM(total_amt) as total_withdraw FROM `tbl_charge_info` WHERE code='WD' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY code";
       $withdraw_sum= $dbObj->select($sql);
	   $total_withdraw=$withdraw_sum[0]['total_withdraw'];
	   
	   
       

		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$year,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$month,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@$no_of_id,0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@number_format((float)$total_depo, 2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@number_format((float)$total_withdraw, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@number_format((float)$total_depo-$$total_withdraw, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,'0.00',0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,'0.00',0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,'0.00',0,0,'C',false); // Fourth column of row 1
		$pdf->Ln(3);
        $pdf->Write(7, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
	}
     
        $pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cell[0],10,'Total',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@$no_of_id,0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@number_format((float)$total_depo, 2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@number_format((float)$total_withdraw, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@number_format((float)$total_depo-$$total_withdraw, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,'0.00',0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,'0.00',0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,'0.00',0,0,'C',false); // Fourth column of row 1\
	    
	    $pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                        ______      ______________  ____________      ______________       ________          ________         ________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                        ______      ______________  ____________      ______________       ________          ________         ________');

	    $pdf->Ln(5);

 $fileName ='monthwise_performance_'.$month.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>