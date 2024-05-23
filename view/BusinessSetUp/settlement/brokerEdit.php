
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$broker_id=$enc->decryptIt($_GET["getID"]);
	
	
				$db_obj->sql("SELECT * FROM tbl_broker_hous WHERE id='".$db_obj->EString($broker_id)."'");
			    $brokerHouse=$db_obj->getResult();
				//print_r($settlement);
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
                  <div align="right"><a href="?BrokerHouseList" class="btn alert-info"><span class="icon-th-large"></span> All Broker List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					
			$db_obj->update('tbl_broker_hous',array('Internal_code'=>$_POST["Internal_code"],
			                 'trace_id'=>$_POST["trace_id"],
							 'name'=>$_POST["name"],
							 'trace_code'=>$_POST["trace_code"],
							 'dsc_clear_id'=>$_POST["dse"],
							 'cse_clear_id'=>$_POST["cse"],
							 'status'=>$_POST["status"],
			                 'contact_person'=>$_POST["contact_person"],
         					 'address'=>$_POST["address"],
							 'contact_no'=>$_POST["contact_no"],
							 'email'=>$_POST["email"],
							 'receivable'=>$_POST["receivable"],
							 'settlement_fee'=>$_POST["settlement_fee"],
							 'payable'=> $_POST["payable"]),
							 "id=".$_POST["broker_id"].""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			           echo'<script>window.location="settlement.php?BrokerHouseList";</script>';
            
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
			  <td width="145" height="33"><strong>Internal Code</strong></td>
              <td width="283">
              <input name="Internal_code" type="text" id="Internal_code" value="<?php echo $brokerHouse[0]['Internal_code']?>" />
              </td>
            </tr>
	     <tr>
           <td width="145" height="33"><strong>Trace Id</strong></td>
           <td width="283"><input type="text" name="trace_id" id="trace_id" value="<?php echo $brokerHouse[0]['trace_id']?>" required /></td>
         </tr>
		 <tr>
	      <td width="155" height="33"><strong>Name</strong></td>
          <td width="283"><input type="text" name="name" id="name" value="<?php echo $brokerHouse[0]['name']?>" /></td>
		 </tr>
	   <tr>
          <td width="155" height="33"><strong>Trace Code</strong></td>
          <td width="283"><input type="text" name="trace_code" id="trace_code" value="<?php echo $brokerHouse[0]['trace_code']?>" /></td>
       </tr>
  
	   <tr>
		<td width="145" height="33"><strong>DSE Clear BOID</strong></td>
		<td width="283"><input type="text" name="dse" id="dse" value="<?php echo $brokerHouse[0]['dsc_clear_id']?>"/></td>
	  </tr>
	  <tr>
		<td width="155" height="33"><strong>CSE Clear BOID</strong></td>
		 <td width="283"><input type="text" name="cse" id="cse" value="<?php echo $brokerHouse[0]['cse_clear_id']?>"/></td>
	 </tr>
		<tr>
		 <td height="31"><strong>Status</strong></td>
		 <td width="283"><select name="status" id="status" required="required">
		  <option value="1">Open</option>
		  <option value="0">Close</option>
		 </select></td>
	   </tr>
           <tr>
               <td width="145" height="33"><strong>Contact Person</strong><br /></td>
              <td width="283">
                <input name="contact_person" type="text" id="contact_person" value="<?php echo $brokerHouse[0]['contact_person']?>"/>
              </td>
            </tr>
			
			<tr>
               <td width="145" height="33"><strong>Address</strong><br /></td>
              <td width="283">
                <input name="address" type="text" id="address" value="<?php echo $brokerHouse[0]['address']?>"/>
              </td>
            </tr>
			
			<tr>
               <td width="145" height="33"><strong>Contact_No</strong><br /></td>
              <td width="283">
                <input name="contact_no" type="text" id="contact_no" value="<?php echo $brokerHouse[0]['contact_no']?>"/>
              </strong></td>
            </tr>
			<tr>
               <td width="145" height="33"><strong>Email</strong><br /></td>
              <td width="283">
                <input name="email" type="text" id="email" value="<?php echo $brokerHouse[0]['email']?>"/>
             </td>
            </tr>
			
			<tr>
               <td width="145" height="33"><strong>Receivable COA</strong><br /></td>
              <td width="283"><strong>
                <input name="receivable" type="text" id="receivable" value="<?php echo $brokerHouse[0]['receivable']?>"/>
              </strong></td>
            </tr>
			<tr>
               <td width="145" height="33"><strong>Settlement Fee</strong><br /></td>
              <td width="283"><strong>
                <input name="settlement_fee" type="text" id="settlement_fee" value="<?php echo $brokerHouse[0]['settlement_fee']?>"/>
              </strong></td>
            </tr>
			<tr>
               <td width="145" height="33"><strong>Payable COA</strong><br /></td>
              <td width="283"><strong>
                <input name="payable" type="text" id="payable" value="<?php echo $brokerHouse[0]['payable']?>"/>
              </strong></td>
            </tr>
            
            <tr>
              <td width="145" height="40"></td>
              <td height="-5" align="center" valign="top"  ><input type="submit" name="updateInv" id="updateInv" onclick="return confirmation()" value="Update Broker House"/></td>
            </tr>
          </table>
          </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         