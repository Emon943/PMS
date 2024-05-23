<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 
 $date=@$_POST["cdate"];
 
  $sql1="SELECT MAX(date_pricedate) FROM `market_price_dse`";
  $last_date= $dbObj->select($sql1);
  $cdate=$last_date[0]['MAX(date_pricedate)'];
  
  $sql="SELECT instrument_id,isin,close FROM `market_price_dse` WHERE `date_pricedate`='$cdate' ORDER BY instrument_id ASC";
  $marketprice= $dbObj->select($sql);
  
  
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'House Stock Balance',0,0,'C');
		$pdf->Ln(10);

		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(0,10,"Date: ".date("d-M-Y", strtotime($date)),0,0,'R');
		$pdf->Ln(10);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(30,40,40,40,39);
		$pdf->SetFillColor(255,255,255);
		
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Instrument',BTL,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[1],10,'Market Price',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Net Balance',BT,0,'C',true); // Fourth header
		$pdf->Cell($width_cell[3],10,'Free Balance',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Market Value',BTR,0,'C',true); // Fourth header column
		$pdf->Ln(10);
		
        if($marketprice){
		
		$fsum=0.00;
		$tsum=0.00;
		$msum=0.00;
        foreach($marketprice as $res){
		
        $instrument_id=$res['instrument_id'];
		$isin=$res['isin'];
		$close=$res['close'];
		$ssql="SELECT SUM(Current_Bal) as free_bal,SUM(qty) as qty,SUM(bonus_share) as bonus_share,SUM(Lockin_Balance) as Lockin_Balance FROM `tbl_ipo` WHERE `ISIN`='$isin' GROUP BY ISIN";
        $result= $dbObj->select($ssql);
		if($result){
		$free_bal=$result[0]['free_bal'];
		$fsum=$fsum+$free_bal;
		$qty=$result[0]['qty'];
		$bonus_share=$result[0]['bonus_share'];
		$Lockin_Balance=$result[0]['Lockin_Balance'];
		$net_bal=$bonus_share+$Lockin_Balance+$qty+$free_bal;
		$tsum=$tsum+$net_bal;
		$market_val=$net_bal*$close;
	    $msum=$msum+$market_val;
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$instrument_id,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$close,0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[2],10,@$net_bal,0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[3],10,@$free_bal,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,@$market_val,0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(3);
        $pdf->Write(8, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		 
   }
	  }
	  
	  }
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'Total',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[2],10,@number_format((float)$fsum,2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[3],10,@number_format((float)@$tsum,2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,@number_format((float)$msum,2),0,0,'C',false); // Fourth column of row 1\

		$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                     ____________                           ____________                         ______________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                     ____________                           ____________                         ______________');

		$pdf->Ln(7);
		

 $fileName ='house_stock_balance'.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>