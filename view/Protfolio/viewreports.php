<?php

if(isset($_GET['dell'])){
     $investor_id=$enc->decryptIt($_GET['dell']);
   // if($investor_id!=1) {
	    
		$db_obj->sql("SELECT txt_file_,investor_images FROM investor where investor_id='$investor_id'");
		$textFile=$db_obj->getResult();
        $db_obj->delete("investor", "investor_id='$investor_id'");
		
		unlink($textFile[0]['txt_file_']);
		unlink("./pms_doc_upload/investor_img/".$textFile[0]['investor_images'].".jpeg");
   // }
   if(isset($_SERVER['HTTP_REFERER'])){
   echo("<script>location.href = '".$_SERVER['HTTP_REFERER']."';</script>");
   exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}

?>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
               <?php
					include 'cdbl_menu.php';
					?>
      <?php endif;?>
                     
       <h2 style="text-align:center">Daily BO-ISIN Holding Report(DP)</h2></br>            
       	<table class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="102" class="head0">Count Share No. </th>
                  <th width="126" class="head1">BO ID</th>
                  <!--<th width="142" class="head0">Securities No.</th>
                  <th width="54" class="head0">Securities Name</th>-->
                  <th width="128" class="head0">Status</th>
              </tr>
          </thead>
          <tbody>
                    
            
                   <?php
					
					 //$sql="SELECT * FROM daily_bo_holding GROUP BY c";
					$sql="SELECT COUNT(Id), bo_id FROM daily_bo_holding GROUP BY bo_id";
					
					
					$db_obj->sql($sql);
					 $daily_bo_holding=$db_obj->getResult();
					// print_r($daily_bo_holding);
					 //die();
					if($daily_bo_holding){
						
						foreach($daily_bo_holding as $bo_holding):
						
					?> 
					
              <tr class="gradeX">
                <td><?php echo $bo_holding['COUNT(Id)'];?></td>
                  <td><?php echo $bo_holding['bo_id'];?></td>
                  
                <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="Protfolio.php?investorEdit&getID=<?php echo urlencode($enc->encryptIt($bo_holding['bo_id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['view_status']=="Active"):
					?>
                  <a href="Protfolio.php?dailyBoholdingReports&getID=<?php echo urlencode($enc->encryptIt($bo_holding['bo_id']));?>" class="btn" title="View Data"><span class="  iconsweets-scan"></span></a>
                            
                    <?php endif;
					if($page['delete_status']=="Active"):
					?>
                     <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($bo_holding['bo_id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
                    <?php endif;?>
                </td>
              </tr>
             <?php
						endforeach;
					}
						?>
                        
          </tbody>
      </table>
                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
         