	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('bank_name'=>$_POST['bank_name']));
			
			if($ck=='Success'){
				
				///Insert
        

        $db_obj->select('tbl_bank_list','*',"bank_name='".$_POST['bank_name']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="financial.php?bank_setup";</script>';
               exit(); 

        }else{
         $date=date("Y-m-d");			
        $ins=$db_obj->insert('tbl_bank_list',array('bank_name'=>$_POST['bank_name'],
		'create_date'=>$date));

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="financial.php?bank_setup";</script>';
            
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
    <div align="right"><a href="?Bank_List" class="btn alert-info"><span class="icon-th-large"></span>All Bank List</a></div>
     <?php endif;?>
    <h4 class="widgettitle">New Bank Setup</h4>
                
  
  <form class="form-inline" action="" method="post">
    <div class="form-group">
      <label for="email">Bank Name:</label>
      <input type="text" class="form-control" id="bank_name" placeholder="Enter bank name" name="bank_name" required>
    </div>
    
    <button type="submit" name="submit_ins" class="btn btn-default">Submit</button>
  </form>
                
                     
  
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->
        