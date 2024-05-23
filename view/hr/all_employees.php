<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $empID=$enc->decryptIt($_GET['dell']);
    if($empID!=1) {
        $db_obj->delete("employee", "id='$empID'");
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
                     <div align="right"><a href="employ_reg.php" class="btn btn-primary"><span class="icon-plus-sign"></span> New Employee</a></div>
                     <?php endif;?>
                     
                     
                    	<table class="table table-bordered" id="dyntable">
                   
                    <thead>
                        <tr>
                          	<th width="19" class="head0">SL</th>
                            <th width="64" class="head1">Login ID</th>
                            <th width="75" class="head0">Name</th>
                            <th width="81" class="head1">Roule</th>
                            <th width="52" class="head1">Contact</th>
                            <th width="77" class="head1">Branch</th>
                            <th width="119" class="head1">Ref#</th>
                            <th width="42" class="head1">Status</th>
                            <th width="91" class="head1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
					if($page['branch_access']=="All"){
                    $sql="SELECT * FROM `employee_view` WHERE employee_id!=1";
					}else{
					 $sql="SELECT * FROM employee_view WHERE branch_id='".$_SESSION['LOGIN_USER']['branch_id']."' and employee_id!=1";
					}
					$db_obj->sql($sql);
					 $employee=$db_obj->getResult();
					 
					if($employee){
						$i=0;

						//print_r($employee);
						foreach($employee as $employee):
						$i++;
					?>
                    
                        <tr class="gradeX">
                          <td><?php echo $i;?></td>
                            <td><?php echo $employee['login_id'];?></td>
                            <td><?php echo $employee['emp_name'];?></td>
                            <td class="center"><?php echo $employee['emp_roule'];?></td>
                            <td class="center"><?php echo $employee['contact_num'];?></td>
                            <td class="center">
                            <?php echo $employee['emp_branch'];?>
                             </td>
                            <td class="center"> <?php if($employee['ref_id']==0){echo "Default Set";}else{echo employee($employee['ref_id']);}?></td>
                            <td class="center"> <?php echo $employee['emp_status'];?></td>
                            <td class="center"><?php
                    if($page['edit_status']=="Active"):
					?>
                            <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active" && $employee['employee_id']!=1):
					?>
                            <a href="?dell=<?php echo urlencode($enc->encryptIt($employee['employee_id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         