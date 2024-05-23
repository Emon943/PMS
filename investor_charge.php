<?php
 include("fpdf/mpdf.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $ac=@$_POST["ac"];

if($ac){
  $sql_inv="SELECT * FROM investor  where investor.dp_internal_ref_number='$ac'";
  $result= $dbObj->select($sql_inv);
  $investor_code=@$res[0]['dp_internal_ref_number'];
 }else{
  $sql_inv="SELECT * FROM investor";
  $result= $dbObj->select($sql_inv);
  //print_r($result);
   $investor_code='All'; 
 }
  $sql="SELECT name FROM transaction_type";
  $transaction_res= $dbObj->select($sql);
 //die();

		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Investors Charge',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Code: ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$ac."");
		$pdf->Ln(5);
	    $pdf->SetFont('Helvetica','B',8);
		$width_cell=array(40,20,30,30);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'Name',B,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Type',B,0,'C',true); // Third header column 
		$pdf->Cell($width_cell[2],10,'Amount',B,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Min Amount',B,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		
		if($result){
		for($i=0; $i<=count($result); $i++){
			
		$ac_no=$result[$i]['dp_internal_ref_number'];
		$investor_name=$result[$i]['investor_name'];
		$investor_group_id=$result[$i]['investor_group_id'];
		$pdf->Write(1, '');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(8,''.$ac_no.'                 '.$investor_name."");
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(8, '-----------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		
		$sqlinvg="SELECT * FROM investor_group  where investor_group_id='$investor_group_id'";
        $investor_group= $dbObj->select($sqlinvg);
		
		
        foreach($investor_group as $investor_res){
		$amount=$investor_res['amount'];
		$name="Commission";
		$type="%";
		$min_amt="0.00";
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$name,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$type,0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$amount,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$min_amt,0,0,'C',false); // Fourth column of row 1
		$pdf->Ln(3);
        $pdf->Write(8, '------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);        	
		}
		foreach($transaction_res as $trans_res){
		$name=$trans_res['name'];
		$type="%";
		$amount="100";
		$min_amt="0.00";
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,@$name,0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,@$type,0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,@$amount,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,@$min_amt,0,0,'C',false); // Fourth column of row 1
		$pdf->Ln(3);
        $pdf->Write(8, '------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);        	
		}
    } 
     	
}
 $fileName ='investor_charge_'.$investor_code.'.pdf';
 $pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
 	
?>