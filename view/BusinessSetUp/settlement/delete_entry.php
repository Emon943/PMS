<?php
if(isset($_POST["submit_ins"])){
foreach ($_POST['check'] as $id){
	$array = explode(";", $id);
	$ids=$array[0];
	$type=$array[1];
	/* echo "<pre>";
	print_r($array);
    echo "</pre>"; 
	die(); */
	if($type=='iocb'){
		$db_obj->delete("tbl_interest_on_credit_bal", "id='$ids'");
	}else{
     $db_obj->delete("tbl_interest", "id='$ids'");
	 }
    }
					
}
    echo "<h2 style='text-align:center; color:green'>Successfully Delete Charge</h2>";
                     
            $db_obj->disconnect();
		echo "<meta http-equiv='refresh' content='1;URL=settlement.php?fee' />";
        exit();

				 
?>