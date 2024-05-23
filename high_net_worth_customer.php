<?php
 include("fpdf/fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
 $db_obj=new PMS;
 $as_on=@$_POST["as_on"];
 $branch_id = $_POST['branch_id'];


 if($as_on){
 $sql_inv="SELECT dp_internal_ref_number,investor_name,investor_ac_number FROM investor Where status=0 ORDER BY dp_internal_ref_number ASC";
 $result= $dbObj->select($sql_inv);
 

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'High Net Worth Customer',0,0,'C');
		$pdf->Ln(10);

		$width_cells=array(190);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,'C',true); // First header column 
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,$branch_id);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'                                                                                                                                                '." Date: " .date("d-M-Y", strtotime($as_on))."");
		$pdf->Ln(7);
	   
		
		$width_cell=array(20,40,35,25,20,30,20);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'Client Code',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Name',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'BO Number',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Total Deposit',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Total Withdraw',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Market Value',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Net Worth',1,1,'C',true); // Fourth header column
		$pdf->Ln(3);
		
	    if($result){
		$sum=0.00;
		for($i=0; $i< count($result); $i++){
		  $ac_no=$result[$i]['dp_internal_ref_number'];
		  $bo_id=$result[$i]['investor_ac_number'];
		  $investor_name=$result[$i]['investor_name'];
	
		  $sqld="SELECT SUM(deposit_amt) as total_deposit FROM tbl_deposit_balance WHERE account_ref='$ac_no' AND `date`<'$as_on'";
		  $res_deposit= $dbObj->select($sqld);
		  $deposit=$res_deposit[0]['total_deposit'];
		  $total_deposit=number_format((float)$deposit, 2);
		  
		  $sqlw="SELECT SUM(withdraw_amt) as withdraw_amt FROM tbl_withdraw_balance WHERE account_ref='$ac_no' AND `date`<'$as_on'";
		  $res_withdraw= $dbObj->select($sqlw);
		  $withdraw_amt=$res_withdraw[0]['withdraw_amt'];
		  $total_withdraw=number_format((float)$withdraw_amt, 2);
		  
		

		
		//$previous_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $csql="SELECT * FROM tbl_balance_forward where ac_no='$ac_no' AND date='$as_on'";
        $curr_res= $dbObj->select($csql);
		$market_value=@$curr_res[0]['market_value'];
		$market_value=number_format((float)$market_value, 2);
		
		
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,$ac_no,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10,$investor_name,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$bo_id,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$total_deposit,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$total_withdraw,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$market_value,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$market_value,0,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(5, '-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);  	
		}
		//$pdf->Ln(1);  	
		//$pdf->Cell(50,0,'',1,0,'C',true); // Fourth header column
		//$pdf->Rect(5, 5, 5, 5, 'D');
		//$pdf -> Line(150, 150, 150, 150);
		//$pdf->Ln(1); 
        $pdf->SetX(165);	
        $pdf->MultiCell(20,5,$total_deposit,B,C,false);
		$pdf->Ln(12); 
        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '------------------------------                                                                                                                  ----------------------------------------------');
	    $pdf->Ln(3);
		$pdf->Write(1, '     Prepared By                                                                                                                                   Authorized Signature.');
        $pdf->Ln(1);
		
	}
}
	
$fileName ='deposit_status_'.$as_on.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>