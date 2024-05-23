<?php
if(isset($_POST["submit_ins"])){
foreach ($_POST['check'] as $id){

    $sql="SELECT * FROM investor WHERE dp_internal_ref_number='$id'";
	$res=$dbObj->select($sql);
    if($res){
	$ava_balance=@$res[0]['total_balance'];
	$ac_no=@$res[0]['dp_internal_ref_number'];
	$charge_amt=$_POST['fee'];
	$update_bal=$ava_balance-$charge_amt;
	$date=date("Y-m-d");

	$sqlu="UPDATE investor SET `total_balance`='$update_bal' WHERE `dp_internal_ref_number`='$ac_no'";
	$dbObj->update($sqlu);
	
	$ins=$db_obj->insert('tbl_charge_info',array('ac_no'=>$ac_no,
		'code'=>$_POST['code'],
		'type'=>$_POST['tran_type'],
		'description'=>$_POST['des'],
		'total_amt'=>$_POST['fee'],
		'total_balance'=>$ava_balance,
		'date'=>$date,
        'data_insert_id'=>$_SESSION['LOGIN_USER']['id']));
	}
					
}
    echo "<h2 style='text-align:center; color:green'>Fee & Charge Successfully Deduct</h2>";
                     
            $db_obj->disconnect();
		echo "<meta http-equiv='refresh' content='1;URL=cashbook.php?yearly_fee' />";
        exit();

}				 
?>