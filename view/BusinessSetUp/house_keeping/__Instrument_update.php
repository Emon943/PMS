
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$instrument_id=$enc->decryptIt($_GET["getID"]);
	//echo $instrument_id;
	//die();
	//date_default_timezone_set('Asia/Dhaka');
   //$update_date= date('Y-m-d h:i:s A');
	//die();

	
				$db_obj->sql("SELECT ins.instrument_id, ins.isin, ins.ins_name, ins.short_name, ins.ins_cat_id, ins.face_value, ins.market_price, ins.cost_per_share, ins.instrument_type, ins.total_share, ins.catagory, ins.status,ins.non_marginable, icp.catagory_name FROM instrument as ins INNER JOIN instrument_catgory_pd as icp ON ins.catagory = icp.id WHERE ins.instrument_id='".$db_obj->EString($instrument_id)."'");
			    $instrument_res=$db_obj->getResult();
			//print_r($instrument_res);
			//die();
			  if(!$instrument_res){
				   echo "<h2>Instrument Not Founded...........</h2>";
						exit();
				  }
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to Modify this?');
    }
</script>
<div class="contentinner content-dashboard">
 
 
  <?php

          
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?Instrument" class="btn alert-info"><span class="icon-th-large"></span>All Instrument </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					$update_date=date("Y-m-d h:i:sa");
					
			$x = $db_obj->update('instrument',array('isin'=>$_POST["isin"],
							 'ins_name'=>$_POST["ins_name"],
							 'short_name'=>$_POST["short_name"],
							 'ins_cat_id'=>$_POST["ins_cat_id"],
							 'face_value'=>$_POST["face_value"],
							 'market_price'=>$_POST["market_price"],
							 'cost_per_share'=>$_POST["cost_per_share"],
							 'instrument_type'=>$_POST["instrument_type"],
							 'non_marginable'=>(@$_POST['non_marginable'])?(@$_POST['non_marginable']):'FALSE',
							 'total_share'=>$_POST["total_share"],
							 'catagory'=>$_POST["catagory"],
							 'insert_employee_id'=>$_SESSION['LOGIN_USER']['id'],
							 'status'=>$_POST["status"]),
							 "instrument_id=".$instrument_id.""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			             echo'<script>window.location="house_keeping.php?Instrument";</script>';
            
               exit(); 
							  
					
					}
				?>



	<div class="widgetcontent" align="center">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="155"><font color="red">* </font><strong>ISIN</strong></td>
    <td width="172"><input type="text" name="isin" id="isin" value="<?php echo $instrument_res[0]['isin']?>" required /></td>
  </tr>
  <tr>
    <td height="31"><font color="red">* </font><strong>Instrument name</strong></td>
    <td width="283"><input type="text" name="ins_name" id="ins_name" value="<?php echo $instrument_res[0]['ins_name']?>" required/></td>

    <td width="155"><font color="red">* </font><strong>Short Name</strong></td>
    <td><input type="text" name="short_name" id="short_name" value="<?php echo $instrument_res[0]['short_name']?>" required/></td>
  </tr>
  <tr>
    <td height="33"><font color="red">* </font><strong>Instrument Catagory</strong></td>
    <td width="283"><select name="ins_cat_id" id="ins_cat_id" required>
    				<option value="<?php echo $instrument_res[0]['ins_cat_id']?>"><?php echo $instrument_res[0]['ins_cat_id']?></option>
    				<option value="">--- Update Instrument Catagory ---</option>
    
     <?php
					 $sql="SELECT * FROM instrumentcategory";
					$db_obj->sql($sql);
					 $instrumentcategory=$db_obj->getResult();
					 
					if($instrumentcategory){
						
						foreach($instrumentcategory as $instrumentcategory):
						?>
                       <option value="<?php echo $instrumentcategory['code'];?>"><?php echo $instrumentcategory['code'];?></option> 
                       
                        <?php
						endforeach;
					}else{
						?>
                        <option value="">Please Insert Instrument Catagory</option>
                        <?php
						}
					?>
                    
    
    </select></td>
    <td width="155"><strong>Face Value</strong></td>
    <td><input type="text" name="face_value" id="face_value" value="<?php echo $instrument_res[0]['face_value']?>" /></td>
  </tr>
  <tr>
    <td height="35"><font color="red">* </font><strong>Market Price</strong></td>
    <td width="283"><input name="market_price" type="text" id="market_price" value="<?php echo $instrument_res[0]['market_price']?>" required/></td>

    <td width="155"><font color="red">* </font><strong>Cost Per Share</strong></td>
    <td><input type="text" name="cost_per_share" id="cost_per_share" value="<?php echo $instrument_res[0]['cost_per_share']?>" required/></td>
  </tr>
  <tr>
    <td height="31"><font color="red">* </font><strong>Instrument Type</strong></td>
    <td width="283"><select name="instrument_type" id="instrument_type" required>
    <option value="<?php echo $instrument_res[0]['instrument_type']?>"><?php echo $instrument_res[0]['instrument_type']?></option>
    <option value="">--- Update Instrument Type ---</option>
    <option value="Demat">Demat</option>
    <option value="Paper">Paper</option>
    </select></td>

    <td width="155"><strong>Catagory</strong></td>
    <td><select name="catagory" id="catagory">
    		<option value="<?php echo $instrument_res[0]['catagory']?>"><?php echo $instrument_res[0]['catagory_name']?></option>
    		<option value="">--- Update Catagory ---</option>
    
    
     <?php
					 $sql="SELECT * FROM instrument_catgory_pd where status='Active'";
					$db_obj->sql($sql);
					 $instrument_catgory_pd=$db_obj->getResult();
					 
					if($instrument_catgory_pd){
						
						foreach($instrument_catgory_pd as $instrument_catgory_pd):
						?>
                       <option value="<?php echo $instrument_catgory_pd['id'];?>"><?php echo $instrument_catgory_pd['catagory_name'];?></option> 
                       
                        <?php
						endforeach;
					}else{
						?>
                        <option value="">Please Insert  Catagory</option>
                        <?php
						}
					?>
    
    </select></td>
  </tr>
  <tr>
    <td height="33"><font color="red">* </font><strong>Total Share</strong></td>
    <td width="283"><input type="text" name="total_share" id="total_share" value="<?php echo $instrument_res[0]['total_share']?>" required/></td>
	<td width="155"><strong>Non Marginable</strong></td>
    <td width="283"><input name="non_marginable" type="checkbox" value="TRUE" <?php if($instrument_res[0]['non_marginable']=="TRUE"){echo "checked";}?>/></td>
  </tr>
  
  <tr>
    <td width="155"><strong>Status</strong></td>
    <td><select name="status" id="status">
    <option value="<?php echo $instrument_res[0]['status']?>"><?php echo $instrument_res[0]['status']?></option>
    <option value="">--- Update Status ---</option>
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
    </select></td>
  </tr>
  <tr>
    <td height="42" colspan="4"> 
    <p class="stdformbutton">
                        <button style="margin-top: 20px;" class="btn btn-primary" name="updateInv" onclick="return confirmation()">Update</button>
                        <button style="margin-top: 20px" type="reset" class="btn">Reset Form</button>
    </p>
</td>
    </tr>
    </table>



                     
                    
                     
                        
                        
    </form> 
                
                     
  </div>
  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         