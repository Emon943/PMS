
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$charge_id=$enc->decryptIt($_GET["getID"]);
	
	
				$db_obj->sql("SELECT * FROM charge_header WHERE id='".$db_obj->EString($charge_id)."'");
			    $charge_info=$db_obj->getResult();
				//print_r($charge_info);
				//die();
			  if(!$charge_info){
				   echo "<h2>Charge Header Not Founded...........</h2>";
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
                  <div align="right"><a href="?ChargeHeader" class="btn alert-info"><span class="icon-th-large"></span>All Charge Header</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					$update_date=date("Y-m-d h:i:sa");
					echo $update_date;
					//die();
					
			$db_obj->update('charge_header',array('name'=>$_POST["name"],
         					 'is_active'=>$_POST["is_active"],
							 'charge_type'=>$_POST["charge_type"],
							 'update_date'=>$update_date),
							 "id=".$charge_id.""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";
                      $db_obj->disconnect();
			             echo'<script>window.location="house_keeping.php?ChargeHeader";</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="155"><strong>Name</strong></td>
    <td width="172"><input type="text" name="name" id="name" value="<?php echo $charge_info[0]['name']?>"required /></td>

  </tr>
  <tr>
    <td width="145" height="33"><strong>Is Percentage (%)</strong></td>
    <td width="283"><select name="is_percentage" id="is_percentage">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
    <td width="155"><strong>Is Active</strong></td>
    <td><select name="is_active" id="is_active">
      <option value="Active">Active</option>
      <option value="Inactive">Inactive</option>
    </select></td>
  </tr>
  <tr>
    <td height="31"><strong>Charge Type</strong></td>
    <td width="283"><select name="charge_type" id="charge_type">
      <option value="House">House</option>
      <option value="DSE">DSE</option>
      <option value="CDBL">CDBL</option>
      <option value="DSE-DLR">DSE-DLR</option>
    </select></td>
    <td width="155"><strong>Transaction Posting</strong></td>
    <td><select name="transaction_posting" id="transaction_posting">
      <?php
					 $sql="SELECT id,CONCAT('[ ',`code`,' ]',' ',`name`) as 'title' FROM transaction_type";
					$db_obj->sql($sql);
					 $transaction_type=$db_obj->getResult();
					 
					if($transaction_type){
						
						foreach($transaction_type as $transaction_type):
						?>
      <option value="<?php echo $transaction_type['id'];?>"><?php echo $transaction_type['title'];?></option>
      <?php
						endforeach;
					}else{
						?>
      <option value="">Please Insert Transaction Posting</option>
      <?php
						}
					?>
    </select></td>
  </tr>
  <tr>
    <td height="33"><strong>Payble By Investor</strong></td>
    <td width="283"><select name="payble_by_investor" id="payble_by_investor">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
    <td width="155"><strong>Is Global</strong></td>
    <td><select name="is_global" id="is_global">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
  </tr>
  
  <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" name="updateInv" onclick="return confirmation()">UPDATE</button>
      
        </p></td>
  </tr>
    </table>            
                        
                        
    </form> 
                
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         