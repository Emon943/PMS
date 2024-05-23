<?php
 include("fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
 $db_obj=new PMS;

 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];
 $branch_id=@$_POST["branch_id"];

$sql="SELECT employee_relation_id FROM investor WHERE employee_relation_id!='NULL' GROUP BY employee_relation_id";
$result= $dbObj->select($sql);
 
		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(0,10,'Employee Wise Income Summary',0,0,'C');
		$pdf->Ln(10);
		$width_cells=array(190);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,C,true); // First header column 
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(0,10,'Branch: '.$branch_id,0,0,'L');
		$pdf->Cell(0,10,'Peroid: '.$fromdate.' To '.$todate,0,0,'R');
		$pdf->Ln(10);
	    
		
		$width_cell=array(30,40,30,30,30,30);
		$pdf->SetFillColor(255,255,255);
		
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'Client Code',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Client Name',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Equity',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Turnover',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Total Com.',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'CNS Fee',1,1,'C',true); // Fourth header column
		$pdf->Ln(10);
		if($result){
	
		for($i=0; $i< count($result); $i++){
		$employee_id=$result[$i]['employee_relation_id'];
		$sqle="SELECT * FROM employee WHERE id='$employee_id'";
        $res_emp= $dbObj->select($sqle);
		$Emp_name=$res_emp[0]['name'];
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,' '.$Emp_name."");
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'-----------------------');
		$pdf->Ln(3);
	
	
		$sqlc="SELECT dp_internal_ref_number,investor_name FROM investor WHERE employee_relation_id='$employee_id'";
        $res= $dbObj->select($sqlc);
		$esum=0.00;
		$csum=0.00;
		$bsum=0.00;
		$tsum=0.00;
		 foreach($res as $r){
		  $ac_no=$r['dp_internal_ref_number'];
		  $investor_name=$r['investor_name'];
		  
	      $sqlss="SELECT SUM(total_amount) as tm,SUM(commission) as commi,SUM(broker_commission) as bcommi FROM tread_data_list WHERE account_no='$ac_no' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY account_no";
          $buy_sell= $dbObj->select($sqlss);
		  $tatal_turnover=@$buy_sell[0]['tm'];
		  $tsum=$tsum+$tatal_turnover;
		  $commi=@$buy_sell[0]['commi'];
		  $bsum=$bsum+$commi;
		  $bcommi=@$buy_sell[0]['bcommi'];
		  $cns=$commi-$bcommi;
		  $csum=$csum+$cns;
		  $sqlm="SELECT equity FROM tbl_balance_forward WHERE ac_no='$ac_no' AND date='$todate'";
		  $market_res= $dbObj->select($sqlm);
		  $equity=@$market_res[0]['equity'];
		  $esum=$esum+$equity;
		  
		 
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10, $ac_no,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $investor_name,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$equity,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,number_format((float)$tatal_turnover, 2),0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,number_format((float)$commi, 2),0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,number_format((float)$cns, 2),0,0,'C',true); // Fourth column of row 1\
	
		$pdf->Ln(4);
        $pdf->Write(6, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);  	

		}
		
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10, 'Total',0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,number_format((float)$esum, 2),0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,number_format((float)$tsum, 2),0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,number_format((float)$bsum, 2),0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,number_format((float)$csum, 2),0,0,'C',true); // Fourth column of row 1\
		
		 $pdf->Ln(10);  
	}
	$pdf->Ln(7);
	}
	   
		
$fileName ='employee_income_summary_'.$branch_id.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
 ob_end_clean();
 $pdf->Output();
        
?>