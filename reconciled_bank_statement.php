<?php
 include("fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
 $db_obj=new PMS;
 $print_date=date("d-M-Y");
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $branch_id = $_POST['branch_id'];
 $bank_id = $_POST['bank_id'];


if($bank_id){
  $dsql="SELECT * FROM tbl_deposit_balance WHERE `date` BETWEEN '$fromdate' AND '$todate' AND recon_status=1 AND com_bank_ac='$bank_id'";
  $depo_res= $dbObj->select($dsql);
  $wsql="SELECT * FROM tbl_withdraw_balance WHERE `date` BETWEEN '$fromdate' AND '$todate' AND recon_status=1 AND com_bank_ac='$bank_id'";
  $withd_res= $dbObj->select($wsql);
  $result = array_merge($depo_res,$withd_res);
  
 
   $bsql="SELECT * FROM bank_ac where account_number='$bank_id'";
   $bank_bal_res= $dbObj->select($bsql);
   $balance=$bank_bal_res[0]['balance'];
   $balance_v=number_format((float)$balance, 2);
   $account_number=$bank_bal_res[0]['account_number'];
   $bank_name=$bank_bal_res[0]['bank_name'];
   $account_name=$bank_name.'-'.$account_number;
 

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->Ln(8);
		$pdf->SetFont('Arial','B',10);
		$pdf->Write(4, 'CAPM Advisory Limited');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,'Tower Hamlet (9th Floor) 
		Kemal Ataturk Avenue Banani Dhaka 1213 
		Bangladesh Tel. No.: 9822391-2');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(5, '                                                                                                                                    Reconciled Bank Statement');
		$pdf->Ln(5);
		$width_cells=array(190);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,'C',true); // First header column 
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'  '  .$branch_id. '                                                                                                                                                   Period :');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,' '.$fromdate.'  To  '.$todate."");
		$pdf->Ln(8);
		
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Account Name: '  .$account_name. '                                                                                              Opening Balance :');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,' '.$balance_v."");
		$pdf->Ln(8);
	   
		
		$width_cell=array(20,25,20,45,25,25,25);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Cell($width_cell[0],10,'Date',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Internal Ref',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Voucher No',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Description',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Debit',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Credit',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Balance',1,1,'C',true); // Fourth header column
		$pdf->Ln(3);
		
	if($result){
		$sum=0.00;
		$sum_dep=0.00;
		$sum_withd=0.00;
		for($i=0; $i< count($result); $i++){
		$date=$result[$i]['date'];
		$account_ref=$result[$i]['account_ref'];
		$code=$result[$i]['code'];
		$our_ref=$result[$i]['our_ref'];
		$our_reference= $code . $our_ref;
		$cheque=$result[$i]['cheque'];
		$voucher_Ref=$result[$i]['voucher_Ref'];
		$des=$result[$i]['des'];
		$decription= $des .' '. $cheque;
		if($code=='INV-FD'){
		$depo_amount=$result[$i]['deposit_amt'];
		$sum_dep=$sum_dep+$depo_amount;
		$depo_amount_v=number_format((float)$depo_amount, 2);
		$withdraw_amt_v=0.00;
		$balance=$balance-$depo_amount;
		}else{
		$withdraw_amt=$result[$i]['withdraw_amt'];
		$sum_withd=$sum_withd+$withdraw_amt;
		$withdraw_amt_v=number_format((float)$withdraw_amt, 2);
		$balance=$balance+$withdraw_amt;
		$depo_amount_v=0.00;
		}
		$balance=number_format((float)$balance, 2);
		
		$pdf->SetFont('Helvetica','',7);
		$pdf->Cell($width_cell[0],10, $date,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $our_reference,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$voucher_Ref,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$decription,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$depo_amount_v,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$withdraw_amt_v,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$balance,0,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(6, '-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);  	
		}
		//$pdf->Ln(1);  	
		//$pdf->Cell(50,0,'',1,0,'C',true); // Fourth header column
		//$pdf->Rect(5, 5, 5, 5, 'D');
		//$pdf -> Line(150, 150, 150, 150);
		$pdf->Ln(1);
        $pdf->SetX(152);	
        $pdf->MultiCell(0,5,'Total Debit:   '. $sum_dep,B,C,false);
         $pdf->SetX(152);	
        $pdf->MultiCell(0,5,'Total Credit:   '. $sum_withd,B,C,false);			
        $pdf->SetX(152);	
        $pdf->MultiCell(0,5,'Net Balance:   '. $balance,B,C,false);
		$pdf->Ln(12); 
        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '----------------------------------                                    ----------------------------------                                                                 -----------------------------------------');
	    $pdf->Ln(3);
		$pdf->Write(1, '        Prepared By                                                       Checked By                                                                                          Approved By');
        $pdf->Ln(1);
		
	}
}
	
$fileName ='bank_reconciled_statement.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>