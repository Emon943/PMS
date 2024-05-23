
<?php
header('Content-disposition: attachment; filename=UserData.txt');
header('Content-type: text/plain');	
    if(isset($_GET["getID"])){
	$getID=$enc->decryptIt($_GET["getID"]);
	 //echo $getID;
	// die();
	
            $db_obj->sql("SELECT * FROM ipo_application WHERE status='".$db_obj->EString($getID)."'");
			$ipo_pay=$db_obj->getResult();
			 print_r($ipo_pay);
			 //die();
			  if(!$ipo_pay){
				   echo "<h2>IPO Application Not Founded...........</h2>";
                 $db_obj->disconnect();
		      echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOapplication' />";
               exit(); 
				  }else{
					  //echo count($ipo_pay);
					  //die();
				for($i=0; $i<=count($ipo_pay);$i++){
					echo "Welcome > " .$ipo_pay[$i]['ac_bal']. "~".$ipo_pay[$i]['ac_no']."~".$ipo_pay[$i]['company_id']."$\r\n";
		          }  
		   //echo "<h2 style='text-align:center; color:green'>Successfully Paid IPO</h2>";
                     
                // $db_obj->disconnect();
		  // echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOapplication' />";
          // exit();  
		}
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
		
	?>
