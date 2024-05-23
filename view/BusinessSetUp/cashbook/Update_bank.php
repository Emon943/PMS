
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
    if(isset($_GET["getID"])){
	$id=$enc->decryptIt($_GET["getID"]);
	
		$db_obj->sql("SELECT * FROM  tbl_bank_transfer WHERE id='".$db_obj->EString($id)."'");
	    $bank_trans_info=$db_obj->getResult();
		//print_r($bank_trans_info);
		
		
		$from_bank=$bank_trans_info[0]['fbank_ac_no'];
		$to_bank=$bank_trans_info[0]['tbank_ac_no'];
		$total_amt=$bank_trans_info[0]['total_amt'];
		
		 $sql1="SELECT * FROM `bank_ac`where account_number='$from_bank'";
		 $db_obj->sql($sql1);
		 $from_bank_info=$db_obj->getResult();
		 //print_r($from_bank_info);
		 //die();
		 if($from_bank_info){
		 $fbank_bal=$from_bank_info[0]['balance'];
		 $f_update_bal=$fbank_bal-$total_amt;
		 }
		 
		 /* $sqltb="SELECT * FROM `bank_ac`where id='$to_bank'";
		 $db_obj->sql($sqltb);
		 $to_bank_info=$db_obj->getResult();
		 if($to_bank_info){
		 $tbank_bal=$to_bank_info[0]['balance'];
		 $to_update_bal=$tbank_bal+$total_amt;
		 } */
		 $db_obj->update("bank_ac",array("balance"=>$f_update_bal),"account_number=".$from_bank."");
		 //$db_obj->update("bank_ac",array("balance"=>$to_update_bal),"id=".$to_bank."");
		 $db_obj->update("tbl_bank_transfer",array("status"=>'1'),"id=".$id."");
		 
		   echo "<h2 style='text-align:center; color:green'>Bank Transfer Successfully</h2>";
                     
                 $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=cashbook.php?bank_transfer_list' />";
           exit();
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>
