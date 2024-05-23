<?php
 include("FPDF/fpdf.php");
 $pdf = new FPDF();
 include("include_file/__class_file.php");
 $db_obj=new PMS;
 $print_date=date("d-M-Y");
 $ac=@$_POST["ac"];
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];

if($ac){
$db_obj->sql("SELECT * FROM   `investor_personal`  INNER JOIN `investor` 
        ON (`investor_personal`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_passport` 
        ON (`investor_passport`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_tax_details` 
        ON (`investor_tax_details`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_bank_details` 
        ON (`investor_bank_details`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_exchange_details` 
        ON (`investor_exchange_details`.`investor_id` = `investor`.`investor_id`) WHERE `investor`.`dp_internal_ref_number`='".$db_obj->EString($ac)."'");
	$investor=$db_obj->getResult();
	//print_r($investor);
	//die();
}
else{
  
  $db_obj->sql("SELECT * FROM   `investor_personal`  INNER JOIN `investor` 
        ON (`investor_personal`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_passport` 
        ON (`investor_passport`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_tax_details` 
        ON (`investor_tax_details`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_bank_details` 
        ON (`investor_bank_details`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_exchange_details` 
        ON (`investor_exchange_details`.`investor_id` = `investor`.`investor_id`) WHERE `investor`.`creatd_date` BETWEEN '$fromdate' AND '$todate' ORDER BY creatd_date ASC");
   $investor=$db_obj->getResult();
   //print_r($investor);
}


 
 
 if($investor){
	   
	   foreach($investor as $investor){
	    $group_id=$investor['investor_group_id'];
	    $invsql = "select * from investor_group where investor_group_id='$group_id'";
        $db_obj->sql($invsql);
	    $investor_group_res=$db_obj->getResult();
	    $group_name=@$investor_group_res[0]['group_name'];
	    $pdf->PageNo();
	    $pdf->AddPage("P","A4");
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'BO Registration Confirmation',0,0,'C');
		$pdf->Ln(10);

		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Client Code: ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$ac."");
		$pdf->Ln(5);
		
		
		
		$pdf->SetFont('Helvetica','B',8);
		
		$width_cell=array(189,50);
		$pdf->SetFillColor(192,192,192);
		// Header starts /// 
		$pdf->Cell($width_cell[0],10,'ACCOUNT DETAILS',0,1,'L',true); // First header column
        $pdf->Ln(2);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Registration Date   :                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'          '.date("d-M-Y", strtotime($investor['creatd_date']))."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'A/C Number/Trading ID   :                                                          ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'          '.$investor['dp_internal_ref_number']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'BO ID   :                                                                                        ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'         '.$investor['investor_ac_number']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'BO Type   :                                                                                   ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'          '.$investor['account_status']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'BO Category   :                                                                           ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'           '.$investor['bo_type']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Investor Group   :                                                                        ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'          '.$group_name."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'PERSONAL DETAILS',0,1,'L',true); // First header column
		$pdf->Ln(2);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Full Name   :                                                                                         ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['name_of_first_holder']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Joint Holder Name :                                                          ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['second_joint_holder']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Father/Husband Name   :                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['father_husbands']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Mother Name   :                                                                                   ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['mothers_name']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Gender   :                                                                                             ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['sex_code']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Nationality  :                                                                                        ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['citizen_of']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Date of Birth   :                                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['date_of_birth']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Occupation   :                                                                                      ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['occupation']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'PASSPORT DETAILS',0,1,'L',true); // First header column
		$pdf->Ln(2);
		
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Passport No.   :                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['passport_no']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Passport Issue Date   :                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['passport_issu_date']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Passport Expiry Date   :                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['passport_expiry_date']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Passport Issue Place   :                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['passport_issue_place']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'ADDRESS',0,1,'L',true); // First header column
		$pdf->Ln(2);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Address Line   :                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['address'].','.$investor['state'].','.$investor['postal_code'].','.$investor['country']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'District   :                                                                     ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'');
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Post Code   :                                                                     ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'' );
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Country   :                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,'' );
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'CONTACT DETAILS',0,1,'L',true); // First header column
		$pdf->Ln(2);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Mobile   :                                                                                  ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['phone']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Telephone   :                                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['fax']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Email   :                                                                                    ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['email']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell($width_cell[0],10,'BANK ACCOUNT DETAILS',0,1,'L',true); // First header column
		$pdf->Ln(2);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Bank Name   :                                                                         ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['bank_name']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Branch Name   :                                                                     ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['branch_name']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Bank Account Number   :                                                     ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$investor['bank_ac_no']."");
		$pdf->Ln(5);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Write(1, '----------------------------------------------------------------------------------------------------------------------------------------------------------');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(4,'Print Date   :                       ');
		$pdf->SetFont('Helvetica','',8);
		$pdf->Write(4,''.$print_date."");
		$pdf->Ln(5);
 }
  }

$fileName ='BO_Registration_Info_'.$ac.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();
 

		
?>