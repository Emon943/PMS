
<?php
	require_once("../config.php");
	$dbObj = new DBUtility();
	$id = $_POST['id'];
         

 	$sql="SELECT * FROM email_template where id='$id'";
 	$result = $dbObj->select($sql);

   	echo json_encode($result);
 
 ?>