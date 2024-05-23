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
                  <div align="right"><a href="?addInvestor" class="btn alert-info"><span class="icon-th-large"></span> All Investor </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">Investor</h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					
					$imgUP=$_FILES["importImages"];
					if($imgUP['name']!=""){
					$investor_imgUP="./pms_doc_upload/investor_img/".$_POST["investor_ac_number"].".jpeg";
					@move_uploaded_file($imgUP['tmp_name'], $investor_imgUP);
					}
					
					$SigniUP=$_FILES["importSignature"];
					if($SigniUP['name']!=""){
					$investor_SigniUP="./pms_doc_upload/investor_Signi/".$_POST["investor_ac_number"].".jpeg";
					@move_uploaded_file($SigniUP['tmp_name'], $investor_SigniUP);
					}
					
					
					  $db_obj->update('investor',array('investor_name'=>$_POST["investor_name"],'account_status'=>$_POST["account_status"],
         					 'dp_internal_ref_number'=>$_POST["dp_internal_ref_number"],'status'=>$_POST["status"],
							 'investor_group_id'=>$_POST["investor_group_id"],'managment_fee_id'=>$_POST["managment_fee_id"],
							 'interest_on_credit_blance_cata_id'=>$_POST["interest_on_credit_blance_cata_id"],'agency_id'=>$_POST["agency_id"],
							 'insert_employee_id'=>$_SESSION['LOGIN_USER']['id']),"investor_id=".$_POST["investorIDHe"].""); 
					  
					  
					   $up=$db_obj->update("investor_personal",array("dp_internal_ref_number"=>$_POST["dp_internal_ref_number"],
							 "bo_id"=>$_POST["investor_ac_number"], "bo_type"=>$_POST["bo_type"],  "bo_catagory"=>$_POST["bo_catagory"],
							   "name_of_first_holder"=>$_POST["investor_name"],"second_joint_holder"=>$_POST["second_joint_holder"],  "third_joint_holder"=>$_POST['third_joint_holder'],
							     "contact_person"=>$_POST['contact_person'],"sex_code"=>$_POST['sex_code'], "date_of_birth"=>$_POST['date_of_birth'], 
								  "registration_number"=>$_POST['registration_number'], 
							    "father_husbands"=>$_POST['father_husbands'],  "mothers_name"=>$_POST['mothers_name'], "occupation"=>$_POST['occupation'],
								"residency_flag"=>$_POST['residency_flag'],"citizen_of"=>$_POST['citizen_of'],
								"address"=>$_POST['address'],
								"city"=>$_POST['city'],"state"=>$_POST['state'],"country"=>$_POST['country'],"postal_code"=>$_POST['postal_code'],
								"phone"=>$_POST['phone'],"email"=>$_POST['email'],"fax"=>$_POST['fax'],"statement_cycle_code"=>$_POST['statement_cycle_code']
							  ),"investor_id=".$_POST["investorIDHe"]."");
					  
					 $db_obj->update("investor_passport",array("passport_no"=>$_POST["passport_no"],
							 "passport_issu_date"=>$_POST["passport_issu_date"], "passport_expiry_date"=>$_POST["passport_expiry_date"],  "passport_issue_place"=>$_POST["passport_issue_place"]
							  ),"investor_id=".$_POST["investorIDHe"]."");
							  
							  
							   $db_obj->update("investor_bank_details",array("routing_number"=>$_POST["routing_number"],
							 "bank_name"=>$_POST["bank_name"], "branch_name"=>$_POST["branch_name"],  "bank_ac_no"=>$_POST["bank_ac_no"],  "bic_code"=>$_POST["bic_code"]
							 ,  "iban"=>$_POST["iban"] ,  "swift_code"=>$_POST["swift_code"] ,  "electronic_divi"=>$_POST["electronic_divi"]
							  ),"investor_id=".$_POST["investorIDHe"]."");
							  
							  
							  $db_obj->update("investor_tax_details",array("exemption"=>$_POST["exemption"],
							 "identification_no"=>$_POST["identification_no"]),"investor_id=".$_POST["investorIDHe"]."");
							 
						     $db_obj->update("investor_exchange_details",array("exchang_name"=>$_POST["exchang_name"],
							 "trading_id"=>$_POST["trading_id"]),"investor_id=".$_POST["investorIDHe"]."");
							 
					 echo "<h2 style='text-align:center; color:green'>Data Update Successfully</h2>";
                     
                     $db_obj->disconnect();
	                 echo "<meta http-equiv='refresh' content='1;URL=Protfolio.php?addInvestor' />";
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
                <input name="investorIDHe" type="hidden" id="investorIDHe" value="<?php echo $investorID;?>" />
              </strong></td>
              <td width="51%" align="center"><strong>
                <input name="dp_internal_ref_number" type="text" id="dp_internal_ref_number" value="<?php echo $investor[0]['dp_internal_ref_number']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>BO ID</strong><br /></td>
              <td align="center"><strong>
                <input name="investor_ac_number" type="text" id="investor_ac_number" value="<?php echo $investor[0]['investor_ac_number']?>" readonly="readonly" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Account Status</strong><br /></td>
              <td align="center"><strong>
              <select name="account_status" id="account_status" required="required">
              <option value="<?php echo $investor[0]['account_status']?>"><?php echo $investor[0]['account_status']?></option>
                  <option value="COMPANY">COMPANY</option>
                  <option value="INDIVIDUAL">INDIVIDUAL</option>
                  <option value="JOINT HOLDERS">JOINT HOLDERS</option>
                </select>
              
              
              </strong></td>
            </tr>
            <tr>
              <td><strong> <font color="red">* </font> Investor Group</strong></td>
              <td align="center">
			  <select name="investor_group_id" id="investor_group_id" required="required">
			  <option value="NULL"></option>
           <?php
                       $invsql = "select * from investor_group where is_active='True' order by investor_group_id";
                       $db_obj->sql($invsql);
					   $investor_group_res=$db_obj->getResult();
						//print_r($investor_group_res);
                        for ($i = 0; $i < count($investor_group_res); $i++) {
                            if ($investor_group_id == $investor_group_res[$i]["investor_group_id"]){
                                $investor_group = "selected";
                            }else{
                                $investor_group = "";
								}
                            ?>
                            <option <?php echo $investor_group; ?> value="<?php echo $investor_group_res[$i]["investor_group_id"]; ?>">
                                <?php echo $investor_group_res[$i]["group_name"]; ?></option>
                        <?php } ?>
      
    </select></td>
   </tr>
            <tr>
              <td><strong><font color="red">* </font>Management Fee</strong></td>
              <td align="center"><select name="managment_fee_id" id="managment_fee_id" required="required">
			   <option value="NULL"></option>
			  <?php
                       $marginsql = "select * from margin_fee_catagory order by id";
                       $db_obj->sql($marginsql);
					   $margin_result=$db_obj->getResult();
						//print_r($investor_group_res);
                        for ($i = 0; $i < count($margin_result); $i++) {
                            if ($managment_fee_id == $margin_result[$i]["id"]){
                                $managment_fee = "selected";
                            }else{
                                $managment_fee = "";
								}
                            ?>
                            <option <?php echo $managment_fee; ?> value="<?php echo $margin_result[$i]["id"]; ?>">
                                <?php echo $margin_result[$i]["description"]; ?></option>
                        <?php } ?>
     
    </select>
	</td>
            </tr>
            <tr>
              <td><strong><font color="red">* </font> Interest On Credit Blance</strong></td>
              <td align="center">
			  <select name="interest_on_credit_blance_cata_id" id="interest_on_credit_blance_cata_id" required="required">
			   <option value="NULL"></option>
			  <?php
                       $interstsql = "select * from interst_on_credit_blance_catagory order by id";
                       $db_obj->sql($interstsql);
					   $interest_result=$db_obj->getResult();
						//print_r($investor_group_res);
                        for ($i = 0; $i < count($interest_result); $i++) {
                            if ($interest_credit_blan_cat_id == $interest_result[$i]["id"]){
                                $interest_credit_blance = "selected";
                            }else{
                                $interest_credit_blance = "";
								}
                            ?>
                            <option <?php echo $interest_credit_blance; ?> value="<?php echo $interest_result[$i]["id"]; ?>">
                                <?php echo $interest_result[$i]["description"]; ?></option>
                        <?php } ?>
	 
    </select>
	</td>
            </tr>
		

