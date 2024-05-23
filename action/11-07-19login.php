<title>Login Action</title>
<?php
require('../include_file/__class_file.php');
$obj=new PMS;
$test=extract($_POST);
/* echo '<pre>';
print_r($test);
echo '</pre>'; */
//die();
session_start();
 $obj->select('employee','*'," login_id='".$obj->EString($username)."' and login_pass='".$obj->EString($password)."' and status='active'");
//echo $querytest;
//die();
$result=$obj->getResult();
/* echo '<pre>';
print_r($result);
echo '</pre>';*/
//die(); 
if($result){
	
	
	$_SESSION['LOGIN_USER']=$result;
	$_SESSION['SECID']=session_id();
	
	$brow=$obj->getBrowser();
	$browserText=" Your browser Name: ".$brow['name'].".  Version: ".$brow['version']." . Platform: ".$brow['platform'];
	$obj->insert('employee_log',array('employee_id'=>$result['id'],
	'ip_adder'=>$obj->EString($obj->getRealIpAddr()),
	'browser'=>$obj->EString($browserText)));
	
	
	//$obj->delete("employee_log","employee_id='".$result['id']."'  AND DATE_FORMAT(`log_date_time`,'%Y-%m-%d')<'".$obj->StrToTime(date('Y-m-d'),'-1 month')."'");
	
	$obj->disconnect();
	header("Location: ../dashboard.php");
	exit();
	
	}else{
		$_SESSION['LOGIN_USER']=false;
		$_SESSION['SECID']=false;
	header("Location: ../");
	
		exit();
		}




$obj->disconnect();
exit();
?>
