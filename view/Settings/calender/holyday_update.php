
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$date_id=$enc->decryptIt($_GET["getID"]);
	
	
				$db_obj->sql("SELECT * FROM tbl_calendar WHERE id='".$db_obj->EString($date_id)."'");
			    $holyday_info=$db_obj->getResult();
				//print_r($holyday_info);
				//die();
			  if(!$holyday_info){
				   echo "<h2>Investor Not Founded...........</h2>";
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
                  <div align="right"><a href="calendar.php?holyday_calendar" class="btn alert-info"><span class="icon-th-large"></span>Holyday List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
			$db_obj->update('tbl_calendar',array('note'=>$_POST["note"]),
							 "id=".$_POST["date_id"].""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			           echo'<script>window.location="calendar.php?holyday_calendar";</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form action="" method="post" enctype="multipart/form-data">
          <table width="80%" border="0" cellpadding="0" cellspacing="5">
            
             <tr>
               <td width="145" height="33"><strong></td>
                <input type="hidden" name="date_id" id="date_id" value="<?php echo $date_id;?>" />
			</tr>
			
	     <tr>
           <td width="145" height="33"><strong>Date</strong></td>
           <td width="283"><input type="text" name="date" id="date" value="<?php echo $holyday_info[0]['date']?>" required /></td>
         </tr>
		 <tr>
	      <td width="155" height="33"><strong>Note</strong></td>
          <td width="283"><input type="text" name="note" id="note" value="<?php echo $holyday_info[0]['note']?>" /></td>
		 </tr>
	   
            
            <tr>
              <td width="145" height="40"></td>
              <td height="-5" align="center" valign="top"  ><input type="submit" name="updateInv" id="updateInv" onclick="return confirmation()" value="Update Holyday"/></td>
            </tr>
          </table>
          </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         