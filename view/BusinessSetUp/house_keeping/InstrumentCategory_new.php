	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('Code'=>$_POST['code']));
			
			if($ck=='Success'){
				
				///Insert
        

          $db_obj->select('instrumentcategory','*',"code='".$_POST['code']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
            // header("Location: house_keeping.php?InstrumentCategory_new");
			   echo'<script>window.location="house_keeping.php?InstrumentCategory_new";</script>';
			 
               exit(); 

        }else{         
        $ins=$db_obj->insert('instrumentcategory',array('code'=>$_POST['code'],
          'description'=>$_POST['description'],
          'sttelment_day_dse'=>$_POST['dse'],
          'sttelment_day_cse'=>$_POST['cse'],
          'deduct'=>$_POST['deduct'],
          'payble'=>$_POST['payble'],
          'receivable'=>$_POST['recivable'],
          'netting'=>$_POST['netting'],
          'status'=>$_POST['status'],
          'effective_date'=>$_POST['effective'],
          'is_non_marginable'=>(@$_POST['noMarginable'])?(@$_POST['noMarginable']):'No',
          'is_enjoy_netting'=>(@$_POST['EnjoyNetting'])?(@$_POST['EnjoyNetting']):'No',
          'insert_employee_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
             //header("Location: house_keeping.php?InstrumentCategory_new");
			 echo'<script>window.location="house_keeping.php?InstrumentCategory_new";</script>';
               exit(); 
        }
				
				}else{
					$_SESSION['in_result_data']= "<h3 align='center'>".$ck."<h3>";

					}
			
		
		}
	?>
    
    <div class="contentinner">


     <?php

          if(@$_SESSION['in_result_data']){

            echo $_SESSION['in_result_data'];
            unset($_SESSION['in_result_data']);
          }



                    if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?InstrumentCategory" class="btn alert-info"><span class="icon-th-large"></span> All Instrument Category</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Instrument Category </h4>
                
  <div class="widgetcontent">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	
                    
                        
                        <p>
                        	<label><font color="red">*</font> Code</label>
                            <span class="field"><input autocomplete="off" type="text" required name="code"  class="input-medium" placeholder="Code" id="code" /></span>
                        </p>
                      <p>
                       	<label><font color="red">*</font> Description </label>
                         <span class="field"><input type="text" autocomplete="off" required name="description" class="input-medium" placeholder="Description" id="description" /></span>
                      </p>
                        <p>
                        	<label><font color="red">*</font> Settlement Day [ DSE ]</label>
                            <span class="field"><input name="dse" autocomplete="off" type="number" class="input-medium" id="dse" value="0" required placeholder="Settlement Day [ DSE ]" /></span>
                        </p>
                        
                      <p>
                        	<label><font color="red">*</font> Settlement Day [ CSE ]</label>
                            
                            <span class="field"><input name="cse" autocomplete="off" type="number" class="input-medium" id="cse" value="0" required placeholder="Settlement Day [ CSE ]" /></span>
                            
                            
                      </p>
                      
                        <p>
                        	<label><font color="red">*</font> Payble</label>
                            
                            <span class="field"><input name="payble" autocomplete="off" type="number" class="input-medium" id="payble" value="0" required placeholder="Payble" /></span>
                            
                            
                      </p>
                      
                       <p>
                        	<label> <font color="red">* </font>Receivable</label>
                            
                            <span class="field"><input name="recivable" autocomplete="off" type="number" class="input-medium" id="recivable" value="0" required placeholder="Receivable" /></span>
                            
                            
                      </p>
                       <p>
                        	<label> <font color="red">*</font> Deduct</label>
                            
                            <span class="field"><input name="deduct" autocomplete="off" type="number" class="input-medium" id="deduct" value="0" required placeholder="Deduct" /></span>
                            
                            
                      </p>
                      
                       <p>
                        	<label> <font color="red">*</font>  Netting</label>
                            
                            <span class="field"><input name="netting" autocomplete="off" type="number" class="input-medium" id="netting" value="0" required placeholder="Netting" /></span>
                            
                            
                      </p>
                        
                       <p>
                       	  <label> <font color="red">* </font>Status</label>
                            <span class="field">
                            <select name="status" required class="uniformselect" id="status">
                            	<option value="Close">Close</option>
                                <option value="Open">Open</option>
                            </select>
                            
                            </span>
                      </p>
                      
                       <p>
                        	<label>Effective Date</label>
                            <span class="field"><input name="effective" autocomplete="off" type="text" class="input-medium" id="effective" value="<?php echo date('Y-m-d');?>" required placeholder="exe: YYYY-MM-DD" /></span>
                      </p>
                      
                    
                        	<label>Is nonMarginable</label>
                            <span class="field">
                            <input name="noMarginable" type="checkbox" value="Yes" />
                            
                            
                            </span>
                            
                            
                      </p>
                      
                      <p>
                        	<label>Is EnjoyNetting</label>
                            <span class="field">
                            
                            <input name="EnjoyNetting" type="checkbox" value="Yes" checked />
                            
                            </span>
                      </p>
                      
                      
                     
                    
                      <p class="stdformbutton">
                        <button class="btn btn-primary" name="submit_ins">Submit</button>
                            <button type="reset" class="btn">Reset Form</button>
                      </p>
                        
                        
                    </form> 
                
                     
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->
        