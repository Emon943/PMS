<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('dp_internal_ref_number'=>$_POST['dp_internal_ref_number']));
			
			if($ck=='Success'){
				
				///Insert
        

        $db_obj->select('investor','*',"dp_internal_ref_number='".$_POST['dp_internal_ref_number']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
            // header("Location: house_keeping.php?InstrumentNew");
			  echo'<script>window.location="Protfolio.php?addInvestorNew";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('investor',array('dp_internal_ref_number'=>$_POST['dp_internal_ref_number'],
          'investor_name'=>$_POST['investor_name'],
          'account_status'=>$_POST['account_status'],
          'investor_group_id'=>$_POST['investor_group_id'],
          'managment_fee_id'=>$_POST['managment_fee_id'],
          'interest_on_credit_blance_cata_id'=>$_POST['interest_on_credit_blance_cata_id'],
          'branch_id'=>$_POST['branch_id'],
		  'agency_id'=>$_POST['agency_id'],
		  'investor_images'=>$_POST['investor_ac_number'],
		  'investor_othersfile'=>$_POST['investor_ac_number'],
          'insert_employee_id'=>$_SESSION['LOGIN_USER']['id']));

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
             //header("Location: house_keeping.php?InstrumentNew");
			   echo'<script>window.location="Protfolio.php?addInvestorNew";</script>';
               exit(); 
        }
				
				}else{
					$_SESSION['in_result_data']= "<h3 align='center'>".$ck."<h3>";

					}
			
		
		}
	?>


<div class="contentinner content-dashboard">
 
 
  <?php

          if(@$_SESSION['in_result_data']){

            echo $_SESSION['in_result_data'];
            unset($_SESSION['in_result_data']);
          }
		  
		  
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?addInvestor" class="btn alert-info"><span class="icon-th-large"></span> All Investor </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Investor  </h4>

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                 
                     
       	
<div align="center">
        <form class="stdform" action="" method="post">
        <table width="45%" border="1" align="center">
  <tr>
    <td width="40%" height="40"><strong>A/C Number</strong></td>
    <td width="60%"><input type="text" name="dp_internal_ref_number" id="dp_internal_ref_number" /></td>
  </tr>
  <tr>
    <td height="32"><strong>Investor Name</strong></td>
    <td height="32"><input type="text" name="investor_name" id="investor_name" /></td>
  </tr>
  <tr>
    <td height="32"><font color="red">* </font><strong>A/C Status</strong></td>
    <td height="32"><select name="account_status" id="account_status" required="required">
      <option value="Company">Company</option>
      <option value="INDIVIDUAL">INDIVIDUAL</option>
      <option value="JOINT HOLDERS">JOINT HOLDERS</option>
    </select></td>
  </tr>
  <tr>
    <td height="37"><font color="red">* </font><strong>Investor Group</strong></td>
    <td height="37"><select name="investor_group_id" id="investor_group_id" required="required">
      <?php
					 $sql="SELECT * FROM investor_group";
					$db_obj->sql($sql);
					 $investor_group=$db_obj->getResult();
					 
					if($investor_group){
						
						foreach($investor_group as $investor_group):
						?>
      <option value="<?php echo $investor_group['investor_group_id'];?>"><?php echo $investor_group['group_name'];?></option>
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
    <td height="33"><font color="red">* </font><strong>Management Fee</strong></td>
    <td height="33"><select name="managment_fee_id" id="managment_fee_id" required="required">
      <?php
					 $sql="SELECT * FROM margin_fee_catagory";
					$db_obj->sql($sql);
					 $margin_fee_catagory=$db_obj->getResult();
					 
					if($margin_fee_catagory){
						
						foreach($margin_fee_catagory as $margin_fee_catagory):
						?>
      <option value="<?php echo $margin_fee_catagory['id'];?>"><?php echo $margin_fee_catagory['description'];?></option>
      <?php
						endforeach;
					}else{
						?>
      <option value="">Please Management Fee</option>
      <?php
						}
					?>
    </select></td>
  </tr>
  <tr>
    <td height="34"><font color="red">* </font><strong>Interest On Credit Blance</strong></td>
    <td height="34"><select name="interest_on_credit_blance_cata_id" id="interest_on_credit_blance_cata_id" required="required">
      <?php
					 $sql="SELECT * FROM interst_on_credit_blance_catagory";
					$db_obj->sql($sql);
					 $interst_on_credit=$db_obj->getResult();
					 
					if($interst_on_credit){
						
						foreach($interst_on_credit as $interst_on_credit):
						?>
      <option value="<?php echo $interst_on_credit['id'];?>"><?php echo $interst_on_credit['description'];?></option>
      <?php
						endforeach;
					}else{
						?>
      <option value="">Please Interest On Credit Blance</option>
      <?php
						}
					?>
    </select></td>
  </tr>
  <tr>
    <td height="42"><font color="red">* </font><strong>Branch</strong></td>
    <td height="42"><select name="branch_id" id="branch_id" required="required">
      <?php
					 $sql="SELECT * FROM branch_list";
					$db_obj->sql($sql);
					 $branch_list=$db_obj->getResult();
					 
					if($branch_list){
						
						foreach($branch_list as $branch_list):
						?>
      <option value="<?php echo $branch_list['name'];?>"><?php echo $branch_list['name'];?></option>
      <?php
						endforeach;
					}else{
						?>
      <option value="">Please Select Branch</option>
      <?php
						}
					?>
    </select></td>
  </tr>
   <tr>
    <td height="42"><font color="red">* </font><strong>Agency</strong></td>
    <td height="42"><select name="agency_id" id="agency_id" required="required">
      <?php
					 $sql="SELECT * FROM tbl_agency_setup";
					$db_obj->sql($sql);
					 $agency_list=$db_obj->getResult();
					 
					if($agency_list){
						
						foreach($agency_list as $agency_list):
						?>
      <option value="<?php echo $agency_list['id'];?>"><?php echo $agency_list['name'];?></option>
      <?php
						endforeach;
					}else{
						?>
      <option value="">Please Select Branch</option>
      <?php
						}
					?>
    </select></td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center"><p>
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
         