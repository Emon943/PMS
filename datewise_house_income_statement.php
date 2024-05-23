<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 
  $fromdate=@$_POST["fromdate"];
  $todate=@$_POST["todate"];
  
  $ssql="SELECT SUM(total_buy) as total_buy,SUM(total_sell) as total_sell,SUM(broker_buy_commi) as bbcommi,SUM(broker_sell_commi) as bscommi,SUM(total_turn_over) as total_turn_over,SUM(total_commission) as total_commission FROM `tbl_buy_sell_info` WHERE `insert_date` BETWEEN '$fromdate' AND '$todate'";
  $sum_summary= $dbObj->select($ssql);
  
  $sql="SELECT * FROM `tbl_buy_sell_info` WHERE `insert_date` BETWEEN '$fromdate' AND '$todate'";
  $house_income_summary= $dbObj->select($sql);
  //Print_r($house_income_summary);
  //die();
  
   
   
   
 
 
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'House Income Statement(DateWise)',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(0,10, "Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate)),0,0,'R');
		$pdf->Ln(10);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(20,20,20,20,20,25,20,25,19);
		$pdf->SetFillColor(255,255,255);
		
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Tran Date',BTL,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[1],10,'Bought',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Sold',BT,0,'C',true); // Fourth header
		$pdf->Cell($width_cell[3],10,'Turn over',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Buy Comm.',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Sale Comm.',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Total Comm.',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Broker Comm.',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[8],10,'Net Income',BTR,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,''." DSE : ");
		$pdf->Ln(1);
        $pdf->Write(8, '-----------------');
        $pdf->Ln(5);
		
        if($house_income_summary){
		$bsum=0.00;
		$ssum=0.00;
		$bcsum=0.00;
		$scsum=0.00;
		$ttbsum=0.00;
		$tbcsum=0.00;
		$tcsum=0.00;
		 $nisum=0.00;
		
        foreach($house_income_summary as $res){
		
        $broker_buy_commi=$res['broker_buy_commi'];
		$broker_sell_commi=$res['broker_sell_commi'];
		$bssum=$bssum+$broker_sell_commi;
		$total_broker_comm=$broker_buy_commi+$broker_sell_commi;
		$tbcsum=$tbcsum+$total_broker_comm;
		$total_buy_commi=$res['total_buy_commi'];
		$bcsum=$bcsum+$total_buy_commi;
		$total_sell_commi=$res['total_sell_commi'];
		$scsum=$scsum+$total_sell_commi;
		$total_comm=$total_buy_commi+$total_sell_commi;
		$tcsum=$tcsum+$total_comm;
		$scsum=$scsum+$total_sell_commi;
		$total_buy=$res['total_buy'];
		$bsum=$bsum+$total_buy;
		$total_sell=$res['total_sell'];
		$ssum=$ssum+$total_sell;
		$total_turnover=$total_buy+$total_sell;
		$ttbsum=$ttbsum+$total_turnover;
		$net_income=$total_comm-$total_broker_comm;
		$nisum=$nisum+$net_income;
	  
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@date("d-M-Y", strtotime($res['insert_date'])),0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$total_buy,0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[2],10,@$total_sell,0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[3],10,@$total_turnover,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,@$broker_buy_commi,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,@$broker_sell_commi,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@$total_comm,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,@$total_broker_comm,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,@$net_income,0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(3);
        $pdf->Write(8, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		 
   }
	  }
        $pdf->SetFont('Helvetica','B',9);
		$pdf->Cell($width_cell[0],10,'Total',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@number_format((float)$bsum, 2),0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[2],10,@number_format((float)$ssum, 2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[3],10,@number_format((float)$ttbsum, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,@number_format((float)$bcsum, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,@number_format((float)$scsum, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@number_format((float)$tcsum, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,@number_format((float)$tbcsum, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,@number_format((float)$nisum, 2),0,0,'C',false); // Fourth column of row 1\
	   $pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                       _____________ ____________ _____________  ___________     ____________     ____________     ____________   ____________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                       _____________ ____________ _____________  ___________     ____________     ____________     ____________   ____________');

		$pdf->Ln(7);
		

 $fileName ='datewise_broker_summary_'.$ac.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>