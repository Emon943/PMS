<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $id=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("tbl_agency_setup", "id='$id'");
   	
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
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
      <div align="right">
        <a href="?Agency_New" class="btn btn-primary"><span class="icon-plus-sign"></span>New Agency Setup </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="113" class="head0" title="Short Name">Code</th>
				  <th width="180" class="head1" title="ISIN">Name</th>
                  <th width="180" class="head1" title="ISIN">Description</th>
                  <th width="167" class="head1" title="Industry">margin Ratio</th>
                  <th width="159" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `tbl_agency_setup` ORDER BY id DESC";
					
					$db_obj->sql($sql);
					 $agency_setup=$db_obj->getResult();
					 
					if($agency_setup){
						
						foreach($agency_setup as $agency):
						
					?>
              <tr class="gradeX">
                <td><?php echo $agency['code'];?></td>
                <td><?php echo $agency['name'];?></td>
				<td><?php echo $agency['des'];?></td>
				<td><?php echo $agency['charge_amt'];?></td>
				
		
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($agency['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         