
<?php 
	if(isset($_GET['dell']) && $page['delete_status']=="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
    if(isset($_GET["getID"])){
	$id=$enc->decryptIt($_GET["getID"]);
	
		$db_obj->sql("SELECT * FROM  tbl_withdraw_balance WHERE id='".$db_obj->EString($id)."'");
	    $balance_info=$db_obj->getResult();
		$ac_no=$balance_info[0]['id'];
		$account_dp=$balance_info[0]['account_ref'];
		$withdraw_amt=$balance_info[0]['withdraw_amt'];
		
		 $db_obj->sql("SELECT total_balance FROM  investor WHERE dp_internal_ref_number='".$db_obj->EString($account_dp)."'");
		 $investor_bal=$db_obj->getResult();
		 $total_bal=$investor_bal[0]['total_balance'];
		 $investor_ac_bal=$total_bal+$withdraw_amt;
	
		 
		 $sql2="UPDATE  investor SET `total_balance`='$investor_ac_bal' WHERE `dp_internal_ref_number`='$account_dp'";
         $res=@mysql_query($sql2);
		   
		if($res){
        $db_obj->delete("tbl_withdraw_balance", "id='$id'");
		
        $db_obj->delete("tbl_charge_info", "company_name='$id'");
		 }
			 
		   echo "<h2 style='text-align:center; color:green'>Withdrawal Cancel Successfully</h2>";
                     
                 $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=fund_management.php?withdrawal' />";
           exit();
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

