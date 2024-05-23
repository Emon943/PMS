<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $agency_id=@$_POST["agency"];
 
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Agent Commission Report',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                                                                          '."Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate))."");
		$pdf->Ln(8);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(20,20,30,28,30,20,20,21);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Agent',BTL,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Client Code',BT,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Client Name',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Turnover',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Total Comm',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Comm Rate',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'House Comm',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Agent Comm',BTR,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		 
  if($agency_id){
  $nsql="SELECT * FROM `tbl_agency_setup` WHERE id='$agency_id'";
  $agency_res= $dbObj->select($nsql);;
  $sql_sum="SELECT SUM(total_amount) as total_turnover,SUM(commission) as total_commi,SUM(broker_commission) as bcommi,SUM(agency_comm) as acommi FROM `tread_data_list` WHERE aid='$agency_id' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
  $agency_sum= $dbObj->select($sql_sum);
  $tvsums=$agency_sum[0]['total_turnover'];
  $tvsums=number_format((float)$tvsums, 2);
  $tsumss=$agency_sum[0]['total_commi'];
  $tsums=number_format((float)$tsumss, 2);
  $bsums=$agency_sum[0]['bcommi'];
  $asums=$agency_sum[0]['acommi'];
  $asums=number_format((float)$asums, 2);
  $house_commi_sum=$tsumss-$bsums;
  $house_commi_sum=number_format((float)$house_commi_sum, 2);
  }else{
  $nsql="SELECT * FROM `tbl_agency_setup` WHERE id!=1";
  $agency_res= $dbObj->select($nsql);
  $sql_sum="SELECT SUM(total_amount) as total_turnover,SUM(commission) as total_commi,SUM(broker_commission) as bcommi,SUM(agency_comm) as acommi FROM `tread_data_list` WHERE aid!='1' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
  $agency_sum= $dbObj->select($sql_sum);
  $tvsums=$agency_sum[0]['total_turnover'];
  $tvsums=number_format((float)$tvsums, 2);
  $tsumss=$agency_sum[0]['total_commi'];
  $tsums=number_format((float)$tsumss, 2);
  $bsums=$agency_sum[0]['bcommi'];
  $asums=$agency_sum[0]['acommi'];
  $asums=number_format((float)$asums, 2);
  $house_commi_sum=$tsumss-$bsums;
  $house_commi_sum=number_format((float)$house_commi_sum, 2); 
  }
  
  
  foreach($agency_res as $res){
   $agent_name=$res['name'];
   $id=$res['id'];

   $sql="SELECT account_no,SUM(total_amount) as total_turnover,SUM(commission) as total_commi,SUM(broker_commission) as bcommi,SUM(agency_comm) as acommi FROM `tread_data_list` WHERE aid='$id' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY account_no";
   $agency_comm= $dbObj->select($sql);
   if($agency_comm){
	  $tvsum=0.00;
	  $bsum=0.00;
	  $asum=0.00;
	  $tsum=0.00;
	foreach($agency_comm as $agency_comm){
	 $ac_no=$agency_comm['account_no'];
	 $insql="SELECT investor_name FROM `investor` WHERE dp_internal_ref_number='$ac_no'";
     $investor_res= $dbObj->select($insql);
	 $investor_name=$investor_res[0]['investor_name'];
	 
    $total_turnover=$agency_comm['total_turnover'];
    $tvsum=$tvsum+$total_turnover;
    $ttvsum=number_format((float)$tvsum, 2);
	$total_commi=$agency_comm['total_commi'];
    $bcommi=$agency_comm['bcommi'];
    $house_commi=$total_commi-$bcommi;
    $acommi=$agency_comm['acommi'];
    $tsum=$tsum+$total_commi;
    $ttsum=number_format((float)$tsum, 2);
    $bsum=$bsum+$house_commi;
    $asum=$asum+$acommi;
    $hbsum=number_format((float)$bsum, 2);
    $aasum=number_format((float)$asum, 2);
    $rate=($total_commi*100/$total_turnover);
    $rate=number_format((float)$rate, 2);
   
  

		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$agent_name,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$ac_no,0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$investor_name,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@number_format((float)$total_turnover, 2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,@number_format((float)$total_commi, 2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@$rate,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,@number_format((float)$house_commi, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,@number_format((float)$acommi, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5);
        $pdf->Write(4, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
	  }
       	$pdf->SetFont('Helvetica','B',10);
	    $pdf->Cell($width_cell[0],10,'Sub Total',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,'',0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,$ttvsum,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$ttsum,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,'',0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$hbsum,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,$aasum,0,0,'C',false); // Fourth column of row 1\
	  }
	   
     }

        $pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                        _________________       ______________                              _____________   ___________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                        _________________       ______________                              _____________   ___________');

	    $pdf->Ln(5);
	    $pdf->Write(4, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
        $pdf->SetFont('Helvetica','B',10);
	    $pdf->Cell($width_cell[0],10,'Total',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,'',0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,$tvsums,0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,$tsums,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,'',0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$house_commi_sum,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,$asums,0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                        _________________       ______________                              _____________   ___________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                        _________________       ______________                              _____________   ___________');

	    $pdf->Ln(5);
		

 $fileName ='agent_commission_'.$ac.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>