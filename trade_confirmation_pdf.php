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
 $sql="SELECT * FROM tread_data_list WHERE account_no='$ac' AND `curr_date`='$as_on' GROUP By account_no";
 $buy_sell= $dbObj->select($sql);
  //print_r($buy_sell);
  $sqlb="SELECT SUM(net_amount) as bnamt FROM tread_data_list WHERE account_no='$ac' AND `curr_date`='$as_on' AND type='B'";
  $sum_buy_res= $dbObj->select($sqlb);
  $b_net_amt=$sum_buy_res[0]['bnamt'];
  $buy_net_amt=number_format((float)$b_net_amt, 2);
  
  
  $sqls="SELECT SUM(net_amount) as bnamt FROM tread_data_list WHERE account_no='$ac' AND `curr_date`='$as_on' AND type='S'";
  $sum_sell_res= $dbObj->select($sqls);
  $s_net_amt=$sum_sell_res[0]['bnamt'];
  $sell_net_amt=number_format((float)$s_net_amt, 2);
  $totals=$b_net_amt+$s_net_amt;
  $total=number_format((float)$totals, 2);   
}else{
 $sql="SELECT * FROM tread_data_list WHERE `curr_date`='$as_on' GROUP By account_no";
 $buy_sell= $dbObj->select($sql);
  //print_r($buy_sell);
  $sqlb="SELECT SUM(net_amount) as bnamt FROM tread_data_list WHERE `curr_date`='$as_on' AND type='B'";
  $sum_buy_res= $dbObj->select($sqlb);
  $b_net_amt=$sum_buy_res[0]['bnamt'];
  $buy_net_amt=number_format((float)$b_net_amt, 2);
  
  
  $sqls="SELECT SUM(net_amount) as bnamt FROM tread_data_list WHERE `curr_date`='$as_on' AND type='S'";
  $sum_sell_res= $dbObj->select($sqls);
  $s_net_amt=$sum_sell_res[0]['bnamt'];
  $sell_net_amt=number_format((float)$s_net_amt, 2);
  $totals=$b_net_amt+$s_net_amt;
  $total=number_format((float)$totals, 2);  	
}

		$pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Trade Confirmation',0,0,'C');
		$pdf->Ln(10);
	    $width_cells=array(190);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,C,true); // First header column 
		$pdf->Ln(5);
		

		if($buy_sell){
		$sqty=0;
		$scommi=0;
		$samt=0;
		$snamt=0;
		$ssqty=0;
		$sscommi=0;
		$ssamt=0;
		$ssnamt=0;
		for($i=0; $i< count($buy_sell); $i++){
		$ac_no=$buy_sell[$i]['account_no'];
		$date=$buy_sell[$i]['curr_date'];
		$type=$buy_sell[$i]['type'];
		$sql_inv="SELECT investor_name,total_balance FROM investor WHERE dp_internal_ref_number='$ac_no'";
        $balance= $dbObj->select($sql_inv);
        $investor_name=$balance[0]['investor_name'];

        $pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Code: ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$ac_no."");
		$pdf->Ln(-3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(0,10,'Trading Date: '. date("d-M-Y", strtotime($as_on)),0,0,'R');
		$pdf->Ln(8);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Name: ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,''.$investor_name."");
		$pdf->Ln(7);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'Dear Sir/Madam,  ');
		$pdf->Ln(4);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'With Reference to your(orders) the following securities have transacted:  ');
		$pdf->Ln(7);
		$width_cell=array(25,20,25,20,15,15,20,25,25);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'Instrument',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Order No',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Contract No',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Exe. Time',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Quantity',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Rate',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Comm.',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[7],10,'Amount',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[8],10,'Net Amount',1,0,'C',true); // Fourth header column
		$pdf->Ln(12);
		
		

		
		$sql="SELECT * FROM tread_data_list WHERE account_no='$ac_no' AND `curr_date`='$as_on' AND type='B'";
        $sub_buy_sell= $dbObj->select($sql);
		
	
	if($sub_buy_sell){
		$sql_sum="SELECT SUM(quantity) as bqty,SUM(commission) as bcomm,SUM(total_amount) as bamt,SUM(net_amount) as bnamt FROM tread_data_list WHERE account_no='$ac_no' AND `curr_date`='$as_on' AND type='B'";
        $sum_buy_res= $dbObj->select($sql_sum);
		$bqty=$sum_buy_res[0]['bqty'];
		$bcomm=$sum_buy_res[0]['bcomm'];
		$bcomm_v=number_format((float)$bcomm, 2);
		$bamt=$sum_buy_res[0]['bamt'];
		$bamt_v=number_format((float)$bamt, 2);
		$bnamt=$sum_buy_res[0]['bnamt'];
		$bnamt_v=number_format((float)$bnamt, 2);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Buy: ');
		$pdf->Ln(5);
	 foreach($sub_buy_sell as $sbs){	 
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell($width_cell[0],10, $sbs['instrument'],0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,$sbs['OrderNo'],0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,$sbs['ContractNo'],0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,$sbs['time_tread'],0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,number_format((int)$sbs['quantity']),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$sbs['rate'],0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,number_format((float)$sbs['commission'],2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,number_format((float)$sbs['total_amount'],2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,number_format((float)$sbs['net_amount'],2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(6);  	
 }
        $pdf->SetFont('Helvetica','B',9);
        $pdf->Write(4, ' ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
		
		$pdf->Cell($width_cell[0],10, ' ',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,' ',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,' ',0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,'Total Buy ',0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,number_format((int)$bqty),0,0,'C',false); // Fourth column of row1 
		$pdf->Cell($width_cell[5],10,' ',0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$bcomm_v,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,$bamt_v,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,$bnamt_v,0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                    _______                         _________       ____________        ____________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                    _______                         _________       ____________        ____________');

		$pdf->Ln(7);
	}
	
	
	$ssql="SELECT * FROM tread_data_list WHERE account_no='$ac_no' AND `curr_date`='$as_on' AND type='S'";
    $ssub_buy_sell= $dbObj->select($ssql);
    if($ssub_buy_sell){
	   $ssql_sum="SELECT SUM(quantity) as sqty,SUM(commission) as scomm,SUM(total_amount) as samt,SUM(net_amount) as snamt FROM tread_data_list WHERE account_no='$ac_no' AND `curr_date`='$as_on' AND type='S'";
        $sum_sell_res= $dbObj->select($ssql_sum);
		$sqty=$sum_sell_res[0]['sqty'];
		$scomm=$sum_sell_res[0]['scomm'];
		$scomm_v=number_format((float)$scomm, 2);
		$samt=$sum_sell_res[0]['samt'];
		$samt_v=number_format((float)$samt, 2);
		$snamt=$sum_sell_res[0]['snamt'];
		$snamt_v=number_format((float)$snamt, 2);
		
        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'Sale: ');
		$pdf->Ln(5);
     foreach($ssub_buy_sell as $ssbs){
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell($width_cell[0],10,$ssbs['instrument'],0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,$ssbs['OrderNo'],0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,$ssbs['ContractNo'],0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,$ssbs['time_tread'],0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,number_format((int)$ssbs['quantity']),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,$ssbs['rate'],0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,number_format((float)$ssbs['commission'],2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,number_format((float)$ssbs['total_amount'],2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,number_format((float)$ssbs['net_amount'],2),0,0,'C',false); // Fourth column of row 1\
		$pdf->Ln(5);
       } 
	   $pdf->SetFont('Helvetica','B',9);
	   
       $pdf->Write(4, ' ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
       $pdf->Ln(3);
   
        //$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cell[0],10, ' ',0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,' ',0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,' Total Sale',0,0,'C',false); // Third column of row 1	
		$pdf->Cell($width_cell[3],10,' ',0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,number_format((int)$sqty),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[5],10,' ',0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[6],10,$scomm_v,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[7],10,$samt_v,0,0,'C',false); // Fourth column of row 1\
		$pdf->Cell($width_cell[8],10,$snamt_v,0,0,'C',true ); // Fourth column of row 1\
		$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                    _______                         _________       ____________        ____________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                    _______                         _________       ____________        ____________');
		
		$pdf->Ln(7);
 
}   
  }
  

}

$fileName ='trade_confirmation_'.$ac.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>