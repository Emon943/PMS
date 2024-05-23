<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Agent Commission Report(Summary)',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                                                                          '."Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate))."");
		$pdf->Ln(8);
		
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(25,25,30,30,30,25,24);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Agency',BTL,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[1],10,'Turnover',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Total Comm',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'% of Total',BT,0,'C',true); // Fourth header
		$pdf->Cell($width_cell[4],10,'Comm Rate',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'House Comm',BT,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Agency Comm',BTR,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		 

  $agency_sql="SELECT * FROM `tbl_agency_setup` WHERE id!='1'";
  $agency_res= $dbObj->select($agency_sql);
  
  $sql_sum="SELECT SUM(total_amount) as total_turnover,SUM(commission) as total_commi,SUM(broker_commission) as bcommi,SUM(agency_comm) as acommi FROM `tread_data_list` WHERE aid!='1' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
  $agency_sum= $dbObj->select($sql_sum);
  
  $tvsum=$agency_sum[0]['total_turnover'];
  $tvsum=number_format((float)$tvsum, 2);
  $tsums=$agency_sum[0]['total_commi'];
  $tsum=number_format((float)$tsums, 2);
  $bsum=$agency_sum[0]['bcommi'];
  $asum=$agency_sum[0]['acommi'];
  $asum=number_format((float)$asum, 2);
  $house_commi_sum=$tsums-$bsum;
  $house_commi_sum=number_format((float)$house_commi_sum, 2);
  
  foreach($agency_res as $res){
   $name=$res['name'];
   $id=$res['id'];
   
   $sql="SELECT SUM(total_amount) as total_turnover,SUM(commission) as total_commi,SUM(broker_commission) as bcommi,SUM(agency_comm) as acommi FROM `tread_data_list` WHERE aid='$id' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY aid";
   $agency_comm= $dbObj->select($sql);
   
   if($agency_comm){
   $total_turnover=$agency_comm[0]['total_turnover'];
   //$tvsum=$tvsum+$total_turnover;
   $total_commi=$agency_comm[0]['total_commi'];
   $bcommi=$agency_comm[0]['bcommi'];
   $house_commi=$total_commi-$bcommi;
   $acommi=$agency_comm[0]['acommi'];
   //$tsum=$tsum+$house_commi;
   //$bsum=$bsum+$bcommi;
   //$asum=$asum+$acommi;
   //$bsum=number_format((float)$bsum, 2);
   //$asum=number_format((float)$asum, 2);
   $rate=($total_commi*100/$total_turnover);
   $rate=number_format((float)$rate, 2);
  

		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$name,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@number_format((float)$total_turnover, 2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[2],10,@number_format((float)$total_commi, 2),0,0,'C',false); // Fourth column of row 1
        $pdf->Cell($width_cell[3],10,@$rate,0,0,'C',false); // Third column of row 1 		
		$pdf->Cell($width_cell[4],10,@$rate,0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,@number_format((float)$house_commi, 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,@number_format((float)$agency_comm[0]['acommi'], 2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5);
        $pdf->Write(4, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(2);
		 }
     }
        $pdf->SetFont('Helvetica','B',10);
	    $pdf->Write(5, "Total :               $tvsum               $tsum                                                                $house_commi_sum          $asum                                      " );

	    $pdf->Ln(-1.75);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                            ___________________     __________________                                                                     ______________   ________________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                            ___________________     __________________                                                                     ______________   ________________');

	    $pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);

		
        $pdf->Ln(3);
		$pdf->Write(4, "Grant Total :     $tvsum             $tsum                                                                 $house_commi_sum           $asum                                      " );

		$pdf->Ln(-1.50);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                            ___________________     __________________                                                                     ______________   ________________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                            ___________________     __________________                                                                     ______________   ________________');

	    $pdf->Ln(5);
		

 $fileName ='agency_commission_'.$ac.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>