
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
    if(isset($_GET["getID"])){
	$id=$enc->decryptIt($_GET["getID"]);
	
		$db_obj->sql("SELECT * FROM  tbl_withdraw_balance WHERE id='".$db_obj->EString($id)."'");
	    $balance_info=$db_obj->getResult();
		$id=$balance_info[0]['id'];
		$our_ref=$balance_info[0]['our_ref'];
		$ac_no=$balance_info[0]['com_bank_ac'];
		$type=$balance_info[0]['type'];
		$date=date("Y-m-d");
		$user_id=$balance_info[0]['data_insert_id'];
		$investor_name=$balance_info[0]['investor_name'];
		$account_dp=$balance_info[0]['account_ref'];
		$withdraw_amt=$balance_info[0]['withdraw_amt'];
		$sql="UPDATE `tbl_withdraw_balance` SET `withdraw_net_balance`='$withdraw_amt',`status`='2' WHERE `id`='$id'";
        $result1=@mysql_query($sql);
		
		
		
		
		//print_r($balance_info);
		//die();
		/*Company Acount Balance Update*/
		 /* $db_obj->sql("SELECT * FROM  bank_ac WHERE account_number='".$db_obj->EString($ac_no)."'");
		 $bank_info=$db_obj->getResult();
		 $balance=@$bank_info[0]['balance'];
		 $total_ac_bal=$balance-$withdraw_amt; */
		 
		 
		  //echo $total_ac_bal;
		 //$sql1="UPDATE `bank_ac` SET `balance`='$total_ac_bal' WHERE `account_number`='$ac_no'";
         //$result1=@mysql_query($sql1);
		 
		  
		/*investor` Balance Update*/
		 $db_obj->sql("SELECT total_balance FROM  investor WHERE dp_internal_ref_number='".$db_obj->EString($account_dp)."'");
		 $investor_bal=$db_obj->getResult();
		 $total_bal=@$investor_bal[0]['total_balance'];
		 $investor_ac_bal=@$total_bal-$withdraw_amt;
		 $des="Fund withdraw ".$our_ref;
		
		 $sql="INSERT INTO `tbl_charge_info`(code,ac_no,type,description,company_name,short_name,total_amt,total_balance,date,data_insert_id)
         VALUES('WD','$account_dp','$type','$des','$id','NULL','$withdraw_amt','$total_bal','$date','$user_id')";
		 $result=mysql_query($sql);
		 
		   $sql2="UPDATE  investor SET `total_balance`='$investor_ac_bal' WHERE `dp_internal_ref_number`='$account_dp'";
           $result2=@mysql_query($sql2);
			 
		   echo "<h2 style='text-align:center; color:green'>Withdrawal Successfully Aproved</h2>";
                     
                 $db_obj->disconnect();
	     echo "<meta http-equiv='refresh' content='1;URL=balance_aprove.php?withdrawal'/>";
         exit();
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

