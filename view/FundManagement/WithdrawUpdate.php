
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
	require_once('phpmailer/class.phpmailer.php');
    if(isset($_GET["getID"])){
	$id=$enc->decryptIt($_GET["getID"]);
	
		$db_obj->sql("SELECT * FROM  tbl_withdraw_balance WHERE id='".$db_obj->EString($id)."'");
	    $balance_info=$db_obj->getResult();
		$ac_no=$balance_info[0]['com_bank_ac'];
		$type=$balance_info[0]['type'];
		$date=date("Y-m-d");
		$user_id=$_SESSION['LOGIN_USER']['id'];
		$investor_name=$balance_info[0]['investor_name'];
		$account_dp=$balance_info[0]['account_ref'];
		$withdraw_amt=$balance_info[0]['withdraw_amt'];
		$sql="UPDATE `tbl_withdraw_balance` SET `withdraw_net_balance`='$withdraw_amt',`data_insert_id`='$user_id',`status`='1' WHERE `id`='$id'";
        $result1=@mysql_query($sql);
		
		if($result1){
	   $msg = $account_dp." Code have withdrawn.Please aprove this code";
       $sub="Withdrawal Pending List";
	   $email="farzana@capmadvisorybd.com";
       

		$mail = new PHPMailer;
        $mail->isMAIL();
        $mail->Host = 'mail.capmadvisorybd.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pms@capmadvisorybd.com';
        $mail->Password = 'capm@123$';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 26;

		$mail->setFrom('pms@capmadvisorybd.com', 'CAPM Advisory Ltd');
		$mail->addAddress($email);
		$mail->addReplyTo('pms@capmadvisorybd.com');
		$mail->AddCC("motiur@capmbd.com");

		//$mail->addAttachment('portpolio_report/'.$fileName);


		$mail->isHTML(true);

		$mail->Subject = $sub;
		$mail->Body    = $msg;

		$mc = $mail->send();
		
		}
		
			 
		   echo "<h2 style='text-align:center; color:green'>Withdrawal Successfully Confirmed</h2>";
                     
                 $db_obj->disconnect();
	     echo "<meta http-equiv='refresh' content='1;URL=fund_management.php?withdrawal'/>";
         exit();
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

