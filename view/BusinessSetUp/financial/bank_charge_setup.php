	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
		$ck=input_check(array('trace_id'=>$_POST['trace_id'],));
			
			if($ck=='Success'){
				
				///Insert
        

          $db_obj->select('tbl_broker_hous','*',"trace_id='".$_POST['trace_id']."'");
         if($db_obj->numRows()!=0){

         $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="settlement.php?BrokerHouse";</script>';
               exit(); 

        }else{         
       $ins=$db_obj->insert('tbl_broker_hous',array('Internal_code'=>$_POST['Internal_code'],
	    'trace_id'=>$_POST['trace_id'],
	    'trace_code'=>$_POST['trace_code'],
	    'name'=>$_POST['name'],
	    'dsc_clear_id'=>$_POST['dse'],
	    'cse_clear_id'=>$_POST['cse'],
	    'status'=>$_POST['status'],
	    'contact_person'=>$_POST['contact_person'],
		'address'=>$_POST['address'],
		'contact_no'=>$_POST['contact_no'],
		'email'=>$_POST['email'],
		'receivable'=>$_POST['receivable'],
		'settlement_fee'=>$_POST['settlement_fee'],
		'payable'=>$_POST['payable'])); 
		
		//print_r($ins);
		//die();

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="settlement.php?BrokerHouse";</script>';
            
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
                  <div align="right"><a href="?BrokerHouseList" class="btn alert-info"><span class="icon-th-large"></span> All Broker </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Broker Setup </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
   <form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Internal Code</strong></td>
    <td width="283"><input type="text" name="Internal_code" id="Internal_code" required /></td>
    
    <td width="155" height="33"><font color="red">* </font><strong>Name</strong></td>
     <td width="283"><input type="text" name="name" id="name" required /></td>
  </tr>
  
  <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Trace Id</strong></td>
    <td width="283"><input type="text" name="trace_id" id="trace_id" required /></td>
    
    <td width="155" height="33"><font color="red">* </font><strong>Trace Code</strong></td>
     <td width="283"><input type="text" name="trace_code" id="trace_code" required /></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>DSE Clear BOID</strong></td>
    <td width="283"><input type="text" name="dse" id="dse" /></td>
    
    <td width="155" height="33"><strong>CSE Clear BOID</strong></td>
     <td width="283"><input type="text" name="cse" id="cse" /></td>
  </tr>
   <tr>
	<td height="31"><font color="red">* </font><strong>Status</strong></td>
    <td width="283"><select name="status" id="status" required="required">
      <option value="1">Open</option>
      <option value="0">Close</option>
    </select></td>
    
    <td width="155" height="33"><font color="red">* </font><strong>Contact Person</strong></td>
     <td width="283"><input type="text" name="contact_person" id="contact_person" required /></td>
  </tr>
  
  <tr>
   <td width="145" height="33"><strong>Address</strong></td>
   <td width="283"><textarea type="text" name="address">Enter text here...</textarea></td>
   
   <td width="155" height="33"><font color="red">* </font><strong>Contact Number</strong></td>
     <td width="283"><input type="text" name="contact_no" id="contact_no" required /></td>
  </tr>
  
  <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Email</strong></td>
    <td width="283"><input type="email" name="email" id="email" required /></td>
	
    <td width="155" height="33"><strong>Receivable COA</strong></td>
    <td width="283"><input type="text" name="receivable" id="receivable" /></td>
  </tr>
  <tr>
   <td width="145" height="33"><font color="red">* </font><strong>Settlement Fee (%)</strong></td>
    <td width="283"><input type="text" name="settlement_fee" id="settlement_fee" required /></td>
	
    <td width="155" height="33"><strong>Payable COA</strong></td>
    <td width="283"><input type="text" name="payable" id="receivable"/></td>
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
        