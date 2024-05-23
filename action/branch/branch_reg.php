  <title>Employee Reg</title>
  <?php
  require('../../include_file/__class_file.php');
  $obj=new PMS;
  $enc=new Encryption;
  session_start();
  if(@$_SESSION['LOGIN_USER']==false || $_SESSION['SECID']!=session_id()){
  session_destroy();
  header("Location: ../../");
  }
  extract($_POST);
  
  if($name=="" || $branch_address==""){
	
	  $obj->disconnect();
	  header("Location: ../../branch_new.php");
	  exit();
	  }
  
  
  
  if($enc->decryptIt($action__)=="Active"):
  	
	$obj->sql("SELECT * FROM `branch_list` WHERE `name`='".$obj->EString($name)."'");
				
			  if($obj->numRows()==0){
				  
						$obj->insert('branch_list',array('insert_employeeid'=>$_SESSION['LOGIN_USER']['id'],
						'name'=>$obj->EString($name),
						'branch_address'=>$obj->EString($branch_address),'status'=>$obj->EString($status)));
						
						$result=$obj->getResult();
						
						 $_SESSION['in_result_data']=$result[0];	
					
						 $obj->disconnect();
						 header("Location: ../../branch_new.php");
					     exit();
				  
				  }else{
					  
					  header("Location: ../../branch_new.php");
					  $obj->disconnect();
					  exit();
					  }
  
    
  else:
   $obj->disconnect();
  header("Location: ../../branch_new.php");
 
  exit();
  
  endif;
  
  $obj->disconnect();
  exit();
  ?>
