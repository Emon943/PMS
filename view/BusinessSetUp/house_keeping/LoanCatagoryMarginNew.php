	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('loan_cat_margin_code'=>$_POST['loan_cat_margin_code']));
			
			if($ck=='Success'){
				
				///Insert
        

          $db_obj->select('loan_catagory_margin','*',"loan_cat_margin_code='".$_POST['loan_cat_margin_code']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="house_keeping.php?LoanCatagoryMarginNew";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('loan_catagory_margin',array('loan_cat_margin_code'=>$_POST['loan_cat_margin_code'],
		'description'=>$_POST['description'],
		'interest_priod'=>$_POST['interest_priod'],
		'charge_interest'=>$_POST['charge_interest'],
		'cumulative_charge'=>(@$_POST['cumulative_charge'])?(@$_POST['cumulative_charge']):'Inactive',
		'auto_debit'=>(@$_POST['auto_debit'])?(@$_POST['auto_debit']):'Inactive',
		'is_default'=>(@$_POST['is_default'])?(@$_POST['is_default']):'Inactive',
		'max_loan_allocation'=>$_POST['max_loan_allocation'],
		'min_account_blance'=>$_POST['min_account_blance'],
		'margin_ratio'=>$_POST['margin_ratio'],
		'interest_rate'=>$_POST['interest_rate'],
		'is_active'=>(@$_POST['is_active'])?(@$_POST['is_active']):'Inactive',
		'auto_charge_on_net_blance'=>(@$_POST['auto_charge_on_net_blance'])?(@$_POST['auto_charge_on_net_blance']):'Inactive',
		'activation_days'=>$_POST['activation_days'],
          'insert_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="house_keeping.php?LoanCatagoryMarginNew";</script>';
            
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
                  <div align="right"><a href="?LoanCatagoryMargin" class="btn alert-info"><span class="icon-th-large"></span> All Loan Catagory Margin </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Loan Catagory Margin   </h4>
                
  <div class="widgetcontent" align="center">
  
  	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="3" cellspacing="5">
  <tr>
    <td width="150" height="36"><strong>Code</strong></td>
    <td width="165"><input type="text" name="loan_cat_margin_code" id="loan_cat_margin_code"   required="required"/></td>
    <td width="210" align="right"><strong>Max Loan Allocation</strong></td>
    <td width="243"><input type="text" name="max_loan_allocation" id="max_loan_allocation"  /></td>
  </tr>
  <tr>
    <td width="150" height="37"><strong>Description</strong></td>
    <td width="165"><input type="text" name="description" id="description"   required/></td>
    <td align="right"><strong>Min Account Balance</strong></td>
    <td><input type="text" name="min_account_blance" id="min_account_blance"  /></td>
    </tr>
  <tr>
    <td height="36"><strong>Interest Preiod</strong></td>
    <td width="165"><select name="interest_priod" id="interest_priod" required="required">
      <option value="monthly">Monthly</option>
	  <option value="quarterly">Quarterly</option>
      <option value="yearly">Yearly</option>
    </select></td>
    <td width="210" align="right"><strong>Margin Ratio</strong></td>
    <td align="center">1: 
      <input type="text" name="margin_ratio" id="margin_ratio"  /></td>
    </tr>
  <tr>
    <td height="33"><strong>Charge Interest</strong></td>
    <td width="165"><select name="charge_interest" id="charge_interest" required="required">
      <option value="Daily">Daily</option>
      <option value="Monthly">Monthly</option>
      <option value="Quarterly">Quarterly</option>
      <option value="Weekly">Weekly</option>
      <option value="Yearly">Yearly</option>
    </select></td>
    <td width="210" align="right"><strong>Interest Rate</strong></td>
    <td><input type="text" name="interest_rate" id="interest_rate"  />
      %</td>
    </tr>
  <tr>
    <td height="43"><strong>Cumulative Charging</strong></td>
    <td align="center"><input name="cumulative_charge" type="checkbox" id="cumulative_charge" value="Active" /></td>
    <td width="210" align="right"><strong>Is Active</strong></td>
    <td align="center"><input name="is_active" type="checkbox" id="is_active" value="Active" checked="checked" /></td>
    </tr>
  <tr>
    <td height="52"><strong>Auto Debit</strong></td>
    <td align="center"><input name="auto_debit" type="checkbox" id="auto_debit" value="Active" /></td>
    <td width="210" align="right"><strong>Auto Charge On Net Balance</strong></td>
    <td align="center"><input name="auto_charge_on_net_blance" type="checkbox" id="auto_charge_on_net_blance" value="True" /></td>
    </tr>
  <tr>
    <td><strong>Is Default</strong></td>
    <td align="center"><input name="is_default" type="checkbox" id="is_default" value="Active" checked="checked" /></td>
    <td width="210" align="right"><strong>Activation Days</strong></td>
    <td><input type="text" name="activation_days" id="activation_days"  /></td>
    </tr>
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
        