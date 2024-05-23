<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $Branch=@$_POST["Branch"];
 $bcsql="select * from branch_list Where branch_id='$Branch'";
 $res=$dbObj->select($bcsql);
 $name=$res[0]['name'];

		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Branchwise Trade Summary',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'' .$name."");
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'                                                                                                                                                                '."Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate))."");
		$pdf->Ln(8);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(25,25,30,30,30,25,23.75);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Name',BTL,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[1],10,'Buy',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Sale',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Turnover',BT,0,'C',true); // Fourth header
		$pdf->Cell($width_cell[4],10,'Commission',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Broker',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Net Income',BTR,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		 
        if($Branch){
         $sql="SELECT SUM(total_buy) as total_buy,SUM(total_sell) as total_sell,SUM(broker_buy_commi) as bbcommi,SUM(broker_sell_commi) as bscommi,SUM(total_turn_over) as total_turn_over,SUM(total_commission) as total_commission FROM `tbl_buy_sell_info` WHERE branch_id='$Branch' AND DATE(`insert_date`) BETWEEN '$fromdate' AND '$todate'";
         $b_trade_summary= $dbObj->select($sql);
          //print_r($b_trade_summary);
        }
  
   foreach($b_trade_summary as $res){
   $name='HO';
   $total_buy=$res['total_buy'];
   $total_sell=$res['total_sell'];
   $bbcommi=$res['bbcommi'];
   $bscommi=$res['bscommi'];
   $total_commission=$res['total_commission'];
   $total_turn_over=$res['total_turn_over'];
   $broker_commi=$bbcommi+$bscommi;
   $net_income=$total_commission-$broker_commi;
  
  

		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$name,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@number_format((float)$total_buy, 2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@number_format((float)$total_sell, 2),0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@number_format((float)$total_turn_over, 2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@number_format((float)$total_commission, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@number_format((float)$broker_commi, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@number_format((float)$total_commission, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5);
        $pdf->Write(4, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(5);
		 }
     
        $pdf->SetFont('Helvetica','B',9);
		$pdf->Cell($width_cell[0],10,'Total',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@number_format((float)$total_buy, 2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@number_format((float)$total_sell, 2),0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@number_format((float)$total_turn_over, 2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@number_format((float)$total_commission, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@number_format((float)$broker_commi, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@number_format((float)$total_commission, 2),0,0,'C',false); // Fourth column of row 1\
	    
	    $pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                              ________________    ________________      ________________      ________________       ____________      ______________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                              ________________    ________________      ________________      ________________       ____________      ______________');

	    $pdf->Ln(5);

 $fileName ='Branch__Trade_summa_'.$ac.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>