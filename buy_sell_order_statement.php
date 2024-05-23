<?php
 include("fpdf/fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $ac=@$_POST["ac"];
 $as_on=@$_POST["as_on"];


if($ac){
$sql="SELECT account_no,bo_id,type,instrument,SUM(total_amount) as total_amt,SUM(quantity) as qty,isin,bokersoftcode FROM tread_data_list WHERE account_no='$ac' AND `curr_date`='$as_on' GROUP By isin,type";
$result= $dbObj->select($sql);
$sql1="SELECT account_no,bo_id,type,instrument,SUM(total_amount) as total_amt,SUM(quantity) as qty,isin,bokersoftcode FROM tread_data_list WHERE account_no='$ac' AND `curr_date`='$as_on' AND type='S' GROUP By isin";
$res= $dbObj->select($sql1);

     $sqlt="SELECT * FROM investor_personal WHERE dp_internal_ref_number='$ac'";
        $res_info=$dbObj->select($sqlt);
        $name=@$res_info[0]['name_of_first_holder'];
		$second_name=@$res_info[0]['second_joint_holder'];
		$third_name=@$res_info[0]['third_joint_holder'];
//print_r($buy_sell);
//die();

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Clientwise Buy Sell Order',0,0,'C');
		$pdf->Ln(10);

		$width_cells=array(190);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cells[0],0,'',1,0,'C',true); // First header column 
		$pdf->Ln(3);

		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,'Client Name: ');
		$pdf->SetFont('Helvetica','',7);
		$pdf->Write(4,''.$name."");
		$pdf->Ln(-3);
		$pdf->SetFont('Helvetica','',7);
		$pdf->Cell(0,10,'Date: '. date("d-M-Y", strtotime($as_on)),0,0,'R');
		$pdf->Ln(8);
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,'Client Code: ');
		$pdf->SetFont('Helvetica','',7);
		$pdf->Write(4,''.$ac."");
		$pdf->Ln(7);
	    
		
		$width_cell=array(50,30,40,40,29);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Cell($width_cell[0],8,'Stock Name',1,0,'C',true);
		$pdf->Cell($width_cell[1],8,'Stock Bought',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],8,'Stock Sold',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[3],8,'Quantity',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],8,'Rate',1,1,'C',true); // Fourth header column
		$pdf->Ln(1);
		
	if($result){
        $exchange_id=10;
		for($i=0; $i< count($result); $i++){
		$account_no=$result[$i]['account_no'];
		$bo_id=$result[$i]['bo_id'];
		$type=$result[$i]['type'];
		$instrument=$result[$i]['instrument'];
		$total_amt=$result[$i]['total_amt'];
		$qty=$result[$i]['qty'];
		$rate=$total_amt/$qty;
		$rate=number_format((float)$rate, 2);
		 if($type=='B'){
		  $buy_qty=$result[$i]['qty'];
		  $sell_qty=0.00;
		 }else{
		 $buy_qty=0.00;
		 $sell_qty=$result[$i]['qty'];; 
		 }
		$isin=$result[$i]['isin'];
		$bokersoftcode=$result[$i]['bokersoftcode'];

		
        $sql1="SELECT investor_name FROM investor WHERE dp_internal_ref_number='$account_no'";
        $investor_info=$dbObj->select($sql1);
        $investor_name=@$investor_info[0]['investor_name'];
		
	    
	
		 
		$pdf->SetFont('Helvetica','',7);
		$pdf->Cell($width_cell[0],7, $instrument,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],7, $buy_qty,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],7,$sell_qty,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],7,$qty,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],7,$rate,0,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(2);
        $pdf->Write(6, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);  	

		}
		
        $pdf->Ln(8);
        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(5, '                                                                                                                                                                      Date: ' .date("d-M-Y", strtotime($as_on)). "");
		$pdf->Ln(5);
		$w_cell=array(189,50);
		$pdf->SetFillColor(192,192,192);
		// Header starts /// 
		$pdf->Cell($w_cell[0],7,'Transferor Details',0,1,'L',true); // First header column
        $pdf->Ln(2);
        $widths_cells=array(40,40,40);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Exchange Name: '.$exchange_id.'                BO ID: '.$bo_id."");
		$pdf->Ln(6);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'BO Name   :  ');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,''.$investor_name."");
		$pdf->Ln(5);
        $pdf->SetFont('Helvetica','B',7);
		$pdf->Cell($widths_cells[0],7,'ISIN',1,0,'C',true); // Second header column
		$pdf->Cell($widths_cells[1],7,'Issuer Company',1,0,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[2],7,'Pay in Quantity',1,1,'C',true); // Fourth header column
		//$pdf->Ln(5);
		$sum=0.00;
		for($i=0; $i< count($res); $i++){
			$isin=$res[$i]['isin'];
			$instrument=$res[$i]['instrument'];
			$qty=$res[$i]['qty'];
			$sum=$sum+$qty;
			$bokercode=$res[$i]['bokersoftcode'];
		$pdf->SetFont('Helvetica','',7);
		$pdf->Cell($widths_cells[0],7,$isin,1,0,'C',true); // First column of row 1 
		$pdf->Cell($widths_cells[1],7,$instrument,1,0,'C',true); // First column of row 1 
		$pdf->Cell($widths_cells[2],7,$qty,1,1,'C',true); // Fourth column of row 1 
		$pdf->Ln(5);
		}
		$sql2="SELECT * FROM tbl_broker_hous WHERE trace_id='$bokercode'";
        $broker_res=$dbObj->select($sql2);
        $broker_name=@$broker_res[0]['name'];
		$dsc_clear_id=@$broker_res[0]['dsc_clear_id'];
		$Internal_code=@$broker_res[0]['Internal_code'];
		$w_cell=array(189,50);
		$pdf->SetFillColor(192,192,192);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($w_cell[0],7,'Transferee Details',0,1,'L',true); // First header column
        $pdf->Ln(2);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Trading ID/Broker Code:   '.$bokercode.'                           Name of Broker	:   '.$broker_name."");
		$pdf->Ln(6);
		$pdf->Cell($w_cell[0],8,'Declaration',0,1,'L',true); // First header column
        $pdf->Ln(2);
		$widths_cells=array(40,40,40);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Helvetica','',7);
		$pdf->Write(4,'The rules and regulations of the Depository and CDBL Participant pertaining to an account which are in focus now have been read by me/us and I/we have understood the same and i/we agree to abide by and to be bound by  the rules as are in force from time to time for such accounts. I/we also declare that the particulars given by me/us are true to the best of my/out  knowledge as on the date of this transaction. I/we further agree that any false/misleading information given by me/us or suppression of any material fact will render my/our account liable for termination and further action.');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Cell($widths_cells[0],6,'Applicants',1,0,'C',true); // Second header column
		$pdf->Cell($widths_cells[1],6,'Name of applicants',1,0,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[2],6,'Signature with date',1,1,'C',true); // Fourth header column
		$pdf->SetFont('Helvetica','',7);
		$pdf->Cell($widths_cells[0],6,'First Applicants',1,0,'C',true); // Second header column
		$pdf->Cell($widths_cells[1],6,$name,1,0,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[2],6,'',1,1,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[0],6,'Second Applicant',1,0,'C',true); // Second header column
		$pdf->Cell($widths_cells[1],6,$second_name,1,0,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[2],6,'',1,1,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[0],6,'3rd Signatory Ltd Co.only)',1,0,'C',true); // Second header column
		$pdf->Cell($widths_cells[1],6,$third_name,1,0,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[2],6,'',1,1,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[0],6,'POA Holder',1,0,'C',true); // Second header column
		$pdf->Cell($widths_cells[1],6,'',1,0,'C',true); // Fourth header column
		$pdf->Cell($widths_cells[2],6,'',1,1,'C',true); // Fourth header column
		$pdf->Ln(2);
		
		$pdf->SetFillColor(192,192,192);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($w_cell[0],7,'To be filled by the DP',0,1,'L',true); // First header column
        $pdf->Ln(2);
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,'BO ID (Broker Clearing A/C) :  ');
		//$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,''.$dsc_clear_id."");
		$pdf->Ln(6);
		$pdf->Write(5,'Internal Reference No :     '.$Internal_code.'                                                        Pay in Quantity :   '.$sum."");
		$pdf->Ln(1);
		$pdf->Write(5, '                                           ----------------------------------                                                     --------------------------------------');
        $pdf->Ln(5);  
		$pdf->Write(4,'    DP ID :                              '.$bokercode.'                                                        Broker Name :     '.$broker_name."");
		$pdf->Ln(1);
		$pdf->Write(5, '                                           ----------------------------------                                                     --------------------------------------');
        $pdf->Ln(5);
		$pdf->SetFont('Helvetica','',7);
        $pdf->Write(5, 'The pay in Quantity has successfully been transferred to Broker Clearing A/C-');
        $pdf->Ln(8);
        $pdf->SetFont('Helvetica','B',7);
		$pdf->Write(1, 'Name of CDBL Participant:		                                                                                                             --------------------------------------------------');
	    $pdf->Ln(3);
	    $pdf->Write(1, 'CAPM Advisory Limited                                                                                                                               DP Signature		');	
	}
}
	
$fileName ='buy_sell_clientwise_'.$as_on.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>