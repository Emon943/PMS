
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$tradeLimit_id=$enc->decryptIt($_GET["getID"]);
	date_default_timezone_set('Asia/Dhaka');
   $update_date= date('Y-m-d h:i:s A');
	//die();
	
				$db_obj->sql("SELECT * FROM tbl_purchase_power WHERE id='".$db_obj->EString($tradeLimit_id)."'");
			    $tradeLimit=$db_obj->getResult();
				//print_r($tradeLimit);
				//die();
			  if(!$tradeLimit){
				   echo "<h2>Trade Limit Not Founded...........</h2>";
						exit();
				  }
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>


<div class="contentinner content-dashboard">
 
 
  <?php

          
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?Settlement" class="btn alert-info"><span class="icon-th-large"></span> All Settlement </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					$update_date=date("Y-m-d h:i:sa");
					
			$db_obj->update('tbl_purchase_power',array('sell_limit'=>$_POST["sell_limit"],
         					 'purchase_limit'=>$_POST["purchase_power"],
							 'netting'=>$_POST["netting"],
							 'min_ratio'=>$_POST["equity_ratio"],
							 'update_date'=>$update_date),
							 "id=".$tradeLimit_id.""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			             echo'<script>window.location="house_keeping.php?PurchasePower_list";</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form action="" method="post" enctype="multipart/form-data">
          <table width="80%" border="0" cellpadding="0" cellspacing="5">
            
     <tr>
    <td width="125" align="right"><strong>Sell Limit(%):  </strong></td>
    <td width="313"><input type="text" name="sell_limit" id="sell_limit" value="<?php echo $tradeLimit[0]['sell_limit']?>" />
      100%= Actual </td>
  </tr>
  
  <tr>
    <td width="125" align="right"><strong>Purchase Power(%):  </strong></td>
    <td width="313"><input type="text" name="purchase_power" id="purchase_power" value="<?php echo $tradeLimit[0]['purchase_limit']?>" />
      100% = Actual</td>
  </tr>
  
    
  <tr>
    <td width="125" align="right"><strong>Netting(%):  </strong></td>
    <td width="313"><input type="text" name="netting" id="netting" value="<?php echo $tradeLimit[0]['netting']?>"/>
      % of netting allowed</td>
  </tr>
 
   <tr>
    <td width="125" align="right"><strong>Min debt Equity Ratio(%):  </strong></td>
    <td width="313"><input type="text" name="equity_ratio" id="equity_ratio" value="<?php echo $tradeLimit[0]['min_ratio'];?>"  />
      % Min Ratio to get purchase</td>
  </tr>
  
   <tr>
    <td width="125" align="right"><strong>Update Date:  </strong></td>
    <td width="313"><input type="text" name="update_date" id="update_date" value="<?php echo $tradeLimit[0]['update_date'];?>"/>
      </td>
  </tr>
			
			
            <br/>
            <tr>
              <td height="-5" valign="top"  ></td>
              <td height="-5" align="right" valign="top"  ><input type="submit" name="updateInv" id="updateInv" value="Update"/></td>
            </tr>
          </table>
          </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         