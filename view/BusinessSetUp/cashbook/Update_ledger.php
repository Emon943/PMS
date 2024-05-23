
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
    if(isset($_GET["getID"])){
	$id=$enc->decryptIt($_GET["getID"]);
	
		$db_obj->sql("SELECT * FROM  tbl_bank_payment WHERE id='".$db_obj->EString($id)."'");
	    $payment_info=$db_obj->getResult();
		
		$bank_id=$payment_info[0]['bank_id'];
		$nominal_id=$payment_info[0]['nominal_id'];
		$payment_amt=$payment_info[0]['payment_amt'];
		 /* $sql1="SELECT * FROM `bank_ac`where id='$bank_id'";
		 $db_obj->sql($sql1);
		 $bank_name=$db_obj->getResult();
		 $bank_bal=$bank_name[0]['balance']; */
		 
		 $sql2="SELECT * FROM `tbl_broker_hous`where trace_id='$nominal_id'";
		 $db_obj->sql($sql2);
		 $nominal_name=$db_obj->getResult();
		 if($nominal_name){
		 $nominal_bal=$nominal_name[0]['payable'];
		 $update_nominal_bal=$nominal_bal-$payment_amt;
		 
	     $db_obj->update("tbl_broker_hous",array("payable"=>$update_nominal_bal),"trace_id=".$nominal_id."");
		 }
		 $db_obj->update("tbl_bank_payment",array("status"=>1),"id=".$id."");
		
		
			 
		   echo "<h2 style='text-align:center; color:green'>House Payment Successfully Aproved</h2>";
                     
                 $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=cashbook.php?payment_list' />";
           exit();
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>
