<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $broker=@$_POST["broker"];
 $bcsql="select * from tbl_broker_hous Where trace_id='$broker'";
 $res=$dbObj->select($bcsql);
 $name=$res[0]['Internal_code'];
 
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Datewise Broker Summary',0,0,'C');
		$pdf->Ln(10);

		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'' .$name."");
		$pdf->Ln(-3);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(0,10, "Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate)),0,0,'R');
		$pdf->Ln(10);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(30,25,25,30,25,25,29);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Transaction Date',BTL,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[1],10,'Total Buy',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Commission',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Total Payable',BT,0,'C',true); // Fourth header
		$pdf->Cell($width_cell[4],10,'Total Sale',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Commission',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Total Receiveable',BTR,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		 
    if($broker){
       $sql="SELECT * FROM `tbl_buy_sell_info` WHERE broker_code='$broker' AND `insert_date` BETWEEN '$fromdate' AND '$todate'";
       $b_trade_summary= $dbObj->select($sql);
	   //print_r($b_trade_summary);
	   
	   $ssql="SELECT SUM(total_buy) as tb,SUM(total_buy_commi) as tbc,SUM(total_sell) as ts,SUM(total_sell_commi) as tsc FROM `tbl_buy_sell_info` WHERE broker_code='$broker' AND `insert_date` BETWEEN '$fromdate' AND '$todate' GROUP BY broker_code";
       $sum_summary= $dbObj->select($ssql);
	   $tb=$sum_summary[0]['tb'];
	   $tbc=$sum_summary[0]['tbc'];
	   $payable=$tb+$tbc;
	   $ts=$sum_summary[0]['ts'];
	   $tsc=$sum_summary[0]['tsc'];
	   $receiable=$ts-$tsc;
       
      } 
   
   
   foreach($b_trade_summary as $res){
   $tran_date=$res['trade_date'];
   $total_buy=$res['total_buy'];
   $total_sell=$res['total_sell'];
   $tsum=$tsum+$total_sell;
   $total_buy_commi=$res['total_buy_commi'];
   $total_sell_commi=$res['total_sell_commi'];
   $total_commission=$res['total_commission'];
   $total_turn_over=$res['total_turn_over'];
   $broker_payable=$total_buy+$total_buy_commi;
   $broker_receiable=$total_sell-$total_sell_commi;
  
  

		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$tran_date,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@number_format((float)$total_buy, 2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@number_format((float)$total_buy_commi, 2),0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@number_format((float)$broker_payable, 2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@number_format((float)$total_sell, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@number_format((float)$total_sell_commi, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@number_format((float)$broker_receiable, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(3);
        $pdf->Write(7, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		 }
     
        $pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cell[0],10,'Total:',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@number_format((float)$tb, 2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@number_format((float)$tbc, 2),0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@number_format((float)$payable, 2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@number_format((float)$ts, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@number_format((float)$tsc, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@number_format((float)$receiable, 2),0,0,'C',false); // Fourth column of row 1\
	    $pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                    ________________    _____________     ________________    ________________   _____________     ________________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                    ________________    _____________     ________________    ________________   _____________     ________________');

		$pdf->Ln(7);
		
		

 $fileName ='datewise_broker_summary_'.$ac.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>