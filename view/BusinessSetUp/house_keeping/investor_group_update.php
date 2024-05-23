
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$investor_group_id=$enc->decryptIt($_GET["getID"]);
	
	$db_obj->sql("SELECT * FROM investor_group WHERE investor_group_id='".$db_obj->EString($investor_group_id)."'");
    $investor_group_res=$db_obj->getResult();
	//print_r($investor_group_res);
	//die();
			  if(!$investor_group_res){
				   echo "<h2>Investor Group Not Founded...........</h2>";
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
 
 
  <?php

          
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?InvestorGroupList" class="btn alert-info"><span class="icon-th-large"></span> Investor Group List </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					
					$investor_group_id=$_POST["id"];
					date_default_timezone_set("Asia/Dhaka");
					$curr_date = date('Y-m-d H:i:s');
					
			 $db_obj->update('investor_group',array('amount'=>$_POST["amount"],'ipo_charge'=>$_POST["ipo_charge"],
			 'insert_id'=>$_SESSION['LOGIN_USER']['id'],'date'=>$curr_date),"investor_group_id=".$investor_group_id.""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			             echo'<script>window.location="house_keeping.php?InvestorGroupList"</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form class="stdform" action="" method="post">
                    	
                        
                        <div>
                        	<label><strong>Code:</strong></label>
                            <input type="text"  name="code"  value="<?php echo $investor_group_res[0]['code']?>" readonly />
							<input type="hidden"  name="id"  value="<?php echo $investor_group_res[0]['investor_group_id']?>" readonly />
                        </div>
						<div>
                       	<label><strong>Name:</strong></label>
                        <input type="text" name="name" id="name" value="<?php echo $investor_group_res[0]['group_name']?>" readonly />
                      </div>
                      <div>
                       	<label><strong>Description: </strong></label>
                         <input type="text"  name="description"  id="description" value="<?php echo $investor_group_res[0]['description']?>" readonly />
                      </div>
                        <div>
                        	<label><strong>Charge Rate:</strong></label>
                           <input name="amount" type="text" id="amount" value="<?php echo $investor_group_res[0]['amount']?>" readonly />
                        </div>
                        
                      <div>
                        	<label><strong>IPO Charge Rate: </strong></label>
                            
                           <input name="ipo_charge" type="text" id="ipo_charge" value="<?php echo $investor_group_res[0]['ipo_charge']?>" readonly />
                            
                            
                      </div>
                    
                      <p class="stdformbutton">
                        <button class="btn btn-primary" name="updateInv" onclick="return confirmation()">Update</button>
                            <button type="reset" class="btn">Reset Form</button>
                      </div>
                        
                        
                    </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
           
           
         