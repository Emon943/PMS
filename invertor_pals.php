<?php
 include("fpdf/fpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $ac=@$_POST["ac"];
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];

if($ac){
  $sql="SELECT ac_no,company_name,SUM(qty)as qty,SUM(total_amt) as stotal_amt  FROM `tbl_charge_info` WHERE ac_no='$ac' AND code='S' AND date BETWEEN '$fromdate' AND '$todate' GROUP BY company_name";
  $sell_res= $dbObj->select($sql);
   //print_r($sell_res);
   //die();
  $sql_inv="SELECT * FROM investor  where investor.dp_internal_ref_number='$ac'";
  $res= $dbObj->select($sql_inv);
  $investor_name=@$res[0]['investor_name'];
  $investor_ac_number=@$res[0]['investor_ac_number'];
 }
 

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Investors Profit and Loss Statement',0,0,'C');
		$pdf->Ln(10);

		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');

		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Code: ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$ac."");
		$pdf->Ln(0);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'                                                                                                                                                                                   '." Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate))."");
		$pdf->Ln(4);

		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Name: ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor_name."");
		$pdf->Ln(7);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(20,20,15,20,20,15,20,20,20,19);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Instrument',@BTL,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Buy Qty',@BT,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Buy Rate',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Buy Amount',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Sale Qty',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Sale Rate',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Sale Amount',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Balance Qty',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[8],10,'Balance Price',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[9],10,'Gain/Loss',@BTR,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		
		if($sell_res){
		$ssum=0;
		$bsum=0;
		$gsum=0;
		for($i=0; $i< count($sell_res); $i++){
		 $ac_no=$sell_res[$i]['ac_no'];
		 $instrument=$sell_res[$i]['company_name'];
		 $scqty=$sell_res[$i]['qty'];
		
		if($ac_no){
		$sql_isin="SELECT isin FROM `instrument` WHERE short_name='$instrument'";
        $isin_res= $dbObj->select($sql_isin);
		$isin=$isin_res[0]['isin'];
		
		$sql_bonus="SELECT SUM(qty)as qty FROM `tbl_bonus_share` WHERE bo_id='$investor_ac_number' AND isin='$isin' AND date <= '$todate'";
        $bonus_res= $dbObj->select($sql_bonus);
		$bonus_qty=$bonus_res[0]['qty'];
	    
		$sqlb="SELECT ac_no,company_name,SUM(qty)as qty,SUM(total_amt)as total_amt FROM `tbl_charge_info` WHERE ac_no='$ac_no' AND code='B' AND company_name='$instrument' AND date <= '$todate' GROUP BY company_name";
        $buy_res= $dbObj->select($sqlb);
		
		if($buy_res){
		$bqty=@$buy_res[0]['qty'];
		$tbqty=@$bqty+$bonus_qty;
		$btotal_buy_amt=@$buy_res[0]['total_amt'];
		$bsum=$bsum+$btotal_buy_amt;
		$tbsum=number_format((float)$bsum, 2);
		$brate=@$btotal_buy_amt/@$tbqty;
		$brat=number_format((float)$brate, 4);
		$bprice=$scqty*$brat;
		}else{
		$bqty='0.00';
        $btotal_buy_amt='0.00';
        $bsrate='0.00';		
		}
		$sqls="SELECT ac_no,company_name,SUM(qty)as qty,SUM(total_amt)as total_amt FROM `tbl_charge_info` WHERE ac_no='$ac_no' AND code='S' AND company_name='$instrument' AND date <= '$todate' GROUP BY company_name";
        $sell_result= $dbObj->select($sqls);
		  
		if($sell_result){
		$sqty=$sell_result[0]['qty'];
		$sell_total_amt=$sell_result[0]['total_amt'];
		$ssum=$ssum+$sell_total_amt;
		$tssum=number_format((float)$ssum, 2);
		$srate=$sell_total_amt/$sqty;
		$srat=number_format((float)$srate, 4);
		$sprice=$scqty*$srat;
		}else{
		$sqty='0.00';
        $sell_total_amt='0.00';
        $srate='0.00';	
		}
		$curr_qty=$bqty-$sqty;
		$curr_amount=$btotal_buy_amt-$sell_total_amt;
		$curr_rate=$curr_amount/$curr_qty;
		$gain_loss=$sprice-$bprice;
		$gsum=$gsum+$gain_loss;
		$tgsum=number_format((float)$gsum, 2);
		}
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,$instrument,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,number_format((float)$tbqty, 2),0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@number_format((float)$brate, 2),0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@number_format((float)$btotal_buy_amt, 2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,number_format((float)$sqty, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,number_format((float)$srate, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,number_format((float)$sell_total_amt, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,number_format((float)$curr_qty, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,number_format((float)$curr_rate, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[9],10,number_format((float)$gain_loss, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5);
        $pdf->Write(4, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);        	
      }

      	$pdf->Ln(-3); 

        $pdf->SetFont('Helvetica','B',10);
        $pdf->Cell($width_cell[0],10,'Total:',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,'',0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,$tbsum,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,'',0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,'',0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$tssum,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,'',0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,'',0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[9],10,$tgsum,0,0,'C',false); // Fourth column of row 1\

	    $pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                 _________________                                     _______________                                                   ___________');
        $pdf->Ln(0.75);
        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                 _________________                                     _______________                                                   ___________');
		$pdf->Ln(7);
}
 $fileName ='investor_profit_loss_gain'.$ac.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
 	
?>