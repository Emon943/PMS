 <?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			//$ck=input_check(array('instrument_id'=>$_POST['instrument_id']));
			$ck=input_check(array('ins_name'=>$_POST['ins_name']));
			
			if($ck=='Success'){
				
				///Insert
        

         $db_obj->select('instrument','*',"ins_name='".$_POST['ins_name']."'");
         if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
            // header("Location: house_keeping.php?InstrumentNew");
			  echo'<script>window.location="house_keeping.php?InstrumentNew";</script>';
               exit(); 

        }else{         
        $ins=$db_obj->insert('instrument',array('entry_date'=>$_POST['entry_date'],
          'ins_name'=>$_POST['ins_name'],
          'ins_cat_id'=>$_POST['ins_cat_id'],
          'market_price'=>$_POST['market_price'],
          'net_asset_value'=>$_POST['net_asset_value'],
          'instrument_type'=>$_POST['instrument_type'],
          'pe_ratio'=>$_POST['pe_ratio'],
          'enjoy_netting'=>(@$_POST['enjoy_netting'])?(@$_POST['enjoy_netting']):'False',
          'total_share'=>$_POST['total_share'],
          'last_up_date'=>$_POST['last_up_date'],
          'isin'=>$_POST['isin'],
		  'declaraction_date'=>$_POST['declaraction_date'],
		  'short_name'=>$_POST['short_name'],
		   'face_value'=>$_POST['face_value'],
		    'cost_per_share'=>$_POST['cost_per_share'],
			 'premium'=>$_POST['premium'],
			 'non_marginable'=>(@$_POST['non_marginable'])?(@$_POST['non_marginable']):'FALSE',
			 'latest_eps'=>$_POST['latest_eps'],
			 'public_share'=>$_POST['public_share'],
			  'catagory'=>$_POST['catagory'],
			   'status'=>$_POST['status'],
          'insert_employee_id'=>$_SESSION['LOGIN_USER']['id'])); 

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
             //header("Location: house_keeping.php?InstrumentNew");
			   echo'<script>window.location="house_keeping.php?InstrumentNew";</script>';
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
                  <div align="right"><a href="?Instrument" class="btn alert-info"><span class="icon-th-large"></span> All Instrument </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Instrument  </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
                	<form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="155"><font color="red">* </font><strong>ISIN</strong></td>
    <td width="172"><input type="text" name="isin" id="isin" required /></td>
  </tr>
  <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Entry Date</strong></td>
    <td width="283"><input type="date" name="entry_date" id="entry_date" required /></td>
    <td width="155"><font color="red">* </font><strong>Declaraction Date</strong></td>
    <td><input type="date" name="declaraction_date" id="declaraction_date" required/></td>
  </tr>
  <tr>
    <td height="31"><font color="red">* </font><strong>Instrument name</strong></td>
    <td width="283"><input type="text" name="ins_name" id="ins_name" required/></td>
    <td width="155"><font color="red">* </font><strong>Short Name</strong></td>
    <td><input type="text" name="short_name" id="short_name" required/></td>
  </tr>
  <tr>
    <td height="33"><font color="red">* </font><strong>Instrument Catagory</strong></td>
    <td width="283"><select name="ins_cat_id" id="ins_cat_id" required>
    
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
    <td><input type="text" name="face_value" id="face_value" /></td>
  </tr>
  <tr>
    <td height="35"><font color="red">* </font><strong>Market Price</strong></td>
    <td width="283"><input name="market_price" type="text" id="market_price" value="0" required/></td>
    <td width="155"><font color="red">* </font><strong>Cost Per Share</strong></td>
    <td><input type="text" name="cost_per_share" id="cost_per_share" required/></td>
  </tr>
  <tr>
    <td height="36"><strong>Net Asset Value</strong></td>
    <td width="283"><input type="text" name="net_asset_value" id="net_asset_value" /></td>
    <td width="155"><strong>Premium</strong></td>
    <td><input type="text" name="premium" id="premium" /></td>
  </tr>
  <tr>
    <td height="31"><font color="red">* </font><strong>Instrument Type</strong></td>
    <td width="283"><select name="instrument_type" id="instrument_type" required>
    <option value="Demat">Demat</option>
    <option value="Paper">Paper</option>
    </select></td>
    <td width="155"><strong>Non Marginable</strong></td>
    <td><input name="non_marginable" type="checkbox" id="non_marginable" value="TRUE" /></td>
  </tr>
  <tr>
    <td height="34"><font color="red">* </font><strong>PE Ratio</strong></td>
    <td width="283"><input name="pe_ratio" type="text" id="pe_ratio" value="0" required/></td>
    <td width="155"><strong>Latest EPS</strong></td>
    <td><input name="latest_eps" type="text" id="latest_eps" value="0.0" /></td>
  </tr>
  <tr>
    <td height="31"><strong>Enjoy Netting</strong></td>
    <td width="283"><input name="enjoy_netting" type="checkbox" id="enjoy_netting" value="True" /></td>
    <td width="155"><font color="red">* </font><strong>Public Share</strong></td>
    <td><input name="public_share" type="text" id="public_share" value="0" required /></td>
  </tr>
  <tr>
    <td height="33"><font color="red">* </font><strong>Total Share</strong></td>
    <td width="283"><input type="text" name="total_share" id="total_share" required/></td>
    <td width="155"><strong>Catagory</strong></td>
    <td><select name="catagory" id="catagory">
    
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
    <td height="32"><font color="red">* </font><strong>Last Update</strong></td>
    <td width="283"><input type="date" name="last_up_date" id="last_up_date"  required/></td>
    <td width="155"><strong>Status</strong></td>
    <td><select name="status" id="status">
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
    </select></td>
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
        