
<?php 
	if(isset($_GET['dell']) && $page['delete_status']=="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
    if(isset($_GET["getID"])){
	$id=$enc->decryptIt($_GET["getID"]);
	
	   $db_obj->sql("SELECT * FROM  tbl_deposit_balance WHERE id='".$db_obj->EString($id)."'");
	    $balance_info=$db_obj->getResult();
		//print_r($balance_info);
		//die();
		$user_id=$_SESSION['LOGIN_USER']['id'];
		$ac_no=$balance_info[0]['id'];
		$account_dp=$balance_info[0]['account_ref'];
		$deposit_amt=$balance_info[0]['deposit_amt'];
		$our_ref=$balance_info[0]['our_ref'];
		$receipt=$balance_info[0]['receipt'];
		$type=$balance_info[0]['type'];
		$company_name=@$balance_info[0]['company_name'];
		$cheque=$balance_info[0]['cheque'];
		$voucher_Ref=$balance_info[0]['voucher_Ref'];
		$bank=$balance_info[0]['bank'];
		$status=$balance_info[0]['status'];
		$desc="Fund Deposite ".$our_ref."< Adjustment Entry >";
		$date=date("Y-m-d");
		
		
		$db_obj->sql("SELECT * FROM  tbl_charge_info WHERE company_name='".$db_obj->EString($id)."'");
	    $ledger_info=$db_obj->getResult();
		$description=$ledger_info[0]['description'];
		$des=$description." Dishonoured";
		
		 $db_obj->sql("SELECT total_balance FROM  investor WHERE dp_internal_ref_number='".$db_obj->EString($account_dp)."'");
		 $investor_bal=$db_obj->getResult();
		 $total_bal=$investor_bal[0]['total_balance'];
		 $investor_ac_bal=$total_bal-$deposit_amt;
	
		 
		 $sql2="UPDATE  investor SET `total_balance`='$investor_ac_bal' WHERE `dp_internal_ref_number`='$account_dp'";
         $res=@mysql_query($sql2);
		   
		if($res){
        //$db_obj->delete("tbl_deposit_balance", "id='$id'");
		$result=$db_obj->update("tbl_deposit_balance",array("status"=>'3',"recon_status"=>'3'),"id=".$id."");
		$result=$db_obj->update("tbl_charge_info",array("description"=>$des),"company_name=".$id."");
		
		 $sql="INSERT INTO `tbl_charge_info`(code,ac_no,type,description,company_name,short_name,total_amt,total_balance,date,data_insert_id)
         VALUES('DP','$account_dp','Payment','$desc','$id','NULL','$deposit_amt','$deposit_amt','$date','$user_id')";
		 $result=mysql_query($sql);
		 }
			 
		   echo "<h2 style='text-align:center; color:green'>Deposite Cancel Successfully</h2>";
                     
                 $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=fund_management.php?deposit' />";
           exit();
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

