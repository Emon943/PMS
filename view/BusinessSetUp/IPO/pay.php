
<?php	
    if(isset($_GET["status"])){
	$status=$enc->decryptIt($_GET["status"]);
	//echo $status;
	 //die();
	
		$db_obj->sql("SELECT * FROM ipo_application WHERE status='".$db_obj->EString($status)."'");
	    $ipo_pay=$db_obj->getResult();
		
		$db_obj->sql("SELECT * FROM transaction_type WHERE id='".$db_obj->EString(8)."'");
	    $ipo_charge=$db_obj->getResult();
		//print_r($ipo_charge);
		$user_id=$_SESSION['LOGIN_USER']['id'];
		$tran_type=$ipo_charge[0]['tran_type'];
		$code=$ipo_charge[0]['code'];
		$description=$ipo_charge[0]['description'];
		$charge_amt=$ipo_charge[0]['charges_amt'];
		
			  if(!$ipo_pay){
				   echo "<h2>IPO Application Not Founded...........</h2>";
                 $db_obj->disconnect();
		    echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOapplication' />";
               exit(); 
				  }else{
					  //echo count($ipo_pay);
					  //die();
				for($i=0; $i<count($ipo_pay);$i++){
					$ac_no = @$ipo_pay[$i]['ac_no'];
					$date = @$ipo_pay[$i]['date'];
					$sql_acb="SELECT total_balance FROM investor WHERE dp_internal_ref_number='$ac_no'";
                    $res_avai_bal= $dbObj->select($sql_acb);
	                $total_bals =@$res_avai_bal[0]["total_balance"];
			
					    $id = @$ipo_pay[$i]['id'];
						$company_name = @$ipo_pay[$i]['company_id'];
						$short_name = @$ipo_pay[$i]['short_name'];
						//$date =date("Y-m-d");
						$ipo_amt=$ipo_pay[$i]['total_amt'];
					    $ac_bal=@$total_bals-($ipo_amt+$charge_amt);
						
						
					    $sql="INSERT INTO `tbl_charge_info`(code,ac_no,type,description,company_name,short_name,total_amt,total_balance,date,data_insert_id)
                        VALUES('$code','$ac_no','$tran_type','$description','$company_name','$short_name','$charge_amt','$ac_bal','$date','$user_id')";
						$result=mysql_query($sql);
						
						$sql="INSERT INTO `tbl_charge_info`(code,ac_no,type,description,company_name,short_name,total_amt,total_balance,date,data_insert_id)
                        VALUES('$code','$ac_no','$tran_type','IPO Payment','$company_name','$short_name','$ipo_amt','$ac_bal','$date','$user_id')";
						$result=mysql_query($sql);

						
						$sql1="UPDATE `ipo_application` SET `status`='1', description='IPO Payment', `ac_bal`='$ac_bal' WHERE `id`='$id'";
                        $result1=@mysql_query($sql1);
						
						
						$sql2="UPDATE `investor` SET `total_balance`='$ac_bal' WHERE `dp_internal_ref_number`='$ac_no'";
                        $result2=@mysql_query($sql2);
						
			}		
		   echo "<h2 style='text-align:center; color:green'>Successfully Paid IPO</h2>";
                     
                 $db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOapplication' />";
           exit();  
		}
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
		
	?>
