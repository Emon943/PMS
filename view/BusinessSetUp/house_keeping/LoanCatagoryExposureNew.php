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
        

          $db_obj->select('loan_catagory_exposure','*',"code='".$_POST['code']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="house_keeping.php?LoanCatagoryExposureNew";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('loan_catagory_exposure',array('code'=>$_POST['code'],
		'name'=>$_POST['name'],
		'exposure_from'=>$_POST['exposure_from'],
		'esposure_to'=>$_POST['esposure_to'],
		'email_alert'=>(@$_POST['email_alert'])?(@$_POST['email_alert']):'Inactive',
		'sms_alert'=>(@$_POST['sms_alert'])?(@$_POST['sms_alert']):'Inactive',
		'is_active'=>(@$_POST['is_active'])?(@$_POST['is_active']):'Inactive',
          'insertid'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="house_keeping.php?LoanCatagoryExposureNew";</script>';
            
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
                  <div align="right"><a href="?LoanCatagoryExposure" class="btn alert-info"><span class="icon-th-large"></span> All Loan Catagory Exposure </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Loan Catagory Exposure   </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="3" cellspacing="5">
  <tr>
    <td width="150" height="36"><strong>Code</strong></td>
    <td width="165"><input type="text" name="code" id="code"   required="required"/></td>
    <td width="210" align="right"><strong>Name</strong></td>
    <td width="243"><input type="text" name="name" id="name"  /></td>
  </tr>
  <tr>
    <td width="150" height="37"><strong>Exposure From</strong></td>
    <td width="165"><input type="text" name="exposure_from" id="exposure_from"   required/></td>
    <td align="right"><strong>Exposure To</strong></td>
    <td><input type="text" name="esposure_to" id="esposure_to"  /></td>
    </tr>
  <tr>
    <td height="43"><strong>Email Alert</strong></td>
    <td align="center"><input name="email_alert" type="checkbox" id="email_alert" value="Active" /></td>
    <td width="210" align="right"><strong>Is Active</strong></td>
    <td align="center"><input name="is_active" type="checkbox" id="is_active" value="Active" checked="checked" /></td>
  </tr>
  <tr>
    <td height="52"><strong>SMS Alert</strong></td>
    <td align="center"><input name="sms_alert" type="checkbox" id="sms_alert" value="Active" /></td>
    <td width="210" align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
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
        