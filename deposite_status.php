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
 $sql="SELECT investor.investor_name,investor.dp_internal_ref_number,investor.investor_ac_number,investor_personal.bo_catagory FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where status=0";
 $result= $dbObj->select($sql);
  

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Deposit Status',0,0,'C');
		$pdf->Ln(10);

		$width_cells=array(190);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,'C',true); // First header column 
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,$branch_id);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'                                                                                                                                                                 '." Date: " .date("d-M-Y", strtotime($as_on))."");
		$pdf->Ln(7);
	    
		
		$width_cell=array(25,50,40,35,40);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'A/C Code',BTL,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Account Name',BTL,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'BO Number',BTL,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Status',BTL,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Deposited Amount',BTLR,0,'C',true); // Fourth header column
		$pdf->Ln(10);
		
	if($result){
		
		for($i=0; $i< count($result); $i++){
		$investor_name=$result[$i]['investor_name'];
		$ac_no=$result[$i]['dp_internal_ref_number'];
		$bo_id=$result[$i]['investor_ac_number'];
		$bo_catagory=$result[$i]['bo_catagory'];
		
	   $db_obj->sql("SELECT * FROM tbl_bo_cate WHERE id='".$db_obj->EString($bo_catagory)."'");
       $bo_type=$db_obj->getResult();
       $cate_name=@$bo_type[0]['cate_name'];
		
		
	 $sqlb="SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_no' AND status=2 AND date <='$as_on' Group By account_ref";
     $res_bal= $dbObj->select($sqlb);
     $deposit_amt=@$res_bal[0]['deposit_amt'];
	 $deposit_amt=number_format((float)$deposit_amt, 2);
	
		 
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10, $ac_no,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $investor_name,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$bo_id,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$cate_name,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$deposit_amt,0,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(6, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);  	

		}
		
	}
}
	
$fileName ='deposit_status_'.$as_on.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>