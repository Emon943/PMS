	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('code'=>$_POST['code']));
			
			if($ck=='Success'){
				
				///Insert
        

          $db_obj->select('investor_group','*',"code='".$_POST['code']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="house_keeping.php?InvestorGroup_New";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('investor_group',array('group_name'=>$_POST['group_name'],
		'code'=>$_POST['code'],
		'ac_type'=>$_POST['ac_type'],
		'loan_applicable'=>(@$_POST['loan_applicable'])?(@$_POST['loan_applicable']):'No',
		'description'=>$_POST['description'],
		'loan_cat'=>$_POST['loan_cat'],
		'interest_margin'=>$_POST['interest_margin'],
		'is_default'=>(@$_POST['is_default'])?(@$_POST['is_default']):'0',
		'trade_volume'=>$_POST['trade_volume'],
		'is_email'=>(@$_POST['is_email'])?(@$_POST['is_email']):'0',
		'is_discount'=>(@$_POST['is_discount'])?(@$_POST['is_discount']):'0',
		'SMS_default'=>(@$_POST['SMS_default'])?(@$_POST['SMS_default']):'0',
		'charge_head'=>$_POST['charge_head'],
		'inst_type'=>$_POST['inst_type'],
		'amount'=>$_POST['amount'],
		 'is_active'=>(@$_POST['is_active'])?(@$_POST['is_active']):'False',
          'insert_id'=>$_SESSION['LOGIN_USER']['id']));
		  
		 // print_r($ins);
           //die();
           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="house_keeping.php?InvestorGroup_New";</script>';
            
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
                  <div align="right"><a href="?InvestorGroupList" class="btn alert-info"><span class="icon-th-large"></span>Investor Group List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">Investor Group</h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="130" height="30"><strong>Code:</strong></td>
    <td width="215"><input type="text" name="code" id="code"   required="required"/></td>
    <td width="125" align="right"><strong>Display Name:</strong></td>
    <td width="313"><input type="text" name="group_name" id="group_name" required="required">
    </td>
  </tr>
  <tr>
    <td height="31"><strong>Account Type:</strong></td>
    <td width="215"><select name="ac_type" id="ac_type" required="required">
	 <option value=" "></option>
      <option value="IDA">IDA</option>
      <option value="NDA">NDA</option>
    </select></td>
	 <td width="125"align="right"><strong>Description:</strong></td>
    <td width="215"><input type="text" name="description" id="description" required="required"></td>
    
  </tr>
 
  
  <tr>
    <td height="31"><strong>Interest Margin:</strong></td>
    <td width="215"><input type="text" name="interest_margin" id="interest_margin" value="<?php echo '0';?>"  required="required"></td>
    <td width="125" align="right"><strong>Is Default:</strong></td>
    <td align="center"><input name="is_default" type="checkbox" id="is_default" value="1" /></td>
  </tr>
  <tr>
    <td height="31"><strong>Trade Volume:</strong></td>
    <td width="215"><input type="text" name="trade_volume" id="trade_volume" value="<?php echo '0';?>"  required/></td>
    <td width="125" align="right"><strong>Allow Email Notification:</strong></td>
    <td align="center"><input name="is_email" type="checkbox" id="is_email" value="1" /></td>
  </tr>
  
 
  <tr>
    <td width="130" height="33"><strong>Charge Header:</strong></td>
     <td width="172"><select class="form-control" name="charge_head" id="charge_head" required="required">
	<option value=""></option>
	
	 <?php
                      $csql="SELECT * FROM `charge_header`";
                       $db_obj->sql($csql);
					   $charge_head=$db_obj->getResult();
						//print_r($loan_catagory_res);
                        for ($i = 0; $i < count($charge_head); $i++){
							
                            ?>
                            <option value="<?php echo $charge_head[$i]["code"]; ?>">
                                <?php echo $charge_head[$i]["name"]; ?></option>
                        <?php } ?>
    
   </select></td>
    <td width="125" align="right"><strong>Instrument Type:</strong></td>
    <td width="172"><select class="form-control" name="inst_type" id="inst_type" required>
	<option value=""></option>
	 <option value="All">All</option>
      <option value="DSE">DSE</option>
      <option value="CSE">CSE</option>
	  <option value="IPO">IPO</option>
	 
   </select></td>
  </tr>
 <tr>
    <td height="31"><strong>Charge Amount :</strong></td>
    <td width="215"><input type="text" name="amount" id="amount" value="<?php echo '0';?>" required></td>
    <td width="125" align="right"><strong>Is Active:</strong></td>
    <td align="center"><input name="is_active" type="checkbox" id="is_active" value="True" /></td>
  </tr>
 
 
  <tr>
     <td width="225" align="right"><strong>Discount on Volume only:</strong></td>
    <td align="center"><input name="is_discount" type="checkbox" id="is_discount" value="1" /></td>
    <td width="225" align="right"><strong>Allow SMS Notification:</strong></td>
    <td align="center"><input name="SMS_default" type="checkbox" id="SMS_default" value="1" /></td>
  </tr>

  
  
    </table>
<p>
<td width="125" align="right"><strong>Is Loan Applicable:</strong></td>
  <td align="center"><input name="loan_applicable" type="checkbox" id="master-checkbox" value="Yes" /></td>
  </p>
<p>Loan Category:
<td width="172"><select class="depends-on-master-checkbox form-control" name="loan_cat" id="dependent-field1">
	<option value=""></option>
	 <?php
                      $lsql="SELECT * FROM `loan_catagory_margin`";
                       $db_obj->sql($lsql);
					   $loan_catagory_res=$db_obj->getResult();
						//print_r($loan_catagory_res);
                        for ($i = 0; $i < count($loan_catagory_res); $i++){
							
                            ?>
                            <option value="<?php echo $loan_catagory_res[$i]["id"]; ?>">
                                <?php echo $loan_catagory_res[$i]["loan_cat_margin_code"]; ?></option>
                        <?php } ?>
	 
    </select></td>
	</p>
                         
     <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" name="submit_ins">Save</button>
        <button type="reset" class="btn">Reset Form</button>
        </p></td>
  </tr>                   
    </form> 
                
                     
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->
    <script>
   $('.depends-on-master-checkbox').dependsOn('#master-checkbox');
   $('#dependent-dropdown').dependsOn('#master-dropdown', ['Canada', 'United States']);
  </script>
	  