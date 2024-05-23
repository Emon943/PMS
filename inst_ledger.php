<?php
 include("fpdf/fpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $ac=@$_POST["ac"];
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $isin=@$_POST["inst"];
 $previous_date=date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
 
 
  $sql_inst="SELECT short_name FROM instrument where isin='$isin'";
  $res_isin= $dbObj->select($sql_inst);
  $short_name=@$res_isin[0]['short_name'];
if($ac){
  $sql_inv="SELECT * FROM investor  where investor.dp_internal_ref_number='$ac'";
  $res= $dbObj->select($sql_inv);
  $investor_name=@$res[0]['investor_name'];
  $Investor_BO_ID=@$res[0]['investor_ac_number'];
	
   $bsql="SELECT SUM(qty) as qty,SUM(Current_Bal) as Current_Bal FROM `tbl_buy_info` WHERE account_no='$ac' AND ISIN='$isin' AND date <='$previous_date' AND action='1'";
   $buy_res= $dbObj->select($bsql);
   $bnon_mature=$buy_res[0]['qty'];
   $b_mature=$buy_res[0]['Current_Bal'];
   $bqty=$bnon_mature+$b_mature;
   //echo $bqty.'<br>';
   $ssql="SELECT SUM(qty) as qty FROM `sale_share` WHERE account_no='$ac' AND isin='$isin' AND trade_date <='$previous_date' AND action='1'";
   $sell_res= $dbObj->select($ssql);
   $sqty=$sell_res[0]['qty'];
    //echo $sqty.'<br>';
   $bosql="SELECT SUM(qty) as qty FROM `tbl_bonus_share` WHERE bo_id='$Investor_BO_ID' AND isin='$isin' AND date<='$previous_date'";
   $bonus_res= $dbObj->select($bosql);
   $bonus_qty=$bonus_res[0]['qty'];
   //echo $bonus_qty.'<br>';
   //die();
   if($bqty >= $sqty){
	$forward_qty=$bqty+$bonus_qty-$sqty;
   }else{
	$forward_qty=0.00; 
   }
  
  
  $sql="SELECT * FROM `tbl_charge_info` WHERE ac_no='$ac' AND company_name='$short_name' AND date BETWEEN '$fromdate' AND '$todate' AND code IN('B','S') ORDER BY date";
  $bs_result= $dbObj->select($sql);
  //print_r($bs_res);
  //die();
  
  $sql_b="SELECT share_cat as code,qty,date FROM `tbl_bonus_share` WHERE bo_id='$Investor_BO_ID' AND isin='$isin' AND date BETWEEN '$fromdate' AND '$todate' ORDER BY date";
  $bonus_res= $dbObj->select($sql_b);
  $bs_res=array_merge($bs_result, $bonus_res);
 }
 //die();
 

		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Instrument Ledger Statement',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Code: ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$ac."                                                                                                                      Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate))."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'BO ID: ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$Investor_BO_ID."                                                                                                             Instrument: ".$short_name."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Name: ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$investor_name."                                                                                                Forward Balance: ".$forward_qty."");
		$pdf->Ln(8);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(20,20,20,20,20,20,20,20,29);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Date',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Buy Qty',1,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Buy Price',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Sale Qty',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Sale Price',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Receive',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Issue',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Type',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[8],10,'Net Balance',1,0,'C',true); // Fourth header column
		$pdf->Ln(10);
		
	 if($bs_res){
		$sum=0.00;
		$bsum=0.00;
		$ssum=0.00;
		$bosum=0.00;
		$sum=$sum+$forward_qty;
		for($i=0; $i< count($bs_res); $i++){
		 $code=$bs_res[$i]['code'];
		 $date=$bs_res[$i]['date'];
		 $date=date('d-M-Y', strtotime($date));
		 $issue="0.00";
         
		 if($code=='B'){
		  $type="Trader";
		  $receive="0.00";
		  $qty_v=$bs_res[$i]['qty'];
		  $sum=$sum+$qty_v;
		  $bsum=$bsum+$qty_v;
		  $rate_v=$bs_res[$i]['rate'];
		 
		 }else{
		   $qty_v='0.00';
		   $rate_v='0.00'; 
		 }
		  if($code=='S'){
		  $type="Trader";
		  $receive="0.00";
		  $sqty_v=$bs_res[$i]['qty'];
		  $ssum=$ssum+$sqty_v;
		  $sum=$sum-$sqty_v;
		  $srate_v=$bs_res[$i]['rate'];
		  }else{
			$sqty_v='0.00';
			$srate_v='0.00'; 
		 }
		 
		 if($code=='BONUS'){
		  $type="BONUS";
		  $receive=$bs_res[$i]['qty'];
		  $sum=$sum+$receive;
		  $bosum=$bosum+$receive;
		  }else{
			$receive='0.00'; 
		 }
		 
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,$date,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$qty_v,0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$rate_v,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$sqty_v,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$srate_v,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$receive,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$issue,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,$type,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,$sum,0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(3);
        $pdf->Write(8, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(5);        	
      }
      	$pdf->Ln(-2);

        $pdf->SetFont('Helvetica','B',10);
        $pdf->Cell($width_cell[0],10,'Total:',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,number_format((float)$bsum,2),0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,'',0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,number_format((float)$ssum,2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,'',0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,number_format((float)$bosum,2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,'',0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,'',0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,'',0,0,'C',false); // Fourth column of row 1\

	    $pdf->Ln(5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                          ___________                             ____________                            ____________');
        $pdf->Ln(0.75);
        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                          ___________                             ____________                            ____________');
		$pdf->Ln(7);
}
$fileName ='instrument_ledger_'.$ac.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>