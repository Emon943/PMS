<?php
require_once("../config.php");
$dbObj = new DBUtility();
$id = $_POST['bank'];
 //echo $id;
 //die();
if($id!=null){
 $sql="SELECT * FROM `tbl_branch_info` where bank_id='$id'";
  $result = $dbObj->select($sql);
 
  if($result){ 
        echo '<option value="">Select Branch</option>'; 
       foreach($result as $res){
            echo '<option value="'.$res['branch_name'].'">'.$res['branch_name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Branch not available</option>'; 
    } 
}

 
 ?>
 
