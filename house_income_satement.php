<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 
  $fromdate=@$_POST["fromdate"];
  $todate=@$_POST["todate"];
  $sql="SELECT account_no FROM `tread_data_list` WHERE `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY account_no";
  $code_summary= $dbObj->select($sql);
   //print_r($code_summary);
   //die();
   $bsum_bsql="SELECT SUM(total_amount) as tam,SUM(commission) as tbc,SUM(broker_commission) as tbbc FROM `tread_data_list` WHERE type='B' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY type";
   $sum_summary= $dbObj->select($bsum_bsql);
   $total_bamt_v=$sum_summary[0]['tam'];
   $total_bamt=number_format((float)$total_bamt_v, 2);
   //die();
   $total_bcommi_v=$sum_summary[0]['tbc'];
   $total_bcommi=number_format((float)$total_bcommi_v, 2);
   $total_bcommi_broker_v=$sum_summary[0]['tbbc'];
   $total_bcommi_broker=number_format((float)$total_bcommi_broker_v, 2);
   
   $sum_ssql="SELECT SUM(total_amount) as tsam,SUM(commission) as tsc,SUM(broker_commission) as tsbc FROM `tread_data_list` WHERE type='S' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY type";
   $ssum_summary= $dbObj->select($sum_ssql);
   
   $total_samt_v=$ssum_summary[0]['tsam'];
   $total_samt=number_format((float)$total_samt_v, 2);
   $total_scommi_v=$ssum_summary[0]['tsc'];
   $total_commi_sum_v=$total_bcommi_v+ $total_scommi_v;
   $total_commi_sum=number_format((float)$total_commi_sum_v, 2);
   
   $total_scommi=number_format((float)$total_scommi_v, 2);
   $total_scommi_broker_v=$ssum_summary[0]['tsbc'];
   $total_scommi_broker=number_format((float)$total_scommi_broker_v, 2);
   $total_broker_commi_v=$total_bcommi_broker_v+$total_scommi_broker_v;
   $total_broker_commi=number_format((float)$total_broker_commi_v, 2);
   $total_bs_commi_v=$total_bcommi_v+$total_scommi_v;
   $total_bs_commi=number_format((float)$total_bs_commi_v, 2);
   $total_turnover_v=$total_bamt_v+$total_samt_v;
   $sum_total_turnover=number_format((float)$total_turnover_v, 2);
   $total_net_income_v=$total_bs_commi_v-$total_broker_commi_v;
   $total_net_income=number_format((float)$total_net_income_v, 2);
  
 
 
 
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'House Income Statement(ClientWise)',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','',9);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(0,10, "Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate)),0,0,'R');
		$pdf->Ln(10);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(17,15,20,20,20,20,20,20,20,17);
		$pdf->SetFillColor(255,255,255);
		
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Client Code',BTL,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[1],10,'Stock Exc',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Bought',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Sold',BT,0,'C',true); // Fourth header
		$pdf->Cell($width_cell[4],10,'Turn over',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Buy Comm.',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Sale Comm.',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Total Comm.',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[8],10,'Broker Comm.',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[9],10,'Net Income',BTR,0,'C',true); // Fourth header column
		$pdf->Ln(10);
     
        foreach($code_summary as $res){
		  
	    $ac_no=$res['account_no'];
		if($ac_no){ 
	    $bsql="SELECT account_no,SUM(total_amount) as tam,SUM(commission) as tbc,SUM(broker_commission) as tbbc FROM `tread_data_list` WHERE account_no='$ac_no' AND type='B' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY account_no";
	    $buy_summary= $dbObj->select($bsql);
		//print_r($buy_summary);
		
		if($buy_summary){
		  $tam=@$buy_summary[0]['tam'];
	      $tbc=@$buy_summary[0]['tbc'];
	      $tbbc=@$buy_summary[0]['tbbc'];
		}else{
		  $tam=0.00;
	      $tbc=0.00;
	      $tbbc=0.00;
		}
	    $ssql="SELECT account_no,SUM(total_amount) as tsam,SUM(commission) as tsc,SUM(broker_commission) as tsbc FROM `tread_data_list` WHERE account_no='$ac_no' AND type='S' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY account_no";
	    $sell_summary= $dbObj->select($ssql);
		//print_r($buy_summary);
	    if($sell_summary){
			$tsam=@$sell_summary[0]['tsam'];
	        $tsc=@$sell_summary[0]['tsc'];
	        $tsbc=@$sell_summary[0]['tsbc'];
		 }else{
			$tsam=0.00;
	        $tsc=0.00;
	        $tsbc=0.00; 
		 }
	   
	  
	   $total_turnover=$tam+$tsam;
	   $total_commi=$tbc+$tsc;
	   $total_broker_comm=$tbbc+$tsbc;
	   $net_income=$total_commi-$total_broker_comm;
 
	  
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$ac_no,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'DSE',0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@number_format((float)$tam, 2),0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@number_format((float)$tsam, 2),0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@number_format((float)$total_turnover, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@number_format((float)$tbc, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@number_format((float)$tsc, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,@number_format((float)$total_commi, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,@number_format((float)$total_broker_comm, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[9],10,@number_format((float)$net_income, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(3);
        $pdf->Write(8, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		 
   }
	  }
        $pdf->SetFont('Helvetica','B',9);
		$pdf->Cell($width_cell[0],10,'',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'Total',0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@$total_bamt,0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@$total_samt,0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@$sum_total_turnover,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@$total_bcommi,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@$total_scommi,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,@$total_commi_sum,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,@$total_broker_commi,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[9],10,@$total_net_income,0,0,'C',false); // Fourth column of row 1\
	    
	    $pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                       _____________ ____________ _____________  ___________  ___________    ___________   ___________ ___________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                       _____________ ____________ _____________  ___________  ___________    ___________   ___________ ___________');

		$pdf->Ln(7);

 $fileName ='Client_broker_summary_'.$ac.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>