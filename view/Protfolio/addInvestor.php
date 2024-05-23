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
      <div align="right"><a href="?addInvestorNew" class="btn alert-info"><span class="icon-th-large"></span>Add Investor</a></div>
          
        <!-- <span class="btn" style="background-color:#003;"> <a href="?importCDBL">Import CDBL File</a></span>-->
		   <!--<span class="btn" style="background-color:#003;"> <a href="?all_importCDBL">All Import CDBL File</a></span>-->
      <?php endif;?>
                     
                     
       	<table class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="102" class="head0">BO ID </th>
                  <th width="126" class="head1">Name</th>
				    <th width="126" class="head1">A/C Number</th>
                  <th width="142" class="head0">Account Status</th>
                  <th width="54" class="head0">Group</th>
                  <th width="128" class="head0">Status</th>
              </tr>
          </thead>
          <tbody>
                    
            
                   <?php
					
					 $sql="SELECT * FROM investor where status=0 ORDER BY dp_internal_ref_number ASC";
					
					$db_obj->sql($sql);
					 $investor=$db_obj->getResult();
					 
					if($investor){
						
						foreach($investor as $investor):
						
					?>  
              <tr class="gradeX">
                <td><?php echo $investor['investor_ac_number'];?></td>
                  <td><?php echo $investor['investor_name'];?></td>
				   <td><?php echo $investor['dp_internal_ref_number'];?></td>
                  <td><?php echo $investor['account_status'];?></td>
                  <td><?php echo @mysql_result(mysql_query("SELECT `group_name` FROM `investor_group` WHERE `investor_group_id`='".$investor['investor_group_id']."'"),0);?></td>
                <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="Protfolio.php?investorEdit&getID=<?php echo urlencode($enc->encryptIt($investor['investor_id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['view_status']=="Active"):
					?>
                  <a href="Protfolio.php?investorView&getID=<?php echo urlencode($enc->encryptIt($investor['investor_id']));?>" class="btn" title="View Data"><span class="  iconsweets-scan"></span></a>
                            
                    <?php endif;
					if($page['delete_status']=="Active"):
					?>
                     <!--<a href="<?php //echo $_SERVER['REQUEST_URI']?>&dell=<?php //echo urlencode($enc->encryptIt($investor['investor_id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>-->
                            
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
         