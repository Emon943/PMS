<?php
    
	 echo $firstname =$_POST['firstname'];
     echo $lastname =$_POST['lastname'];
	 die();
  include 'config.php';
  $dbObj = new DBUtility();
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