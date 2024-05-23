	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$ck=input_check(array('sell_limit'=>$_POST['sell_limit']));
			
			if($ck=='Success'){
				
				///Insert
        

          $db_obj->select('tbl_purchase_power','*',"sell_limit='".$_POST['sell_limit']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="house_keeping.php?PurchasePower";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('tbl_purchase_power',array('sell_limit'=>$_POST['sell_limit'],
		'purchase_limit'=>$_POST['purchase_power'],
		'netting'=>$_POST['netting'],
		'min_ratio'=>$_POST['equity_ratio'],
        'insert_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="house_keeping.php?PurchasePower";</script>';
            
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
                  <div align="right"><a href="?PurchasePower_list" class="btn alert-info"><span class="icon-th-large"></span>Trade Limit</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">Trade Limit  </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
   <form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="125" align="right"><strong>Sell Limit(%):  </strong></td>
    <td width="313"><input type="text" name="sell_limit" id="sell_limit"  />
      100%= Actual </td>
  </tr>
  
  <tr>
    <td width="125" align="right"><strong>Purchase Power(%):  </strong></td>
    <td width="313"><input type="text" name="purchase_power" id="purchase_power"  />
      100% = Actual</td>
  </tr>
  
    
  <tr>
    <td width="125" align="right"><strong>Netting(%):  </strong></td>
    <td width="313"><input type="text" name="netting" id="netting"/>
      % of netting allowed</td>
  </tr>
   <tr>
    <td width="125" align="right"><strong>Min debt Equity Ratio(%):  </strong></td>
    <td width="313"><input type="text" name="equity_ratio" id="equity_ratio" value="<?php echo "0"; ?>"  />
      % Min Ratio to get purchase</td>
  </tr>
  <tr>
    <td width="125" colspan="2" align="center">
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
        