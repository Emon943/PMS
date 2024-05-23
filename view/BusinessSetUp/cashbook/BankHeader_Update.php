
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$bank_id=$enc->decryptIt($_GET["getID"]);
	//echo $bank_id;
	//die();
	
			$db_obj->sql("SELECT * FROM bank_charge_header WHERE id='".$db_obj->EString($bank_id)."'");
			$bank_res=$db_obj->getResult();
			//print_r($bank_res);
			$account_use_id=$bank_res[0]['trace_id'];
			//die();
			  if(!$bank_res){
				   echo "<h2>Bank Info Not Founded...........</h2>";
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
                  <div align="right"><a href="?bchs_list" class="btn alert-info"><span class="icon-th-large"></span>Bank PR head List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">Bank PR head Update</h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["submit_ins"])){
					$update_date=date("Y-m-d h:i:sa");
					
			  $db_obj->update('bank_charge_header',array('trace_id'=>$_POST['trace_id'],
		      'shortcode'=>$_POST['shortcode'],
		      'type'=>$_POST['type'],
		      'Internal_code'=>$_POST['Internal_code'],
		      'des'=>$_POST['des']),
			  "id=".$bank_id.""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			          echo'<script>window.location="cashbook.php?bchs_list";</script>';
                      exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" height="33"><strong>Trace Code:</strong></td>
    <td width="283"><input type="text" name="trace_id" id="trace_id" value="<?php echo $bank_res[0]['trace_id']?>" required /></td>
    <td width="155"><strong>Short Code :</strong></td>
    <td><input type="text" name="shortcode" id="shortcode" value="<?php echo $bank_res[0]['shortcode']?>"/></td>
  </tr>
  <tr>
    <td height="31"><strong>Name :</strong></td>
    <td width="283"><input type="text" name="Internal_code" id="Internal_code" value="<?php echo $bank_res[0]['Internal_code']?>" required /></td>
    <td width="155"><strong>Type :</strong></td>
   <td width="283"><select name="type" id="type" required="required">
    <option value="<?php echo $bank_res[0]['type']?>"><?php echo $bank_res[0]['type']?></option>
      <option value="Payment">Payment</option>
      <option value="Receipt">Receipt</option>
    </select></td>
  </tr>
 
    <td height="35"><strong>Description :</strong></td>
	<td><textarea rows="90" cols="100" type="text" name="des" id="des" required="" style="width: 212px; height: 54px;"><?php echo $bank_res[0]['des']?></textarea></td>
  </tr>
  
  <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" name="submit_ins">Submit</button>
        <button type="reset" class="btn">Reset Form</button>
        </p></td>
  </tr>
    </table>
                 
    </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         