	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('branch_name'=>$_POST['branch_name']));
			
			if($ck=='Success'){
				
				///Insert
        

        $db_obj->select('tbl_branch_info','*',"	branch_name='".$_POST['branch_name']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="financial.php?branch_setup";</script>';
               exit(); 

        }else{
         $date=date("Y-m-d");			
        $ins=$db_obj->insert('tbl_branch_info',array('bank_id'=>$_POST['bank_id'],
		'branch_name'=>$_POST['branch_name'],
		'date'=>$date));

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="financial.php?branch_setup";</script>';
            
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
    <div align="right"><a href="?branch_List" class="btn alert-info"><span class="icon-th-large"></span>All Bank Branch</a></div>
     <?php endif;?>
    <h4 class="widgettitle">New Branch Setup</h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
    <form class="stdform" action="" method="post">              	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="14" height="33"><strong>Bank Name: </strong> </td>
    <td width="283"><select name="bank_id" id="bank_id" required="required">
	<option value="">SELECT</option>
    <?php
	 $sqlw="SELECT * FROM `tbl_bank_list`";
					
					 $db_obj->sql($sqlw);
					 $bank_name=$db_obj->getResult();
					 //print_r($broker_house);
					//die();
  //if($company_name){
						
	foreach($bank_name as $bl){
	?>
	
    <option value="<?php echo $bl['id'];?>"><?php echo $bl['bank_name']; ?></option>
	 <?php
	}
	?> 	 
    </select></td>
	
   </tr>
  
  
  <tr>
    <td height="31"><strong>Branch name:</strong></td>
    <td><input type="text" name="branch_name" id="branch_name" required ></td>
  </tr>
  
  <tr>
    <td width="14"> 
        
	</td>
	<td>
	 <button class="btn btn-default" name="submit_ins">Submit</button>
	</td>
  </tr>
    </table>
                
    </form> 
                
                     
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->
        