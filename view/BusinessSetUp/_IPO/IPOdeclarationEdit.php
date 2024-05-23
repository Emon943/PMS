
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		}
		
    if(isset($_GET["getID"])){
	$ipo_id=$enc->decryptIt($_GET["getID"]);
	
	
				$db_obj->sql("SELECT * FROM tbl_ipo_declaration WHERE id='".$db_obj->EString($ipo_id)."'");
			    $ipo_declaration=$db_obj->getResult();
				//print_r($ipo_declaration);
				//die();
			  if(!$ipo_declaration){
				   echo "<h2>Investor Not Founded...........</h2>";
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
 <div align="right"><a href="?IPOdeclarationReport" class="btn alert-info"><span class="icon-th-large"></span> All IPO Declaration </a></div>
                     <?php endif;?>
     <h4 class="widgettitle">New IPO Declaration Update</h4>

  <div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
		if(isset($_POST["updateInv"])){
					
			$db_obj->update('tbl_ipo_declaration',array('inst_name'=>$_POST['inst_name'],
			'addressline1'=>$_POST['addressline1'],
			'short_name'=>$_POST['short_name'],
			'addressline2'=>$_POST['addressline2'],
			'dec_date'=>$_POST['dec_date'],
			'city'=>$_POST['city'],
			'close_date'=>$_POST['close_date'],
			'country'=>$_POST['country'],
			'postcode'=>$_POST['postcode'],
			'telephone'=>$_POST['telephone'],
            'currency'=>$_POST['currency'],
		    'market_lot'=>$_POST['market_lot'],
		    'face_val'=>$_POST['face_val'],
		    'Premium'=>$_POST['Premium'],
		     'Active'=>$_POST['status']),		
			 "id=".$_POST["ipo_id"].""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			             echo'<script>window.location="ipo.php?IPOdeclarationReport";</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
    <form action="" method="post" enctype="multipart/form-data">
     <table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
		  
  <tr>
   <td width="145"><strong>
   <input name="ipo_id" type="hidden" id="ipo_id" value="<?php echo $ipo_id;?>" />
    <strong>Instrument Name</strong></td>
    <td width="283"><input type="text" name="inst_name" id="inst_name" value="<?php echo $ipo_declaration[0]['inst_name']?>"/></td>
	 <td width="155" height="33"><strong>Addressline1 </strong> </td>
     <td width="283"><input type="text" name="addressline1" id="addressline1" value="<?php echo $ipo_declaration[0]['addressline1']?>"/></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Short Name </strong> </td>
    <td width="283"><input type="text" name="short_name" id="short_name" value="<?php echo $ipo_declaration[0]['short_name']?>"/></td>
	<td width="155" height="33"><strong>Addressline2 </strong> </td>
     <td width="283"><input type="text" name="addressline2" id="addressline2" value="<?php echo $ipo_declaration[0]['addressline2']?>"/></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Declaration Date</strong></td>
    <td width="283"><input type="date" name="dec_date" id="dec_date" value="<?php echo $ipo_declaration[0]['dec_date']?>" /></td>
	<td width="155" height="33"><strong>City</strong></td>
     <td width="283"><input type="text" name="city" id="city" value="<?php echo $ipo_declaration[0]['city']?>"/></td>
  </tr>
    <tr>
    <td width="145" height="33"><strong>Closing Date</strong></td>
    <td width="283"><input type="date" name="close_date" id="close_date" value="<?php echo $ipo_declaration[0]['close_date']?>" /></td>
	<td width="155" height="33"><strong>Country</strong></td>
     <td width="283"><input type="text" name="country" id="country" value="<?php echo $ipo_declaration[0]['country']?>"/></td>
  </tr>
 
  <tr>
    <td width="145" height="33"><strong>PostCode</strong></td>
    <td width="283"><input type="text" name="postcode" id="postcode" value="<?php echo $ipo_declaration[0]['postcode']?>"/></td>
	
	<td width="155" height="33"><strong>Telephone</strong></td>
     <td width="283"><input type="text" name="telephone" id="telephone" value="<?php echo $ipo_declaration[0]['telephone']?>"/></td>
	
     </tr>
	 
	  <tr>
      <td height="25" colspan="4" align="center" valign="top"  style=  "background-color:#CCC;"><strong>IPO Face Value Declaration</strong></td>
    </tr>
   <tr>
    <td width="155"><strong>Currency</strong></td>
    <td width="283"><select name="currency" id="currency" required="required">
      <option value="<?php echo $ipo_declaration[0]['currency']?>"><?php echo $ipo_declaration[0]['currency'];?></option>
      <option value="USD">USD</option>
	  <option value="EURO">EURO</option>
    </select></td>
     <td width="155"><strong>Market Lot</strong></td>
    <td><input type="text" name="market_lot" id="market_lot" value="<?php echo $ipo_declaration[0]['market_lot'];?>"/></td>
    
  </tr>
  <tr>
    <td width="155"><strong>Face Value</strong></td>
    <td><input type="text" name="face_val" id="face_val" value="<?php echo $ipo_declaration[0]['face_val'];?>"/></td>
   <td width="155"><strong>Premium</strong></td>
   <td><input type="text" name="Premium" id="Premium" value="<?php echo    $ipo_declaration[0]['premium'];?>"/></td></tr>
  
  <tr>
    <td width="155"><strong>Status</strong></td>
    <td width="283"><select name="status" id="status" required="required">
      <option value="<?php echo $ipo_declaration[0]['Active']?>"><?php if($ipo_declaration[0]['Active']==True){
		  echo "Active";
	  }else{
		   echo "Default";
	  } ?></option>
	  <option value="False">Default</option>
      <option value="True">Active</option>
    </select></td>
    
  </tr>
	 
        <tr>
          <td width="145" height="33" valign="top"  ></td>
          <td width="283" height="33" align="right" valign="top"  ><input type="submit" name="updateInv" id="updateInv" value="Update"/></td>
        </tr>
    </table>

          </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         