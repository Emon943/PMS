<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $branch=@$_POST["branch"];
 $ac_no=@$_POST["ac"];
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];

if($ac_no){
$trader=$ac_no;
$sql="SELECT account_no,curr_date FROM tread_data_list WHERE account_no='$ac_no' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY curr_date";
$buy_sell= $dbObj->select($sql);

  
 $sqll="SELECT account_no,type,SUM(total_amount)as total_turnover,SUM(commission)as commission FROM tread_data_list WHERE account_no='$ac_no' AND type='B' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
 $date_buy_sum= $dbObj->select($sqll); 
 $buy_total_turnover=$date_buy_sum[0]['total_turnover'];
 $buy_total_turnover=number_format($buy_total_turnover,2);
 $commission_buy_sums=$date_buy_sum[0]['commission'];
 $commission_buy_sum=number_format($commission_buy_sums,2);
 

 
 $sql2="SELECT account_no,type,SUM(total_amount)as total_turnover,SUM(commission)as commission FROM tread_data_list WHERE account_no='$ac_no' AND type='S' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
 $date_sell_sum= $dbObj->select($sql2);
 
 $sell_total_turnover=$date_sell_sum[0]['total_turnover'];
 $sell_total_turnover=number_format($sell_total_turnover,2);
 $commission_sell_sums=$date_sell_sum[0]['commission'];
 $commission_sell_sum=number_format($commission_sell_sums,2);
 $net_income=$commission_buy_sums+$commission_sell_sums;
 $net_income=number_format($net_income,2);
  
}else{
$trader='All';
$sql="SELECT curr_date FROM tread_data_list WHERE `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY curr_date";
$buy_sell= $dbObj->select($sql);

 $sqll="SELECT account_no,type,SUM(total_amount)as total_turnover,SUM(commission)as commission FROM tread_data_list WHERE type='B' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
 $date_buy_sum= $dbObj->select($sqll); 
 $buy_total_turnover=$date_buy_sum[0]['total_turnover'];
 $buy_total_turnover=number_format($buy_total_turnover,2);
 $commission_buy_sums=$date_buy_sum[0]['commission'];
 $commission_buy_sum=number_format($commission_buy_sums,2);
 

 
 $sql2="SELECT account_no,type,SUM(total_amount)as total_turnover,SUM(commission)as commission FROM tread_data_list WHERE type='S' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
 $date_sell_sum= $dbObj->select($sql2);
 
 $sell_total_turnover=$date_sell_sum[0]['total_turnover'];
 $sell_total_turnover=number_format($sell_total_turnover,2);
 $commission_sell_sums=$date_sell_sum[0]['commission'];
 $commission_sell_sum=number_format($commission_sell_sums,2);
 $net_income=$commission_buy_sums+$commission_sell_sums;
 $net_income=number_format($net_income,2);
}
	
		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Periodic commission earning client wise',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(0,10, "Period: ".date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate)),0,0,'R');
		$pdf->Ln(7);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(20,26,36,36,35.5,35);
		$pdf->SetFillColor(255,255,255);
		
      if($buy_sell){
		
		for($i=0; $i< count($buy_sell); $i++){
		 $date=@$buy_sell[$i]['curr_date'];
		 $account_no=@$buy_sell[$i]['account_no'];
		 
		 $pdf->SetFont('Helvetica','B',9);
		 $pdf->Write(6,'Trade Date: ');
		 $pdf->SetFont('Helvetica','',9);
		 $pdf->Write(6,''.date("d-M-Y", strtotime($date))."");
		 $pdf->Ln(5);
		 $pdf->SetFont('Helvetica','B',9);
		 $pdf->Write(4,'Branch: ');
		 $pdf->SetFont('Helvetica','',8);
		 $pdf->Write(4,''.$branch."");
		 $pdf->Ln(5);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'SI No','B',0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Client Code','B',0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Buy Turnover','B',0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Sale Turnover','B',0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Commission','B',0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Net Income','B',0,'C',true); // Fourth header column
		$pdf->Ln(10);
			
       if($account_no){
	   $bssql="SELECT account_no,type,SUM(total_amount)as total_turnover,SUM(commission)as commission FROM tread_data_list WHERE account_no='$account_no' AND `curr_date`='$date' GROUP BY type";
       $date_buy_sell= $dbObj->select($bssql);  
	   }else{
	   $bssql="SELECT account_no,type,SUM(total_amount)as total_turnover,SUM(commission)as commission FROM tread_data_list WHERE `curr_date`='$date' GROUP BY type,account_no ORDER BY account_no";
       $date_buy_sell= $dbObj->select($bssql);
	   }
	   if($date_buy_sell){
	   $row=0;
	   $bsum=0.00;
	   $ssum=0.00;
	   $csum=0.00;
	   foreach($date_buy_sell as $res){
		  
	   $type=$res['type'];
	
	if($type=='B'){
	   $account_no=$res['account_no'];
	   $btotal_turnover=$res['total_turnover'];
	   $bsum=$bsum+$btotal_turnover;
	   $bsums=number_format($bsum,2);
	   $btotal_turnover=number_format($btotal_turnover,2);
	   $commission=$res['commission'];	   
       $commissions=number_format($commission,2);	   
	   $stotal_turnover=0.00;
	   
		 }else{
		 $account_no=$res['account_no'];
	     $stotal_turnover=$res['total_turnover'];
		 $ssum=$ssum+$stotal_turnover;
		 $ssums=number_format($ssum,2);
		 $stotal_turnover=number_format($stotal_turnover,2);
	     $commission=$res['commission'];
		 $commissions=number_format($commission,2);
         $btotal_turnover=0.00;		 
		 }
		  $csum=$csum+$commission;
		  $csums=number_format($csum,2);
		 //die();
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,$row+1,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$account_no,0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$btotal_turnover,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$stotal_turnover,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$commissions,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$commissions,0,0,'C',false); // Fourth column of row 1 
		$pdf->Ln(3);
        $pdf->Write(8, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		$row++;
        } 
		//$pdf->Ln(12);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell($width_cell[0],10,'Trading Datewise To: ',0,0,'L',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$bsums,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$ssums,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$csums,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$csums,0,0,'C',false); // Fourth column of row 1 
	   	
	   	$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                     ____________                      ___________                           ________                             ________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                     ____________                      ___________                           ________                             ________');

	    $pdf->Ln(6);
		
		
	   }
		}
   	     
        $pdf->SetFont('Helvetica','B',9);
        $pdf->Write(1, '                                 ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell($width_cell[0],10,'Total :',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$buy_total_turnover,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$sell_total_turnover,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$net_income,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$net_income,0,0,'C',false); // Fourth column of row 1 
		$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                   _____________                     _____________                     ___________                       ___________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                   _____________                     _____________                     ___________                       ___________');

	    $pdf->Ln(6);
	}

	
$fileName ='periodic_commission'.$trader.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>