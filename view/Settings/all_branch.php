<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $branchID=$enc->decryptIt($_GET['dell']);
    if($branchID!=1) {
        $db_obj->delete("branch_list", "branch_id='$branchID'");
    }
  if(isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}

?>



<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
                	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
                     <div align="right"><a href="branch_new.php" class="btn btn-primary"><span class="icon-plus-sign"></span> New Branch</a></div>
                     <?php endif;?>
                     
                     
                    	<table class="table table-bordered" id="dyntable">
                   
                    <thead>
                        <tr>
                          	<th width="19" class="head0">SL</th>
                            <th width="146" class="head1">Branch Name</th>
                            <th width="132" class="head0">Address</th>
                            <th width="42" class="head1">Status</th>
                            <th width="80" class="head1">Insert Data</th>
                            <th width="77" class="head1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
					if($page['branch_access']=="All"){
                    $sql="SELECT * FROM branch_list";
					}else{
					 $sql="SELECT * FROM branch_list WHERE branch_id='".$_SESSION['LOGIN_USER']['branch_id']."'";
					}
					$db_obj->sql($sql);
					 $branch=$db_obj->getResult();
					 
					if($branch){
						$i=0;
						foreach($branch as $branch):
						$i++;
					?>
                    
                        <tr class="gradeX">
                          <td><?php echo $i;?></td>
                            <td><a  href="?emp_=<?php echo $branch['name'];?>&token=<?php echo urlencode($enc->encryptIt($branch['branch_id']));?>" id="employee" onclick="MainModule(<?php echo $branch['branch_id'];?>,'<?php echo session_id();?>');"><?php echo $branch['name'];?></a></td>
                            <td><?php echo $branch['branch_address'];?></td>
                            <td class="center"><?php echo $branch['status'];?></td>
                            <td class="center"><?php echo employee($branch['insert_employeeid']);?></td>
                            <td class="center">
                             <?php
                    if($page['edit_status']=="Active"):
					?>
                            <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active" && $branch['branch_id']!=1):
					?>
                            <a href="?dell=<?php echo urlencode($enc->encryptIt($branch['branch_id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         