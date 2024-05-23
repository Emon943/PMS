<?php
 include("fpdf/fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
 $db_obj=new PMS;
 
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $branch_id = $_POST['branch_id'];
 $emp_id =@$_POST['emp_id'];


if($emp_id){
	$esql="SELECT name FROM employee where id=$emp_id";
    $user_res= $dbObj->select($esql);
	$emp_name=$user_res[0]['name'];
	
  $sql="SELECT tbl_deposit_balance.date,tbl_deposit_balance.account_ref,tbl_deposit_balance.investor_name,tbl_deposit_balance.code,tbl_deposit_balance.our_ref,tbl_deposit_balance.receipt,tbl_deposit_balance.cheque,tbl_deposit_balance.voucher_Ref,tbl_deposit_balance.bank,tbl_deposit_balance.branch,tbl_deposit_balance.deposit_amt,tbl_deposit_balance.data_insert_id FROM investor INNER JOIN tbl_deposit_balance ON investor.dp_internal_ref_number=tbl_deposit_balance.account_ref WHERE employee_relation_id='$emp_id' AND `date` BETWEEN '$fromdate' AND '$todate' AND tbl_deposit_balance.status=2";
  $result=$dbObj->select($sql);
  
  }else{
  $sql="SELECT * FROM tbl_deposit_balance WHERE `date` BETWEEN '$fromdate' AND '$todate' AND status=2";
  $result= $dbObj->select($sql);
  $emp_name="All";
  }

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Deposit List',0,0,'C');
		$pdf->Ln(10);

		$width_cells=array(190);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,'C',true); // First header column 
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,$branch_id);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'                                                                                                                                                '." Period: " .date("d-M-Y", strtotime($fromdate)). " to " .date("d-M-Y", strtotime($todate))."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Employee:  '.$emp_name);
		$pdf->Ln(7);
		
	   
		
		$width_cell=array(15,20,35,25,20,40,20,15);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Cell($width_cell[0],10,'Date',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Account Ref',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Account Name',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Our Ref',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Type',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Investor Bank',1,0,'C',true); // Fourth header column
		//$pdf->Cell($width_cell[7],10,'Current Balance',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Net Amount',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Entry By',1,1,'C',true); // Fourth header column
		$pdf->Ln(3);
		
	if($result){
		$sum=0.00;
		for($i=0; $i< count($result); $i++){
		$date=$result[$i]['date'];
		$account_ref=$result[$i]['account_ref'];
		$investor_name=$result[$i]['investor_name'];
		$code=$result[$i]['code'];
		$our_ref=$result[$i]['our_ref'];
		$our_reference= $code . $our_ref;
		$type=$result[$i]['receipt'];
		$cheque=$result[$i]['cheque'];
		$voucher_Ref=$result[$i]['voucher_Ref'];
		$bank=$result[$i]['bank'];
		$branch=$result[$i]['branch'];
		$investor_bank= $bank .' '. $branch;
		$deposit_amt=$result[$i]['deposit_amt'];
		$deposit_amt_v=number_format((float)$deposit_amt, 2);
		$sum=$sum+$deposit_amt;
		$total_deposit=number_format((float)$sum, 2);
		$data_insert_id=$result[$i]['data_insert_id'];
		
		//$previous_date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
        //$csql="SELECT * FROM tbl_balance_forward where ac_no='$account_ref' AND date='$previous_date'";
        //$curr_res= $dbObj->select($csql);
		//$current_bal=$curr_res[0]['balace_forward'];
		
	   $esql="SELECT * FROM employee where id=$data_insert_id";
       $user_res= $dbObj->select($esql);
	   $user_name=$user_res[0]['login_id'];
		
		$pdf->SetFont('Helvetica','',7);
		$pdf->Cell($width_cell[0],10, date("d-M-Y", strtotime($date)),0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $account_ref,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$investor_name,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$our_reference,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$type,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$bank,0,0,'C',true); // Fourth column of row 1\
		//$pdf->Cell($width_cell[7],10,$current_bal,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$deposit_amt_v,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,$user_name,0,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(6, '-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
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
		$pdf->Write(1, '----------------------------------------------                                                                                                                  ----------------------------------------------');
	    $pdf->Ln(3);
		$pdf->Write(1, '              Prepared By                                                                                                                                               Authorized Signature');
        $pdf->Ln(1);
		
	}

	
$fileName ='deposit_list_'.$emp_name.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>