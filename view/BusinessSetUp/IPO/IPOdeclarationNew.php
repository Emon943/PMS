	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
		$ck=input_check(array('dec_date'=>$_POST['dec_date'],));
			
			if($ck=='Success'){
				
				///Insert
        

         $db_obj->select('tbl_ipo_declaration','*',"dec_date='".$_POST['dec_date']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="ipo.php?IPOdeclarationNew";</script>';
               exit(); 

        }else{         
       $ins=$db_obj->insert('tbl_ipo_declaration',array('inst_name'=>$_POST['inst_name'],
		'addressline1'=>$_POST['addressline1'],
		'short_name'=>$_POST['short_name'],
		'addressline2'=>$_POST['addressline2'],
		'dec_date'=>$_POST['dec_date'],
		'city'=>$_POST['city'],
		'close_date'=>$_POST['close_date'],
		'country'=>$_POST['country'],
		'postcode'=>$_POST['postcode'],
		'telephone'=>$_POST['telephone'],
		'record_date'=>$_POST['record_date'],
		'min_amount'=>$_POST['min_amount'],
		'max_amount'=>$_POST['max_amount'],
		'min_investment'=>$_POST['min_investment'],
		'currency'=>$_POST['currency'],
		'market_lot'=>$_POST['market_lot'],
		'face_val'=>$_POST['face_val'],
		'Premium'=>$_POST['Premium'],
		'Active'=>$_POST['status']));
		
		
$ins=$db_obj->insert('instrument',array('ins_name'=>$_POST['inst_name'],
		'short_name'=>$_POST['short_name'],
		'declaraction_date'=>$_POST['dec_date'],
		'face_value'=>$_POST['face_val']));
		
		
		
		//print_r($ins);
		//die();

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="ipo.php?IPOdeclarationNew";</script>';
            
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
                  <div align="right"><a href="?IPOdeclarationReport" class="btn alert-info"><span class="icon-th-large"></span> All IPO Declaration</a></div>
                     <?php endif;?>
   <h4 class="widgettitle">Add IPO Declaration</h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
 <form class="stdform" action="" method="post">
                    	

<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
            <td height="25" colspan="4" align="center" valign="top"  style=  "background-color:#CCC;"><strong>IPO Company INFO</strong></td>
            </tr>
  <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Instrument Name</strong></td>
    <td width="283"><input type="text" name="inst_name" id="inst_name" required=""/></td>
	 <td width="155" height="33"><font color="red">* </font><strong>Addressline1 </strong> </td>
     <td width="283"><input type="text" name="addressline1" id="addressline1" required=""/></td>
  </tr>
  <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Short Name </strong> </td>
    <td width="283"><input type="text" name="short_name" id="short_name" required=""/></td>
	<td width="155" height="33"><font color="red">* </font><strong>Addressline2 </strong> </td>
     <td width="283"><input type="text" name="addressline2" id="addressline2" required=""/></td>
  </tr>
  <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Declaration Date</strong></td>
    <td width="283"><input type="date" name="dec_date" id="dec_date" required /></td>
	<td width="155" height="33"><font color="red">* </font><strong>City</strong></td>
     <td width="283"><input type="text" name="city" id="city" required=""/></td>
  </tr>
    <tr>
    <td width="145" height="33"><font color="red">* </font><strong>Closing Date</strong></td>
    <td width="283"><input type="date" name="close_date" id="close_date" required /></td>
	<td width="155" height="33"><font color="red">* </font><strong>Country</strong></td>
     <td width="283"><input type="text" name="country" id="country" required=""/></td>
  </tr>
 
  <tr>
    <td height="33"><font color="red">* </font><strong>PostCode</strong></td>
    <td width="283"><input type="text" name="postcode" id="postcode" required=""/></td>
	
	<td width="155" height="33"><font color="red">* </font><strong>Telephone</strong></td>
     <td width="283"><input type="text" name="telephone" id="telephone" required=""/></td>
	
  </tr>
  
     <tr>
    <td height="33"><font color="red">* </font><strong>Record Date</strong></td>
    <td width="283"><input type="date" name="record_date" id="record_date" required=""/></td>
	
	<td width="155" height="33"><font color="red">* </font><strong>Min Amount</strong></td>
     <td width="283"><input type="text" name="min_amount" id="min_amount" required=""/></td>
	
  </tr>
   </tr>
  
     <tr>
    <td height="33"><font color="red">* </font><strong>Max Amount</strong></td>
    <td width="283"><input type="text" name="max_amount" id="max_amount" required=""/></td>
	
	<td width="155" height="33"><font color="red">* </font><strong>Min Investment</strong></td>
    <td width="283"><input type="text" name="min_investment" id="min_investment" required=""/></td>
	
  </tr>
  
     <tr>
      <td height="25" colspan="4" align="center" valign="top"  style=  "background-color:#CCC;"><strong>IPO Face Value Declaration</strong></td>
    </tr>
   <tr>
    <td width="155"><font color="red">* </font><strong>Currency</strong></td>
    <td width="283"><select name="currency" id="currency" required="required">
      <option value="BD">BDT</option>
      <option value="USD">USD</option>
	  <option value="EURO">EURO</option>
    </select></td>
     <td width="155"><strong>Market Lot</strong></td>
    <td><input type="text" name="market_lot" id="market_lot" value="<?php echo "1" ?>"/></td>
    
  </tr>
  <tr>
    <td width="155"><strong>Face Value</strong></td>
     <td><input type="text" name="face_val" id="face_val" value="<?php echo "0" ?>"/></td>
     <td width="155"><strong>Premium</strong></td>
    <td><input type="text" name="Premium" id="Premium" value="<?php echo "0" ?>"/></td>
    
  </tr>
  
  <tr>
    <td width="155"><font color="red">* </font><strong>Status</strong></td>
    <td width="283"><select name="status" id="status" required="required">
      <option value="False">Default</option>
      <option value="True">Active</option>
    </select></td>
    
  </tr>
  <tr>
    <td height="50" colspan="4" align="right"> 
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
        