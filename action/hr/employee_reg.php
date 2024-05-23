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
  
  if($login_id=="" || $employee_code==""){
	
	  $obj->disconnect();
	  header("Location: ../../employ_reg.php");
	  exit();
	  }
  
  
  
  if($enc->decryptIt($action__)=="Active"):
  	
	$obj->sql("SELECT * FROM `employee` WHERE `login_id`='".$obj->EString($login_id)."' OR `employee_code`='".$obj->EString($employee_code)."'");
				
			  if($obj->numRows()==0){
				  
						$obj->insert('employee',array('reg_rep_id'=>$_SESSION['LOGIN_USER']['id'],
						'employee_code'=>$obj->EString($employee_code),
						'login_id'=>$obj->EString($login_id),'login_pass'=>$obj->EString(md5($login_pass)),
						'rules'=>$obj->EString($rules),'status'=>$obj->EString($status),'join_date'=>$obj->EString($join_date),
						'branch_id'=>$obj->EString($branch_id),'name'=>$obj->EString($name),'address'=>$obj->EString($address),
						'nid_no'=>$obj->EString($nid_no),'contact_number'=>$obj->EString($contact_number)));
						
						$result=$obj->getResult();
						$_SESSION['in_result_data']=$result[0];	
					
						 $obj->disconnect();
						 header("Location: ../../employ_reg.php");
					     exit();
				  
				  }else{
					  
					  header("Location: ../../employ_reg.php");
					  $obj->disconnect();
					  exit();
					  }
  
    
  else:
   $obj->disconnect();
  header("Location: ../../employ_reg.php");
 
  exit();
  
  endif;
  
  $obj->disconnect();
  exit();
  ?>
