	<div class="contentinner">
     <?php
                    if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="all_branch.php" class="btn alert-info"><span class="icon-th-large"></span> Branch List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Branch Registration </h4>
                
  <div class="widgetcontent">
  
  						<?php
						
                        if(isset($_SESSION['in_result_data'])){
							$db_obj->sql("SELECT * FROM `branch_list` WHERE `branch_id`='".$db_obj->EString($_SESSION['in_result_data'])."'");
							$branch=$db_obj->getResult();
							
							/********************Insert Data Show......................********/
							?>
							<div align="center">
                            <table width="75%" border="1" align="center">
  <tr>
    <td width="9%" height="55">&nbsp;</td>
    <td align="center"><h3><?php echo $branch[0]['name']?></h3></td>
    <td width="12%" bgcolor="#CCCCCC"><h5><?php echo $branch[0]['status']?></h5></td>
  </tr>
  <tr>
    <td height="59"><strong>Branch</strong></td>
    <td width="16%" align="center">
      <?php echo $branch[0]['name']?>
    </td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="54"><strong>Branch Address</strong></td>
    <td align="center"><?php echo $branch[0]['branch_address']?></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right"><a href="#" class="btn">Print</a> <a href="branch_new.php" class="btn">New Registation / Back</a></td>
    </tr>
    </table>

</div>                      
					<?php
                        unset($_SESSION['in_result_data']);
                         /********************Insert Data Show......................********/
							}else{
								
						?>
  
                	<form class="stdform" action="action/branch/branch_reg.php" method="post">
                    	
                    <input name="action__" type="hidden" value="<?php echo $enc->encryptIt($page['add_status']);?>" />
                        
                        <p>
                        	<label>Branch Name</label>
                            <span class="field"><input type="text" required name="name"  class="input-medium" placeholder="Branch Name" id="name" /></span>
                        </p>
                     
<p>
                        	<label>Address</label>
                            <span class="field"><input type="text" required name="branch_address" class="input-medium" placeholder="Branch Address" id="branch_address" /></span>
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
        