<?php
session_start();
if(@$_SESSION['LOGIN_USER']==false || $_SESSION['SECID']!=session_id()):
session_destroy();
header("Location: ./");
else:

require("include_file/__class_file.php");
$db_obj=new PMS;
 $mainLink=basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$enc=new Encryption;
    
endif;


?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>PMS::Employee..</title>
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
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>            	
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
</head>

<body>

<div class="mainwrapper">
	
    <!-- START OF LEFT PANEL -->
    <?php
	
	
	
	
	
    require_once("include_file/leftpanel.php");
	
	
	?>
    <!-- END OF LEFT PANEL -->
    
    <!-- START OF RIGHT PANEL -->
    <div class="rightpanel">
    	
         <!--headerpanel-->
        
        <?php
    require_once("include_file/header.php");
	?>
        
        <!--headerpanel-->
       
     
     <!-- <div class="pagetitle">
        	<h1>Dashboard</h1> <span>This is a sample description for dashboard page...</span>
        </div>-->
        
        <!--pagetitle-->
      
      
      
      
        
        <div class="maincontent">
        
        
       		 <!--contentinner-->
        	 <?php


			
			 if($page):
			
						 if($page['view_status']=="Active"):

                             include("view/hr/all_employees.php");
						 else:
						 include("view/page_check.php");
						 endif;
			  
			  else:
			 include("view/page_check.php");
			  endif;
			 
			 ?>
            
            
            
            <!--contentinner-->
            
            
            
            
        </div><!--maincontent-->
        
    </div><!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
    
  <?php include("include_file/footer.php");
  
  $db_obj->disconnect();
  ?>
    
    <!--footer-->
    
</div><!--mainwrapper-->

</body>
</html>
