<?php
 include("fpdf/fpdf.php");
 include("NumberConvert.php");
 $pdf = new FPDF();
 include("config.php");
 $dbObj = new DBUtility();
 $print_date=date("d-M-Y");
 $ac=@$_POST["ac"];
 $as_on=@$_POST["as_on"];
 $previous_date=date('Y-m-d', strtotime('-1 day', strtotime($as_on)));
 $format_date=date('d-M-Y', strtotime($as_on));
 

if($ac){
 $sql_inv="SELECT investor_name,total_balance FROM investor WHERE dp_internal_ref_number='$ac'";
 $balance= $dbObj->select($sql_inv);
 $investor_name=$balance[0]['investor_name'];
 $Abal=$balance[0]['total_balance'];
 $sql_inv="SELECT * FROM tbl_balance_forward WHERE ac_no='$ac' AND date='$previous_date'";
 $forward_bal= $dbObj->select($sql_inv);
 $fbal=$forward_bal[0]['balace_forward'];
 $sql="SELECT * FROM tread_data_list WHERE account_no='$ac' AND `curr_date`='$as_on' GROUP By account_no";
 $buy_sell= $dbObj->select($sql);
  //print_r($buy_sell);
  $sqlb="SELECT SUM(net_amount) as bnamt FROM tread_data_list WHERE account_no='$ac' AND `curr_date`='$as_on' AND type='B'";
  $sum_buy_res= $dbObj->select($sqlb);
  $b_net_amt=$sum_buy_res[0]['bnamt'];
  $buy_net_amt=number_format((float)$b_net_amt, 2);
  
  $sqlim="SELECT SUM(immatured_bal) as immatured_bal FROM sale_share WHERE account_no='$ac' AND status=0";
  $immature_res= $dbObj->select($sqlim);
  $imm_bal=$immature_res[0]['immatured_bal'];
  $imm_balance=number_format((float)$imm_bal, 2);
  
  
  $sqls="SELECT SUM(net_amount) as bnamt FROM tread_data_list WHERE account_no='$ac' AND `curr_date`='$as_on' AND type='S'";
  $sum_sell_res= $dbObj->select($sqls);
  $s_net_amt=$sum_sell_res[0]['bnamt'];
  $sell_net_amt=number_format((float)$s_net_amt, 2);
  $totals=$b_net_amt+$s_net_amt;
  $total=number_format((float)$totals, 2);   
}
else{
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
		$pdf->Cell(0,10,'Trade Confirmation Summary (Customer Copy)',0,0,'C');
		$pdf->Ln(10);

		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
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
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Code: ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$ac_no."");
		$pdf->Ln(0);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'                                                                                                                                                                         Trading Date: '.date("d-M-Y", strtotime($as_on)));
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Name: ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor_name."");
		$pdf->Ln(7);
		$pdf->SetFont('Helvetica','',10);
		$pdf->Write(4,'Dear Sir/Madam,  ');
		$pdf->Ln(4);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(4,'With Reference to your order no as stated before dated '.$format_date.', we have purchased & sold following securities:  ');
		$pdf->Ln(7);
		
		$width_cell=array(25,30,25,25,25,25,33);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'Trade',BTL,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Instrument',BT,'C',true); // Second header column
		$pdf->Cell($width_cell[2],10,'Quantity',BT,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Rate',BT,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Comm.',BT,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Amount',BT,'C',true); // Fourth header column
		$pdf->Cell($width_cell[6],10,'Net Amount',BTR,'C',true); // Fourth header column
		$pdf->Ln(10);
		$sql="SELECT instrument,SUM(quantity) as bqty,SUM(commission) as bcomm,SUM(total_amount) as bamt,SUM(net_amount) as bnamt FROM tread_data_list WHERE account_no='$ac_no' AND `curr_date`='$as_on' AND type='B' GROUP BY instrument";
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
		$pdf->Write(4,'DSE   :  ');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(1, '---------------------------  ');
	    $pdf->Ln(3);
		$pdf->Write(4,'Marke Type: P');
		$pdf->Ln(5);
		$pdf->Write(4,'Buy   :  ');
		$pdf->Ln(3);
		$pdf->Write(6, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
	 foreach($sub_buy_sell as $sbs){
		$rate=$sbs['bamt']/$sbs['bqty'];
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell($width_cell[0],10, '',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, $sbs['instrument'],0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,number_format((int)$sbs['bqty']),0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,number_format((float)$rate,2),0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,number_format((float)$sbs['bcomm'],2),0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,number_format((float)$sbs['bamt'],2),0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,number_format((float)$sbs['bnamt'],2),0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(6, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);  	
 }
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cell[0],10, '',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, 'Total',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,number_format((int)$bqty),0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,' ',0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$bcomm_v,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$bamt_v,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$bnamt_v,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
		$pdf->Write(6, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cell[0],10, '',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, '',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,'',0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,'Total Buy',0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$bcomm_v,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$bamt_v,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$bnamt_v,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                                                   _________        ____________                  ____________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                                                   _________        ____________                  ____________');

		$pdf->Ln(20);
		
	}
	$ssql="SELECT instrument,SUM(quantity) as sqty,SUM(commission) as scomm,SUM(total_amount) as samt,SUM(net_amount) as snamt FROM tread_data_list WHERE account_no='$ac_no' AND `curr_date`='$as_on' AND type='S' GROUP BY instrument";
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
		$pdf->Write(4,'DSE   :  ');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(1, '---------------------------  ');
	    $pdf->Ln(3);
		$pdf->Write(4,'Marke Type: P');
		$pdf->Ln(5);
		$pdf->Write(4,'Sale   :  ');
		$pdf->Ln(3);
		$pdf->Write(6, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(3);
        foreach($ssub_buy_sell as $ssbs){
		$rate=$ssbs['samt']/$ssbs['sqty'];
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell($width_cell[0],10,'',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10,$ssbs['instrument'],0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,number_format((int)$ssbs['sqty']),0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,number_format((float)$rate,2),0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,number_format((float)$ssbs['scomm'],2),0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,number_format((float)$ssbs['samt'],2),0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,number_format((float)$ssbs['snamt'],2),0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4);
        $pdf->Write(6, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);		
      }
        $pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cell[0],10, '',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, 'Total',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,number_format((int)$sqty),0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,'',0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$scomm_v,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$samt_v,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$snamt_v,0,'C',true); // Fourth column of row 1\
		$pdf->Ln(4); 
		$pdf->Write(6, '----------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(4);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cell[0],10, '',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[1],10, '',0,'C',true); // First column of row 1 
		$pdf->Cell($width_cell[2],10,'',0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[3],10,'Total Sale',0,'C',true); // Fourth column of row 1 
		$pdf->Cell($width_cell[4],10,$scomm_v,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[5],10,$samt_v,0,'C',true); // Fourth column of row 1\
		$pdf->Cell($width_cell[6],10,$snamt_v,0,'C',true); // Fourth column of row 1\
		
		$pdf->Ln(5.5);

		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                                                   _________        ____________                  ____________');
        $pdf->Ln(0.75);

        $pdf->SetFont('Helvetica','B',8);
		$pdf->Write(1, '                                                                                                                                                   _________        ____________                  ____________');

		$pdf->Ln(20);
 }  
   
  }
       $width_cell=array(40,30,30,28,30,30);
		$pdf->SetFillColor(255,255,255);
		// Header starts /// 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'Opening Balance',1,0,'C',true); // Second header column
		$pdf->Cell($width_cell[1],10,'Total Sale',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[2],10,'Total Buy',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[3],10,'Today Net',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[4],10,'Closing Balance',1,0,'C',true); // Fourth header column
		$pdf->Cell($width_cell[5],10,'Matured Balance',1,0,'C',true); // Fourth header column
		$pdf->Ln(10);
		if(!$snamt_v){
			$snamt_v='0.00';
		}
		if(!$bnamt_v){
			$bnamt_v='0.00';
		}
		
		$today_net=$snamt-$bnamt;
		$closing=$fbal+$today_net;
		$mature_bal=$closing-$imm_bal;
		
		$pdf->Cell($width_cell[0],10,number_format((float)$fbal,2),0,0,'C',false); // First column of row 1 
		$pdf->Cell($width_cell[1],10,$snamt_v,0,0,'C',false); // Second column of row 1 
		$pdf->Cell($width_cell[2],10,$bnamt_v,0,0,'C',false); // Third column of row 1 
		$pdf->Cell($width_cell[3],10,number_format((float)$today_net,2),0,0,'C',false); // Fourth column of row 1
		$pdf->Cell($width_cell[4],10,number_format((float)$closing,2),0,0,'C',false); // Fourth column of row 1 
		$pdf->Cell($width_cell[5],10,number_format((float)$closing,2),0,0,'C',false); // Fourth column of row 1
		$pdf->Ln(5);
		}
		$pdf->Write(4, '-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
        $pdf->Ln(14);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(1, '---------------------------                                                                                                                        --------------------------------------------------');
	    $pdf->Ln(3);
		$pdf->Write(1, 'Clinet Acceptance                                                                                                                           On Behalf of: CAPM Advisory Ltd.');
        $pdf->Ln(1);
$fileName ='trade_confirmation_details_'.$ac.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 	
?>