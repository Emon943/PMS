	<?php 
	
	if($page['add_status']!="Active"){
		header("Location: ".$mainLink);
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('code'=>$_POST['code']));
			
			if($ck=='Success'){
				
				///Insert
        

         $db_obj->select('charge_header','*',"code='".$_POST['code']."'");
		 
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
		  echo("<script>location.href = 'house_keeping.php?ChargeHeaderNew';</script>");
           
			 
               exit(0); 

        }else{         
        $ins=$db_obj->insert('charge_header',array('code'=>$_POST['code'],
          'name'=>$_POST['name'],
          'is_percentage'=>$_POST['is_percentage'],
          'is_active'=>$_POST['is_active'],
          'charge_type'=>$_POST['charge_type'],
          'transaction_posting'=>$_POST['transaction_posting'],
          'payble_by_investor'=>$_POST['payble_by_investor'],
          'is_global'=>$_POST['is_global'],
          'insert_employee_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Fully.....<h3>";

             $db_obj->disconnect();
			 
            echo("<script>location.href = 'house_keeping.php?ChargeHeaderNew';</script>");
			exit(0);
            
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
                  <div align="right"><a href="?ChargeHeader" class="btn alert-info"><span class="icon-th-large"></span> All Charge Header </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Charge Header  </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" height="36"><font color="red">* </font> <strong>Code</strong></td>
    <td width="283"><input type="text" name="code" id="code" required /></td>
    <td width="155"> <font color="red">* </font> <strong>Name</strong></td>
    <td width="172"><input type="text" name="name" id="name" required /></td>
  </tr>
  <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Is Percentage (%)</strong></td>
    <td width="283"><select name="is_percentage" id="is_percentage" required="required">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
    <td width="155"><font color="red">* </font><strong>Is Active</strong></td>
    <td><select name="is_active" id="is_active" required="required">
      <option value="Active">Active</option>
      <option value="Inactive">Inactive</option>
    </select></td>
  </tr>
  <tr>
    <td height="31"><font color="red">* </font><strong>Charge Type</strong></td>
    <td width="283"><select name="charge_type" id="charge_type" required="required">
      <option value="House">House</option>
      <option value="DSE">DSE</option>
      <option value="CDBL">CDBL</option>
      <option value="DSE-DLR">DSE-DLR</option>
    </select></td>
    <td width="155"><font color="red">* </font><strong>Transaction Posting</strong></td>
    <td><select name="transaction_posting" id="transaction_posting" required="required">
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
    <td height="33"><font color="red">* </font><strong>Payble By Investor</strong></td>
    <td width="283"><select name="payble_by_investor" id="payble_by_investor" required="required">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
    <td width="155"><font color="red">* </font><strong>Is Global</strong></td>
    <td><select name="is_global" id="is_global" required="required">
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select></td>
  </tr>
  <!--<tr>
    <td height="35"><font color="red">* </font><strong>Amount</strong></td>
    <td width="283"><input name="amount" type="text" id="amount" value="0" required/></td>
    <td width="155"><strong>Minimum Amount</strong></td>
    <td><input name="minimum_amount" type="text" id="minimum_amount" value="0" /></td>
  </tr>-->
  <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" name="submit_ins">Submit</button>
        <button type="reset" class="btn">Reset Form</button>
        </p></td>
  </tr>
    </table>            
                        
                        
    </form> 
                
                     
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->
        