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
        

          $db_obj->select('on_demand_charge_fee','*',"code='".$_POST['code']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="house_keeping.php?OnDemandTransactionNew";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('on_demand_charge_fee',array('code'=>$_POST['code'],
		'name'=>$_POST['name'],
		'is_active'=>(@$_POST['is_active'])?(@$_POST['is_active']):'InActive',
		'fee_type'=>$_POST['fee_type'],
		'transaction_posting_id'=>$_POST['transaction_posting_id'],
		
		'fee_mode'=>$_POST['fee_mode'],
		 
		 'is_global'=>(@$_POST['is_global'])?(@$_POST['is_global']):'Inactive',
		 
		 'amount'=>$_POST['amount'],
		 'minimum_amount'=>$_POST['minimum_amount'],
		 
          'insert_id'=>$_SESSION['LOGIN_USER']['id'])); 



           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="house_keeping.php?OnDemandTransactionNew";</script>';
            
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
                  <div align="right"><a href="?OnDemandTransaction" class="btn alert-info"><span class="icon-th-large"></span> All On Demand Transaction  </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New On Demand Transaction   </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="130" height="36"><strong>Code</strong></td>
    <td width="215"><input type="text" name="code" id="code"   required="required"/></td>
    <td width="125" align="right"><strong>Name</strong></td>
    <td width="313" align="center"><input type="text" name="name" id="name"  /></td>
  </tr>
  <tr>
    <td width="130" height="33"><strong>Fee Type</strong></td>
    <td width="215"><select name="fee_type" id="fee_type" required="required">
      <option value="Opening">Opening</option>
      <option value="Renewal">Renewal</option>
      <option value="On Demand">On Demand</option>
	  <option value="On Demand">On Demand</option>
	  <option value="House">House</option>
    </select></td>
    <td width="125" align="right"><strong>Is Active</strong></td>
    <td align="center"><input name="is_active" type="checkbox" id="is_active" value="Active" checked="checked" /></td>
  </tr>
  <tr>
    <td height="31"><strong>Transaction Posting</strong></td>
    <td width="215"><select name="transaction_posting_id" id="transaction_posting_id" required="required">
      <?php
					 $sql="SELECT id,CONCAT('[ ',`code`,' ]',' ',`name`) as 'title' FROM transaction_type";
					$db_obj->sql($sql);
					 $transaction_type=$db_obj->getResult();
					 
					if($transaction_type){
						
						foreach($transaction_type as $transaction_type):
						?>
      <option value="<?php echo $transaction_type['id'];?>"><?php echo $transaction_type['title'];?></option>
      <?php
						endforeach;
					}else{
						?>
      <option value="">Please Insert Transaction Posting</option>
      <?php
						}
					?>
    </select></td>
    <td width="125" align="right"><strong> Amount</strong></td>
    <td align="center"><input type="text" name="amount" id="amount"  /></td>
  </tr>
  <tr>
    <td height="28"><strong>Fee Mode</strong></td>
    <td width="215"><select name="fee_mode" id="fee_mode" required="required">
      <option value="Recurring">Recurring</option>
      <option value="Once">Once</option>
    </select></td>
    <td width="125" rowspan="2" align="right"><strong>Minimum Amount</strong></td>
    <td rowspan="2" align="center"><input type="text" name="minimum_amount" id="minimum_amount"  /></td>
  </tr>
  <tr>
    <td height="8"><strong>Is Global</strong></td>
    <td><input name="is_global" type="checkbox" id="is_global" value="Active" /></td>
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
        