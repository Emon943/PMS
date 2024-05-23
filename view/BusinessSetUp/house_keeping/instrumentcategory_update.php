
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$instrumentcategory=$enc->decryptIt($_GET["getID"]);
	//echo $instrumentcategory;
	//die();
	//date_default_timezone_set('Asia/Dhaka');
   //$update_date= date('Y-m-d h:i:s A');
	//die();
	
				$db_obj->sql("SELECT * FROM instrumentcategory WHERE id='".$db_obj->EString($instrumentcategory)."'");
			    $instrumentcat_res=$db_obj->getResult();
				//print_r($instrumentcat_res);
			//die();
			  if(!$instrumentcat_res){
				   echo "<h2>Instrument Category Not Founded...........</h2>";
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
                  <div align="right"><a href="?InstrumentCategory" class="btn alert-info"><span class="icon-th-large"></span> Instrument Category </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					$update_date=date("Y-m-d h:i:sa");
					
			$db_obj->update('instrumentcategory',array('code'=>$_POST["code"],
         					 'description'=>$_POST["description"],
							 'sttelment_day_dse'=>$_POST["dse"],
							 'sttelment_day_cse'=>$_POST["cse"]),
							 "id=".$instrumentcategory.""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			             echo'<script>window.location="house_keeping.php?InstrumentCategory";</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form class="stdform" action="" method="post">
                    	
                    
                        
                        <p>
                        	<label>Code</label>
                            <span class="field"><input autocomplete="off" type="text" required name="code"  class="input-medium" value="<?php echo $instrumentcat_res[0]['code']?>" /></span>
                        </p>
                      <p>
                       	<label>Description </label>
                         <span class="field"><input type="text" autocomplete="off" required name="description" class="input-medium" placeholder="Description" id="description" value="<?php echo $instrumentcat_res[0]['description']?>"/></span>
                      </p>
                        <p>
                        	<label>Settlement Day [ DSE ]</label>
                            <span class="field"><input name="dse" autocomplete="off" type="number" class="input-medium" id="dse" value="<?php echo $instrumentcat_res[0]['sttelment_day_dse']?>" /></span>
                        </p>
                        
                      <p>
                        	<label>Settlement Day [ CSE ]</label>
                            
                            <span class="field"><input name="cse" autocomplete="off" type="number" class="input-medium" id="cse" value="<?php echo $instrumentcat_res[0]['sttelment_day_cse']?>" /></span>
                            
                            
                      </p>
                    
                      <p class="stdformbutton">
                        <button class="btn btn-primary" name="updateInv" onclick="return confirmation()">Update</button>
                            <button type="reset" class="btn">Reset Form</button>
                      </p>
                        
                        
                    </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         