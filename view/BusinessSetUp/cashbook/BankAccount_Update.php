
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$bank_id=$enc->decryptIt($_GET["getID"]);
	//echo $bank_id;
	//die();
	
			$db_obj->sql("SELECT * FROM bank_ac WHERE id='".$db_obj->EString($bank_id)."'");
			$bank_res=$db_obj->getResult();
			//print_r($bank_res);
			$account_use_id=$bank_res[0]['account_use'];
			//die();
			  if(!$bank_res){
				   echo "<h2>Bank Info Not Founded...........</h2>";
						exit();
				  }
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to Modify this?');
    }
</script>
<div class="contentinner content-dashboard">
 
 
  <?php

          
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?BankAccount" class="btn alert-info"><span class="icon-th-large"></span>Bank List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["submit_ins"])){
					$update_date=date("Y-m-d h:i:sa");
					
			$db_obj->update('bank_ac',array('account_type'=>$_POST["account_type"],
							 'bacsrf'=>$_POST["bacsrf"],
						     'account_use'=>$_POST["account_use"],
						     'account_number'=>$_POST["account_number"],
							 'iban'=>$_POST["iban"],
							 'bank_name'=>$_POST["bank_name"],
							 'swift_code'=>$_POST["swift_code"],
							 'branch_name'=>$_POST["branch_name"],
							 'additaional_ref'=>$_POST["additaional_ref"],
							 'bank_account_name'=>$_POST["bank_account_name"],
							 'cheque_name'=>$_POST["cheque_name"]),
							 "id=".$bank_id.""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			             echo'<script>window.location="cashbook.php?BankAccount";</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" height="36"><strong>Account Type</strong></td>
    <td width="283"><select name="account_type" id="account_type" value="<?php echo $bank_res[0]['account_type']?>" required="required">
      <option value="Credit Card">Credit Card</option>
      <option value="Current">Current</option>
      <option value="Saving">Saving</option>
      <option value="SND">SND</option>
      <option value="STD">STD</option>
    </select></td>
    <td width="155"><strong>BACSRef</strong></td>
    <td width="172"><input type="text" name="bacsrf" value="<?php echo $bank_res[0]['bacsrf']?>" id="bacsrf"  /></td>
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
                        for ($i = 0; $i < count($investor_cat_res); $i++) {
                            if(@$account_use_id == $investor_cat_res[$i]["id"]){
                                $account_use = "selected";
                            }else{
                                $account_use = "";
								}
                            ?>
                            <option <?php echo $account_use; ?> value="<?php echo $investor_cat_res[$i]["id"]; ?>">
                                <?php echo $investor_cat_res[$i]["cate_name"]; ?></option>
                        <?php } ?>
				 </select></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Account Number</strong></td>
    <td width="283"><input type="text" name="account_number" id="account_number" value="<?php echo $bank_res[0]['account_number']?>" required ></td>
    <td width="155"><strong>IBAN</strong></td>
    <td><input type="text" name="iban" id="iban" value="<?php echo $bank_res[0]['iban']?>" /></td>
  </tr>
  <tr>
    <td height="31"><strong>Bank name</strong></td>
    <td width="283"><input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_res[0]['bank_name']?>" required></td>
    <td width="155"><strong>Swift Code</strong></td>
    <td><input type="text" name="swift_code" id="swift_code" value="<?php echo $bank_res[0]['swift_code']?>"/></td>
  </tr>
  <tr>
    <td height="33"><strong>Branch</strong></td>
    <td width="283"><input type="text" name="branch_name" id="branch_name" value="<?php echo $bank_res[0]['branch_name']?>" required=""/></td>
    <td width="155"><strong>Additional Reference</strong></td>
    <td><input type="text" name="additaional_ref" id="additaional_ref" value="<?php echo $bank_res[0]['additaional_ref']?>" /></td>
  </tr>
  <tr>
    <td height="35"><strong>Bank Account Name</strong></td>
    <td width="283"><input name="bank_account_name" type="text" id="bank_account_name" value="<?php echo $bank_res[0]['bank_account_name']?>" /></td>
    <td width="155"><strong>Cheque Name</strong></td>
    <td><input type="text" name="cheque_name" id="cheque_name" value="<?php echo $bank_res[0]['cheque_name']?>"/></td>
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
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         