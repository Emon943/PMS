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
$trader=$ac;
$sql="SELECT * FROM tbl_charge_info WHERE code IN('B','S') AND ac_no='$ac' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY date";
$buy_sell= $dbObj->select($sql);
}
else{
	$trader="All";
   $sql="SELECT date FROM tbl_charge_info WHERE code IN('B','S') AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY date";
   $buy_sell= $dbObj->select($sql);
   //print_r($buy_sell);
}
//die();
	
		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Buy Sale Statement',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);

		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Code: ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$trader."");
		$pdf->Ln(-3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(0,10,'Period: '. date("d-M-Y", strtotime($fromdate)).' To '.date("d-M-Y", strtotime($todate)),0,0,'R');
		$pdf->Ln(10);
		


		
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(39,20,30,20,30,20,30);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,' ',@BTL,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Market',@BT,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Instrument',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Buy Qty',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Buy Amount',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Sale Qty',@BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Sale Amount',@BTR,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		if($buy_sell){
		$cba_sum=0.00;
		$cbq_sum=0.00;
		$csa_sum=0.00;
		$csq_sum=0.00;
		for($i=0; $i< count($buy_sell); $i++){
		 //$ac_no=$buy_sell[$i]['ac_no'];
		 $date=$buy_sell[$i]['date']; 
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(4,'Trade Date: ');
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(4,''.date("d-M-Y", strtotime($date))."");
		$pdf->Ln(7);
		if($ac){
	    $su_sql="SELECT ac_no FROM tbl_charge_info WHERE code IN('B','S') AND ac_no='$ac' AND `date`='$date' GROUP BY ac_no";
        $buy_sell_res= $dbObj->select($su_sql);
		
		$sum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='B' AND ac_no='$ac' AND `date`='$date' GROUP BY date ASC";
        $buy_res= $dbObj->select($sum_sql);
		$sum_total_amt=@$buy_res[0]['tm'];
		$sum_total_qty=@$buy_res[0]['tqty'];
		if($buy_res){
		$sum_total_amt=$buy_res[0]['tm'];
		$sum_total_qty=$buy_res[0]['tqty'];	
		}else{
			$sum_total_amt='0.00';
			$sum_total_qty='0.00';
		}
		
		$ssum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='S' AND ac_no='$ac' AND `date`='$date' GROUP BY date ASC";
        $sell_res= $dbObj->select($ssum_sql);
		if($sell_res){
		$ssum_total_amt=$sell_res[0]['tm'];
		$ssum_total_qty=$sell_res[0]['tqty'];
		}else{
		$ssum_total_amt='0.00';
		$ssum_total_qty='0.00';
		}
		
		}else{
		$su_sql="SELECT ac_no FROM tbl_charge_info WHERE code IN('B','S') AND `date`='$date' GROUP BY ac_no";
        $buy_sell_res= $dbObj->select($su_sql);
		$sum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='B' AND `date`='$date' GROUP BY date ASC";
        $buy_res= $dbObj->select($sum_sql);
		$sum_total_amt=$buy_res[0]['tm'];
		$sum_total_amt=number_format((float)$sum_total_amt, 2);
		$sum_total_qty=$buy_res[0]['tqty'];
		$sum_total_qty=number_format((float)$sum_total_qty, 2);
		
		$ssum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='S' AND `date`='$date' GROUP BY date ASC";
        $sell_res= $dbObj->select($ssum_sql);
		$ssum_total_amt=$sell_res[0]['tm'];
		$ssum_total_amt=number_format((float)$ssum_total_amt, 2);
		$ssum_total_qty=$sell_res[0]['tqty'];
		$ssum_total_qty=number_format((float)$ssum_total_qty, 2);
		
		}
	for($j=0; $j< count($buy_sell_res); $j++){
		$account_no=$buy_sell_res[$j]['ac_no'];
        $code_sql="SELECT * FROM tbl_charge_info WHERE code IN('B','S') AND `date`='$date' AND ac_no='$account_no'";
        $ind_buy_sell_res= $dbObj->select($code_sql);
		
		$csum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='B' AND `date`='$date' AND ac_no='$account_no' GROUP BY ac_no";
        $code_buy_res= $dbObj->select($csum_sql);
		$cba_sum=@$code_buy_res[0]['tm'];
		$cba_sum=number_format((float)$cba_sum, 2);
		$cbq_sum=@$code_buy_res[0]['tqty'];
		$cbq_sum=number_format((float)$cbq_sum, 2);
		
		$cssum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='S' AND `date`='$date' AND ac_no='$account_no' GROUP BY ac_no";
        $code_sell_res= $dbObj->select($cssum_sql);
		$csa_sum=@$code_sell_res[0]['tm'];
		$csa_sum=number_format((float)$csa_sum, 2);
		$csq_sum=@$code_sell_res[0]['tqty']; 
		$csq_sum=number_format((float)$csq_sum, 2);

        $pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'   ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$account_no."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','',7);
		$pdf->Write(1, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(1);
		
	 foreach($ind_buy_sell_res as $bs){
		 $code=@$bs['code'];
		 $account_no=$bs['ac_no'];
		 $company_name=@$bs['company_name'];
		 $market='P';
		 if($code=='B'){
		 $qty=$bs['qty'];
		 $qty=number_format((float)$qty, 2);
		 $total_amt=$bs['total_amt'];
		 $total_amt=number_format((float)$total_amt, 2);
		 //$cba_sum=$cba_sum+$total_amt;
		 //$cbq_sum=$cbq_sum+$qty;
		 }else{
		 $qty=0;
		 $total_amt=0; 
		 }
		 if($code=='S'){
		 $sqty=$bs['qty'];
		 $sqty=number_format((float)$sqty, 2);
		 $stotal_amt=$bs['total_amt'];
		 $stotal_amt=number_format((float)$stotal_amt, 2);
         //$csa_sum=$csa_sum+$stotal_amt;
		 //$csq_sum=$csq_sum+$sqty;
		 }else{
		 $sqty=0;
		 $stotal_amt=0;
         //$ssum_total_amt=0;		 
		 }
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,'  ',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$market,0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$company_name,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$qty,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$total_amt,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$sqty,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$stotal_amt,0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(3);
        $pdf->Write(8, '                                 ------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
			
       }
	    
	    $pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'   ',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,'Sub Total: ',0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,$cbq_sum,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$cba_sum,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$csq_sum,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$csa_sum,0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                     _________           ___________         ____________        ____________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                     _________           ___________         ____________        ____________');

		$pdf->Ln(0);
	  
	}
	$pdf->SetFont('Helvetica','B',9);
	    $pdf->Write(8, '                                 ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		$pdf->Cell($width_cell[0],10,'Total :  ',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,' ',0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,number_format((float)$sum_total_qty, 2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,number_format((float)$sum_total_amt, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,number_format((float)$ssum_total_qty, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,number_format((float)$ssum_total_amt, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5.5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                     _________           ___________         ____________        ____________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                     _________           ___________         ____________        ____________');

		$pdf->Ln(0);
  }
		
}
$fileName ='buy_sell_statement_'.$trader.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>