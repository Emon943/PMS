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
        

          $db_obj->select('tbl_agency_setup','*',"code='".$_POST['code']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="house_keeping.php?Agency_New";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('tbl_agency_setup',array('code'=>$_POST['code'],
		'name'=>$_POST['name'],
		'des'=>$_POST['des'],
		'charge_amt'=>$_POST['charge_amt'],
		'address'=>$_POST['address'],
		'status'=>$_POST['status'],
        'insert_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="house_keeping.php?Agency_New";</script>';
            
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
                  <div align="right"><a href="?AgencyList" class="btn alert-info"><span class="icon-th-large"></span>Agency List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Agency Setup</h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
    <form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="130" height="33"><strong>Agency Name:</strong></td>
    <td width="215"><input type="text" name="name" id="name"   required="required"/></td>
    <td width="125" align="right"><strong>Charge_amt:</strong></td>
    <td width="313"><input type="text" name="charge_amt" id="charge_amt"/>
      %</td>
  </tr>
  
   <tr>
    <td width="130" height="33"><strong>Code:</strong></td>
    <td width="215"><input type="text" name="code" id="code"   required="required"/></td>
    <td width="125" align="right"><strong>Descrption:</strong></td>
    <td width="313"><input type="text" name="des" id="des"/></td>
  </tr>
  
  <tr>
    <td width="130" height="33"><strong>Address:</strong></td>
    <td width="215"><input type="text" name="address" id="address" required></td>
	<td height="125" align="right"><strong>Status:</strong></td>
    <td width="215"><select name="status" id="status" required="required">
      <option value="1">Active</option>
      <option value="0">InActive</option>
    </select></td>
  </tr>
  
  <tr>
    <td height="32" colspan="4" align="right"> 
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
        