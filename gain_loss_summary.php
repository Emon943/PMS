<?php
 include("fpdf/fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
 $db_obj=new PMS;
 $print_date=date("d-M-Y");
 $date=@$_POST["as_on"];

if($date){
  $sql_inv="SELECT * FROM investor Where status=0 ORDER BY dp_internal_ref_number ASC";
  $res= $dbObj->select($sql_inv);
  
		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Gain Loss Summary',0,0,'C');
		$pdf->Ln(10);

		$width_cells=array(190);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,'C',true); // First header column 
		$pdf->Ln(3);
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'                                                                                                                                                                                          '." Date: " .date("d-M-Y", strtotime($date))."");
		$pdf->Ln(7);
	   
		
		$width_cell=array(30,40,40,40,40);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Cell($width_cell[0],10,'Client Code',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Client Name',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'BO ID',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Realised Gain',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Realised Loss',1,1,'C',true); // Fourth header column
		$pdf->Ln(3);
		
	    for($i=0; $i< count($res); $i++){
        $ac_no=@$res[$i]['dp_internal_ref_number'];
		$investor_ac_number=@$res[$i]['investor_ac_number'];
		$investor_name=@$res[$i]['investor_name'];
		if($ac_no){{
        $sql_bonus="SELECT SUM(qty)as qty FROM `tbl_bonus_share` WHERE bo_id='$investor_ac_number' AND date <= '$date'";
        $bonus_res= $dbObj->select($sql_bonus);
		$bonus_qty=@$bonus_res[0]['qty'];
	    
		$sqlb="SELECT SUM(qty)as qty,SUM(total_amt)as total_amt FROM `tbl_charge_info` WHERE ac_no='$ac_no' AND code='B' AND date <= '$date' GROUP BY ac_no";
        $buy_res= $dbObj->select($sqlb);
		$buy_qty=@$buy_res[0]['qty'];
		$btotal_amt=@$buy_res[0]['total_amt'];
		$tbuy_qty=$buy_qty+$bonus_qty;
		if($tbuy_qty < $btotal_amt){
		$buy_rate=@$btotal_amt/@$tbuy_qty;
		}
		$sqls="SELECT SUM(qty)as qty,SUM(total_amt)as total_amt FROM `tbl_charge_info` WHERE ac_no='$ac_no' AND code='S' AND date <= '$date' GROUP BY ac_no";
        $sell_res= $dbObj->select($sqls);
		$sell_qty=@$sell_res[0]['qty'];
		$stotal_amt=@$sell_res[0]['total_amt'];
		if($sell_qty < $stotal_amt){
		$sell_rate=@$stotal_amt/@$sell_qty;
		}
		$cur_buy_qty=@$tbuy_qty-$sell_qty;
		$cur_buy_cost=@$cur_buy_qty*@$buy_rate;
		$pre_buy_cost=@$btotal_amt-@$cur_buy_cost;
		$profit_loss=@$stotal_amt-@$pre_buy_cost;
		if(@$profit_loss > 0){
		$gain=$profit_loss;
		$gain=number_format((float)$gain, 2);
		}else{
		$gain=0.00;
		}
		if(@$profit_loss < 0){
		$loss=$profit_loss;
		$loss=number_format((float)$loss, 2);
		}else{
		$loss=0.00;
		}
		
		
    }
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10, $ac_no,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $investor_name,0,0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,$investor_ac_number,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,$gain,0,0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$loss,0,0,'C',true); // Fourth column of row 1\
		
		$pdf->Ln(5);
        $pdf->Write(5, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);  	
		}
		
        //$pdf->SetX(165);	
        //$pdf->MultiCell(20,5,$total_deposit,B,C,false);
		//$pdf->Ln(12); 
		
	}

}
$fileName ='gain_loss_summary_'.$date.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>