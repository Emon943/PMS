	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('account_type'=>$_POST['account_type'],'account_number'=>$_POST['account_number']));
			
			if($ck=='Success'){
				
				///Insert
        

          $db_obj->select('bank_ac','*',"account_number='".$_POST['account_number']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="financial.php?BankAccountNew";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('bank_ac',array('account_type'=>$_POST['account_type'],
		'account_use'=>$_POST['account_use'],
		'account_number'=>$_POST['account_number'],
		'bank_name'=>$_POST['bank_name'],
		'branch_name'=>$_POST['branch_name'],
		'bank_account_name'=>$_POST['bank_account_name'],
		'bacsrf'=>$_POST['bacsrf'],
		'iban'=>$_POST['iban'],
		'swift_code'=>$_POST['swift_code'],
		'additaional_ref'=>$_POST['additaional_ref'],
		'cheque_name'=>$_POST['cheque_name'],
          'data_insert_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="cashbook.php?BankAccount";</script>';
            
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
                  <div align="right"><a href="?BankAccount" class="btn alert-info"><span class="icon-th-large"></span> All Bank Account </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Bank Account  </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
    <form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" height="36"><strong>Account Type</strong></td>
    <td width="283"><select name="account_type" id="account_type" required="required">
      <option value="Credit Card">Credit Card</option>
      <option value="Current">Current</option>
      <option value="Saving">Saving</option>
      <option value="SND">SND</option>
      <option value="STD">STD</option>
    </select></td>
    <td width="155"><strong>BACSRef</strong></td>
    <td width="172"><input type="text" name="bacsrf" id="bacsrf"  /></td>
  </tr>
   <tr>
    <td width="145" height="36"><strong>Account Use Type</strong></td>
    <td width="283">
	<select name="account_use" id="account_use" required="required">
			   <option value=""> </option>
               <?php
                       $bcsql = "select * from tbl_bo_cate";
                       $db_obj->sql($bcsql);
					   $investor_cat_res=$db_obj->getResult();
						//print_r($investor_cat_res);
                        for ($i = 0; $i < count($investor_cat_res); $i++){ 
                            ?>
                            <option value="<?php echo $investor_cat_res[$i]["id"]; ?>">
                              <?php echo $investor_cat_res[$i]["cate_name"]; ?></option>
                        <?php } ?>
				 </select></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Account Number</strong></td>
    <td width="283"><input type="text" name="account_number" id="account_number"   required/></td>
    <td width="155"><strong>IBAN</strong></td>
    <td><input type="text" name="iban" id="iban" /></td>
  </tr>
  <tr>
    <td height="31"><strong>Bank name</strong></td>
    <td width="283"><input type="text" name="bank_name" id="bank_name" required/></td>
    <td width="155"><strong>Swift Code</strong></td>
    <td><input type="text" name="swift_code" id="swift_code" /></td>
  </tr>
  <tr>
    <td height="33"><strong>Branch</strong></td>
    <td width="283"><input type="text" name="branch_name" id="branch_name" required=""/></td>
    <td width="155"><strong>Additional Reference</strong></td>
    <td><input type="text" name="additaional_ref" id="additaional_ref" /></td>
  </tr>
  <tr>
    <td height="35"><strong>Bank Account Name</strong></td>
    <td width="283"><input name="bank_account_name" type="text" id="bank_account_name" /></td>
    <td width="155"><strong>Cheque Name</strong></td>
    <td><input type="text" name="cheque_name" id="cheque_name" /></td>
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
        