<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>PMS::House Keeping Set Up..</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="prettify/prettify.css" type="text/css" />
<script type="text/javascript" src="prettify/prettify.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/detectizr.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
 <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
 <script src="js/jquery.dependent.fields.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
</head>

<body>
<?php
require("include_file/__class_file.php");
$db_obj=new PMS;	
if(isset($_GET["getID"])){
	$id=($_GET["getID"]);

	
	$db_obj->sql("SELECT * FROM employee WHERE id='".$db_obj->EString($id)."'");
	$employee_res=$db_obj->getResult();
	 //print_r($employee_res);
		//die();
			  if(!$employee_res){
				   echo "<h2>Employee Info Not Founded...........</h2>";
						exit();
				  }
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to Modify this?');
    }
</script>


<div class="contentinner content-dashboard">
 
 
    <h4 class="widgettitle"></h4>

   <div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					$update_date=date("Y-m-d h:i:sa");
					
			$x = $db_obj->update('employee',array('employee_code'=>$_POST["employee_code"],
         					 'login_id'=>$_POST["login_id"],
							 'login_pass'=>md5($_POST["login_pass"]),
							 'join_date'=>$_POST["join_date"],
							 'name'=>$_POST["name"],
							 'address'=>$_POST["address"],
							 'nid_no'=>$_POST["nid_no"],
							 'contact_number'=>$_POST["contact_number"],
							 'Update_date'=>$update_date),
							 "id=".$id."");
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			             echo'<script>window.location="logout.php";</script>';
            
               exit(); 
							  
					
					}
				?>



	<div class="widgetcontent" align="center">
  
    <form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="155" height="36"><font color="red">* </font><strong>Employee Code</strong></td>
    <td width="283"><input type="text" name="employee_code" id="employee_code" value="<?php echo $employee_res[0]['employee_code']?>" required /></td>

    <td width="155"><font color="red">* </font><strong>User Name</strong></td>
    <td width="172"><input type="text" name="login_id" id="login_id" value="<?php echo $employee_res[0]['login_id']?>" required /></td>
  </tr>
  <tr>
    <td height="31"><font color="red">* </font><strong>Password</strong></td>
    <td width="283"><input type="Password" name="login_pass" id="login_pass" required ></td>

    <td width="155"><font color="red">* </font><strong>Join Date</strong></td>
    <td><input type="date" name="join_date" id="join_date" value="<?php echo $employee_res[0]['join_date']?>" required ></td>
  </tr>
  
  <tr>
    <td height="35"><font color="red">* </font><strong>Name</strong></td>
    <td width="283"><input name="name" type="text" id="name" value="<?php echo $employee_res[0]['name']?>" required ></td>

    <td width="155"><font color="red">* </font><strong>Address</strong></td>
    <td><input type="text" name="address" id="address" value="<?php echo $employee_res[0]['address']?>" required ></td>
  </tr>
   <tr>
    <td height="33"><font color="red">* </font><strong>National ID</strong></td>
    <td width="283"><input type="text" name="nid_no" id="nid_no" value="<?php echo $employee_res[0]['nid_no']?>" required/></td>
	<td width="155"><strong>Contact Number</strong></td>
    <td width="283"><input name="contact_number" type="text" value="<?php echo $employee_res[0]['contact_number']?>"/></td>
  </tr>

    </table> 
   <p class="stdformbutton">
    <button style="margin-top: 20px; margin-left: 50px;" class="btn btn-primary" name="updateInv" onclick="return confirmation()">Update</button>
   </p>	
                        
    </form> 
                
                     
  </div>
  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
</div>
</body>
</html>
           
         