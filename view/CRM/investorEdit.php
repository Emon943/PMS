<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$investorID=$enc->decryptIt($_GET["getID"]);
	
	
	$db_obj->sql("SELECT * FROM   `investor_personal`  INNER JOIN `investor` 
        ON (`investor_personal`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_passport` 
        ON (`investor_passport`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_tax_details` 
        ON (`investor_tax_details`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_bank_details` 
        ON (`investor_bank_details`.`investor_id` = `investor`.`investor_id`)
    INNER JOIN `investor_exchange_details` 
        ON (`investor_exchange_details`.`investor_id` = `investor`.`investor_id`) WHERE `investor`.`investor_id`='".$db_obj->EString($investorID)."'");
			  $investor=$db_obj->getResult();
			  if(!$investor){
				   echo "<h2>Investor Not Founded...........</h2>";
						exit();
				  }else{
					$investor_group_id=$investor[0]["investor_group_id"];
					$managment_fee_id=$investor[0]["managment_fee_id"];
					$agency_id=$investor[0]["agency_id"];
					$cate_id=$investor[0]["bo_catagory"];
					$interest_credit_blan_cat_id=$investor[0]["interest_on_credit_blance_cata_id"];
					
				  }
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>


<div class="contentinner content-dashboard">
 
 
  <?php

          
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?investor_list" class="btn alert-info"><span class="icon-th-large"></span> All Investor </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">Investor</h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					
	
					  
					  
					   $up=$db_obj->update("investor_personal",array("contact_person"=>$_POST['contact_person'],"date_of_birth"=>$_POST['date_of_birth'],
								"address"=>$_POST['address'],
								"city"=>$_POST['city'],"state"=>$_POST['state'],"country"=>$_POST['country'],"postal_code"=>$_POST['postal_code'],
								"phone"=>$_POST['phone'],"email"=>$_POST['email'],"fax"=>$_POST['fax']),"investor_id=".$_POST["investorIDHe"]."");
					  
					 
							  
							  
							 
							 
					 echo "<h2 style='text-align:center; color:green'>Data Update Successfully</h2>";
                     
                     $db_obj->disconnect();
	                 echo "<meta http-equiv='refresh' content='1;URL=crm.php?investor_list' />";
                     exit();
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form action="" method="post" enctype="multipart/form-data">
          <table width="80%" border="0" cellpadding="0" cellspacing="5">
            <tr>
              <td height="24" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>PERSONAL DETAILS</strong></td>
            </tr>
            <tr>
              <td width="49%"><strong>DP Internal Reference Number
                <input name="investorIDHe" type="hidden" id="investorIDHe" value="<?php echo $investorID;?>" readonly />
              </strong></td>
              <td width="51%" align="center"><strong>
                <input name="dp_internal_ref_number" type="text" id="dp_internal_ref_number" value="<?php echo $investor[0]['dp_internal_ref_number']?>" readonly />
              </strong></td>
            </tr>
            <tr>
              <td><strong>BO ID</strong><br /></td>
              <td align="center"><strong>
                <input name="investor_ac_number" type="text" id="investor_ac_number" value="<?php echo $investor[0]['investor_ac_number']?>" readonly />
              </strong></td>
            </tr>
            
            
               <tr>
              <td><strong>Contact Person</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="contact_person" id="contact_person" value="<?php echo $investor[0]['contact_person']?>" />
              </strong></td>
            </tr>
			
			
        
			
            <tr>
              <td><strong>Date of Birth / Registration</strong></td>
              <td align="center"><strong>
                <input type="text" name="date_of_birth" id="date_of_birth"  value="<?php echo $investor[0]['date_of_birth']?>"/>
              </strong></td>
            </tr>
            
            <tr>
              <td><strong>Address</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="address" id="address" value="<?php echo $investor[0]['address']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>City</strong></td>
              <td align="center"><strong>
                <input type="text" name="city" id="city" value="<?php echo $investor[0]['city']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>State/Division</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="state" id="state" value="<?php echo $investor[0]['state']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Country</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="country" id="country" value="<?php echo $investor[0]['country']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Postal Code</strong><br />
              <br /></td>
              <td align="center"><strong>
                <input type="text" name="postal_code" id="postal_code" value="<?php echo $investor[0]['postal_code']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Phone</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="phone" id="phone" value="<?php echo $investor[0]['phone']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Email</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="email" id="email" value="<?php echo $investor[0]['email']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Fax</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="fax" id="fax" value="<?php echo $investor[0]['fax']?>" />
              </strong></td>
            </tr>
			
			
			
			<!---- here is the code for status--->
			<!--<tr>
              <td><strong>Status</strong><br /></td>
              <td align="center"><strong>
              <select name="status" id="status" required="required">
			  <option value="<?php echo $investor[0]['status'];?>"><?php if($investor[0]['status']==0){
				  echo "Active";
			  }else{
				  echo "Inactive";
			  }?></option>
                     <option value="0">Active</option>
					 <option value="1">Inactive</option>
                   
                 
                </select>
              
              
              </strong></td>
            </tr>-->
			<tr>
			<td> &nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td> &nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>
			
			 <tr>
              <td height="-5" valign="top"  >&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td height="-5" align="left" valign="top"  ><input type="submit" name="updateInv" id="updateInv" value="Update Investor" /></td>
            </tr>
		
          </table>
          </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         