	<div class="contentinner">
     <?php
                    if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="all_employees.php" class="btn alert-info"><span class="icon-th-large"></span> All Employee</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Employee Registration </h4>
                
  <div class="widgetcontent">
  
  						<?php
						
                        if(isset($_SESSION['in_result_data'])){
							$db_obj->sql("SELECT * FROM `employee_view` WHERE `employee_id`='".$db_obj->EString($_SESSION['in_result_data'])."'");
							$employee=$db_obj->getResult();
							
							/********************Insert Data Show......................********/
							?>
							<div align="center">
                            <table width="83%" border="1" align="center">
  <tr>
    <td width="9%" height="55">&nbsp;</td>
    <td colspan="6" align="center"><h3><?=$employee[0]['emp_name']?></h3></td>
    <td width="12%" bgcolor="#CCCCCC"><h5><?=$employee[0]['emp_status']?></h5></td>
  </tr>
  <tr>
    <td height="59"><strong>E-mail</strong></td>
    <td width="16%" align="center">
      <?=$employee[0]['login_id']?>
    </td>
    <td width="14%"><strong>Employee Code</strong></td>
    <td width="16%" align="center">
      <?=$employee[0]['emp_code']?>
    </td>
    <td width="8%" align="center"><strong>NID</strong></td>
    <td width="17%" align="center"><?=$employee[0]['emp_nid']?></td>
    <td width="8%" align="right"><strong>Join Date</strong></td>
    <td align="center"><?=$employee[0]['join_date']?></td>
  </tr>
  <tr>
    <td height="54"><strong>Branch</strong></td>
    <td align="center"><?=$employee[0]['emp_branch']?></td>
    <td><strong>Address</strong></td>
    <td align="center"><?=$employee[0]['emp_address']?></td>
    <td align="center"><strong>Contact</strong></td>
    <td align="center"><?=$employee[0]['contact_num']?></td>
    <td align="right"><strong>Roule</strong></td>
    <td align="center"><?=$employee[0]['emp_roule']?></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8" align="right"><a href="#" class="btn">Print</a> <a href="employ_reg.php" class="btn">New Registation / Back</a></td>
  </tr>
    </table>

     </div>                      
					<?php
                        unset($_SESSION['in_result_data']);
                         /********************Insert Data Show......................********/
							}else{
						?>
  
                	<form class="stdform" action="action/hr/employee_reg.php" method="post">
                    	
                    <input name="action__" type="hidden" value="<?php echo $enc->encryptIt($page['add_status']);?>" />
                        
                        <p>
                        	<label>User Name</label>
                            <span class="field"><input type="text" required name="login_id"  class="input-medium" placeholder="User-name" id="login_id" /></span>
                        </p>
                      <p>
                       	<label>Password </label>
                         <span class="field"><input type="password" required name="login_pass" class="input-medium" placeholder="Password" id="login_pass" /></span>
                      </p>
                        <p>
                        	<label>Employee Code</label>
                            <span class="field"><input type="text" required name="employee_code" class="input-medium" placeholder="Employee Code" id="employee_code" /></span>
                        </p>
                        
                      <p>
                        	<label>Roule</label>
                            <span class="field">
<select name="rules" class="uniformselect" required id="rules">
                            	
                               
                               <?php
                     $db_obj->sql("SELECT `rules_id`,`rules_title` FROM `rules` WHERE `active`='Active' ORDER BY rules_id DESC");
					 $roule=$db_obj->getResult();
					 foreach($roule as $roule):
					 ?>
                     <option value="<?php echo $roule['rules_id'];?>"><?php echo $roule['rules_title'];?></option>
                     <?php
					 endforeach;
							   ?>
                               
                            </select>
                            
                            </span>
                      </p>
                        
                       <p>
                       	  <label>Status</label>
                            <span class="field">
                            <select name="status" required class="uniformselect" id="status">
                            	<option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            
                            </span>
                      </p>
                      
                       <p>
                        	<label>Join Date</label>
                            <span class="field"><input required type="date" name="join_date" class="input-medium" placeholder="exe: YYYY-MM-DD" id="join_date" /></span>
                      </p>
                      
                      <p>
                       	  <label>Branch</label>
                            <span class="field">
                            <select name="branch_id" required class="uniformselect" id="branch_id">
                            	
                               <?php
                     $db_obj->sql("SELECT `branch_id`,`name` FROM `branch_list` WHERE `status`='Active' ORDER BY branch_id DESC");
					 $branch_list=$db_obj->getResult();
					 foreach($branch_list as $branch_list):
					 ?>
                     <option value="<?php echo $branch_list['branch_id'];?>"><?php echo $branch_list['name'];?></option>
                     <?php
					 endforeach;
							   ?>
                              
                            </select>
                            
                            </span>
                      </p>
                      
                       <p>
                        	<label>Employee Name</label>
                            <span class="field"><input type="text" required name="name" class="input-medium" placeholder="Employee Name" id="name" /></span>
                      </p>
                        
                        <p>
                        	<label>Address</label>
                            <span class="field"><input type="text" required name="address" class="input-xlarge" placeholder="Employee Address" id="address" /></span>
                        </p>
                        
                         <p>
                        	<label>NID No</label>
                            <span class="field"><input type="text" required name="nid_no" class="input-xlarge" placeholder="National ID Number" id="nid_no" /></span>
                        </p>
                        
                      <p>
                       	<label>Contact Number</label>
                          <span class="field"><input type="text" required name="contact_number" class="input-xlarge" placeholder="Contact Number" id="contact_number" /></span>
                      </p>
                        
                        
                    
                      <p class="stdformbutton">
                        <button class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn">Reset Form</button>
                      </p>
                        
                        
                    </form> 
                    <?php }?>
                    
                     
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->
        