<tr>
              <td><strong><font color="red">* </font>Agency</strong></td>
              <td align="center"><select name="agency_id" id="agency_id" required="required">
			   <option value=" "></option>
			  <?php
                       $agencysql = "select * from tbl_agency_setup order by id";
                       $db_obj->sql($agencysql);
					   $agency_setup=$db_obj->getResult();
						//print_r($investor_group_res);
                        for ($i = 0; $i < count($agency_setup); $i++) {
                            if ($agency_id == $agency_setup[$i]["id"]){
                                $agency_name = "selected";
                            }else{
                                $agency_name = "";
								}
                            ?>
                            <option <?php echo $agency_name; ?> value="<?php echo $agency_setup[$i]["id"]; ?>">
                                <?php echo $agency_setup[$i]["name"]; ?></option>
                        <?php } ?>
     
    </select>
	</td>
            </tr>		
			
			
            <tr>
              <td><strong>BO Type</strong></td>
              <td align="center"><strong>
                <input type="text" name="bo_type" id="bo_type" value="<?php echo $investor[0]['bo_type']?>" />
              </strong></td>
            </tr>
			 <tr>
              <td><strong>BO Category</strong></td>
              <td align="center"><strong>
                <select name="bo_catagory" id="bo_catagory" required="required">
              <option value="<?php echo $investor[0]['bo_catagory']?>"><?php echo $investor[0]['bo_catagory']?></option>
                  <option value="IDA">IDA</option>
                  <option value="NDA">NDA</option>
                </select>
              </strong></td>
            </tr>
            <tr>
              <td><strong>Name of the First Holder / </strong><strong>Company</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="investor_name" id="investor_name" value="<?php echo $investor[0]['name_of_first_holder']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Second Joint Holder</strong></td>
              <td align="center"><strong>
                <input type="text" name="second_joint_holder" id="second_joint_holder"  value="<?php echo $investor[0]['second_joint_holder']?>"/>
              </strong></td>
            </tr>
            <tr>
              <td><strong>Third Joint Holder</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="third_joint_holder" id="third_joint_holder" value="<?php echo $investor[0]['third_joint_holder']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Contact Person</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="contact_person" id="contact_person" value="<?php echo $investor[0]['contact_person']?>" />
              </strong></td>
            </tr>
			
			
        <!---    <tr>
              <td><strong>Sex Code</strong></td>
              <td align="center"><strong>
                <input type="text" name="sex_code" id="sex_code" value="<?php echo $investor[0]['sex_code']?>" />
              </strong></td>
            </tr>
			!--->
			
			<tr>
              <td><strong><font color="red">* </font> SEX CODE</strong><br /></td>
              <td align="center"><strong>
              <select name="sex_code" id="sex_code" required="required">
              <option value="<?php echo $investor[0]['sex_code']?>"><?php echo $investor[0]['sex_code']?></option>
                  <option value="Female">Female</option>
				   <option value="Male">Male</option>
                 
                </select>
              
              
              </strong></td>
            </tr>
			
			
            <tr>
              <td><strong>Date of Birth / Registration</strong></td>
              <td align="center"><strong>
                <input type="text" name="date_of_birth" id="date_of_birth"  value="<?php echo $investor[0]['date_of_birth']?>"/>
              </strong></td>
            </tr>
            <tr>
              <td><strong>Registration Number</strong></td>
              <td align="center"><strong>
                <input type="text" name="registration_number" id="registration_number" value="<?php echo $investor[0]['registration_number']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Father / Husbands Name</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="father_husbands" id="father_husbands" value="<?php echo $investor[0]['father_husbands']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Mothers Name</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="mothers_name" id="mothers_name" value="<?php echo $investor[0]['mothers_name']?>" />
              </strong></td>
            </tr>
            <tr>
              <td><strong>Occupation</strong><br /></td>
              <td align="center"><strong>
                <input type="text" name="occupation" id="occupation" value="<?php echo $investor[0]['occupation']?>" />
              </strong></td>
            </tr>
            <!--<tr>
              <td><strong>Residency Flag</strong><br />
              <br /></td>
              <td align="center"><strong>
                <input type="text" name="residency_flag" id="residency_flag" value="<?php //echo $investor[0]['residency_flag']?>" />
              </strong></td>
            </tr>-->
			<tr>
              <td><strong><font color="red">* </font> Residency Flag</strong></td>
              <td align="center"><select name="residency_flag" id="residency_flag" required="required">
              <option value="<?php echo $investor[0]['residency_flag'];?>"><?php echo $investor[0]['residency_flag'];?></option>
              
      <?php
					 $sql="SELECT * FROM Applicant_cate";
					 $db_obj->sql($sql);
					 $Applicant_cate=$db_obj->getResult();
					 
					if($Applicant_cate){
						
						foreach($Applicant_cate as $Applicant_cat):
						?>
      <option value="<?php echo $Applicant_cat['short_name'];?>"><?php echo $Applicant_cat['applicant_cat'];?></option>
      <?php
						endforeach;
					}else{
						?>
      <option value="">Please Investor Group</option>
      <?php
						}
					?>
    </select></td>
   </tr>
            <tr>
              <td><strong>Citizen Of</strong><br />
              <br /></td>
              <td align="center"><strong>
                <input type="text" name="citizen_of" id="citizen_of"  value="<?php echo $investor[0]['citizen_of']?>"/>
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
            <tr>
              <td><strong>Statement Cycle Code</strong></td>
              <td align="center"><strong>
                <input type="text" name="statement_cycle_code" id="statement_cycle_code" value="<?php echo $investor[0]['statement_cycle_code']?>" />
              </strong></td>
            </tr>
			
			
			
			<!---- here is the code for status--->
			<tr>
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
            </tr>
			
			
			
			
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>SHORT NAME</strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>First Holder</strong><br /></td>
              <td height="-4" align="center" valign="top"  ><strong>
               <?php echo $investor[0]['name_of_first_holder']?>
              </strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Second Holder</strong><br /></td>
              <td height="-2" align="center" valign="top"  ><strong>
               <?php echo $investor[0]['second_joint_holder']?>
              </strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Third Holder</strong></td>
              <td height="-1" align="center" valign="top"  ><strong>
               <?php echo $investor[0]['third_joint_holder']?>
              </strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>PASSPORT DETAILS</strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>Passport No.</strong><br /></td>
              <td height="-4" align="center" valign="top"  ><strong>
                <input type="text" name="passport_no" id="passport_no" value="<?php echo $investor[0]['passport_no']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Passport Issue Date</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="passport_issu_date" id="passport_issu_date" value="<?php echo $investor[0]['passport_issu_date']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Passport Expiry Date</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="passport_expiry_date" id="passport_expiry_date" value="<?php echo $investor[0]['passport_expiry_date']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>Passport Issue Place</strong></td>
              <td height="-4" align="center" valign="top"  ><strong>
                <input type="text" name="passport_issue_place" id="passport_issue_place" value="<?php echo $investor[0]['passport_issue_place']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>BANK DETAILS</strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Routing Number</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="routing_number" id="routing_number" value="<?php echo $investor[0]['routing_number']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>Bank Name</strong><br /></td>
              <td height="-4" align="center" valign="top"  ><strong>
                <input type="text" name="bank_name" id="bank_name"  value="<?php echo $investor[0]['bank_name']?>"/>
              </strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Branch Name</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="branch_name" id="branch_name" value="<?php echo $investor[0]['branch_name']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Bank A/C No.</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="bank_ac_no" id="bank_ac_no" value="<?php echo $investor[0]['bank_ac_no']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="4" valign="top"  ><strong>Bank Identifier Code (BIC)</strong><br /></td>
              <td height="-4" align="center" valign="top"  ><strong>
                <input type="text" name="bic_code" id="bic_code"  value="<?php echo $investor[0]['bic_code']?>"/>
              </strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>International Bank A/C No. (IBAN)</strong></td>
              <td height="-2" align="center" valign="top"  ><strong>
                <input type="text" name="iban" id="iban" value="<?php echo $investor[0]['iban']?>"/>
              </strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>SWIFT CODE</strong></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="swift_code" id="swift_code" value="<?php echo $investor[0]['swift_code']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Electronic Dividend</strong></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="electronic_divi" id="electronic_divi" value="<?php echo $investor[0]['electronic_divi']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>TAX DETAILS</strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Tax Exemption</strong></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="exemption" id="exemption"  value="<?php echo $investor[0]['exemption']?>"/>
              </strong></td>
            </tr>
            <tr>
              <td height="11" valign="top"  ><strong>Tax Identification No</strong></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="identification_no" id="identification_no"  value="<?php echo $investor[0]['identification_no']?>"/>
              </strong></td>
            </tr>
            <tr>
              <td height="11" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>EXCHANGE DETAILS</strong></td>
            </tr>
            <tr>
              <td height="5" valign="top"  ><strong>Exchange Name</strong><br /></td>
              <td height="-1" align="center" valign="top"  ><strong>
                <input type="text" name="exchang_name" id="exchang_name" value="<?php echo $investor[0]['exchang_name']?>" />
              </strong></td>
            </tr>
            <tr>
              <td height="9" valign="top"  ><strong>Trading ID</strong></td>
              <td height="-3" align="center" valign="top"  ><strong>
                <input type="text" name="trading_id" id="trading_id"  value="<?php echo $investor[0]['trading_id']?>"/>
              </strong></td>
            </tr>
            <tr>
              <td height="-4" valign="top"  ><strong>Import Images</strong></td>
              <td height="-4" align="center" valign="top"  ><input type="file" name="importImages" id="importImages" /></td>
            </tr>
            <tr>
              <td height="-4" valign="top"  ><strong>Import Signature</strong></td>
              <td height="-4" align="center" valign="top"  ><input type="file" name="importSignature" id="importSignature" /></td>
            </tr>
            <tr>
              <td height="-5" valign="top"  >&nbsp;</td>
              <td height="-5" align="right" valign="top"  ><input type="submit" name="updateInv" id="updateInv" value="Update Investor" /></td>
            </tr>
          </table>
          </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         