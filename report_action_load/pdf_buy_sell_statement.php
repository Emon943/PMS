<?php
 include("fpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $ac=@$_POST["ac"];
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];

if($ac){
$trader=$ac;
$sql="SELECT * FROM tbl_charge_info WHERE code!='DP' AND code!='WD' AND code!='ISC' AND code!='RF' AND ac_no='$ac' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY date ASC";
$buy_sell= $dbObj->select($sql);
}
else{
	$trader="All";
   $sql="SELECT * FROM tbl_charge_info WHERE code!='DP' AND code!='WD' AND code!='ISC' AND code!='RF' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY date ASC";
   $buy_sell= $dbObj->select($sql);
}
	
		$pdf->AddPage();
		$pdf->Ln(8);
		$pdf->SetFont('Helvetica','B',12);
		$pdf->Write(4, 'CAPM Advisory Limited');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Kemal Ataturk Avenue Banani 
		Tower Hamlet (9th Fl)Dhaka 1213 
		BangladeshTel. No.: 9822391-2');
		$pdf->Ln(3);
		
		

		$pdf->SetFont('Helvetica','',10);
		$pdf->Write(5, '                                                                                                           BO Registration Confirmation');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Ln();
		
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'A/C Number   :  ');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,''.$trader."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'From Date   :  ');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,''.$fromdate."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'To Date   :  ');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,''.$todate."");
		$pdf->Ln(5);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(40,20,30,20,30,20,30);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,' ',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Market',1,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Instrument',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Buy Units',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Buy Amount',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Sell Units',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Sell Amount',1,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		if($buy_sell){
		
		for($i=0; $i< count($buy_sell)-1; $i++){
		 $ac_no=$buy_sell[$i]['ac_no'];
		 $date=$buy_sell[$i]['date']; 
		 
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Trade Date   :  ');
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,''.$date."");
		$pdf->Ln(5);
		if($ac){
	    $su_sql="SELECT * FROM tbl_charge_info WHERE code!='DP' AND code!='WD' AND code!='ISC' AND code!='RF' AND ac_no='$ac' AND `date`='$date' ORDER BY date ASC";
        $buy_sell_res= $dbObj->select($su_sql);
		$sum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='B' AND ac_no='$ac' AND `date`='$date' GROUP BY date ASC";
        $buy_res= $dbObj->select($sum_sql);
		$sum_total_amt=$buy_res[0]['tm'];
		$sum_total_qty=$buy_res[0]['tqty'];
		
		$ssum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='S' AND ac_no='$ac' AND `date`='$date' GROUP BY date ASC";
        $sell_res= $dbObj->select($ssum_sql);
		$ssum_total_amt=$sell_res[0]['tm'];
		$ssum_total_qty=$sell_res[0]['tqty'];
		
		}else{
		$su_sql="SELECT * FROM tbl_charge_info WHERE code!='DP' AND code!='WD' AND code!='ISC' AND code!='RF' AND `date`='$date' ORDER BY date ASC";
        $buy_sell_res= $dbObj->select($su_sql);
		$sum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='B' AND `date`='$date' GROUP BY date ASC";
        $buy_res= $dbObj->select($sum_sql);
		$sum_total_amt=$buy_res[0]['tm'];
		$sum_total_qty=$buy_res[0]['tqty'];
		
		$ssum_sql="SELECT SUM(total_amt) as tm, SUM(qty) as tqty FROM tbl_charge_info WHERE code='S' AND `date`='$date' GROUP BY date ASC";
        $sell_res= $dbObj->select($ssum_sql);
		$ssum_total_amt=$sell_res[0]['tm'];
		$ssum_total_qty=$sell_res[0]['tqty'];
		
		}
		
	 foreach($buy_sell_res as $bs){	
		 $code=$bs['code'];
		 $account_no=$bs['ac_no'];
		 $company_name=$bs['company_name'];
		 $market='P';
		 if($code=='B'){
		 $qty=$bs['qty'];
		 $total_amt=$bs['total_amt']; 
		 //$sum_total_amt=$sum_total_amt+$total_amt;
		 }else{
		 $qty=0;
		 $total_amt=0; 
		 }
		 if($code=='S'){
		 $sqty=$bs['qty'];
		 $stotal_amt=$bs['total_amt'];
          //$ssum_total_amt=$ssum_total_amt+$stotal_amt;		 
		 }else{
		 $sqty=0;
		 $stotal_amt=0;
         //$ssum_total_amt=0;		 
		 }
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'   ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$account_no."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','',7);
		$pdf->Write(1, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(1);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,'  ',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$market,0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$company_name,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$qty,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$total_amt,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$sqty,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$stotal_amt,0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5);
        $pdf->Write(4, '                                 ------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
        	
 }
   $pdf->SetFont('Helvetica','B',10);
	    $pdf->Write(5, "                             Sub Total :                                            $sum_total_qty      $sum_total_amt             $ssum_total_qty        $ssum_total_amt         " );
	    $pdf->Ln(10);	     
      
  }
        $pdf->SetFont('Helvetica','B',9);
        $pdf->Write(1, '                                 ------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(1);
}
$fileName ='investor_protfolio_'.$ac.'.pdf';
$pdf->Output($fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>