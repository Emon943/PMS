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
        

          $db_obj->select('transaction_type','*',"code='".$_POST['code']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="financial.php?TransactionTypeNew";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('transaction_type',array('code'=>$_POST['code'],
		'name'=>$_POST['name'],
		'tran_type'=>$_POST['tran_type'],
		'charge_type'=>(@$_POST['cdbl'])?(@$_POST['cdbl']):'other',
		'description'=>$_POST['description'],
		'charges_amt'=>$_POST['charge_amt'],
		'status'=>(@$_POST['status'])?(@$_POST['status']):'Inactive',
        'insert_imployee_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="financial.php?TransactionTypeNew";</script>';
            
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
                  <div align="right"><a href="?TransactionType" class="btn alert-info"><span class="icon-th-large"></span> All Transaction Type </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Transaction Fee </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" height="36"><strong>Code</strong></td>
    <td width="283"><input type="text" name="code" id="code"   required="required"/></td>
    <td width="155">&nbsp;</td>
    <td width="172">&nbsp;</td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Name</strong></td>
    <td width="283"><input type="text" name="name" id="name"   required/></td>
    <td width="155">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="31"><strong>Tran Type</strong></td>
    <td width="283"><select name="tran_type" id="tran_type" required="required">
      <option value="Both">Both</option>
      <option value="Payment">Payment</option>
      <option value="Receipt">Receipt</option>
    </select></td>
    <td width="155">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="33"><strong>Description</strong></td>
    <td width="283"><input type="text" name="description" id="description" required=""/></td>
    <td width="155">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td height="33"><strong>Charge Amount</strong></td>
    <td width="283"><input type="text" name="charge_amt" id="charge_amt" required=""/></td>
    <td width="155">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="22"><strong>Is Active</strong></td>
    <td width="283"><input name="status" type="checkbox" id="status" value="Active" checked="checked" /></td>
    <td width="155">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td height="22"><strong>CDBL Charge</strong></td>
    <td width="183"><input name="cdbl" type="checkbox" id="cdbl" value="cdbl"/></td>
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
        