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
        

          $db_obj->select('interst_on_credit_blance_catagory','*',"code='".$_POST['code']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="house_keeping.php?iocbNew";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('interst_on_credit_blance_catagory',array('code'=>$_POST['code'],
		'description'=>$_POST['description'],
		'interest_period'=>$_POST['interest_period'],
		'chage_interst'=>$_POST['chage_interst'],
		'tax_on_return_rate'=>$_POST['tax_on_return_rate'],
		'interest_rate'=>$_POST['interest_rate'],
		 'status'=>(@$_POST['status'])?(@$_POST['status']):'InActive',
		 'is_default'=>(@$_POST['is_default'])?(@$_POST['is_default']):'False',
          'insert_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="house_keeping.php?iocbNew";</script>';
            
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
                  <div align="right"><a href="?iocb" class="btn alert-info"><span class="icon-th-large"></span> All Interest On Credit balance Catagory </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Interest On Credit balance Catagory  </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="130" height="30"><strong>Code</strong></td>
    <td width="190"><input type="text" name="code" id="code"   required="required"/></td>
    <td width="150" align="right"><strong>Interest Rate</strong></td>
    <td width="313"><input type="text" name="interest_rate" id="interest_rate"  />
      %</td>
  </tr>
  <tr>
    <td width="130" height="33"><strong>Description</strong></td>
    <td width="190"><input type="text" name="description" id="description"   required/></td>
    <td align="right"><strong>TAX on Return Rate</strong></td>
    <td><input type="text" name="tax_on_return_rate" id="tax_on_return_rate"  />
      %</td>
    </tr>
  <tr>
    <td height="31"><strong>Interest Preiod</strong></td>
    <td width="190"><select name="interest_period" id="interest_period" required="required">
      <option value="Monthly">Monthly</option>
      <option value="Yearly">Yearly</option>
    </select></td>
    <td width="150" align="right"><strong>Is Active</strong></td>
    <td align="center"><input name="status" type="checkbox" id="status" value="Active" checked="checked" /></td>
    </tr>
  <tr>
    <td height="33"><strong>Charge Interest</strong></td>
    <td width="190"><select name="chage_interst" id="chage_interst" required="required">
      <option value="Daily">Daily</option>
      <option value="Monthly">Monthly</option>
      <option value="Quarterly">Quarterly</option>
      <option value="Weekly">Weekly</option>
      <option value="Yearly">Yearly</option>
    </select></td>
    <td width="150" align="right"><strong>Is Default</strong></td>
    <td align="center"><input name="is_default" type="checkbox" id="is_default" value="True" /></td>
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
        