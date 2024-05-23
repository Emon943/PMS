<?php

if(isset($_GET['dell'])){
    $instrumentcategory=$enc->decryptIt($_GET['dell']);
    if($instrumentcategory!=1) {
        $db_obj->delete("instrumentcategory", "id='$instrumentcategory'");
    }
   if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}

?>
<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to delete this?');
    }
</script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <div align="right">
        <a href="?InstrumentCategory_new" class="btn btn-primary"><span class="icon-plus-sign"></span> New Instrument Category</a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="35" class="head0">Code</th>
                  <th width="72" class="head1">Settlement</th>
                  <th width="80" class="head0">CSE Settlement Day</th>
                  <th width="45" class="head1">Payble</th>
                  <th width="70" class="head1">Receivable</th>
                  <th width="48" class="head1">Deduct</th>
                  <th width="131" class="head1">Description</th>
                  <th width="63" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM instrumentcategory";
					
					$db_obj->sql($sql);
					 $instrumentcategory=$db_obj->getResult();
					 
					if($instrumentcategory){
						
						foreach($instrumentcategory as $instrumentcategory):
						
					?>
                    
              <tr class="gradeX">
                <td><?php echo $instrumentcategory['code'];?></td>
                  <td><?php echo $instrumentcategory['sttelment_day_dse'];?></td>
                  <td><?php echo $instrumentcategory['sttelment_day_cse'];?></td>
                  <td class="center"><?php echo $instrumentcategory['payble'];?></td>
                  <td class="center"><?=$instrumentcategory['receivable'];?></td>
                  <td class="center">
                    <?=$instrumentcategory['deduct'];?>
                   </td>
                  <td class="center"> <?php echo $instrumentcategory['description'];//if($instrumentcategory['insert_employee_id']==0){echo "Default Set";}else{echo employee($instrumentcategory['insert_employee_id']);}?></td>
                  <td class="center"><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="house_keeping.php?instrumentcategory_update&getID=<?php echo urlencode($enc->encryptIt($instrumentcategory['id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($instrumentcategory['id']));?>" onclick="return confirmation()" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         