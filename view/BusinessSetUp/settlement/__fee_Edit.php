
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$broker_id=$enc->decryptIt($_GET["getID"]);
	
	
				$db_obj->sql("SELECT * FROM tbl_interest WHERE id='".$db_obj->EString($broker_id)."'");
			    $brokerHouse=$db_obj->getResult();
				 //print_r($brokerHouse);
				//die();
			  if(!$brokerHouse){
				   echo "<h2>Investor Not Founded...........</h2>";
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
                  <div align="right"><a href="?fee" class="btn alert-info"><span class="icon-th-large"></span> All Fee List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					
			$db_obj->update('tbl_interest',array('daily_interest'=>$_POST["daily_interest"]),
							 "id=".$_POST["broker_id"].""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			           echo'<script>window.location="settlement.php?fee";</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form action="" method="post" enctype="multipart/form-data">
          <table width="80%" border="0" cellpadding="0" cellspacing="5">
            <tr>
              <td height="24" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>Broker House Details</strong></td>
            </tr>
             <tr>
               <td width="145" height="33"><strong></td>
                <input name="broker_id" type="hidden" id="broker_id" value="<?php echo $broker_id;?>" />
			</tr>
			<tr>
			  <td width="145" height="33"><strong>Client Code</strong></td>
              <td width="283">
              <input name="Internal_code" type="text" id="Internal_code" value="<?php echo $brokerHouse[0]['ac_no']?>" />
              </td>
            </tr>
	     <tr>
           <td width="145" height="33"><strong>Interest Amount</strong></td>
           <td width="283"><input type="text" name="daily_interest" id="daily_interest" value="<?php echo $brokerHouse[0]['daily_interest']?>" required /></td>
         </tr>
		 <tr>
	      <td width="155" height="33"><strong>Date</strong></td>
          <td width="283"><input type="text" name="name" id="name" value="<?php echo $brokerHouse[0]['date']?>" /></td>
		 </tr>
	  
            <tr>
              <td width="145" height="40"></td>
              <td height="-5" align="center" valign="top"  ><input type="submit" name="updateInv" id="updateInv" onclick="return confirmation()" value="Update Fee"/></td>
            </tr>
          </table>
          </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         