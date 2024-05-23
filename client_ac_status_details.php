<?php
 include("fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
 $db_obj=new PMS;

 $as_on=@$_POST["as_on"];
 $investor=@$_POST["age"];
 $ac=@$_POST["ac"];
//die();
if($investor=="all"){
 $sql="SELECT * FROM tbl_balance_forward where date='$as_on' ORDER BY ac_no ASC";
 $result= $dbObj->select($sql);
 $acc="All";
}else{
 $sql="SELECT * FROM tbl_balance_forward where date='$as_on' AND ac_no='$ac'";
 $result= $dbObj->select($sql);
 $acc=$ac;
}

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->Ln(8);
		$pdf->SetFont('Arial','b',12);
		$pdf->Write(4, 'CAPM Advisory Limited');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Tower Hamlet (9th Floor) 
		Kemal Ataturk Avenue Banani Dhaka 1213 
		Bangladesh Tel. No.: 9822391-2');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(5, '                                                                                                                                          Client Account Status Details');
		$pdf->Ln(5);
		$width_cells=array(190);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,C,true); // First header column 
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'A/C No:   '  .$acc. '                                                                                                                                                      Date :');
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,' '.$as_on."");
		$pdf->Ln(8);
	    
		
		$width_cell=array(20,40,30,30,30,25,15);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'A/C Code',BTL,'L',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Account Name',BTL,'L',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Immatured Sale',BTL,'L',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Unclear Cheque',BTL,'L',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Available Balance',BTL,'L',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Ledger Balance',BTL,'L',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Status',BTLR,'L',true); // Fourth header column
		$pdf->Ln(10);
		
	if($result){
		$imsum=0.00;
		$lgsum=0.00;
		$avsum=0.00;
		for($i=0; $i< count($result); $i++){
		$ac_no=$result[$i]['ac_no'];
		$balace_forward	=$result[$i]['balace_forward'];
		$ava_balance=$result[$i]['ava_balance'];
		$immatured=$balace_forward-$ava_balance;
		$imsum=$imsum+$immatured;
		$lgsum=$lgsum+$balace_forward;
		$avsum=$avsum+$ava_balance;
		$unclear_cheque='0.00';
		
	   //$db_obj->sql("SELECT * FROM tbl_bo_cate WHERE id='".$db_obj->EString($bo_catagory)."'");
       //$bo_type=$db_obj->getResult();
       ///$cate_name=@$bo_type[0]['cate_name'];
		
		
	 $sqlb="SELECT * FROM investor WHERE dp_internal_ref_number='$ac_no'";
     $res_bal= $dbObj->select($sqlb);
     $investor_name=@$res_bal[0]['investor_name'];
	 $status=@$res_bal[0]['status'];
	  if($status=="0"){
		$a='Active';
	  }else{
	    $a='Inactive'; 
	  }
	
	
		 
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10, $ac_no,0,0,'L',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $investor_name,0,0,'L',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,number_format((float)$immatured, 2),0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$unclear_cheque,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,number_format((float)$ava_balance, 2),0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,number_format((float)$balace_forward, 2),0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$a,0,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(6, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);  	

		}
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10, 'Total',0,0,'L',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10,'',0,0,'L',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,number_format((float)$imsum, 2),0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,'0.00',0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,number_format((float)$avsum, 2),0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,number_format((float)$lgsum, 2),0,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,'',0,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
		
	}
	
$fileName ='deposit_status_'.$as_on.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>