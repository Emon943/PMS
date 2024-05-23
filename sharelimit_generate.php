<?php
include "config.php";
$dbObj = new DBUtility();
$date=date("d-m-Y");
$newDate = date("d-M-Y", strtotime($date));
$newfilename = date("dmY", strtotime($date));
$file="DSE-Share-Mika".$newfilename.".txt";
header('Content-Disposition: attachment; filename="'.$file.'"');
header('Content-type: text/plain');
foreach ($_POST['check'] as $id){
       //$sql="SELECT * FROM tbl_ipo WHERE id='$id'";
	    $sql="SELECT * FROM tbl_ipo INNER JOIN investor ON tbl_ipo.account_no = investor.dp_internal_ref_number  WHERE id='$id'";
	   $res= $dbObj->select($sql);
	   $free_bal=$res[0]['qty']+$res[0]['Current_Bal'];
	    echo $res[0]['ISIN']."~";
		echo $res[0]['instrument']."~";
		echo $res[0]['BO_ID']."~";
		echo $res[0]['investor_name']."~";
		echo $res[0]['Current_Bal']."~";
		echo $free_bal."~";
		echo $res[0]['account_no']."~";
		echo $newDate."\r\n";
	}
?>