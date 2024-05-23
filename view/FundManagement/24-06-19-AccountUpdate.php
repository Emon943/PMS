

<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
    if(isset($_GET["getID"])){
	$id=$enc->decryptIt($_GET["getID"]);
	
		$db_obj->sql("SELECT * FROM  tbl_deposit_balance WHERE id='".$db_obj->EString($id)."'");
	    $balance_info=$db_obj->getResult();
		$ac_no=$balance_info[0]['com_bank_ac'];
		$account_dp=$balance_info[0]['account_ref'];
		$deposit_amt=$balance_info[0]['deposit_amt'];
		$sql="UPDATE `tbl_deposit_balance` SET `net_balance`='$deposit_amt',`status`='1' WHERE `id`='$id'";
        $result1=@mysql_query($sql);
		
		//print_r($balance_info);
		//die();
		/*Company Acount Balance Update*/
		 $db_obj->sql("SELECT * FROM  bank_ac WHERE account_number='".$db_obj->EString($ac_no)."'");
		 $bank_info=$db_obj->getResult();
		 $balance=$bank_info[0]['balance'];
		 $total_ac_bal=$balance+$deposit_amt;
		 
		  //echo $total_ac_bal;
		 $sql1="UPDATE `bank_ac` SET `balance`='$total_ac_bal' WHERE `account_number`='$ac_no'";
         $result1=@mysql_query($sql1);
		 
		  
		/*investor` Balance Update*/
		 $db_obj->sql("SELECT total_balance FROM  investor WHERE dp_internal_ref_number='".$db_obj->EString($account_dp)."'");
		 $investor_bal=$db_obj->getResult();
		 $total_bal=$investor_bal[0]['total_balance'];
		 $investor_ac_bal=$total_bal+$deposit_amt;
		 //die();
		 
		   $sql2="UPDATE  investor SET `total_balance`='$investor_ac_bal' WHERE `dp_internal_ref_number`='$account_dp'";
           $result2=@mysql_query($sql2);
			 
		   echo "<h2 style='text-align:center; color:green'>Deposite Successfully Aproved</h2>";
                     
                 $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=fund_management.php?deposit' />";
           exit();
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

