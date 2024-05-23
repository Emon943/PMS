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
 $previous_date=date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));


if($bank_id){
  $sql="SELECT * FROM bank_ledger WHERE `date` BETWEEN '$fromdate' AND '$todate' AND bank_ac_no='$bank_id' ORDER BY date ASC";
  $result= $dbObj->select($sql);
 
   $bnsql="SELECT bank_name FROM bank_ac where account_number='$bank_id'";
   $bank_name_res= $dbObj->select($bnsql);
   $bank_name=$bank_name_res[0]['bank_name'];
 
   $bsql="SELECT * FROM bank_forward_balance where account_number='$bank_id' AND date='$previous_date'";
   $bank_bal_res= $dbObj->select($bsql);
   $fbalance=$bank_bal_res[0]['balance'];
   $balance_v=number_format((float)$fbalance, 2);
   $account_number=$bank_bal_res[0]['account_number'];
   $account_name=$bank_name.'-'.$account_number;
 

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->SetFont('Arial','B',10);
		$pdf->Write(4, 'CAPM Advisory Limited');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Write(4,'Tower Hamlet (9th Floor) 
		Kemal Ataturk Avenue Banani Dhaka 1213 
		Bangladesh Tel. No. : 9822391-2');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(5, '                                                                                                                                    Bank General Ledger Statement');
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
		$internal_ref=$result[$i]['internal_ref'];
		$code=$result[$i]['code'];
		$type=$result[$i]['type'];
		$voucher_no=$result[$i]['voucher_no'];
		$des=$result[$i]['description'];
		if($type=='Receipt'){
		$balance=$result[$i]['balance'];
		$sum_dep=$sum_dep+$balance;
		$dr_bal=number_format((float)$balance, 2);
		$cr_bal=0.00;
		$fbalance=$fbalance+$balance;
		}else{
		$balancec=$result[$i]['balance'];
		$sum_withd=$sum_withd+$balancec;
		$cr_bal=number_format((float)$balancec, 2);
		$fbalance=$fbalance-$balancec;
		$dr_bal=0.00;
		}
		$drcr_bal=number_format((float)$fbalance, 2);
		
		$pdf->SetFont('Helvetica','',7);
		$pdf->Cell($width_cell[0],10, $date,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $internal_ref,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$voucher_no,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$des,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$dr_bal,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$cr_bal,0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$drcr_bal,0,0,'C',true); // Fourth column of row 1\
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
        $pdf->MultiCell(0,5,'Total Debit:   '. number_format((float)$sum_dep, 2),B,C,false);
         $pdf->SetX(152);	
        $pdf->MultiCell(0,5,'Total Credit:   '. number_format((float)$sum_withd, 2),B,C,false);			
        $pdf->SetX(152);	
        $pdf->MultiCell(0,5,'Net Balance:   '. number_format((float)$fbalance, 2),B,C,false);
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