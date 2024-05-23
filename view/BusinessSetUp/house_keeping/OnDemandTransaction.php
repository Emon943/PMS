<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $on_demand_charge_fee=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("on_demand_charge_fee", "id='$on_demand_charge_fee'");
   	
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
        <a href="?OnDemandTransactionNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New On Demand Transaction </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="52" class="head0" title="Short Name">Code</th>
                  <th width="201" class="head1" title="ISIN">Name</th>
                  <th width="227" class="head0" title="Name">Fee Type</th>
                  <th width="69" class="head1" title="Industry">Fee Mode</th>
                  <th width="69" class="head1" title="Industry">Active</th>
                  <th width="134" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `on_demand_charge_fee` ORDER BY id DESC";
					
					$db_obj->sql($sql);
					 $on_demand_charge_fee=$db_obj->getResult();
					 
					if($on_demand_charge_fee){
						
						foreach($on_demand_charge_fee as $on_demand_charge_fee):
						
					?>
              <tr class="gradeX">
                <td><?php echo $on_demand_charge_fee['code'];?></td>
                  <td><?php echo $on_demand_charge_fee['name'];?></td>
                  <td><?php echo $on_demand_charge_fee['fee_type'];?></td>
                  <td class="center"><?php echo $on_demand_charge_fee['fee_mode'];?></td>
                  <td class="center"><?php echo $on_demand_charge_fee['is_active'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($on_demand_charge_fee['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         