	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('trace_id'=>$_POST['trace_id']));
			
			if($ck=='Success'){
				
				///Insert
        

          $db_obj->select('bank_charge_header','*',"trace_id='".$_POST['trace_id']."'");
        if($db_obj->numRows()!=0){

         $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="cashbook.php?bchs";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('bank_charge_header',array('trace_id'=>$_POST['trace_id'],
		'shortcode'=>$_POST['shortcode'],
		'type'=>$_POST['type'],
		'Internal_code'=>$_POST['Internal_code'],
		'des'=>$_POST['des'],
        'data_insert_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="cashbook.php?bchs_list";</script>';
            
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
                  <div align="right"><a href="?bchs_list" class="btn alert-info"><span class="icon-th-large"></span>Bank Charge Head List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Bank Charge Head Setup </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
    <form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td width="145" height="33"><strong>Trace Code:</strong></td>
    <td width="283"><input type="text" name="trace_id" id="trace_id"  required /></td>
    <td width="155"><strong>Short Code :</strong></td>
    <td><input type="text" name="shortcode" id="shortcode" /></td>
  </tr>
  <tr>
    <td height="31"><strong>Name :</strong></td>
    <td width="283"><input type="text" name="Internal_code" id="Internal_code" required/></td>
    <td width="155"><strong>Type :</strong></td>
   <td width="283"><select name="type" id="type" required="required">
      <option value="Payment">Payment</option>
      <option value="Receipt">Receipt</option>
    </select></td>
  </tr>
 
    <td height="35"><strong>Description :</strong></td>
	<td><textarea rows="90" cols="100" type="text" name="des" id="des" required="" style="width: 212px; height: 54px;"></textarea></td>
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
        