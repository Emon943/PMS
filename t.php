<?php
include("fpdf.php");
//include("config.php");
require("include_file/__class_file.php");
$db_obj=new PMS;
 
//$dbObj = new DBUtility();
$ac_code=base64_decode($_GET["id"]);
//print_r($ac_code);
//die();
$db_obj->sql("SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where investor.dp_internal_ref_number='$ac_code' AND investor_personal.dp_internal_ref_number='$ac_code'");
$res=$db_obj->getResult();
//print_r($res);
//die();
 $p_date=date("d/m/y");
 $bo_id=@$res[0]['investor_ac_number'];
 $db_obj->sql("SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='".$db_obj->EString($bo_id)."'");
 $result=$db_obj->getResult();
 $sum=0;
 $sums=0;
 for($i=0; $i<count($result); $i++){ 
		    $total_share=@$result[$i]['Current_Bal']+@$result[$i]['Lockin_Bal'];
			$avg_rate=$result[$i]['avg_rate'];
			$total_cost=$total_share*$avg_rate;
			$sum=$sum+$total_cost;
			$market_value=@$result[$i]['market_price']*$total_share;
			$sums=$sums+$market_value;
			$u_gain=$sums-$sum; 
	}
		
 //print_r($result);
 //die();
 $sqls=$db_obj->sql("SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$ac_code' AND status=0 Group By account_no");
 $ress= $db_obj->getResult();
 $im_bal=@$ress[0]['im_bal'];
 $immatured_bal=round($im_bal, 2);
 // echo $immatured_bal;
  
  $sqlb=$db_obj->sql("SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_code' AND status=0 Group By account_ref");
 $res_bal= $db_obj->getResult();
 $unclear_cheque=@$res_bal[0]['deposit_amt'];
 $unclear_cheque=round($unclear_cheque, 2);
  //echo $unclear_cheque;
  $ledger_bal=@$res[0]['total_balance']+$unclear_cheque+$immatured_bal;
  $ledger_bal=round($ledger_bal, 2);
  $total_balance=round(@$res[0]['total_balance'], 2);
  $total_equity=$ledger_bal+$sums;


$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->Ln(8);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',18);

		$pdf->Write(4, '                                    Protfolio Statement');
		$pdf->Ln(6);
		

		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(5, '                                                                                                                                 Account Status  :');
		$pdf->SetFont('Helvetica','',7);
		$pdf->Ln();
		$pdf->Write(6, ''.$p_date." ");
		$pdf->Ln();
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		
	
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'A/C NO                         :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$ac_code."");
		$pdf->Ln(5);
		
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'BO Number                      :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$bo_id."");
		$pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Account Name            :  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.@$res[0]['investor_name']."");
		$pdf->Ln(5);
		$pdf->Write(1, '-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Write(4,'SL   Company Name    Total       Saleable       Avg Cost     Total Cost    Market Rate    Market Value   u_gain    gain');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		///$sum=0;
		//$no_of_share=0;
		//$sql="SELECT * FROM ipo_application WHERE status=1";
        //$res= $dbObj->select($sql);
     //print_r($res);

  
        for($i=0; $i<count($result); $i++){
            $zero=0;		   
		    $total_share=@$result[$i]['Current_Bal']+@$result[$i]['Lockin_Bal'];
			$avg_rate=$result[$i]['avg_rate'];
			$total_cost=$total_share*$avg_rate;
			$market_value=@$result[$i]['market_price']*$total_share;
			
		$pdf->SetFont('Helvetica','',8); 
		$pdf->Write(4,$i."      ".@$result[$i]['ISIN_Short_Name']."             ".$total_share."           ".$result[$i]['Current_Bal']."           ".$avg_rate."             ".$total_cost."                          "       .$result[$i]['market_price']."                      "       .$market_value."            ".$zero."                  ".$market_value-$total_cost."");
		$pdf->Ln(5);
		
		$pdf->Write(1, '-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
	}
		//$pdf->Write(5, "                                                                                                                                                                                     $no_of_share                   $sum" );
		//$pdf->Ln();
	
//$fileName = 'homework-' . $_POST['teacher_name'] . '.pdf';
$fileName = 'investor_protfolio.pdf';
$pdf->Output($fileName, 'D');		
$pdf->Output();
 exit;

		
?>