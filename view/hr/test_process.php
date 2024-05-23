<?php
    include'../../config.php';
	$dbObj = new DBUtility();
	 $firstname =$_POST['firstname'];
     $lastname =$_POST['lastname'];
 
 $query = "insert into test
	(firstname, lastname)
	 values('$firstname', '$lastname')";
     $res = $dbObj->insert($query);
	 if($res)}{
		echo "insert data successfully";
	 }else{
		 echo "Data not insert";
	 }
?>