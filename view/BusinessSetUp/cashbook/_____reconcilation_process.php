<?php
if(@$_POST['check']){
foreach ($_POST['check'] as $id){
	$array = explode(";", $id);
	$balance=$array[0];
	$id_no=$array[1];
	$code=$array[2];
	$ac_no=$array[3];
	$type=$array[4];
	$des=$array[5];
    $date=$array[6];
	$inter_ref=(rand(100000,100));
	$internal_ref="NOM".$inter_ref;
   /* echo "<pre>";
	print_r($array);
    echo "</pre>"; 
	die(); */
	$sql="INSERT INTO `bank_ledger`(bank_ac_no,code,type,internal_ref,voucher_no,description,balance,date)
    VALUES('$ac_no','$code','$type','$internal_ref','0.00','$des','$balance','$date')";
	$result=$dbObj->insert($sql);

	/*Company Acount Balance Update*/
		 $db_obj->sql("SELECT * FROM  bank_ac WHERE account_number='".$db_obj->EString($ac_no)."'");
		 $bank_info=$db_obj->getResult();
		 $bank_bal=$bank_info[0]['balance'];
		 $recon_log=$_SESSION['LOGIN_USER']['login_id'];
		
		 
	if($code=='INV-FD'){
	$total_bank_bal=$bank_bal+$balance;
	$sqld="UPDATE tbl_deposit_balance SET `recon_status`='1',recon_log='$recon_log' WHERE `id`='$id_no'";
	$dbObj->update($sqld);
	 $sqldu="UPDATE `bank_ac` SET `balance`='$total_bank_bal' WHERE `account_number`='$ac_no'";
     $dbObj->update($sqldu);
	}elseif($code=='INV-FW'){
	$total_bank_bal=$bank_bal-$balance;
	$sqlw="UPDATE tbl_withdraw_balance SET `recon_status`='1',recon_log='$recon_log' WHERE `id`='$id_no'";
	$dbObj->update($sqlw);
	$sqlwu="UPDATE `bank_ac` SET `balance`='$total_bank_bal' WHERE `account_number`='$ac_no'";
    $dbObj->update($sqlwu);
	 
	}elseif($code=="BH-PAY"){
	$total_bank_bal=$bank_bal-$balance;
	$sqlp="UPDATE tbl_bank_payment SET `recon_status`='1',recon_log='$recon_log' WHERE `id`='$id_no'";
	$dbObj->update($sqlp);
	$sqlbp="UPDATE `bank_ac` SET `balance`='$total_bank_bal' WHERE `account_number`='$ac_no'";
    $dbObj->update($sqlbp);
	}elseif($code=="BTB"){
	$total_bank_bal=$bank_bal+$balance;
	$sqlp="UPDATE tbl_bank_transfer SET `recon_status`='1',recon_log='$recon_log' WHERE `id`='$id_no'";
	$dbObj->update($sqlp);
	$sqlbp="UPDATE `bank_ac` SET `balance`='$total_bank_bal' WHERE `account_number`='$ac_no'";
    $dbObj->update($sqlbp);
	}else{
	$total_bank_bal=$bank_bal+$balance;
	$sqlr="UPDATE tbl_bank_receipt SET `recon_status`='1',recon_log='$recon_log' WHERE `id`='$id_no'";
	$dbObj->update($sqlr);
	$sqlbr="UPDATE `bank_ac` SET `balance`='$total_bank_bal' WHERE `account_number`='$ac_no'";
    $dbObj->update($sqlbr);
	} 
	
	
}

}else{
	echo "<h2>Please Select Checkbox</h2>";
	exit();
}

        echo "<h2 style='text-align:center; color:green'>Reconcilation Process Successfully</h2>";
                $db_obj->disconnect();
		echo "<meta http-equiv='refresh' content='1;URL=cashbook.php?reconciliation'/>";
        exit();